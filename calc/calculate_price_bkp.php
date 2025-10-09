<?php
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id     = intval($_POST['material_id']);
    $width           = floatval($_POST['width']);
    $height          = floatval($_POST['height']);
    $quantity        = intval($_POST['quantity']);
    // $sides           = $_POST['sides'] ?? "single";
    $sides        = isset($_POST['sides']) ? 1 : 0;
    $grommets        = isset($_POST['grommets']) ? 1 : 0;
    $production_time = floatval($_POST['production_time']); // percentage

    if ($material_id <= 0 || $width <= 0 || $height <= 0 || $quantity <= 0) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Please fill in all fields.</p>"
        ]);
        exit;
    }

    // Fixed costs
    $ink_cost     = 0.003700; // per sq.in
    $running_cost = 0.04; // per sq.in
    $markup       = 0.30; // 30%
    $grommet_cost = 3.00; // flat per piece if selected
    $hframe_cost = 3.00; // flat per piece if selected
    $aframe_cost = 80.00; // flat per piece if selected

    // Get material cost
    $sql = "SELECT name, cost_per_sq_in FROM materials WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $material_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $material_name, $material_cost);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$material_cost) {
        echo json_encode([
            "final_price" => "0.00",
            "breakdown"   => "<p>Invalid material selected.</p>"
        ]);
        exit;
    }

    // Calculate area
    $area = $width * $height;

    // Adjust ink cost if double-sided
    $ink_multiplier = ($sides === 1) ? 2 : 1;

    // Base cost per sq.in.
    $base_cost = $material_cost + ($ink_cost * $ink_multiplier) + $running_cost;

    // Total before markup
    $total_cost = $base_cost * $area * $quantity;

    $breakdown  = "<ul>";
    $breakdown .= "<li>Material: {$material_name} @ $" . number_format($material_cost, 4) . "/sq.in</li>";
    $breakdown .= "<li>Ink Cost: $" . number_format($ink_cost * $ink_multiplier, 4) . "/sq.in (" . ucfirst($sides) . " Sided)</li>";
    $breakdown .= "<li>Running Cost: $" . number_format($running_cost, 4) . "/sq.in</li>";
    $breakdown .= "<li>Area: {$area} sq.in × {$quantity} pcs</li>";
    $breakdown .= "<li>Subtotal (before extras): $" . number_format($total_cost, 2) . "</li>";

    // Add grommets
    if ($grommets) {
        $grommet_total = $grommet_cost * $quantity;
        $total_cost += $grommet_total;
        $breakdown .= "<li>Grommets: +$" . number_format($grommet_total, 2) . "</li>";
    }

    // Apply markup
    $marked_up_cost = $total_cost * (1 + $markup);
    $breakdown .= "<li>+ Markup (20%): $" . number_format($marked_up_cost, 2) . "</li>";

    // Apply rush production surcharge
    $final_price = $marked_up_cost;
    if ($production_time > 0) {
        $surcharge = $final_price * $production_time;
        $final_price += $surcharge;
        $breakdown .= "<li>+ Rush Fee (" . ($production_time * 100) . "%): $" . number_format($surcharge, 2) . "</li>";
    }

    $breakdown .= "</ul>";

    echo json_encode([
        "final_price" => number_format($final_price, 2, '.', ''),
        "breakdown"   => $breakdown
    ]);
}
