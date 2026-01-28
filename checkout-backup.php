<?php
session_start();
require 'ps-admin/db_function.php';

$conn = db_connect();

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    die("Cart is empty!");
}

// --- 1. Get POST data ---
$client_name  = $_POST['client_name'] ?? '';
$client_email = $_POST['client_email'] ?? '';
$client_phone = $_POST['client_phone'] ?? '';
$business_name = $_POST['business_name'] ?? '';
$business_address = $_POST['business_address'] ?? '';
$total_after_tax = floatval($_POST['total_price'] ?? 0);
$rush_selected = intval($_POST['rush_selected'] ?? 0);
$order_date = date('Y-m-d');

// --- 2. Insert client (simplified, you can add check for existing email) ---
$sql = "INSERT INTO ps_clients 
        (business_name, business_address, contact_name, contact_email, contact_phone, client_username, client_password, client_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
$password = password_hash("default123", PASSWORD_DEFAULT);
execute_query($conn, $sql, "sssssss", $business_name, $business_address, $client_name, $client_email, $client_phone, $client_email, $password);
$client_id = mysqli_insert_id($conn);

// --- 3. Calculate subtotal and tax ---
$sub_total = 0;
foreach ($cart as $item) {
    $sub_total += floatval($item['total_price']);
}

$taxRate = 0.0825;
$taxAmt = ($sub_total + ($rush_selected ? $sub_total * 0.3 : 0)) * $taxRate;

// --- 4. Insert order ---
$sql_order = "INSERT INTO ps_orders 
(order_date, user_id, order_before_tax, order_tax, order_after_tax, order_production_time, client_id, status_id) 
VALUES (?, ?, ?, ?, ?, ?, ?, 1)";

$user_id = 0; // if logged in, set actual user_id
$production_time = $rush_selected ? 1 : 0;

execute_query($conn, $sql_order, "siddiii", $order_date, $user_id, $sub_total, $taxAmt, $total_after_tax, $production_time, $client_id);
$order_id = mysqli_insert_id($conn);

// --- 5. Insert order items ---
foreach ($cart as $item) {
    $sql_item = "INSERT INTO ps_order_items 
    (order_id, material_id, item_details, item_quantity, item_size_width, item_size_height, item_grommets, item_price, item_total, item_is_design) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $details = json_encode([
        'cat_name' => $item['cat_name'],
        'orientation' => $item['orientation'] ?? 0,
        'sides' => $item['sides'] ?? 0,
        'hframes' => $item['hframes'] ?? 0
    ]);

    execute_query(
        $conn,
        $sql_item,
        "iisiddiddi",
        $order_id,
        $item['material_id'],
        $details,
        intval($item['quantity']),
        floatval($item['width']),
        floatval($item['height']),
        intval($item['grommets'] ?? 0),
        floatval($item['unit_price']),
        floatval($item['total_price']),
        intval($item['have_design'] ?? 0)
    );
}

// --- 6. Clear cart ---
unset($_SESSION['cart']);

// --- 7. Redirect to success page ---
header("Location: order-success.php?order_id=$order_id");
exit;
