<?php
include 'ps-admin/config.php';

$categories = select_query($conn, "SELECT cat_id, cat_name FROM ps_material_categories ORDER BY cat_name ASC");

$materials = select_query($conn, "SELECT mat_id, mat_name FROM ps_materials ORDER BY mat_name ASC");

$printSizes = select_query($conn, "SELECT s_id, labels FROM ps_print_sizes ORDER BY labels ASC");

include 'include/head.php';
include 'include/header.php';
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>

                <span>Quote</span>
            </div>

            <h2>Get A Quote</h2>
        </div>

        <div class="row">
            <div class="col-6">
                <img id="item_image" src="img/product-mockups.jpg" class="img-fluid" alt="">
            </div>

            <div class="col-5 offset-1">
                <div class="order-form-wrap">

                    <!-- MATERIAL -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="category_id" id="category_id">
                                <option value="">-- Select Category --</option>
                                <?php
                                foreach ($categories as $cat) {
                                    echo "<option value='{$cat['cat_id']}'>{$cat['cat_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- MATERIAL -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Material</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="material_id" id="material_id">
                                <option value="">-- Select Material --</option>
                                <?php
                                foreach ($materials as $mat) {
                                    echo "<option value='{$mat['mat_id']}'>{$mat['mat_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Digital Size -->
                    <div class="mb-3 row" id="digital_size">
                        <label class="col-sm-4 col-form-label">Size</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="item_print_size" id="item_print_size" required>
                                <option value="">-- Select Size --</option>
                                <?php
                                foreach ($printSizes as $psize) {
                                    echo "<option value='{$psize['s_id']}'>{$psize['labels']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- SIZE -->
                    <div class="mb-3 row" id="large_size">
                        <label class="col-sm-4 col-form-label">Size</label>
                        <div class="col-sm-8 d-flex gap-3">
                            <div class="input-group">
                                <input type="number" class="form-control" name="item_width" id="item_width" value="24"
                                    min="24">
                                <span class="input-group-text">in</span>
                            </div>
                            <div class="input-group">
                                <input type="number" class="form-control" name="item_height" id="item_height" value="36"
                                    min="36">
                                <span class="input-group-text">in</span>
                            </div>
                        </div>
                        <div class="errorBox mt-2 text-end"></div>
                    </div>

                    <!-- QUANTITY -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="item_qty" id="item_qty" value="1" min="1">
                        </div>
                    </div>

                    <!-- Sides -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Sides</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="item_sides" id="item_sides">
                                <option value="0" selected>Single Sided</option>
                                <option value="1">Double Sided</option>
                            </select>
                        </div>
                    </div>

                    <!-- Orientation -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Orientation</label>
                        <div class="col-sm-8">
                            <div class="orientation-picker">

                                <label class="orientation-option">
                                    <input type="radio" name="item_orientation" value="0" checked>
                                    <span class="orientation-box landscape">Landscape</span>
                                </label>

                                <label class="orientation-option">
                                    <input type="radio" name="item_orientation" value="1">
                                    <span class="orientation-box portrait">Portrait</span>
                                </label>

                            </div>
                        </div>
                    </div>

                    <!-- GROMMETS -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Grommets</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="item_grommets" id="item_grommets">
                                <option value="0" selected>No Grommets</option>
                                <option value="1">With Grommets</option>
                            </select>
                        </div>
                    </div>

                    <!-- HFrames -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">H-Frame</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="item_hframes" id="item_hframes">
                                <option value="0" selected>No H-Frame</option>
                                <option value="1">With H-Frame</option>
                            </select>
                        </div>
                    </div>

                    <!-- DETAILS -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Details</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="item_details" id="item_details"></textarea>
                        </div>
                    </div>

                    <!-- Have Logo -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Have Logo?</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="have_logo" id="logo_yes" value="1">
                                <label class="form-check-label" for="logo_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="have_logo" id="logo_no" value="0">
                                <label class="form-check-label" for="logo_no">No</label>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3 row d-none" id="logo_upload">
                        <label class="col-sm-4 col-form-label">Upload Logo</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="logo_file" id="logo_file"
                                accept="image/*,.pdf">
                            <div id="file_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <!-- have design -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Have Design?</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="have_design" id="design_no"
                                    value="0">
                                <label class="form-check-label" for="design_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="have_design" id="design_yes"
                                    value="1">
                                <label class="form-check-label" for="design_yes">Yes</label>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3 row d-none" id="design_upload">
                        <label class="col-sm-4 col-form-label">Upload Design</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="design_file" id="design_file"
                                accept="image/*,.pdf" required>
                            <div id="design_file_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <button id="get_a_quote" class="thm-btn red w-100"><span>Submit</span></button>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="cartSuccess" class="alert alert-success position-fixed top-0 end-0 m-3 d-none" style="z-index: 9999;">
    ✅ Item added to cart
</div>

<?php
include 'include/footer.php';
mysqli_close($conn);
?>