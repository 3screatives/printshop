<?php
require_once 'db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

$sql = "SELECT m.mat_id, m.mat_name, c.cat_name 
        FROM ps_materials m
        LEFT JOIN ps_material_categories c ON m.cat_id = c.cat_id
        ORDER BY m.mat_name";

$materials = select_query($conn, $sql);

$data = [];
foreach ($materials as $row) {
    $data[] = [
        'id' => $row['mat_id'],
        'name' => $row['mat_name'],
        'category' => $row['cat_name'] ?? 'Uncategorized'
    ];
}

echo json_encode($data);