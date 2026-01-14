<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
$grandTotal = 0;
$itemCount  = 0;
$html       = '';

if (!$cart) {

    $html = "<p class='text-muted text-center my-3'>Your cart is empty.</p>";
} else {

    $html .= "
    <table class='table table-sm align-middle cart-table'>
        <thead class='table-light'>
            <tr>
                <th style='width:40px'></th>
                <th>Product</th>
                <th class='text-end'>Price</th>
                <th style='width:80px' class='text-center'>Qty</th>
                <th class='text-end'>Sub Total</th>
            </tr>
        </thead>
        <tbody>
    ";

    foreach ($cart as $item) {
        $key         = $item['key'] ?? '';
        $material_id = $item['material_id'] ?? 0;
        $cat_name    = $item['cat_name'];
        $qty         = intval($item['quantity'] ?? 1);
        $unit_price  = floatval($item['unit_price'] ?? 0);
        $sub_total   = floatval($item['total_price'] ?? 0);

        $itemCount  += $qty;
        $grandTotal += $sub_total;

        $html .= "
        <tr>
            <td class='text-center'>
                <button class='btn btn-sm btn-danger remove-item' data-key='{$key}'>✕</button>
            </td>

            <td>
                <!-- <strong>Material #{$material_id}</strong> -->
                {$cat_name}
            </td>

            <td class='text-end'>
                $" . number_format($unit_price, 2) . "
            </td>

            <td class='text-center'>
                <input type='number'
                       class='form-control form-control-sm text-center cart-qty'
                       value='{$qty}'
                       min='1'
                       data-key='{$key}'>
            </td>

            <td class='text-end'>
                $" . number_format($sub_total, 2) . "
            </td>
        </tr>
        ";
    }

    $html .= "
        </tbody>
    </table>
    ";
}

// Return JSON
echo json_encode([
    'html'  => $html,
    'total' => number_format($grandTotal, 2),
    'count' => $itemCount,
    'catName' => $cat_name
]);