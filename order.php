<?php
include 'include/head.php';
include 'include/header.php';
include 'ps-admin/db_function.php';

$conn = db_connect();

$material_id = $_GET['mat_id'] ?? 0;

// Fetch material info
$mat_sql = "SELECT mat_id, mat_name FROM ps_materials WHERE mat_id = ? LIMIT 1";
$mat_stmt = mysqli_prepare($conn, $mat_sql);
mysqli_stmt_bind_param($mat_stmt, "i", $material_id);
mysqli_stmt_execute($mat_stmt);
mysqli_stmt_bind_result($mat_stmt, $mat_id_db, $mat_name);
mysqli_stmt_fetch($mat_stmt);
mysqli_stmt_close($mat_stmt);

// Fallbacks
if (!$mat_name) $mat_name = 'Unknown Material';
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a> <i class="bi bi-chevron-right"></i>
                <a href="shop">Shop</a> <i class="bi bi-chevron-right"></i>
                <?php echo htmlspecialchars($mat_name); ?>
            </div>
            <h2><?php echo htmlspecialchars($mat_name); ?></h2>
        </div>

        <div class="row">

            <div class="col-6">
                <img src="<?php echo $cat_image; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($mat_name); ?>">
            </div>

            <div class="col-6">
                <!-- MATERIAL -->
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Material</label>
                    <div class="col-sm-8">
                        <input type="hidden" id="material_id" value="<?php echo $material_id; ?>">
                        <input class="form-control" type="text" id="material_name"
                            value="<?php echo htmlspecialchars($mat_name); ?>" readonly>
                    </div>
                </div>

                <!-- SIZE -->
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Size</label>
                    <div class="col-sm-8 d-flex gap-3">
                        <div class="input-group">
                            <input type="number" class="form-control" name="item_width" id="item_width" value="24">
                            <span class="input-group-text">in</span>
                        </div>
                        <div class="input-group">
                            <input type="number" class="form-control" name="item_height" id="item_height" value="36">
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

                <!-- Hidden details (optional note/details) -->
                <textarea name="item_details" id="item_details" class="d-none"></textarea>

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

                <h4 class="fw-bold mt-6 mb-4" id="result">Final Price: $0.00</h4>

                <button type="button" class="thm-btn red w-100" id="addToCart">
                    <span>Add to Cart</span>
                </button>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>