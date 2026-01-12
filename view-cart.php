<?php
session_start();               // MUST be first
include 'include/head.php';
include 'include/header.php';
?>

<section class="cart-page">
    <div class="container">
        <div class="row">
            <div class="col-6 hero-head">
                <h2>My Cart</h2>
            </div>
        </div>
    </div>
</section>

<section class="my-cart py-4" style="min-height: 50vh;">
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
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <strong>Grand Total: $<span id="cart_total_footer">${data.total}</span></strong>
                        <div>
                            <a href="index.php" class="btn btn-secondary me-2">Continue Shopping</a>
                            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                            <button id="clear_cart" class="btn btn-warning ms-2">Clear Cart</button>
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