<?php
include 'ps-admin/config.php';

$conn = db_connect();

/* =========================================
   AJAX HANDLER (SAME PAGE)
========================================= */
if (isset($_POST['action']) && $_POST['action'] === 'get_materials') {

    header('Content-Type: application/json');

    $cat_id = (int)$_POST['cat_id'];

    $materials = select_query(
        $conn,
        "SELECT m.mat_id, m.mat_name, m.mat_type
         FROM ps_materials m
         INNER JOIN ps_material_categories_map map
            ON map.mat_id = m.mat_id
         WHERE map.cat_id = ?
         ORDER BY m.mat_name ASC",
        "i",
        $cat_id
    );

    echo json_encode($materials);
    exit;
}

/* =========================================
   NORMAL PAGE DATA
========================================= */
$categories = select_query(
    $conn,
    "SELECT cat_id, cat_name FROM ps_material_categories ORDER BY cat_name ASC"
);

$printSizes = select_query(
    $conn,
    "SELECT s_id, labels FROM ps_print_sizes ORDER BY labels ASC"
);

include 'include/head.php';
include 'include/header.php';
?>

<section class="order-page">
    <div class="container">
        <h2 class="mb-4">Get A Quote</h2>

        <!-- CATEGORY -->
        <div class="mb-3 row">
            <label class="col-sm-4 col-form-label">Category</label>
            <div class="col-sm-8">
                <select class="form-select" id="category_id">
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['cat_id'] ?>">
                            <?= $cat['cat_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- MATERIAL -->
        <div class="mb-3 row">
            <label class="col-sm-4 col-form-label">Material</label>
            <div class="col-sm-8">
                <select class="form-select" id="material_id" disabled>
                    <option value="">-- Select Material --</option>
                </select>
            </div>
        </div>

        <!-- DIGITAL SIZE -->
        <div class="mb-3 row" id="digital_size" style="display:none;">
            <label class="col-sm-4 col-form-label">Size</label>
            <div class="col-sm-8">
                <select class="form-select" id="item_print_size">
                    <option value="">-- Select Size --</option>
                    <?php foreach ($printSizes as $psize): ?>
                        <option value="<?= $psize['s_id'] ?>">
                            <?= $psize['labels'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- LARGE SIZE -->
        <div class="mb-3 row" id="large_size" style="display:none;">
            <label class="col-sm-4 col-form-label">Size</label>
            <div class="col-sm-8 d-flex gap-3">
                <div class="input-group">
                    <input type="number" class="form-control" id="item_width" value="24" min="1">
                    <span class="input-group-text">in</span>
                </div>
                <div class="input-group">
                    <input type="number" class="form-control" id="item_height" value="36" min="1">
                    <span class="input-group-text">in</span>
                </div>
            </div>
        </div>

        <button class="btn btn-danger w-100 mt-3">Submit</button>
    </div>
</section>

<script>
    $(function() {

        $('#digital_size, #large_size').hide();

        // CATEGORY → MATERIAL
        $('#category_id').on('change', function() {

            const catId = $(this).val();

            $('#material_id')
                .prop('disabled', true)
                .html('<option value="">Loading materials...</option>');

            $('#digital_size, #large_size').hide();

            if (!catId) {
                $('#material_id')
                    .prop('disabled', true)
                    .html('<option value="">-- Select Material --</option>');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '', // SAME FILE
                dataType: 'json',
                data: {
                    action: 'get_materials',
                    cat_id: catId
                },
                success: function(materials) {

                    let options = '<option value="">-- Select Material --</option>';

                    materials.forEach(mat => {
                        options += `
                        <option value="${mat.mat_id}" data-type="${mat.mat_type}">
                            ${mat.mat_name}
                        </option>`;
                    });

                    $('#material_id')
                        .prop('disabled', false)
                        .html(options);
                }
            });
        });

        // MATERIAL → SIZE TYPE
        $('#material_id').on('change', function() {

            const type = $(this).find(':selected').data('type');

            $('#digital_size, #large_size').hide();

            if (type === 'digital') {
                $('#digital_size').slideDown();
            }

            if (type === 'large') {
                $('#large_size').slideDown();
            }
        });

    });
</script>

<?php
include 'include/footer.php';
mysqli_close($conn);
?>