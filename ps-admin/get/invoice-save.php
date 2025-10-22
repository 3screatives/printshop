<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json');

include('../db_function.php');
$conn = db_connect();

// Collect input safely
$user_id = $_POST['user_id'] ?? '';
$order_id = intval($_POST['order_id'] ?? 0);

$order_receiver_name = trim($_POST['order_receiver_name'] ?? '');
$order_receiver_address = trim($_POST['order_receiver_address'] ?? '');
$order_receiver_phone = trim($_POST['order_receiver_phone'] ?? '');
$order_receiver_email = trim($_POST['order_receiver_email'] ?? '');

$order_total_before_tax = floatval($_POST['order_total_before_tax'] ?? 0);
$order_total_tax = floatval($_POST['order_total_tax'] ?? 0);
$order_tax_per = floatval($_POST['order_tax_per'] ?? 0);
$order_total_after_tax = floatval($_POST['order_total_after_tax'] ?? 0);
$order_amount_paid = floatval($_POST['order_amount_paid'] ?? 0);
$order_total_amount_due = floatval($_POST['order_total_amount_due'] ?? 0);

$order_due_raw = $_POST['order_due'] ?? '';
$order_due_date = DateTime::createFromFormat('Y-m-d', $order_due_raw);
$order_due = $order_due_date && $order_due_date->format('Y-m-d') === $order_due_raw
    ? $order_due_date->format('Y-m-d')
    : null;

$payment_id = $_POST['payment_id'] ?? '';
$order_status_id = intval($_POST['order_status'] ?? 1);
$order_comment = 'Thank you for your business.';
$items = $_POST['items'] ?? [];

$client_id = intval($_POST['client_id'] ?? 0);

// === CLIENT INSERT/UPDATE ===
if ($client_id > 0) {
    $sql = "UPDATE invoice_client 
            SET client_name=?, client_address=?, client_phone=?, client_email=?
            WHERE client_id=?";
    $updated = execute_query($conn, $sql, "ssssi", $order_receiver_name, $order_receiver_address, $order_receiver_phone, $order_receiver_email, $client_id);
    if (!$updated) {
        echo json_encode(['status' => 'error', 'message' => 'Client update failed.']);
        exit;
    }
} else {
    $sql = "INSERT INTO invoice_client (client_name, client_address, client_phone, client_email)
            VALUES (?, ?, ?, ?)";
    $inserted = execute_query($conn, $sql, "ssss", $order_receiver_name, $order_receiver_address, $order_receiver_phone, $order_receiver_email);
    if ($inserted) {
        $client_id = mysqli_insert_id($conn);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting client.']);
        exit;
    }
}

// === ORDER INSERT/UPDATE ===
if ($order_id > 0) {
    $sql = "UPDATE invoice_order SET 
        user_id=?, order_due=?, order_total_before_tax=?, order_total_tax=?, order_tax_per=?,
        order_total_after_tax=?, order_amount_paid=?, order_total_amount_due=?, payment_id=?, 
        order_comment=?, order_status_id=?, client_id=? 
        WHERE order_id=?";
    $updated = execute_query(
        $conn,
        $sql,
        "ssddddddsssii",
        $user_id,
        $order_due,
        $order_total_before_tax,
        $order_total_tax,
        $order_tax_per,
        $order_total_after_tax,
        $order_amount_paid,
        $order_total_amount_due,
        $payment_id,
        $order_comment,
        $order_status_id,
        $client_id,
        $order_id
    );
    if (!$updated) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating invoice.']);
        exit;
    }

    // Delete old items before inserting new ones
    $sql_delete = "DELETE FROM invoice_order_item WHERE order_id=?";
    execute_query($conn, $sql_delete, "i", $order_id);
} else {
    $sql = "INSERT INTO invoice_order (
        user_id, order_due, order_total_before_tax, order_total_tax, order_tax_per,
        order_total_after_tax, order_amount_paid, order_total_amount_due, payment_id,
        order_comment, order_status_id, client_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $inserted = execute_query(
        $conn,
        $sql,
        "ssddddddssii",
        $user_id,
        $order_due,
        $order_total_before_tax,
        $order_total_tax,
        $order_tax_per,
        $order_total_after_tax,
        $order_amount_paid,
        $order_total_amount_due,
        $payment_id,
        $order_comment,
        $order_status_id,
        $client_id
    );
    if (!$inserted) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting new invoice.']);
        exit;
    }
    $order_id = mysqli_insert_id($conn);
}

// === ORDER ITEMS ===
$all_items_inserted = true;
$sql_item = "INSERT INTO invoice_order_item (
    order_id, item_code, details, order_size_width, order_size_height,
    order_item_quantity, order_item_price, order_item_final_amount
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

foreach ($items as $item) {
    $item_code = $item['item_code'] ?? '';
    $details = $item['details'] ?? '';
    $order_size_width = floatval($item['order_size_width'] ?? 0);
    $order_size_height = floatval($item['order_size_height'] ?? 0);
    $order_item_quantity = intval($item['order_item_quantity'] ?? 0);
    $order_item_price = floatval($item['order_item_price'] ?? 0);
    $order_item_final_amount = floatval($item['order_item_final_amount'] ?? 0);

    $inserted = execute_query(
        $conn,
        $sql_item,
        "issddidd",
        $order_id,
        $item_code,
        $details,
        $order_size_width,
        $order_size_height,
        $order_item_quantity,
        $order_item_price,
        $order_item_final_amount
    );

    if (!$inserted) {
        $all_items_inserted = false;
        break;
    }
}

// Flush any captured output (in case of warnings)
$output = ob_get_clean();
if (!empty($output)) {
    echo json_encode(['status' => 'error', 'message' => 'Unexpected output: ' . $output]);
    exit;
}

if ($all_items_inserted) {
    echo json_encode(['status' => 'success', 'message' => 'Invoice saved successfully.', 'order_id' => $order_id]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error inserting invoice items.']);
}

mysqli_close($conn);
