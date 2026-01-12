<?php
session_start();
include 'ps-admin/db_function.php';
$conn = db_connect();

$mat_id = intval($_POST['mat_id']);
$qty = intval($_POST['item_qty']) ?: 1;
$width = floatval($_POST['width']);
$height = floatval($_POST['height']);
$grommets = intval($_POST['item_grommets']) ?: 0;
$hframes = intval($_POST['item_hframes']) ?: 0;
$sides = intval($_POST['item_sides']) ?: 0;
$has_design = intval($_POST['have_design']) ?: 0;
$unit_price = floatval($_POST['unit_price']);
$total_price = floatval($_POST['total_price']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Create a unique key for identical items (same material + options)
$item_key = $mat_id . '_' . $width . 'x' . $height . '_' . $grommets . '_' . $hframes . '_' . $sides . '_' . $has_design;

if (isset($_SESSION['cart'][$item_key])) {
    $_SESSION['cart'][$item_key]['quantity'] += $qty;
    $_SESSION['cart'][$item_key]['total_price'] += $total_price;
} else {
    $_SESSION['cart'][$item_key] = [
        'material_id' => $mat_id,
        'quantity' => $qty,
        'width' => $width,
        'height' => $height,
        'grommets' => $grommets,
        'hframes' => $hframes,
        'sides' => $sides,
        'has_design' => $has_design,
        'unit_price' => $unit_price,
        'total_price' => $total_price
    ];
}

// Return updated cart summary
$totalItems = 0;
$totalAmount = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalItems += $item['quantity'];
    $totalAmount += $item['total_price'];
}

echo json_encode([
    'items' => $totalItems,
    'total' => number_format($totalAmount, 2)
]);
