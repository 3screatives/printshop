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
                <th style='width:96px'></th>
                <th>Product</th>
                <th class='text-end'>Price</th>
                <th style='width:96px' class='text-center'>Qty</th>
                <th class='text-end'>Sub Total</th>
            </tr>
        </thead>
        <tbody>
    ";

    foreach ($cart as $item) {
        $key                = $item['key'] ?? '';
        $material_id        = $item['material_id'] ?? 0;
        $cat_name           = $item['cat_name'];
        $qty                = intval($item['quantity'] ?? 1);
        $unit_price         = floatval($item['unit_price'] ?? 0);
        $sub_total          = floatval($item['total_price'] ?? 0);
        $width              = floatval($item['width'] ?? 0);
        $height             = floatval($item['height'] ?? 0);
        $grommets           = floatval($item['grommets'] ?? 0);
        $hframes            = floatval($item['hframes'] ?? 0);
        $sides              = floatval($item['sides'] ?? 0);
        $process_time       = floatval($item['process_time'] ?? 1);

        $process_label = match ($process_time) {
            2       => 'Rush (1–2 days)',
            default => 'Standard (3–5 days)',
        };

        $side_label = match ($sides) {
            1       => 'Double Sided',
            default => 'Single Sided',
        };

        $grommets_label = match ($grommets) {
            1       => 'With Grommets',
            default => 'No Grommets',
        };

        $hframes_label = match ($hframes) {
            1       => 'With H-Frame',
            default => 'No H-Frame',
        };

        $itemCount  += $qty;
        $grandTotal += $sub_total;

        $html .= "
            <tr>
                <td class='text-center px-2 py-2'>
                    <button class='btn btn-sm btn-danger remove-item' data-key='{$key}'>✕</button>
                </td>

                <td class='px-3 py-2'>
                    <strong class='fs-4 thm-link blue'>{$cat_name}</strong>
                    <div class='ps-'>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Size:</span>{$width}x{$height}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Sides:</span>{$side_label}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Processing time:</span>{$process_label}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Grommets:</span>{$grommets_label}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>H-Frames:</span>{$hframes_label}
                        </div>
                    </div>
                </td>

                <td class='text-end px-3 py-2'>
                    $" . number_format($unit_price, 2) . "
                </td>

                <td class='text-center px-2 py-1'>
                    <input type='number'
                        class='form-control form-control-sm text-center cart-qty'
                        value='{$qty}'
                        min='1'
                        data-key='{$key}'>
                </td>

                <td class='text-end px-3 py-2'>
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
    'html' => $html,
    'total' => number_format($grandTotal, 2),
    'count' => $itemCount,
    'catName' => $cat_name
]);