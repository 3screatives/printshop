<?php
require_once '../ps-admin/db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id     = intval($_POST['material_id']);
    $width           = floatval($_POST['width']);
    $height          = floatval($_POST['height']);
    $quantity        = intval($_POST['quantity']);
    $sides           = $_POST['sides'] ?? "single";
    $grommets        = isset($_POST['grommets']) ? 1 : 0;
    $production_time = floatval($_POST['production_time']);
    $mem_type        = isset($_POST['mem_type']) ? intval($_POST['mem_type']) : 1;

    // Basic validation
    if ($material_id <= 0 || $width <= 0 || $height <= 0 || $quantity <= 0) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Please fill in all fields.</p>"
        ]);
        exit;
    }

    // Fixed costs
    $running_cost   = 0.04;
    $grommet_cost   = 3.00;
    $white_ink_diff = 0.0005;

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

    // ✅ Calculations
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

    $cost_per_print = $mat_cost_total + $ink_cost_total + $running_cost;

    // Membership markup
    switch ($mem_type) {
        case 1:
            $markup = 3.00;
            break; // Silver
        case 2:
            $markup = 4.00;
            break; // Gold
        default:
            $markup = 1.00;       // Regular
    }

    $total_cost = $cost_per_print * $markup;
    if ($grommets) $total_cost += $grommet_cost;

    $final_cost = ceil($total_cost) * $quantity;

    if ($production_time > 0) {
        $final_cost += $final_cost * $production_time;
    }

    // ✅ Breakdown
    $breakdown  = "<ul>";
    $breakdown .= "<li><b>Material:</b> {$mat_name}</li>";
    $breakdown .= "<li>Width × Height: {$width} × {$height} in</li>";
    $breakdown .= "<li>Roll Size Limit: {$mat_size} in</li>";
    $breakdown .= "<li>Min Effective Size: {$min_size} in</li>";
    $breakdown .= "<li>Material Cost/Linear Inch: $" . number_format($mat_cost_per_linear_inch, 4) . "</li>";
    $breakdown .= "<li>Material Total: $" . number_format($mat_cost_total, 2) . "</li>";
    $breakdown .= "<li>Ink Cost (" . ($sides === "double" ? "Double" : "Single") . "): $" . number_format($ink_cost_total, 2) . "</li>";
    $breakdown .= "<li>Printshop Running Cost: $" . number_format($running_cost, 2) . "</li>";
    $breakdown .= "<li>Markup Multiplier: ×" . number_format($markup, 2) . "</li>";
    if ($grommets) $breakdown .= "<li>Grommets: +$" . number_format($grommet_cost, 2) . "</li>";
    if ($production_time > 0) $breakdown .= "<li>Rush Surcharge: +" . ($production_time * 100) . "%</li>";
    $breakdown .= "<li>Quantity: {$quantity}</li>";
    $breakdown .= "</ul>";

    echo json_encode([
        "final_price" => number_format($final_cost, 2, '.', ''),
        "breakdown"   => $breakdown
    ]);
}
