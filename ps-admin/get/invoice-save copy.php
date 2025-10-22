<?php
// Start output buffering to capture any unexpected output
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log'); // Logs will go here

// Set JSON response header
header('Content-Type: application/json');

// Include DB connection
include('include/conn.php');

// Sanitize common input
$user_id = mysqli_real_escape_string($conn, $_POST['user_id'] ?? '');
$order_id = intval($_POST['order_id'] ?? 0);

$order_receiver_name = mysqli_real_escape_string($conn, $_POST['order_receiver_name'] ?? '');
$order_receiver_address = mysqli_real_escape_string($conn, $_POST['order_receiver_address'] ?? '');
$order_receiver_phone = mysqli_real_escape_string($conn, $_POST['order_receiver_phone'] ?? '');
$order_receiver_email = mysqli_real_escape_string($conn, $_POST['order_receiver_email'] ?? '');

$order_total_before_tax = mysqli_real_escape_string($conn, $_POST['order_total_before_tax'] ?? '0');
$order_total_tax = mysqli_real_escape_string($conn, $_POST['order_total_tax'] ?? '0');
$order_tax_per = mysqli_real_escape_string($conn, $_POST['order_tax_per'] ?? '0');
$order_total_after_tax = mysqli_real_escape_string($conn, $_POST['order_total_after_tax'] ?? '0');
$order_amount_paid = mysqli_real_escape_string($conn, $_POST['order_amount_paid'] ?? '0');
$order_total_amount_due = mysqli_real_escape_string($conn, $_POST['order_total_amount_due'] ?? '0');
// $order_due = mysqli_real_escape_string($conn, $_POST['order_due'] ?? '');

// Get raw POST value
$order_due_raw = $_POST['order_due'] ?? '';

$order_due_date = DateTime::createFromFormat('Y-m-d', $order_due_raw);

if ($order_due_date && $order_due_date->format('Y-m-d') === $order_due_raw) {
    $order_due = mysqli_real_escape_string($conn, $order_due_date->format('Y-m-d'));
} else {
    $order_due = null;
}

$payment_id = mysqli_real_escape_string($conn, $_POST['payment_id'] ?? '');
$order_status_id = mysqli_real_escape_string($conn, $_POST['order_status'] ?? 1);
$order_comment = 'Thank you for your business.';
$items = $_POST['items'] ?? [];

$client_id = mysqli_real_escape_string($conn, $_POST['client_id'] ?? '0');

if ($client_id > 0) {
    $query_update_client = "UPDATE invoice_client SET 
                client_name = '$order_receiver_name',
                client_address = '$order_receiver_address',
                client_phone = '$order_receiver_phone',
                client_email = '$order_receiver_email'
                WHERE client_id = $client_id";

    $update_result = mysqli_query($conn, $query_update_client);

    if (!$update_result) {
        echo json_encode(['status' => 'error', 'message' => 'Update failed: ' . mysqli_error($conn)]);
        exit;
    }
} else {
    $query_insert_client = "INSERT INTO invoice_client (client_name, client_address, client_phone, client_email)
                            VALUES ('$order_receiver_name', '$order_receiver_address', '$order_receiver_phone', '$order_receiver_email')";
    if (mysqli_query($conn, $query_insert_client)) {
        $client_id = mysqli_insert_id($conn);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting client: ' . mysqli_error($conn)]);
        exit;
    }
}

if ($order_id > 0) {
    // Update existing invoice
    $query_update_order = "UPDATE invoice_order SET 
        user_id = '$user_id',
        order_due = '$order_due',
        order_total_before_tax = '$order_total_before_tax',
        order_total_tax = '$order_total_tax',
        order_tax_per = '$order_tax_per',
        order_total_after_tax = '$order_total_after_tax',
        order_amount_paid = '$order_amount_paid',
        order_total_amount_due = '$order_total_amount_due',
        payment_id = '$payment_id',
        order_comment = '$order_comment',
        order_status_id = '$order_status_id',
        client_id = '$client_id'
        WHERE order_id = $order_id";

    if (!mysqli_query($conn, $query_update_order)) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating invoice: ' . mysqli_error($conn)]);
        exit;
    }

    // Delete old items
    mysqli_query($conn, "DELETE FROM invoice_order_item WHERE order_id = $order_id");
} else {
    // Insert new invoice
    $query_insert_order = "INSERT INTO invoice_order (
        user_id, order_due, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax,
        order_amount_paid, order_total_amount_due, payment_id, order_comment, order_status_id, client_id
    ) VALUES (
        '$user_id', '$order_due', '$order_total_before_tax', '$order_total_tax', '$order_tax_per', '$order_total_after_tax',
        '$order_amount_paid', '$order_total_amount_due', '$payment_id', '$order_comment', '$order_status_id', '$client_id'
    )";

    if (!mysqli_query($conn, $query_insert_order)) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting new invoice: ' . mysqli_error($conn)]);
        exit;
    }

    $order_id = mysqli_insert_id($conn);
}

// Insert items
$all_items_inserted = true;

foreach ($items as $item) {
    $item_code = mysqli_real_escape_string($conn, $item['item_code'] ?? '');
    $details = mysqli_real_escape_string($conn, $item['details'] ?? '');
    $order_size_width = mysqli_real_escape_string($conn, $item['order_size_width'] ?? '0');
    $order_size_height = mysqli_real_escape_string($conn, $item['order_size_height'] ?? '0');
    $order_item_quantity = mysqli_real_escape_string($conn, $item['order_item_quantity'] ?? '0');
    $order_item_price = mysqli_real_escape_string($conn, $item['order_item_price'] ?? '0');
    $order_item_final_amount = mysqli_real_escape_string($conn, $item['order_item_final_amount'] ?? '0');

    $query_insert_item = "INSERT INTO invoice_order_item (
        order_id, item_code, details, order_size_width, order_size_height,
        order_item_quantity, order_item_price, order_item_final_amount
    ) VALUES (
        '$order_id', '$item_code', '$details', '$order_size_width', '$order_size_height',
        '$order_item_quantity', '$order_item_price', '$order_item_final_amount'
    )";

    if (!mysqli_query($conn, $query_insert_item)) {
        $all_items_inserted = false;
        break;
    }
}

// Check for unexpected output (e.g., PHP warnings)
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
