<?php
// session_start();
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
        <form id="clientForm">
            <input type="hidden" name="n_client_id" id="n_client_id">
            <div class="">
                <div class="row g-3">
                    <div class="col-8">
                        <div class="row"></div>
                        <!-- <div class="row">
                            <div class="col-md-12 mb-4">
                                <label>Client STMA ID</label>
                                <input type="number" name="client_stma_id" id="client_stma_id" class="form-control">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label>Business Name</label>
                                <input type="text" name="mbusiness_name" id="mbusiness_name" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label>Business Address</label>
                                <textarea name="mbusiness_address" id="mbusiness_address"
                                    class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label>Contact Name</label>
                                <input type="text" name="contact_name" id="contact_name" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label>Phone</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label>Email</label>
                                <input type="email" name="contact_email" id="contact_email" class="form-control"
                                    required>
                            </div>
                        </div> -->
                        <table class="table table-responsive">
                            <tr>
                                <td width="30%">STMA ID</td>
                                <td id="client_stma_id"></td>
                            </tr>
                            <tr>
                                <td>Business Name</td>
                                <td id="mbusiness_name"></td>
                            </tr>
                            <tr>
                                <td>Business Address</td>
                                <td id="mbusiness_address"></td>
                            </tr>
                            <tr>
                                <td>Contact Name</td>
                                <td id="contact_name"></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td id="contact_phone"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td id="contact_email"></td>
                            </tr>
                        </table>

                        <div>
                            <h4 class="mb-3">Cart Items</h4>
                            <div class="cart-table">

                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card shadow-sm sticky-top" style="top: 96px;">
                            <div class="card-body">
                                <h4 class="mb-4">Order Summary</h4>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <strong>$<span id="cart-subtotal">0.00</span></strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rush</span>
                                    <strong>$<span id="cart-rush">0.00</span></strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sales Tax (8.25%)</span>
                                    <strong>$<span id="cart-tax">0.00</span></strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fs-5 mb-4">
                                    <span><strong>Total</strong></span>
                                    <strong class="text-primary">
                                        $<span id="cart-total">0.00</span>
                                    </strong>
                                </div>

                                <button type="button" id="proceedPayment" class="thm-btn btn-primary w-100 mb-2">
                                    <span>Proceed to Payment</span>
                                </button>

                                <p class="text-muted small text-center mb-0">
                                    Prices shown before payment confirmation
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'include/footer.php'; ?>

<script>
    $.ajax({
        url: 'cart/cart_get.php',
        method: 'GET',
        dataType: 'json',
        success: function(res) {

            // Inject cart HTML
            $('.cart-table-wrapper').html(res.html);

            // Update totals
            $('#cart-subtotal').text(res.sub_total);
            $('#cart-rush').text(res.rush);
            $('#cart-tax').text(res.tax);
            $('#cart-total').text(res.total);

        }
    });

    $(document).ready(function() {
        $.ajax({
            url: 'ps-admin/get/client_action.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_by_session'
            },
            success: function(data) {
                if (!data || !data.client_id) return;

                $('#n_client_id').val(data.client_id);
                $('#client_stma_id').text(data.client_stma_id);
                $('#mbusiness_name').text(data.business_name);
                $('#mbusiness_address').text(data.business_address);
                $('#contact_name').text(data.contact_name);
                $('#contact_phone').text(data.contact_phone);
                $('#contact_email').text(data.contact_email);

                $('#contact_phone, #contact_email, #contact_name').prop('readonly', true);
                $('#client_stma_id').prop('disabled', true);
            }
        });
    });
</script>