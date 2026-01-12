<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
$grandTotal = 0;
$itemCount  = 0;
$html       = '';

if (!$cart) {
    $html = "<p>Your cart is empty.</p>";
} else {
    $html .= "<ul class='list-group'>";

    foreach ($cart as $item) {
        $key = $item['key'] ?? '';
        $material_id = $item['material_id'] ?? 0;
        $qty = intval($item['quantity'] ?? 0);
        $total_price = floatval($item['total_price'] ?? 0);

        $itemCount += $qty;
        $grandTotal += $total_price;

        $html .= "
        <li class='list-group-item d-flex justify-content-between align-items-center'>
            <div>
                <strong>Material #{$material_id}</strong>
                <div class='d-flex align-items-center mt-1 gap-2'>
                    <input type='number' class='form-control form-control-sm cart-qty'
                        value='{$qty}' min='1' data-key='{$key}' style='width:70px'>
                    <button class='btn btn-sm btn-danger remove-item' data-key='{$key}'>✕</button>
                </div>
            </div>
            <span>$" . number_format($total_price, 2) . "</span>
        </li>";
    }

    $html .= "</ul>";
}

// Return JSON
echo json_encode([
    'html'  => $html,
    'total' => number_format($grandTotal, 2),
    'count' => $itemCount
]);
