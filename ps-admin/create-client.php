<div class="modal fade" id="clientModal">
    <div class="modal-dialog modal-lg">
        <form id="clientForm">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="client_id" id="client_id">
                    <div class="col-md-6">
                        <label>Business Name</label>
                        <input type="text" name="business_name" id="business_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Business Address</label>
                        <textarea name="business_address" id="business_address" class="form-control"
                            required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label>Client STMA ID</label>
                        <input type="number" name="client_stma_id" id="client_stma_id" class="form-control">
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