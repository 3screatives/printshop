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
                    <th>Product</th>
                    <th style='width:136px' class='text-center'>Price</th>
                    <th style='width:136px' class='text-center'>Qty</th>
                    <th style='width:196px' class='text-center'>Sub Total</th>
                </tr>
            </thead>
            <tbody id="cart_container">
            </tbody>
        </table>
        <div class="row d-flex align-item-center justify-content-right">
            <div class="col-8 text-end">
                Rush Printing?
            </div>
            <div class="col-4">
                <select class='form-select' name='process_time' id='process_time'>
                    <option value='0' $standardSelected>Standard (3-5 days)</option>
                    <option value='1' $rushSelectedAttr>Rush (1-2 days)</option>
                </select>
            </div>
        </div>
        <div id="cart_calc">

        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>