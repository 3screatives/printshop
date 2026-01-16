<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

$sql = "SELECT 
            m.mat_id, 
            m.mat_name, 
            GROUP_CONCAT(c.cat_name ORDER BY c.cat_name SEPARATOR ', ') AS categories
        FROM ps_materials m
        LEFT JOIN ps_material_categories_map mc ON m.mat_id = mc.mat_id
        LEFT JOIN ps_categories c ON mc.cat_id = c.cat_id
        GROUP BY m.mat_id
        ORDER BY m.mat_name";

$materials = select_query($conn, $sql);

$data = [];
foreach ($materials as $row) {
    $data[] = [
        'id' => $row['mat_id'],
        'name' => $row['mat_name'],
        'category' => $row['categories'] ?? 'Uncategorized'
    ];
}

echo json_encode($data);
