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
                            <input id="cat_name" name="cat_name" class="form-control" required
                                value="<?= $edit['cat_name'] ?? '' ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <input id="cat_slug" name="cat_slug" class="form-control" required
                                value="<?= $edit['cat_slug'] ?? '' ?>" readonly tabindex="-1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image</label>
                            <input name="cat_image" class="form-control" value="<?= $edit['cat_image'] ?? '' ?>">
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
                            <input name="cat_section" class="form-control" value="<?= $edit['cat_section'] ?? '' ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="cat_description" class="form-control"
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