<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json');

include('../db_function.php');
$conn = db_connect();

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
    exit;
}

// === CLIENT DATA ===
$business_name = trim($data['business_name'] ?? '');
$business_address = trim($data['business_address'] ?? '');
$contact_name = trim($data['contact_name'] ?? '');
$contact_phone = trim($data['contact_phone'] ?? '');
$contact_email = trim($data['contact_email'] ?? '');
$client_since = date('Y-m-d');

// === ORDER DATA ===
$user_id = intval($data['user_id'] ?? 0);
$order_id = intval($data['order_id'] ?? 0);
$order_date = $data['order_date'] ?? date('Y-m-d H:i:s');
$order_due = $data['order_due'] ?? null;
$order_before_tax = floatval($data['order_before_tax'] ?? 0);
$order_tax = floatval($data['order_tax'] ?? 0);
$order_after_tax = floatval($data['order_after_tax'] ?? 0);
$order_amount_paid = floatval($data['order_amount_paid'] ?? 0);
$order_amount_due = floatval($data['order_amount_due'] ?? 0);
$order_production_time = intval($data['order_production_time'] ?? 0);
$payment_type_id = intval($data['payment_type_id'] ?? 0);
$status_id = intval($data['status_id'] ?? 1);
$order_comment = trim($data['order_comment'] ?? '');
$items = $data['items'] ?? [];

// === CLIENT HANDLING ===
if ($order_id == 0) {
    // New order → new client
    $sql_client = "INSERT INTO ps_clients (business_name, business_address, contact_name, contact_phone, contact_email, client_since)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_client);
    mysqli_stmt_bind_param($stmt, "ssssss", $business_name, $business_address, $contact_name, $contact_phone, $contact_email, $client_since);
    mysqli_stmt_execute($stmt);
    $client_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
} else {
    // Existing order → update client
    $res = mysqli_query($conn, "SELECT client_id FROM ps_orders WHERE order_id = $order_id");
    $row = mysqli_fetch_assoc($res);
    $client_id = $row['client_id'] ?? 0;
    mysqli_free_result($res);

    $sql_update_client = "UPDATE ps_clients 
                          SET business_name=?, business_address=?, contact_name=?, contact_phone=?, contact_email=?
                          WHERE client_id=?";
    $stmt = mysqli_prepare($conn, $sql_update_client);
    mysqli_stmt_bind_param($stmt, "sssssi", $business_name, $business_address, $contact_name, $contact_phone, $contact_email, $client_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// === ORDER HANDLING ===
if ($order_id == 0) {
    // Insert new order
    $sql_order = "INSERT INTO ps_orders (
        order_date, order_due, user_id, order_before_tax, order_tax, order_after_tax,
        order_amount_paid, order_amount_due, order_production_time, payment_type_id,
        client_id, status_id, order_comment
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_order);
    mysqli_stmt_bind_param(
        $stmt,
        "ssidddddiiiis",
        $order_date,
        $order_due,
        $user_id,
        $order_before_tax,
        $order_tax,
        $order_after_tax,
        $order_amount_paid,
        $order_amount_due,
        $order_production_time,
        $payment_type_id,
        $client_id,
        $status_id,
        $order_comment
    );
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
} else {
    // Update existing order
    $sql_update_order = "UPDATE ps_orders SET
        order_date=?, order_due=?, order_before_tax=?, order_tax=?, order_after_tax=?,
        order_amount_paid=?, order_amount_due=?, order_production_time=?, payment_type_id=?,
        status_id=?, order_comment=? WHERE order_id=?";
    $stmt = mysqli_prepare($conn, $sql_update_order);
    mysqli_stmt_bind_param(
        $stmt,
        "ssddddddii si",
        $order_date,
        $order_due,
        $order_before_tax,
        $order_tax,
        $order_after_tax,
        $order_amount_paid,
        $order_amount_due,
        $order_production_time,
        $payment_type_id,
        $status_id,
        $order_comment,
        $order_id
    );
    mysqli_stmt_execute($stmt);
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

    if ($item_id > 0) {
        // Update existing item
        $sql_item_update = "UPDATE ps_order_items 
                            SET material_id=?, item_details=?, item_quantity=?, item_size_width=?, 
                                item_size_height=?, item_price=?, item_total=? 
                            WHERE item_id=?";
        $stmt = mysqli_prepare($conn, $sql_item_update);
        mysqli_stmt_bind_param(
            $stmt,
            "isiddddi",
            $material_id,
            $item_details,
            $item_quantity,
            $item_size_width,
            $item_size_height,
            $item_price,
            $item_total,
            $item_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        // Insert new item
        $sql_item_insert = "INSERT INTO ps_order_items (
            order_id, material_id, item_details, item_quantity, item_size_width,
            item_size_height, item_price, item_total
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_item_insert);
        mysqli_stmt_bind_param(
            $stmt,
            "iisiiddd",
            $order_id,
            $material_id,
            $item_details,
            $item_quantity,
            $item_size_width,
            $item_size_height,
            $item_price,
            $item_total
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

echo json_encode(['status' => 'success', 'message' => 'Order saved successfully!', 'order_id' => $order_id]);
mysqli_close($conn);
