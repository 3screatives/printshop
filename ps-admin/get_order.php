<?php
require_once 'db_function.php';

header("Content-Type: application/json");

$conn = db_connect();

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$sql = "
SELECT 
    o.order_id,
    o.order_date,
    o.order_due,
    o.order_before_tax,
    o.order_tax,
    o.order_after_tax,
    o.order_amount_paid,
    o.order_amount_due,
    o.order_comment,
    o.order_production_time,
    c.client_id,
    c.client_name,
    c.client_address,
    c.client_phone,
    c.client_email,
    c.client_stma_id,
    u.user_name,
    s.status_name,
    pt.payment_type,
    i.item_id,
    m.material_code,
    m.material_name,
    i.item_details,
    i.item_quantity,
    i.item_size_width,
    i.item_size_height,
    i.item_grommets,
    i.item_price,
    i.item_total
FROM ps_orders o
JOIN ps_clients c ON o.client_id = c.client_id
JOIN ps_users u ON o.user_id = u.user_id
JOIN ps_status s ON o.status_id = s.status_id
JOIN ps_payment_type pt ON o.payment_type_id = pt.payment_type_id
LEFT JOIN ps_order_items i ON o.order_id = i.order_id
LEFT JOIN ps_materials m ON i.material_id = m.material_id
WHERE o.order_id = ?
";

$data = select_query($conn, $sql, "i", $order_id);

$response = [];
if (!empty($data)) {
    $order = $data[0];
    $response['order'] = [
        "order_id" => $order['order_id'],
        "order_date" => $order['order_date'],
        "order_due" => $order['order_due'],
        "before_tax" => $order['order_before_tax'],
        "tax" => $order['order_tax'],
        "after_tax" => $order['order_after_tax'],
        "paid" => $order['order_amount_paid'],
        "due" => $order['order_amount_due'],
        "comment" => $order['order_comment'],
        "production_time" => $order['order_production_time'],
        "client_name" => $order['client_name'],
        "client_address" => $order['client_address'],
        "client_phone" => $order['client_phone'],
        "client_email" => $order['client_email'],
        "user_name" => $order['user_name'],
        "status_name" => $order['status_name'],
        "payment_type" => $order['payment_type'],
        "stmaID" => $order['client_stma_id'],
    ];

    $response['items'] = [];

    foreach ($data as $row) {
        if (!empty($row['item_id'])) {
            $response['items'][] = [
                "quantity" => $row['item_quantity'],
                "material" => $row['material_code'] . " - " . $row['material_name'],
                "details" => $row['item_details'],
                "size" => number_format($row['item_size_width'], 2) . " x " . number_format($row['item_size_height'], 2),
                "grommets" => $row['item_grommets'],
                "price" => "$" . number_format($row['item_total'], 2)
            ];
        }
    }
} else {
    $response['error'] = "Order not found";
}

echo json_encode($response);
