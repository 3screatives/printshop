<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id     = intval($_POST['material_id']);

    // ✅ Get material data using select_query()
    $sql = "SELECT * FROM ps_materials WHERE mat_id = ?";
    $materials = select_query($conn, $sql, "i", $material_id);

    $mat = $materials[0]; // Single material row

    // Extract values for readability
    $mat_name       = $mat['mat_name'];
    $mat_size       = $mat['mat_size'];
    $mat_roll_size  = $mat['mat_roll_size'];
    $mat_cost       = $mat['mat_cost'];
    $ink_cost       = $mat['ink_cost'];

    echo json_encode([
        "final_price" => round(($mat_cost + $ink_cost), 2),
        "mat_name"    => $mat_name
    ]);
}
