<div class="overlay order-details" style="display: none;">
    <div class="container h-100 py-3 position-relative">
        <div class="close">X</div>
        <div class="order-wrap p-2 border-radius-1">
            <div class="card border-0 mb-7 p-0">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0 py-3">Order ID: <b>#PS25-</b><b id="orderID"></b></h5>
                    <div>
                        <button class="btn btn-outline-primary btn-sm me-2 edit-order">
                            <span class="bi bi-pencil"> Edit</span>
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-outline-primary download-pdf">Download/Print</button>
                    </div>
                </div>
                <div class="card-body container-fluid py-3 scroll">
                    <div class="table-responsive">
                        <table class="table borderless">
                            <tr>
                                <td>
                                    <span class="d-block"><b id="business_name"></b></span>
                                    <span class="d-block" id="business_address"></span>
                                    <span class="d-block" id="client_name"></span>
                                    <span class="d-block" id="client_phone"></span>
                                    <span class="d-block" id="client_email"></span>
                                </td>
                                <td class="text-end">
                                    <h4>Due: <b id="orderDue"></b></h4>
                                    <!-- <h5>Status: <b id="order_status"></b></h5> -->
                                    <h5>Status:
                                        <select id="order_status_select" class="form-select form-select-sm order-status"
                                            style="display:inline-block; width:auto; padding:4px 36px 4px 8px; font-weight: bold; font-size: 16px;"
                                            data-order-id="">
                                        </select>
                                    </h5>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered" id="order_items">
                            <thead class="table-light">
                                <tr>
                                    <th width="6%" class="text-center">Qty</th>
                                    <th width="18%">Material</th>
                                    <th width="30%">Details</th>
                                    <th width="22%">Size (inches)</th>
                                    <th width="12%">Price</th>
                                    <th width="12%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tr>
                                <td width="66%"><b>Payment Mode:</b> <span id="payment_method"></span></td>
                                <td width="22%">Sub Total</td>
                                <td width="12%" style="text-align: right;" id="order_sub_total"></td>
                            </tr>
                            <tr>
                                <td width="66%" rowspan="7" style="vertical-align: top !important;"><b>Comments:</b>
                                    <span id="order_t_comments" class="d-block"></span>
                                </td>
                                <td width="22%">Rush Charges</td>
                                <td width="12%" style="text-align: right;" id="order_t_rush"></td>
                            </tr>
                            <tr>
                                <td width="22%">Credits</td>
                                <td width="12%" style="text-align: right;" id="order_t_credits"></td>
                            </tr>
                            <tr>
                                <td width="22%">Discount</td>
                                <td width="12%" style="text-align: right;" id="order_t_discount"></td>
                            </tr>
                            <tr>
                                <td width="22%">Total Tax (8.25%)</td>
                                <td width="12%" style="text-align: right;" id="order_t_tax"></td>
                            </tr>
                            <tr class="table-light">
                                <td width="22%"><b>Total</b></td>
                                <td width="12%" style="text-align: right;"><b id="order_t_total"></b></td>
                            </tr>
                            <tr>
                                <td width="22%">Total Paid</td>
                                <td width="12%" style="text-align: right;" id="order_t_amount_paid"></td>
                            </tr>
                            <tr class="table-light">
                                <td width="22%"><b>Due</b></td>
                                <td width="12%" style="text-align: right;"><b id="order_t_amount_due"></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <span class="text-muted text-sm me-3">STMA ID: <b id="stmaID"></b></span>
                </div>
            </div>
        </div>
    </div>
</div>