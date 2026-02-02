<?php
include '../ps-admin/config.php';
include '../include/head.php';

if (
    !isset($_SESSION['client_user_id']) ||
    $_SESSION['client_user_type'] !== 'client'
) {
    header("Location: login.php");
    exit;
}

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
                    <!-- <th>Due Date</th> -->
                    <th>Total</th>
                    <th>Amount Due</th>
                    <th>Status</th>
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
                            <td>
                                <span class="badge bg-secondary">
                                    <?= $order['status_id'] ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="order_view.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">
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

<?php include '../include/footer.php'; ?>