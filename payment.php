<?php
session_start();

require_once 'ps-admin/config.php';

if (empty($_SESSION['cart'])) {
    http_response_code(400);
    exit('Cart is empty');
}

// ---- totals from your existing logic ----
$taxRate = 0.0825;
$rushSelected = $_SESSION['rush'] ?? 0;

$grandTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $grandTotal += (float)$item['total_price'];
}

$rushCharge = ($rushSelected == 1) ? max(15, $grandTotal * 0.3) : 0;
$taxable    = $grandTotal + $rushCharge;
$taxAmt     = $taxable * $taxRate;
$total      = round($taxable + $taxAmt, 2);

// Clover uses cents
$amountCents = (int) round($total * 100);

// ---- create order record (important) ----
$order_id = uniqid('ORD-');

$_SESSION['pending_order'] = [
    'order_id' => $order_id,
    'amount'   => $total
];

// ---- Clover Hosted Checkout ----
$payload = [
    'amount' => $amountCents,
    'currency' => 'USD',
    'redirectUrl' => 'payment_success.php',
    'cancelUrl'   => 'checkout.php',
    'externalReferenceId' => $order_id
];

$ch = curl_init("https://scl-sandbox.dev.clover.com/v1/checkouts");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer YOUR_CLOVER_ACCESS_TOKEN",
        "Content-Type: application/json"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!isset($data['checkoutUrl'])) {
    http_response_code(500);
    exit('Payment initialization failed');
}

// Redirect user to Clover
header("Location: " . $data['checkoutUrl']);
exit;
