<?php
include 'ps-admin/db_function.php';
$conn = db_connect();

session_start();               // MUST be first
include 'include/head.php';
include 'include/header.php';
?>

<!-- <section class="cart-page">
    <div class="container">
        <div class="row">
            <div class="col-6 hero-head">
                <h2>My Cart</h2>
            </div>
        </div>
    </div>
</section> -->

<section class="my-cart" style="min-height: 50vh;">
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
    <div class="container" id="cart_container">
        <!-- Cart items will load here via AJAX -->
        <p>Loading cart...</p>
    </div>
</section>

<?php include 'include/footer.php'; ?>

<script>
    $(document).ready(function() {

        // Load cart into page
        function loadCart() {
            $.getJSON('cart/cart_get.php', function(data) {
                $('#cart_container').html(data.html);

                // Add grand total at bottom if items exist
                if (data.count > 0) {
                    $('#cart_container').append(`
                    <div class="mt-3 d-flex justify-content-end">
                        <div class="text-end">
                        <div>
                            <div class="d-flex justify-content-between" style="min-width:220px;">
                                <b>Grand Total:</b>
                                <span id="cart_total_footer">$${data.total}</span>
                            </div>

                            <div class="d-flex justify-content-between" style="min-width:220px;">
                                <b>Tax:</b>
                                <span>8.25%</span>
                            </div>
                        </div>
                            <div class="mt-3">
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
                `);
                }
            });
        }

        loadCart(); // initial load

        // Update quantity live
        $(document).on('change', '.cart-qty', function() {
            const key = $(this).data('key');
            const qty = parseInt($(this).val()) || 1;

            $.post('cart/cart_update.php', {
                key: key,
                qty: qty
            }, function() {
                loadCart(); // reload cart after update
            });
        });

        // Remove item
        $(document).on('click', '.remove-item', function() {
            const key = $(this).data('key');
            $.post('cart/cart_remove.php', {
                key: key
            }, function() {
                loadCart();
            });
        });

        // Clear cart
        $(document).on('click', '#clear_cart', function() {
            $.post('cart/cart_clear.php', {}, function() {
                loadCart();
            });
        });

    });
</script>