<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --------------------------
    // INPUT VALUES
    // --------------------------
    $material_id = intval($_POST['material_id']);
    $width       = floatval($_POST['width']);
    $height      = floatval($_POST['height']);
    $sides       = $_POST['sides'] ?? "single";

    // --------------------------
    // FETCH MATERIAL DATA
    // --------------------------
    $sql = "SELECT mat_id, mat_vendor, mat_name, mat_details, mat_roll_size,
                   mat_length, mat_size, mat_cost, mat_cost_multiplier, ink_cost, mat_added_on
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

    $mat = $materials[0];

    // Material fields
    $mat_name      = $mat['mat_name'];
    $roll_width    = floatval($mat['mat_roll_size']);  // e.g., 60"
    $mat_size      = floatval($mat['mat_size']);       // total length per cost
    $mat_cost      = floatval($mat['mat_cost']);       // cost per mat_size
    $ink_cost      = floatval($mat['ink_cost']);

    $mat_cost_multiplier = floatval($mat['mat_cost_multiplier']);
    $mat_cost = $mat_cost * $mat_cost_multiplier;   // <-- APPLY MULTIPLIER

    // System constants
    $running_cost  = 0.4;
    $markup_factor = 3.0;

    // --------------------------
    // PRINT SIZE LOGIC
    // --------------------------
    $short_side = min($width, $height);   // must fit roll width
    $long_side  = max($width, $height);   // linear length used for cost

    // If the print cannot fit the roll → cost = 0
    if ($short_side > $roll_width) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Print size exceeds roll width. Cannot print.</p>"
        ]);
        exit;
    }

    // Use the long dimension for linear material cost
    $linear_inches_used = $long_side;

    // --------------------------
    // MATERIAL COST
    // --------------------------
    $material_cost_per_inch = $mat_cost / $mat_size;
    $material_cost_total = $material_cost_per_inch * $linear_inches_used;

    // --------------------------
    // INK COST
    // --------------------------
    $ink_multiplier = ($sides === "double") ? 2 : 1;
    $ink_cost_total = $ink_cost * ($width * $height) * $ink_multiplier;

    // --------------------------
    // TOTAL COST
    // --------------------------
    $cost_before_markup = $material_cost_total + $ink_cost_total + $running_cost;
    $total_cost = $cost_before_markup * $markup_factor;

    // Round final cost
    $final_cost = ceil($total_cost);

    // --------------------------
    // OUTPUT
    // --------------------------
    echo json_encode([
        "final_cost"        => round($final_cost, 2),
        "material_per_inch" => round($material_cost_per_inch, 4),
        "material_total"    => round($material_cost_total, 4),
        "ink_cost_total"    => round($ink_cost_total, 4),
        "cost_before_markup" => round($cost_before_markup, 4),
        "total_cost"        => round($total_cost, 4),
        "final_price"       => number_format($final_cost, 2),
        "debug" => [
            "roll_width" => $roll_width,
            "linear_inches_used" => $linear_inches_used
        ]
    ]);
}
