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
                <th style='width:136px'></th>
                <th>Product</th>
                <th style='width:136px' class='text-center'>Price</th>
                <th style='width:136px' class='text-center'>Qty</th>
                <th style='width:196px' class='text-center'>Sub Total</th>
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
        $orientation        = (int)($item['orientation'] ?? 0);
        $grommets           = (int)($item['grommets'] ?? 0);
        $hframes            = (int)($item['hframes'] ?? 0);
        $sides              = (int)($item['sides'] ?? 0);
        $process_time       = (int)($item['process_time'] ?? 0);

        $orientation_label = ($orientation === 1) ? 'Horizontal' : 'Portrait';
        $sides_label = ($sides === 1) ? 'Double Sided' : 'Single Sided';
        $grommets_label = ($grommets === 1) ? 'With Grommets' : 'No Grommets';
        $hframes_label = ($hframes === 1) ? 'With H-Frame' : 'No H-Frame';
        $process_label = ($process_time === 1) ? 'Rush (1-2 days)' : 'Standard (3-5 days)';

        $itemCount  += $qty;
        $grandTotal += $sub_total;

        $taxRate = 0.0825;
        $taxAmt  = $grandTotal * $taxRate;
        $total   = $grandTotal + $taxAmt;

        $html .= "
            <tr>
                <td class='text-center px-2 py-2'>
                    <button class='btn btn-outline-danger btn-sm me-2 remove-item' data-key='{$key}' style='color: var(--color-red)'>
                        <span class='bi bi-trash'></span>
                    </button>
                    <button class='btn btn-outline-primary btn-sm me-2 edit-item' data-key='{$key}' style='color: var(--color-blue)'>
                        <span class='bi bi-pencil'></span>
                    </button>
                </td>

                <td class='py-4'>
                    <strong class='fs-4 thm-link blue'>{$cat_name}</strong>
                    <div class='pt-3'>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Size:</span>{$width}x{$height}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Orientation:</span>{$orientation_label}
                        </div>
                        <div class='d-flex'>
                            <span class='fw-bold me-2'>Sides:</span>{$sides_label}
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

                <td class='text-center px-3 py-2'>
                    $" . number_format($unit_price, 2) . "
                </td>

                <td class='text-center px-2 py-1'>
                    <span><b>{$qty}</b></span>
                </td>

                <td class='text-center px-3 py-2'>
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
    'sub_total' => number_format($grandTotal, 2),
    'tax' => number_format($taxAmt, 2),
    'total' => number_format($total, 2),
    'count' => $itemCount,
    'catName' => $cat_name
]);
