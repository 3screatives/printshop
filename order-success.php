<?php
session_start();
require 'ps-admin/db_function.php';

$conn = db_connect();

// Get order_id from GET
$order_id = intval($_GET['order_id'] ?? 0);
if (!$order_id) {
    die("Invalid order ID.");
}

// --- 1. Fetch order info ---
$order = select_query($conn, "SELECT o.*, c.contact_name, c.contact_email, c.contact_phone, c.business_name 
                              FROM ps_orders o
                              JOIN ps_clients c ON o.client_id = c.client_id
                              WHERE o.order_id = ?", "i", $order_id);

if (!$order) {
    die("Order not found.");
}

$order = $order[0];

// --- 2. Fetch order items ---
$items = select_query($conn, "SELECT * FROM ps_order_items WHERE order_id = ?", "i", $order_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order #<?= $order_id ?> - Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container my-5">

        <div class="text-center mb-4">
            <h2>Thank You for Your Order!</h2>
            <p>Order #<strong><?= $order_id ?></strong> placed on <?= date("M d, Y", strtotime($order['order_date'])) ?></p>
        </div>

        <!-- Client Info -->
        <div class="card mb-4">
            <div class="card-header"><strong>Billing Information</strong></div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= htmlspecialchars($order['contact_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['contact_email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($order['contact_phone']) ?></p>
                <p><strong>Company:</strong> <?= htmlspecialchars($order['business_name']) ?></p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header"><strong>Order Items</strong></div>
            <div class="card-body">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($items as $item):
                            $details = json_decode($item['item_details'], true);
                        ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($details['cat_name'] ?? '') ?></strong><br>
                                    Size: <?= $item['item_size_width'] ?> x <?= $item['item_size_height'] ?><br>
                                    Orientation: <?= ($details['orientation'] ?? 0) ? 'Horizontal' : 'Portrait' ?><br>
                                    Sides: <?= ($details['sides'] ?? 0) ? 'Double' : 'Single' ?><br>
                                    H-Frames: <?= ($details['hframes'] ?? 0) ? 'Yes' : 'No' ?><br>
                                    Grommets: <?= $item['item_grommets'] ? 'Yes' : 'No' ?><br>
                                    Design: <?= $item['item_is_design'] ? 'Yes' : 'No' ?>
                                </td>
                                <td class="text-center"><?= $item['item_quantity'] ?></td>
                                <td class="text-center">$<?= number_format($item['item_price'], 2) ?></td>
                                <td class="text-center">$<?= number_format($item['item_total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals -->
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Subtotal:</strong> $<?= number_format($order['order_before_tax'], 2) ?></p>
                <p><strong>Tax:</strong> $<?= number_format($order['order_tax'], 2) ?></p>
                <p><strong>Grand Total:</strong> $<?= number_format($order['order_after_tax'], 2) ?></p>
                <p><strong>Rush:</strong> <?= $order['order_production_time'] ? 'Yes' : 'No' ?></p>
            </div>
        </div>

        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            <button onclick="window.print()" class="btn btn-secondary">Print Receipt</button>
        </div>
    </div>
</body>

</html>