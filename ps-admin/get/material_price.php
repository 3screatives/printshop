<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id     = intval($_POST['material_id']);
    $width           = floatval($_POST['width']);
    $height          = floatval($_POST['height']);
    $quantity        = intval($_POST['quantity']);
    $sides           = $_POST['sides'] ?? "single";

    // ✅ Get material data using select_query()
    $sql = "SELECT mat_id, mat_vendor, mat_name, mat_details, mat_roll_size, mat_length, 
                   mat_size, mat_cost, ink_cost, mat_added_on
            FROM ps_materials 
            WHERE mat_id = ?";
    $materials = select_query($conn, $sql, "i", $material_id);

    if (empty($materials)) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Invalid material selected.</p>"
        ]);
        exit;
    }

    $mat = $materials[0]; // Single material row

    // Extract values for readability
    $mat_name       = $mat['mat_name'];
    $mat_size       = $mat['mat_size'];
    $mat_roll_size  = $mat['mat_roll_size'];
    $mat_cost       = $mat['mat_cost'];
    $ink_cost       = $mat['ink_cost'];

    $min_print_size = min($width, $height);
    $max_print_size = max($width, $height);

    if ($min_print_size > $mat_roll_size) {
        $min_size = 0;
    } elseif ($max_print_size <= $mat_roll_size) {
        $min_size = $min_print_size;
    } else {
        $min_size = $max_print_size;
    }

    $mat_cost_per_linear_inch = $mat_cost / $mat_size;
    $mat_cost_total = $mat_cost_per_linear_inch * $min_size;

    $ink_multiplier = ($sides === "double") ? 2 : 1;
    $ink_cost_total = $ink_cost * ($width * $height) * $ink_multiplier;

    echo json_encode([
        "mat_cost"   => round(($mat_cost_total), 2),
        "ink_cost"   => round(($ink_cost_total), 2),
        "mat_name"      => $mat_name,
        "width"         => $width,
        "height"        => $height,
        "quantity"      => $quantity
    ]);
}
