<?php
include '../ps-admin/config.php';
include '../include/head.php';

$client_id = intval($_SESSION['client_id'] ?? 0);

if ($client_id <= 0) {
    header("Location: login.php");
    exit;
}

$orders = select_query(
    $conn,
    "SELECT 
        o.order_id,
        o.order_date,
        o.order_completed,
        o.order_after_tax,
        o.order_amount_due,
        s.status_id,
        s.status_name,
        s.status_color
     FROM ps_orders o
     JOIN ps_status s ON o.status_id = s.status_id
     WHERE o.client_id = ?
     ORDER BY o.order_date DESC",
    "i",
    $client_id
);

include '../include/header.php';
?>

<section class="my-cart" style="min-height: 50vh; padding-bottom: 96px;">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>
                Dashboard
            </div>

            <h2>Dashboard</h2>
        </div>
    </div>
    <div class="container">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Amount Due</th>
                    <th>Status</th>
                    <th>Completed on</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= (int)$order['order_id'] ?></td>
                            <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                            <!-- <td>
                        <?= $order['order_due']
                            ? date('M d, Y', strtotime($order['order_due']))
                            : '-' ?>
                    </td> -->
                            <td>$<?= number_format($order['order_after_tax'], 2) ?></td>
                            <td>$<?= number_format($order['order_amount_due'], 2) ?></td>
                            <td class="p-2">
                                <span style="
                                    display: block;
                                    width: 100%;
                                    height: 100%;
                                    background-color: <?= htmlspecialchars($order['status_color']) ?>;
                                    color: #000;
                                    padding: 8px;
                                    text-align: center;
                                    font-weight: 500;
                                ">
                                    <?= htmlspecialchars($order['status_name']) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($order['order_completed'])) ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary view-order-btn"
                                    data-order-id="<?= (int)$order['order_id'] ?>" data-bs-toggle="modal"
                                    data-bs-target="#orderModal">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            No orders found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
include 'order_view.php';
include '../include/footer.php';
?>