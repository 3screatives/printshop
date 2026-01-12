<?php
session_start();

$key = $_POST['key'] ?? '';
$qty = max(1, intval($_POST['qty'] ?? 1));

if ($key && isset($_SESSION['cart'][$key])) {
    $unitPrice = floatval($_SESSION['cart'][$key]['unit_price'] ?? 0);
    $_SESSION['cart'][$key]['quantity'] = $qty;
    $_SESSION['cart'][$key]['total_price'] = round($unitPrice * $qty, 2);
}

echo json_encode(['success' => true]);
