<div class="overlay create-order" style="display: none;">
    <div class="container h-100 py-3 position-relative">
        <div class="close">X</div>
        <div class="order-wrap p-2 border-radius-1">
            <div class="card border-0 mb-7 p-0">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-0 py-3 text-uppercase">Create Order</h5>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="d-flex align-items-center">
                            <label for="order_today_date" class="mb-0 me-2"
                                style="min-width: 90px; white-space: nowrap;">Order Date:</label>
                            <input type="date" class="form-control form-control-sm" name="order_today_date"
                                id="order_today_date" value="" disabled>
                        </div>

                        <div class="d-flex align-items-center">
                            <label for="order_due" class="mb-0 me-2" style="min-width: 90px; white-space: nowrap;">Due
                                Date:</label>
                            <input type="date" class="form-control form-control-sm" name="order_due" id="order_due">
                        </div>
                    </div>
                </div>
                <div class="card-body container-fluid py-3 scroll">
                    <form id="calcForm">
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
                                    <td width="66%"><b>Payment Method:</b> Cash/Account/Card</td>
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
                                    <td width="66%" rowspan="5" style="vertical-align: top;"><b>Comments:</b>
                                        xyz</td>
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
                                    <td width="22%"><b>Total</b></td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm fw-bold"
                                                name="order_total" id="order_total" value="" placeholder="0.00"
                                                disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Discount</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                placeholder="00" name="order_discount" id="order_discount">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%">Total Paid</td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm"
                                                placeholder="0.00" name="order_amount_paid" id="order_amount_paid">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="22%"><b>Due</b></td>
                                    <td width="12%" style="text-align: right;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input dir="rtl" type="number" class="form-control form-control-sm fw-bold"
                                                name="order_amount_due" id="order_amount_due" value=""
                                                placeholder="0.00" disabled>
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