<?php
header('Content-Type: application/json');
require_once '../db_function.php';

$conn = db_connect();

$sql = "
    SELECT 
        o.order_id,
        o.order_date,
        o.order_due,
        o.order_after_tax,
        c.business_name AS client_name,
        c.contact_name AS contact_name,
        c.contact_phone,
        s.status_name,
        s.status_id,
        GROUP_CONCAT(m.mat_name SEPARATOR ', ') AS materials
    FROM ps_orders AS o
    LEFT JOIN ps_clients AS c ON o.client_id = c.client_id
    LEFT JOIN ps_status AS s ON o.status_id = s.status_id
    LEFT JOIN ps_order_items AS oi ON oi.order_id = o.order_id
    LEFT JOIN ps_materials AS m ON m.mat_id = oi.material_id
    GROUP BY o.order_id
    ORDER BY o.order_id DESC
";

$orders = select_query($conn, $sql);

echo json_encode(["orders" => $orders]);

mysqli_close($conn);
