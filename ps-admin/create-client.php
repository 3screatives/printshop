<div class="modal fade" id="clientModal">
    <div class="modal-dialog modal-lg">
        <form id="clientForm">
            <input type="hidden" name="n_client_id" id="n_client_id">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Business Name</label>
                        <input type="text" name="mbusiness_name" id="mbusiness_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Business Address</label>
                        <textarea name="mbusiness_address" id="mbusiness_address" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Client STMA ID</label>
                        <input type="number" name="client_stma_id" id="client_stma_id" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Tax Exempt ID</label>
                        <input type="number" name="tax_exempt_id" id="tax_exempt_id" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Is Employee at STMA?</label>
                        <select name="is_employee" id="is_employee" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>