<?php
session_start();
include 'ps-admin/config.php';

$rush = $_SESSION['rush'] ?? 0;

$standardSelected = ($rush == 0) ? 'selected' : '';
$rushSelectedAttr = ($rush == 1) ? 'selected' : '';

include 'include/head.php';
include 'include/header.php';
?>

<section class="my-cart" style="min-height: 50vh; padding-bottom: 96px;">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>
                My Cart
            </div>

            <h2>My Cart</h2>
        </div>
    </div>
    <div class="container">
        <table class='table table-sm align-middle cart-table'>
            <thead class='table-light'>
                <tr>
                    <th style='width:136px'></th>
                    <th>Image</th>
                    <th>Product</th>
                    <th style='width:136px' class='text-center'>Price</th>
                    <th style='width:136px' class='text-center'>Qty</th>
                    <th style='width:196px' class='text-center'>Sub Total</th>
                </tr>
            </thead>
            <tbody id="cart_container">
            </tbody>
        </table>
        <div class="row justify-content-end mb-3">
            <div class="col-5 py-3" style="background-color: var(--color-white);">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <label for="process_time" class="mb-0 fw-semibold text-nowrap">
                        Rush Printing?
                    </label>
                    <select class="form-select" name="process_time" id="process_time">
                        <option value="0" <?= $standardSelected ?>>Standard (3-5 days)</option>
                        <option value="1" <?= $rushSelectedAttr ?>>Rush (1-2 days)</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="cart_calc">
            <div class="row">
                <div class="col-5 offset-7" style="background-color: var(--color-white);">
                    <div class="mt-3">
                        <div class="text-end">
                            <div id="cart_totals">
                                <div class="d-flex justify-content-between py-2" style="min-width:220px;">
                                    <b>Sub Total:</b>
                                    <span id="cart_total_footer"></span>
                                </div>

                                <div id="rush_charges_row" class="d-flex justify-content-between py-2"
                                    style="min-width:220px;">
                                    <b>Rush Charges:</b>
                                    <span id="rush_charge_val"></span>
                                </div>

                                <div class="d-flex justify-content-between py-2" style="min-width:220px;">
                                    <b>Tax (8.25%):</b>
                                    <span id="cart_tax"></span>
                                </div>

                                <div class="d-flex justify-content-between fw-bold py-2" style="min-width:220px;">
                                    Grand Total:
                                    <span id="cart_total"></span>
                                </div>
                            </div>
                            <div class="my-3">
                                <a href="index.php" class="thm-btn gray me-2">
                                    <span>Continue Shopping</span>
                                </a>
                                <a href="checkout.php" class="thm-btn blue">
                                    <span>Proceed to Checkout</span>
                                </a>
                                <button id="clear_cart" class="thm-btn red ms-2">
                                    <span>Clear Cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php include 'include/footer.php'; ?>