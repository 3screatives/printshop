<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');

session_start();

header('Content-Type: application/json');

include('../db_function.php');
$conn = db_connect();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
    exit;
}

// === ORDER DATA ===
$order_date = $data['order_date'] ?? date('Y-m-d H:i:s');
$order_process = $data['order_due_date'] ?? 1;

// --- Calculate base due date ---
switch ($order_process) {
    case 1: // Standard: 3–5 days
        $add_days = 5;
        break;
    case 2: // Urgent: 1–2 days
        $add_days = 2;
        break;
    case 3: // Same Day
        $add_days = 0;
        break;
    default:
        $add_days = 5;
        break;
}

// --- Add days to order date ---
$order_due = date('Y-m-d', strtotime("$order_date +$add_days days"));

// --- Adjust for weekends ---
$dayOfWeek = date('N', strtotime($order_due)); // 6 = Saturday, 7 = Sunday
if ($dayOfWeek == 6) {
    // Saturday → push to Monday (+2 days)
    $order_due = date('Y-m-d', strtotime($order_due . ' +2 days'));
} elseif ($dayOfWeek == 7) {
    // Sunday → push to Monday (+1 day)
    $order_due = date('Y-m-d', strtotime($order_due . ' +1 day'));
}

$user_id = intval($_SESSION['user_id'] ?? 0);
$order_id = intval($data['order_id'] ?? 0);
$client_id = intval($data['client_id'] ?? 0); // ✅ add this line
$order_before_tax = floatval($data['order_before_tax'] ?? 0);
$order_tax = floatval($data['order_tax'] ?? 0);
$order_after_tax = floatval($data['order_after_tax'] ?? 0);
$order_amount_paid = floatval($data['order_amount_paid'] ?? 0);
$order_amount_due = floatval($data['order_amount_due'] ?? 0);
$order_discount = floatval($data['order_discount'] ?? 0);
$order_credits = floatval($data['order_credits'] ?? 0);
$process_time = intval($data['process_time'] ?? 0);
$payment_type_id = intval($data['payment_type_id'] ?? 0);
$status_id = intval($data['status_id'] ?? 1);
$order_comments = trim($data['order_comments'] ?? 'None');

$items = $data['items'] ?? [];

// === ORDER HANDLING ===
if ($order_id == 0) {
    // Insert new order
    $sql_order = "INSERT INTO ps_orders (
        order_date, order_due, user_id, order_before_tax, order_tax, order_after_tax,
        order_amount_paid, order_amount_due, order_discount, order_credits, order_production_time, payment_type_id,
        client_id, status_id, order_comment
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_order);
    mysqli_stmt_bind_param(
        $stmt,
        "ssidddddddiiiis",
        $order_date,
        $order_due,
        $user_id,
        $order_before_tax,
        $order_tax,
        $order_after_tax,
        $order_amount_paid,
        $order_amount_due,
        $order_discount,
        $order_credits,
        $process_time,
        $payment_type_id,
        $client_id,
        $status_id,
        $order_comments
    );
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
        echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
        exit;
    }

    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
} else {
    // Update existing order
    $sql_update_order = "UPDATE ps_orders SET
    order_date=?, order_due=?, order_before_tax=?, order_tax=?, order_after_tax=?,
    order_amount_paid=?, order_amount_due=?, order_discount=?, order_credits=?, order_production_time=?, payment_type_id=?,
    order_comment=? WHERE order_id=?";
    $stmt = mysqli_prepare($conn, $sql_update_order);

    mysqli_stmt_bind_param(
        $stmt,
        "ssdddddddiisi",
        $order_date,
        $order_due,
        $order_before_tax,
        $order_tax,
        $order_after_tax,
        $order_amount_paid,
        $order_amount_due,
        $order_discount,
        $order_credits,
        $process_time,
        $payment_type_id,
        $order_comments,
        $order_id
    );

    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_error($stmt)) {
        echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
        exit;
    }
    mysqli_stmt_close($stmt);
}

// === ORDER ITEMS ===
foreach ($items as $item) {
    $item_id = intval($item['item_id'] ?? 0);
    $material_id = intval($item['material_id'] ?? 0);
    $item_details = trim($item['item_details'] ?? '');
    $item_quantity = intval($item['item_quantity'] ?? 0);
    $item_size_width = floatval($item['item_size_width'] ?? 0);
    $item_size_height = floatval($item['item_size_height'] ?? 0);
    $item_price = floatval($item['item_price'] ?? 0);
    $item_total = floatval($item['item_total'] ?? 0);

    $item_is_design  = intval($item['item_is_design'] ?? 0);
    $item_is_printed = intval($item['item_is_printed'] ?? 0);

    if ($item_id > 0) {
        // Update existing item
        $sql_item_update = "UPDATE ps_order_items 
                            SET material_id=?, item_details=?, item_quantity=?, item_size_width=?, 
                                item_size_height=?, item_price=?, item_total=?, item_is_design=?, item_is_printed=? 
                            WHERE item_id=?";
        $stmt = mysqli_prepare($conn, $sql_item_update);
        mysqli_stmt_bind_param(
            $stmt,
            "isiddddiii",
            $material_id,
            $item_details,
            $item_quantity,
            $item_size_width,
            $item_size_height,
            $item_price,
            $item_total,
            $item_is_design,
            $item_is_printed,
            $item_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        // Insert new item
        $sql_item_insert = "INSERT INTO ps_order_items (
            order_id, material_id, item_details, item_quantity, item_size_width,
            item_size_height, item_price, item_total, item_is_design, item_is_printed
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_item_insert);
        mysqli_stmt_bind_param(
            $stmt,
            "iisiidddii",
            $order_id,
            $material_id,
            $item_details,
            $item_quantity,
            $item_size_width,
            $item_size_height,
            $item_price,
            $item_total,
            $item_is_design,
            $item_is_printed
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

echo json_encode(['status' => 'success', 'message' => 'Order saved successfully!', 'order_id' => $order_id]);
mysqli_close($conn);
