<?php
session_start();
include 'ps-admin/config.php';

include 'include/head.php';
include 'include/header.php';
?>

<section class="my-cart" style="min-height: 50vh; padding-bottom: 96px;">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>
                Checkout
            </div>

            <h2>My Cart</h2>
        </div>
    </div>
    <div class="container">
        <p>Checkout</p>
        <a href="index.php" class="thm-btn gray me-2">
            <span>Continue Shopping</span>
        </a>
    </div>
</section>

<?php include 'include/footer.php'; ?>