<?php
session_start();

if (!isset($_GET['checkoutId'], $_SESSION['pending_order'])) {
    die('Invalid payment response');
}

// OPTIONAL but recommended:
// Verify payment via Clover API using checkoutId

$order = $_SESSION['pending_order'];

// TODO:
// - Update orders table: status = PAID
// - Store Clover checkoutId / paymentId
// - Clear cart

unset($_SESSION['cart'], $_SESSION['pending_order']);

header("Location: /thank-you.php");
exit;
