<div class="overlay create-order" style="display: none;">
    <div class="container h-100 py-3 position-relative">
        <div class="close"></div>
        <div class="order-wrap p-2 border-radius-1">
            <div class="card border-0 mb-7 p-0">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-0 py-3 text-uppercase">Create Order</h5>
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="d-flex align-items-center">
                            <label for="order_today_date" class="mb-0 me-2"
                                style="min-width: 90px; white-space: nowrap;">Order Date:</label>
                            <input type="date" class="form-control form-control-sm" name="order_today_date"
                                id="order_today_date" value="" disabled>
                        </div>

                        <div class="d-flex align-items-center">
                            <label for="order_due_date" class="mb-0 me-2"
                                style="min-width: 90px; white-space: nowrap;">Due
                                Date:</label>
                            <select class="form-select form-select-sm" name="order_due_date" id="order_due_date">
                                <option value="1" selected>Standard 3-5 days</option>
                                <option value="2">Urgent 1-2 days</option>
                                <option value="3">Same Day</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body container-fluid py-3 scroll">
                    <form>
                        <div class="table-responsive">
                            <table class="table borderless">
                                <tr>
                                    <td width="70%"></td>
                                    <td width="30%" class="position-relative">
                                        <div>
                                            <input type="text" class="form-control form-control-sm mb-1" id="itemInput"
                                                autocomplete="off" placeholder="Client Name" />
                                            <div id="suggestions"></div>
                                        </div>
                                        <input type="hidden" name="c_client_id" id="c_client_id" value="">
                                        <textarea name="c_client_address" rows="2" id="c_client_address"
                                            class="form-control form-control-sm mb-1"
                                            placeholder="Client Address"></textarea>
                                        <input type="text" name="c_client_name" id="c_client_name"
                                            class="form-control form-control-sm mb-1" placeholder="Client Name">
                                        <input type="tel" name="c_client_phone" id="c_client_phone"
                                            class="form-control form-control-sm mb-1" placeholder="Client Phone">
                                        <input type="email" name="c_client_email" id="c_client_email"
                                            class="form-control form-control-sm" placeholder="Client Email">
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered" id="orderItems">
                                <thead class="table-light">
                                    <tr>
                                        <th width="18%">Material</th>
                                        <th width="27%">Details</th>
                                        <th width="20%">Size (inches)</th>
                                        <th width="6%" class="text-center">Qty</th>
                                        <th width="12%">Price</th>
                                        <th width="12%">Total</th>
                                        <th width="5%">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <button type="button" id="addItem" class="btn btn-sm btn-outline-primary mb-3">Add
                                Item</button>
                            <button type="button" id="createDraft" class="btn btn-sm btn-outline-secondary mb-3">Create
                                Draft</button>
                            <table class="table table-bordered">
                                <tr>
                                    <td width="66%">
                                        <div class="d-flex align-items-center">
                                            <label for="payment_method" class="mb-0 me-2">Payment Method:</label>
                                            <select class="form-select form-select-sm" name="payment_method"
                                                id="payment_method">
                                                <option value="1" selected>Credit/Debit Card</option>
                                                <option value="2">Cash</option>
                                                <option value="3">Account</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td width="22%">Sub Total</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="order_subtotal" id="order-subtotal" value="" placeholder="0.00"
                                                disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="66%" rowspan="6" style="vertical-align: top;"><b>Comments:</b>
                                        <textarea name="order_comments" id="order_comments" class="form-control"
                                            rows="6" style="width: 100%;"></textarea>
                                    </td>
                                    <td width="22%">Total Tax (8.25%)</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="order_tax" id="order-tax" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Discount</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="order_discount" id="order-discount" value="" placeholder="0">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Credits</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="order_credits" id="order-credits" value="" placeholder="0.00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="order_total" id="order-total" value="" placeholder="0.00"
                                                disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total Paid</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="order_paid" id="order-paid" value="" placeholder="0.00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Due</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="order_due" id="order-due" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="card-footer py-3 text-end">
                    <button type="button" id="submitOrder" class="btn btn-sm btn-primary">Submit Invoice</button>
                </div>
            </div>
        </div>
    </div>
</div>