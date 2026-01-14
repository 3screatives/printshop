<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get POST data
$mat_id      = intval($_POST['mat_id'] ?? 0);
$catName     = isset($_POST['catName']) ? trim($_POST['catName']) : '';
$qty         = max(1, intval($_POST['item_qty'] ?? 1));
$width       = floatval($_POST['width'] ?? 0);
$height      = floatval($_POST['height'] ?? 0);
$grommets    = intval($_POST['item_grommets'] ?? 0);
$hframes     = intval($_POST['item_hframes'] ?? 0);
$sides       = intval($_POST['item_sides'] ?? 0);
$has_design  = intval($_POST['have_design'] ?? 0);
$unit_price  = floatval($_POST['unit_price'] ?? 0);
$total_price = floatval($_POST['total_price'] ?? ($unit_price * $qty));

if ($mat_id <= 0 || $unit_price <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid cart item']);
    exit;
}

// Unique key for this combination
$key = md5($mat_id . $width . $height . $grommets . $hframes . $sides . $has_design);

// Add or update cart item
if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['quantity'] += $qty;
    $_SESSION['cart'][$key]['total_price'] = $_SESSION['cart'][$key]['quantity'] * $unit_price;
} else {
    $_SESSION['cart'][$key] = [
        'key'         => $key,
        'material_id' => $mat_id,
        'cat_name'    => $catName,
        'width'       => $width,
        'height'      => $height,
        'grommets'    => $grommets,
        'hframes'     => $hframes,
        'sides'       => $sides,
        'has_design'  => $has_design,
        'unit_price'  => $unit_price,
        'quantity'    => $qty,
        'total_price' => $total_price
    ];
}

// Cart summary
$totalItems = 0;
$totalAmount = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalItems += $item['quantity'];
    $totalAmount += $item['total_price'];
}

echo json_encode([
    'items_count' => $totalItems,
    'total_amount' => number_format($totalAmount, 2),
    'cart' => array_values($_SESSION['cart'])
]);