<?php
require_once 'db_function.php';

header("Content-Type: application/json");

$conn = db_connect();

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$sql = "
SELECT 
    o.order_id,
    o.order_due,
    o.order_after_tax,
    c.client_name,
    s.status_name
FROM ps_orders o
JOIN ps_clients c ON o.client_id = c.client_id
JOIN ps_status s ON o.status_id = s.status_id
ORDER BY o.order_date DESC
";

$data = select_query($conn, $sql); // No need for parameter
echo json_encode(['orders' => $data]);
