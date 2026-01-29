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
        <form id="clientForm">
            <input type="hidden" name="n_client_id" id="n_client_id">
            <div class="">
                <div class="row g-3">
                    <div class="col-8">
                        <div class="row"></div>
                        <div class="row">
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
                            <div class="col-md-12 mb-4">
                                <label>Tax Exempt ID</label>
                                <input type="number" name="tax_exempt_id" id="tax_exempt_id" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Is Employee at STMA?</label>
                                <select name="is_employee" id="is_employee" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'include/footer.php'; ?>