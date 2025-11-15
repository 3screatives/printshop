<?php
// Include DB functions
include 'ps-admin/db_function.php';
$conn = db_connect();

// Get product slug from URL
$slug = isset($_GET['product']) ? $_GET['product'] : '';

if (empty($slug)) {
    echo "<p>Product not found.</p>";
    exit;
}

// Fetch category based on slug
$sql = "SELECT cat_id, cat_name, cat_image FROM ps_material_categories WHERE slug = ?";
$category = select_query($conn, $sql, "s", $slug);

if (empty($category)) {
    echo "<p>Product not found.</p>";
    exit;
}

$category = $category[0];
$cat_id = $category['cat_id'];
$form_title = $category['cat_name'];
$cat_image = !empty($category['cat_image']) ? 'img/' . $category['cat_image'] . '.jpg' : 'img/default.jpg';

// Fetch assigned material for this category
$material = select_query($conn, "SELECT * FROM ps_materials WHERE cat_id = ? LIMIT 1", "i", $cat_id);
if (empty($material)) {
    echo "<p>No material assigned to this category.</p>";
    exit;
}

$material = $material[0];

include 'include/head.php';
include 'include/header.php';
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a> <i class="bi bi-chevron-right"></i>
                <a href="shop">Shop</a> <i class="bi bi-chevron-right"></i>
                <?php echo htmlspecialchars($form_title); ?>
            </div>
            <h2><?php echo htmlspecialchars($form_title); ?></h2>
        </div>

        <div class="row">
            <!-- Product Image -->
            <div class="col-6">
                <img src="<?php echo $cat_image; ?>" alt="<?php echo htmlspecialchars($form_title); ?>" class="img-fluid">
            </div>

            <!-- Order Form -->
            <div class="col-6">
                <form id="calcForm">
                    <!-- Hidden Fields -->
                    <input type="hidden" name="material_id" value="<?php echo $material['mat_id']; ?>">
                    <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                    <input type="hidden" name="mat_cost" value="<?php echo $material['mat_cost']; ?>">
                    <input type="hidden" name="ink_cost" value="<?php echo $material['ink_cost']; ?>">

                    <!-- Size -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Size <span class="tc-red">*</span></label>
                        <div class="col-sm-8">
                            <div class="d-flex gap-3">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="width" value="24" min="24" max="48">
                                    <span class="input-group-text">in</span>
                                </div>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="height" value="36" min="24" max="220">
                                    <span class="input-group-text">in</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Quantity <span class="tc-red">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantity" value="1" min="1" required>
                        </div>
                    </div>

                    <!-- Sides -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Sides <span class="tc-red">*</span></label>
                        <div class="col-sm-8">
                            <select name="sides" class="form-control">
                                <option value="single">Single Side</option>
                                <option value="double">Double Side</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grommets -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Grommets</label>
                        <div class="col-sm-8">
                            <input type="checkbox" name="grommets" value="1"> Add Grommets (+$5)
                        </div>
                    </div>

                    <!-- H-Frame -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">H-Frame</label>
                        <div class="col-sm-8">
                            <select name="order_sides" class="form-control">
                                <option value="0">Wire H-Frame</option>
                                <option value="1">No Wire H-Frame</option>
                            </select>
                        </div>
                    </div>

                    <!-- Production Time -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Production Time</label>
                        <div class="col-sm-8">
                            <select name="production_time" class="form-control">
                                <option value="0">Normal (no extra)</option>
                                <option value="0.15">Rush (2-Day +15%)</option>
                                <option value="0.30">Same-Day +30%</option>
                            </select>
                        </div>
                    </div>

                    <!-- Final Price -->
                    <div class="mb-3 row">
                        <div class="col-sm-12">
                            <h4 class="fw-bold" id="result">Final Price: $0.00</h4>
                            <div id="breakdown"></div>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    <div class="mb-3 row">
                        <div class="col-sm-12">
                            <button type="button" class="thm-btn red w-100" id="addToCart">
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<!-- Product Description -->
<section class="product-details">
    <div class="container">
        <div class="sec-head">
            <h2>Product Description</h2>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <p>High quality, customizable banners and signs for your business or event. Options include grommets, H-frames, and multiple sizes for your convenience.</p>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-5">
                <ul>
                    <li>High visual impact</li>
                    <li>Highly Customizable</li>
                    <li>Easy to install</li>
                    <li>Durable</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>