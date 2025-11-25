<?php
include 'include/head.php';
include 'include/header.php';

// Get category ID from URL
$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;

// Fetch materials for this category
$materials = select_query($conn, "SELECT mat_id, mat_name FROM ps_materials WHERE cat_id = ?", "i", $cat_id);

// Fetch category details
$categoryResult = select_query($conn, "SELECT cat_name, cat_image FROM ps_material_categories WHERE cat_id = ?", "i", $cat_id);

// Get the first row (or empty array if none)
$category = $categoryResult[0] ?? ['cat_name' => '', 'cat_image' => ''];

$cat_name = $category['cat_name'];
$cat_image = $category['cat_image'];

$grommetCategories = [1, 3];

mysqli_close($conn);
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a> <i class="bi bi-chevron-right"></i>
                <?php echo htmlspecialchars($cat_name); ?>
            </div>
            <h2><?php echo htmlspecialchars($cat_name); ?></h2>
        </div>

        <div class="row">
            <div class="col-6">
                <img src="img/product-<?php echo htmlspecialchars($cat_image); ?>.jpg" class="img-fluid"
                    alt="<?php echo htmlspecialchars($cat_name); ?>">
            </div>

            <div class="col-5 offset-1">
                <div class="order-form-wrap">
                    <!-- MATERIAL -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Material</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="material_id" id="material_id">
                                <option value="">-- Select Material --</option>
                                <?php
                                if ($materials) {
                                    foreach ($materials as $mat) {
                                        echo '<option value="' . htmlspecialchars($mat['mat_id']) . '">' . htmlspecialchars($mat['mat_name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- SIZE -->
                    <div class="mb-3 row">
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
                    </div>

                    <!-- QUANTITY -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="item_qty" id="item_qty" value="1" min="1">
                        </div>
                    </div>

                    <!-- GROMMETS -->
                    <?php if (in_array($cat_id, $grommetCategories)): ?>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Grommets</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="item_grommets" id="item_grommets">
                                    <option value="0" selected>No Grommets</option>
                                    <option value="1">With Grommets</option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- DETAILS -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Details</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="item_details" id="item_details"></textarea>
                        </div>
                    </div>

                    <!-- PROCESS TIME -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Production Time</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="process_time" id="process_time">
                                <option value="1" selected>Standard (3-5 days)</option>
                                <option value="2">Rush (1-2 days)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Price Outputs -->
                    <input type="hidden" name="unit_price" id="unit_price">
                    <input type="hidden" name="total_price" id="total_price">

                    <div class="price-wrap">
                        <h3 class="fw-bold mt-6 mb-4 text-end">
                            <span class="fs-5 d-block thm-color mt-4 mb-3" style="color: #666666;">
                                Price: <b id="unit_price_display">$0.00</b> /item
                            </span>
                            <b id="result">Final Price: $0.00</b>
                        </h3>
                    </div>

                    <button type="button" class="thm-btn red w-100" id="addToCart">
                        <span>Add to Cart</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>