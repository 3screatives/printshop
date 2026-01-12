<div id="materialModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="materialForm">
                <input type="hidden" name="mat_id" id="mat_id">

                <div class="modal-header">
                    <h5 class="modal-title">Material Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">
                        <!-- Vendor -->
                        <div class="col-md-12">
                            <label for="mat_vendor" class="form-label">Vendor</label>
                            <input type="text" name="mat_vendor" id="mat_vendor" class="form-control">
                        </div>

                        <!-- Material Name -->
                        <div class="col-md-6">
                            <label for="mat_name" class="form-label">Material Name</label>
                            <input type="text" name="mat_name" id="mat_name" class="form-control">
                        </div>

                        <!-- Material Type -->
                        <div class="col-md-6">
                            <label for="mat_type" class="form-label">Material Type</label>
                            <select id="mat_type" name="mat_type" class="form-select mt-2">
                                <option value="">Select Material Type</option>
                                <option value="large">Large Format</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>

                        <!-- Details -->
                        <div class="col-12">
                            <label for="mat_details" class="form-label">Details</label>
                            <textarea name="mat_details" id="mat_details" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Roll Size -->
                        <div class="col-md-4">
                            <label for="mat_roll_size" class="form-label">Roll Size</label>
                            <input type="text" name="mat_roll_size" id="mat_roll_size" class="form-control">
                        </div>

                        <!-- Length -->
                        <div class="col-md-4">
                            <label for="mat_cost_multiplier" class="form-label">Markup</label>
                            <input type="text" name="mat_cost_multiplier" id="mat_cost_multiplier" class="form-control"
                                value="3.00">
                        </div>

                        <!-- Size -->
                        <div class="col-md-4">
                            <label for="mat_size" class="form-label">Size</label>
                            <input type="text" name="mat_size" id="mat_size" class="form-control">
                        </div>

                        <!-- Material Cost -->
                        <div class="col-md-6">
                            <label for="mat_cost" class="form-label">Material Cost ($)</label>
                            <input type="number" step="0.0000001" name="mat_cost" id="mat_cost" class="form-control">
                        </div>

                        <!-- Ink Cost -->
                        <div class="col-md-6">
                            <label for="ink_cost" class="form-label">Ink Cost ($)</label>
                            <input type="number" step="0.0001" name="ink_cost" id="ink_cost" class="form-control"
                                value="0.003400">
                        </div>

                        <!-- Categories -->
                        <div class="col-12">
                            <label for="cat_ids" class="form-label">Categories</label>
                            <select id="cat_ids" name="cat_ids[]" class="form-select" multiple></select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>
</div>