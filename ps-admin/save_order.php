<?php
require_once 'db_function.php';
$conn = db_connect();

$order_date = $_POST['order_date'];
$order_due = $_POST['order_due'];
$client_name = $_POST['client_name'];
$client_address = $_POST['client_address'];
$client_phone = $_POST['client_phone'];
$client_email = $_POST['client_email'];

$material_ids = $_POST['material_ids'];
$details = $_POST['details'];
$widths = $_POST['widths'];
$heights = $_POST['heights'];
$quantities = $_POST['quantities'];
$prices = $_POST['prices'];
$totals = $_POST['totals'];

// Step 1: Insert Client (or get existing client_id)
$client_sql = "INSERT INTO ps_clients (client_name, client_address, client_phone, client_email)
               VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $client_sql);
mysqli_stmt_bind_param($stmt, "ssss", $client_name, $client_address, $client_phone, $client_email);
mysqli_stmt_execute($stmt);
$client_id = mysqli_insert_id($conn);

// Step 2: Insert Order
$order_sql = "INSERT INTO ps_orders (order_date, order_due, user_id, client_id)
              VALUES (?, ?, 1, ?)";
$stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($stmt, "ssi", $order_date, $order_due, $client_id);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($conn);

// Step 3: Insert Items
$item_sql = "INSERT INTO ps_order_items (order_id, material_id, item_details, item_quantity, item_size_width, item_size_height, item_price, item_total)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $item_sql);

foreach ($material_ids as $i => $mat_id) {
    $d = $details[$i];
    $w = $widths[$i];
    $h = $heights[$i];
    $q = $quantities[$i];
    $p = $prices[$i];
    $t = $totals[$i];

    mysqli_stmt_bind_param($stmt, "iisidddd", $order_id, $mat_id, $d, $q, $w, $h, $p, $t);
    mysqli_stmt_execute($stmt);
}

echo json_encode(['status' => 'success', 'message' => 'Order saved successfully']);
?>