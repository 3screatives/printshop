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
    $quantity    = intval($_POST['quantity']);
    $is_cost_price = isset($_POST['is_cost_price']) ? (int)$_POST['is_cost_price'] : 0;

    // --------------------------
    // FETCH MATERIAL DATA
    // --------------------------
    $sql = "SELECT mat_id, mat_vendor, mat_name, mat_type, mat_details, mat_roll_size,
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
    // DIGITAL MATERIAL OVERRIDE
    // --------------------------
    if (strtolower($mat['mat_type']) === 'digital') {

        // $width  = floatval($_POST['width']);
        // $height = floatval($_POST['height']);
        // $quantity = intval($_POST['quantity']);

        $area_sq_in = $width * $height;
        $area_sq_ft = $area_sq_in / 144;

        $mat_cost_per_sq_ft = floatval($mat['mat_cost']);
        $ink_cost_per_sq_ft = floatval($mat['ink_cost']);

        $running_cost_per_sq_ft = 0.026;
        $markup_factor = 3.00;

        $base_cost_per_sq_ft =
            $mat_cost_per_sq_ft +
            $ink_cost_per_sq_ft +
            $running_cost_per_sq_ft;

        $total_cost =
            $base_cost_per_sq_ft *
            $area_sq_ft *
            $quantity *
            $markup_factor;

        $discount_rate = 0;
        if ($quantity >= 5000) {
            $discount_rate = 0.28;
        } elseif ($quantity >= 2500) {
            $discount_rate = 0.14;
        } elseif ($quantity >= 1000) {
            $discount_rate = 0.10;
        } elseif ($quantity >= 500) {
            $discount_rate = 0.06;
        }

        $final_cost = $total_cost - ($total_cost * $discount_rate);

        echo json_encode([
            "final_cost"   => round($final_cost, 2),
            "final_price"  => number_format($final_cost, 2),
            "sq_ft"        => round($area_sq_ft, 4),
            "unit_cost"    => round($base_cost_per_sq_ft, 4),
            "note"         => "Digital pricing calculated per square inch (converted to sq ft)"
        ]);
        exit;
    }

    // --------------------------
    // MATERIAL & INK DATA
    // --------------------------
    $roll_width           = floatval($mat['mat_roll_size']);        // inches
    $roll_length          = floatval($mat['mat_size']);             // inches
    $mat_cost             = floatval($mat['mat_cost']);             // cost for the roll_length
    $ink_cost_per_sq_in   = floatval($mat['ink_cost']);             // per sq in
    $mat_cost_multiplier  = floatval($mat['mat_cost_multiplier']);  // multiplier

    // Apply material multiplier
    $mat_cost = $mat_cost * $mat_cost_multiplier;

    // --------------------------
    // SYSTEM CONSTANTS
    // --------------------------
    $running_cost_per_sq_ft = 0.04;     // overhead/labor per sq ft
    $markup_factor          = 3.00;     // e.g. 3x for profit and overhead

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
    // $markup_amount = ($cost_before_markup * $markup_factor) - $cost_before_markup;
    // $total_cost = $cost_before_markup + $markup_amount;
    // $final_cost = ceil($total_cost);
    // --------------------------
    // MARKUP (SKIP IF COST PRICE)
    // --------------------------
    if ($is_cost_price == 1) {
        $markup_amount = 0;
        $total_cost = $cost_before_markup;
    } else {
        $markup_amount = ($cost_before_markup * $markup_factor) - $cost_before_markup;
        $total_cost = $cost_before_markup + $markup_amount;
    }
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
