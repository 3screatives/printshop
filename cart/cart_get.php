<?php
session_start();

$rushSelected = $_SESSION['rush'] ?? 0;
$cart = $_SESSION['cart'] ?? [];

$grandTotal = 0;
$itemCount  = 0;
$html       = '';

$taxRate = 0.0825;
$rushCharge = 0;
$taxAmt = 0;
$total = 0;

if (empty($cart)) {

    $html = "<tr>
                <td colspan='5' class='text-center text-muted py-4'>
                    Your cart is empty.
                </td>
             </tr>";
} else {

    foreach ($cart as $item) {

        $mat_type = $item['mat_type'] ?? 'None';

        $key         = $item['key'];
        $cat_name    = $item['cat_name'];
        $qty         = (int)$item['quantity'];
        $unit_price  = (float)$item['unit_price'];
        $sub_total   = (float)$item['total_price'];
        $width       = (float)$item['width'];
        $height      = (float)$item['height'];

        $item_size   = $item['item_size'];
        $orientation = (int)$item['orientation'];
        $grommets    = (int)$item['grommets'];
        $hframes     = (int)$item['hframes'];
        $sides       = (int)$item['sides'];

        $orientation_label = $orientation ? 'Horizontal' : 'Portrait';
        $sides_label       = $sides ? 'Double Sided' : 'Single Sided';
        $grommets_label    = $grommets ? 'With Grommets' : 'No Grommets';
        $hframes_label     = $hframes ? 'With H-Frame' : 'No H-Frame';

        $itemCount  += $qty;
        $grandTotal += $sub_total;

        $optionsText = $sides_label;

        if ($mat_type !== 'digital') {
            $optionsText .= ", {$grommets_label}, {$hframes_label}";
        }
        $sizeText = ($mat_type === 'digital')
            ? "{$item_size}"
            : "{$width} × {$height}";

        $html .= "
        <tr>
            <td class='text-center'>
                <button class='btn btn-outline-danger btn-sm remove-item' data-key='{$key}'>
                    <i class='bi bi-trash'></i>
                </button>
            </td>

            <td>
                <strong>{$cat_name}</strong>
                <div class='small text-muted'>
                    {$sizeText} • {$orientation_label}<br>
                    {$optionsText}
                </div>
            </td>

            <td class='text-center'>$" . number_format($unit_price, 2) . "</td>
            <td class='text-center'>{$qty}</td>
            <td class='text-center'>$" . number_format($sub_total, 2) . "</td>
        </tr>";
    }

    /* ===== TOTALS ===== */
    if ($rushSelected == 1) {
        $rushCharge = max(15, $grandTotal * 0.3);
    }

    $taxableTotal = $grandTotal + $rushCharge;
    $taxAmt = $taxableTotal * $taxRate;
    $total  = $taxableTotal + $taxAmt;
}

echo json_encode([
    'html'      => $html,
    'sub_total' => number_format($grandTotal, 2),
    'rush'      => number_format($rushCharge, 2),
    'tax'       => number_format($taxAmt, 2),
    'total'     => number_format($total, 2),
    'count'     => $itemCount,
    'items'     => array_values($cart) // IMPORTANT for checkout
]);