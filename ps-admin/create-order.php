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
                            <label for="process_time" class="mb-0 me-2"
                                style="min-width: 90px; white-space: nowrap;">Due
                                Date:</label>
                            <select class="form-select form-select-sm" name="process_time" id="process_time">
                                <option value="1" selected>Standard (3-5 days)</option>
                                <option value="2">Rush (1-2 days)</option>
                                <!-- <option value="3">Same Day</option> -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body container-fluid py-3 scroll">
                    <form>
                        <div class="table-responsive">
                            <table class="table borderless find-client">
                                <tr>
                                    <td width="70%">
                                        <div class="errorBox text-danger"></div>
                                    </td>
                                    <td width="30%" class="position-relative">
                                        <div>
                                            <input type="text" class="form-control form-control-sm mb-1" id="c_business"
                                                autocomplete="off" placeholder="Client Name" />
                                            <div id="suggestions"></div>
                                        </div>
                                        <input type="hidden" name="client_id" id="client_id" value="">
                                        <span id="c_address"></span>
                                        <span id="c_name"></span>
                                        <span id="c_phone"></span>
                                        <span id="c_email"></span>
                                        <input type="hidden" id="taxEx" name="taxEx" value="">
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered" id="orderItems">
                                <thead class="table-light">
                                    <tr>
                                        <th width="4%" class="text-center"><i class="bi bi-brush"></i></th>
                                        <th width="4%" class="text-center"><i class="bi bi-printer"></i></th>
                                        <th width="12%">Material</th>
                                        <th width="30%">Details</th>
                                        <th width="15%">Size (inches)</th>
                                        <th width="6%" class="text-center">Qty</th>
                                        <th width="12%">Price</th>
                                        <th width="12%">Total</th>
                                        <th width="5%"></th>
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
                                            <select class="form-select form-select-sm" name="payment_t_method"
                                                id="payment_t_method">
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
                                                name="o_subtotal" id="o_subtotal" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="66%" rowspan="7" style="vertical-align: top !important;"><b>Comments:</b>
                                        <textarea name="o_comments" id="o_comments" class="form-control" rows="6"
                                            style="width: 100%;"></textarea>
                                    </td>
                                    <td width="22%">Rush Charges</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="o_rush" id="o_rush" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Credits</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="o_credits" id="o_credits" value="" placeholder="0.00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Discount</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="o_discount" id="o_discount" value="" placeholder="0">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total Tax (8.25%)</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="o_tax" id="o_tax" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="o_total" id="o_total" value="" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total Paid</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" min="0" class="form-control form-control-sm"
                                                name="o_paid" id="o_paid" value="" placeholder="0.00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Due</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                name="o_due" id="o_due" value="" placeholder="0.00" disabled>
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