<?php
header('Content-Type: application/json');
require_once '../db_function.php';

$conn = db_connect();

$sql = "
    SELECT 
        o.order_id,
        o.order_due,
        o.order_after_tax,
        c.business_name AS client_name,
        s.status_name,
        s.status_id
    FROM ps_orders AS o
    LEFT JOIN ps_clients AS c ON o.client_id = c.client_id
    LEFT JOIN ps_status AS s ON o.status_id = s.status_id
    ORDER BY o.order_id DESC
";

$orders = select_query($conn, $sql);

echo json_encode(["orders" => $orders]);

mysqli_close($conn);
