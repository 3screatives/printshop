<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --------------------------
    // INPUT VALUES
    // --------------------------
    $material_id = intval($_POST['material_id']);
    $width       = floatval($_POST['width']);   // inches
    $height      = floatval($_POST['height']);  // inches
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

    // --------------------------
    // MATERIAL & INK DATA
    // --------------------------
    $roll_width           = floatval($mat['mat_roll_size']);  // inches
    $roll_length          = floatval($mat['mat_size']);       // inches
    $mat_cost             = floatval($mat['mat_cost']);       // cost for the roll_length
    $ink_cost_per_sq_in   = floatval($mat['ink_cost']);       // per sq in
    $mat_cost_multiplier  = floatval($mat['mat_cost_multiplier']);

    // Apply material multiplier
    $mat_cost = $mat_cost * $mat_cost_multiplier;

    // --------------------------
    // SYSTEM CONSTANTS
    // --------------------------
    $running_cost_per_sq_ft = 0.04; // overhead/labor per sq ft
    $markup_factor          = 3.0; // e.g., 3x for profit and overhead

    // --------------------------
    // VALIDATION: FIT ROLL WIDTH
    // --------------------------
    $short_side = min($width, $height);
    if ($short_side > $roll_width) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Print size exceeds roll width. Cannot print.</p>"
        ]);
        exit;
    }

    // --------------------------
    // AREA CALCULATION
    // --------------------------
    $area_sq_in = $width * $height;
    $area_sq_ft = $area_sq_in / 144;

    // --------------------------
    // ROLL AREA (SQ FT)
    // --------------------------
    $roll_area_sq_ft = ($roll_width * $roll_length) / 144;

    // --------------------------
    // COST PER SQ FT
    // --------------------------
    $material_cost_per_sq_ft = $mat_cost / $roll_area_sq_ft;
    $ink_cost_per_sq_ft      = $ink_cost_per_sq_in * 144;
    $base_cost_per_sq_ft     = $material_cost_per_sq_ft + $ink_cost_per_sq_ft + $running_cost_per_sq_ft;

    // --------------------------
    // ADJUST INK FOR DOUBLE-SIDED
    // --------------------------
    $ink_multiplier = ($sides === "double") ? 2 : 1;
    $ink_cost_per_sq_ft_adjusted = $ink_cost_per_sq_ft * $ink_multiplier;
    $base_cost_per_sq_ft_adjusted = $material_cost_per_sq_ft + $ink_cost_per_sq_ft_adjusted + $running_cost_per_sq_ft;

    // --------------------------
    // TOTAL COST BEFORE MARKUP
    // --------------------------
    $cost_before_markup = $base_cost_per_sq_ft_adjusted * $area_sq_ft;
    $total_cost_sq_ft = $material_cost_per_sq_ft + $ink_cost_per_sq_ft_adjusted + $running_cost_per_sq_ft + $base_cost_per_sq_ft_adjusted;

    // --------------------------
    // MARKUP
    // --------------------------
    $markup_amount = ($cost_before_markup * $markup_factor) - $cost_before_markup;
    $total_cost = $cost_before_markup + $markup_amount;
    $final_cost = ceil($total_cost);

    // --------------------------
    // OUTPUT JSON
    // --------------------------
    echo json_encode([
        "final_cost"                 => round($final_cost, 2),
        "final_price"                => number_format($final_cost, 2),

        // Costs per sq ft
        "material_cost_per_sq_ft"    => round($material_cost_per_sq_ft, 4),
        "ink_cost_per_sq_ft"         => round($ink_cost_per_sq_ft_adjusted, 4),
        "running_cost_per_sq_ft"     => round($running_cost_per_sq_ft, 4),
        "base_cost_per_sq_ft"        => round($base_cost_per_sq_ft_adjusted, 4),
        "total_cost_sq_ft"           => round($total_cost_sq_ft, 4),

        // Totals
        "material_total"             => round($material_cost_per_sq_ft * $area_sq_ft, 4),
        "ink_cost_total"             => round($ink_cost_per_sq_ft_adjusted * $area_sq_ft, 4),
        "running_cost_total"         => round($running_cost_per_sq_ft * $area_sq_ft, 4),
        "cost_before_markup"         => round($cost_before_markup, 4),

        // Markup
        "markup_amount"              => round($markup_amount, 4),
        "total_cost_raw"             => round($total_cost, 4),

        // Area
        "area_sq_ft"                 => round($area_sq_ft, 4),

        // Debug
        "debug" => [
            "roll_width"      => $roll_width,
            "roll_length"     => $roll_length,
            "roll_area_sq_ft" => $roll_area_sq_ft,
            "area_sq_in"      => $area_sq_in
        ]
    ]);
}