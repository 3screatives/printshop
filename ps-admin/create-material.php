<div id="materialModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="materialForm">
                <input type="hidden" name="mat_id" id="mat_id">
                <div class="modal-body">
                    <!-- Input fields -->
                    <input type="text" name="mat_vendor" id="mat_vendor" class="form-control" placeholder="Vendor">
                    <input type="text" name="mat_name" id="mat_name" class="form-control" placeholder="Material Name">
                    <textarea name="mat_details" id="mat_details" class="form-control" placeholder="Details"></textarea>
                    <input type="text" name="mat_roll_size" id="mat_roll_size" class="form-control" placeholder="Roll Size">
                    <input type="text" name="mat_length" id="mat_length" class="form-control" placeholder="Length">
                    <input type="text" name="mat_size" id="mat_size" class="form-control" placeholder="Size">
                    <input type="number" step="0.01" name="mat_cost" id="mat_cost" class="form-control" placeholder="Material Cost">
                    <input type="number" step="0.01" name="ink_cost" id="ink_cost" class="form-control" placeholder="Ink Cost">
                    <input type="number" name="cat_id" id="cat_id" class="form-control" placeholder="Category ID">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>