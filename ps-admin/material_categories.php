<?php

require_once "db_function.php";

$conn = db_connect();

/* =========================
   DELETE
========================= */
if (isset($_GET['delete'])) {
    execute_query(
        $conn,
        "DELETE FROM ps_material_categories WHERE cat_id = ?",
        "i",
        (int)$_GET['delete']
    );
    header("Location: material_categories.php");
    exit;
}

/* =========================
   ADD / UPDATE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id      = $_POST['cat_id'] ?? '';
    $name    = $_POST['cat_name'];
    $desc    = $_POST['cat_description'];
    $image   = $_POST['cat_image'];
    $slug    = $_POST['cat_slug'];
    $group   = $_POST['cat_group'];
    $section = $_POST['cat_section'];
    $order   = (int)$_POST['cat_order'];

    if ($id) {
        execute_query(
            $conn,
            "UPDATE ps_material_categories
             SET cat_name=?, cat_description=?, cat_image=?, cat_slug=?,
                 cat_group=?, cat_section=?, cat_order=?
             WHERE cat_id=?",
            "ssssssii",
            $name,
            $desc,
            $image,
            $slug,
            $group,
            $section,
            $order,
            $id
        );
    } else {
        execute_query(
            $conn,
            "INSERT INTO ps_material_categories
             (cat_name, cat_description, cat_image, cat_slug,
              cat_group, cat_section, cat_order)
             VALUES (?,?,?,?,?,?,?)",
            "ssssssi",
            $name,
            $desc,
            $image,
            $slug,
            $group,
            $section,
            $order
        );
    }

    header("Location: material_categories.php");
    exit;
}

/* =========================
   EDIT DATA
========================= */
$edit = null;
if (isset($_GET['edit'])) {
    $row = select_query(
        $conn,
        "SELECT * FROM ps_material_categories WHERE cat_id = ?",
        "i",
        (int)$_GET['edit']
    );
    $edit = $row[0] ?? null;
}

/* =========================
   FETCH ALL
========================= */
$categories = select_query(
    $conn,
    "SELECT * FROM ps_material_categories
     ORDER BY cat_group, cat_section, cat_order"
);

include 'include/head.php';
?>

<style>
    body {
        overflow: hidden;
    }

    .table-wrapper {
        max-height: calc(100vh - 140px);
        overflow-y: auto;
    }
</style>

<body class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Material Categories</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
            + Add Category
        </button>
    </div>

    <!-- ================= MODAL FORM ================= -->
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <form method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?= $edit ? 'Edit Category' : 'Add Category' ?>
                        </h5>
                        <a href="material_categories.php" class="btn-close"></a>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="cat_id" value="<?= $edit['cat_id'] ?? '' ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input name="cat_name" class="form-control" required
                                    value="<?= $edit['cat_name'] ?? '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input name="cat_slug" class="form-control" required
                                    value="<?= $edit['cat_slug'] ?? '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Image</label>
                                <input name="cat_image" class="form-control"
                                    value="<?= $edit['cat_image'] ?? '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Order</label>
                                <input type="number" name="cat_order" class="form-control"
                                    value="<?= $edit['cat_order'] ?? 0 ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Group</label>
                                <select name="cat_group" class="form-select" required>
                                    <option value="">Select Format</option>
                                    <option value="Large Format"
                                        <?= (($edit['cat_group'] ?? '') === 'Large Format') ? 'selected' : '' ?>>
                                        Large Format
                                    </option>
                                    <option value="Digital Format"
                                        <?= (($edit['cat_group'] ?? '') === 'Digital Format') ? 'selected' : '' ?>>
                                        Digital Format
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Section</label>
                                <input name="cat_section" class="form-control"
                                    value="<?= $edit['cat_section'] ?? '' ?>">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="cat_description"
                                    class="form-control"
                                    rows="3"><?= $edit['cat_description'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            <?= $edit ? 'Update' : 'Add' ?>
                        </button>
                        <a href="material_categories.php" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="table-wrapper">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-dark sticky-top">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Section</th>
                    <th>Order</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['cat_id'] ?></td>
                        <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_group']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_section']) ?></td>
                        <td><?= $cat['cat_order'] ?></td>
                        <td>
                            <a href="?edit=<?= $cat['cat_id'] ?>"
                                class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <a href="?delete=<?= $cat['cat_id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this category?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <?php if ($edit): ?>
        <script>
            const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
            modal.show();
        </script>
    <?php endif; ?>

</body>

</html>