<?php
require_once 'db_function.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Clear existing homepage categories
    execute_query($conn, "TRUNCATE TABLE ps_homepage_categories", "");

    if (!empty($_POST['categories'])) {
        foreach ($_POST['categories'] as $cat_id) {
            execute_query(
                $conn,
                "INSERT INTO ps_homepage_categories (cat_id, is_visible)
                 VALUES (?, 1)",
                "i",
                (int)$cat_id
            );
        }
    }

    $message = "Homepage categories updated successfully.";
}

// All categories
$categories = select_query(
    $conn,
    "SELECT cat_id, cat_name 
     FROM ps_material_categories 
     ORDER BY cat_name ASC"
);

// Enabled categories
$enabled = select_query(
    $conn,
    "SELECT cat_id FROM ps_homepage_categories WHERE is_visible = 1"
);

$enabled_ids = array_column($enabled, 'cat_id');

include 'include/head.php';
?>

<h2>Homepage Category Settings</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= $message; ?></div>
<?php endif; ?>

<form method="post">
    <div class="row">
        <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 mb-2">
                <label class="form-check-label">
                    <input type="checkbox"
                        class="form-check-input"
                        name="categories[]"
                        value="<?= $cat['cat_id']; ?>"
                        <?= in_array($cat['cat_id'], $enabled_ids) ? 'checked' : ''; ?>>
                    <?= htmlspecialchars($cat['cat_name']); ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">
        Save Settings
    </button>
</form>