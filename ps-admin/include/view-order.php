<div class="overlay order-details" style="display: none;">
    <div class="container h-100 py-3 position-relative">
        <div class="close">X</div>
        <div class="order-wrap p-2 border-radius-1">
            <div class="card border-0 mb-7 p-0">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0 py-3">Order ID: <b>#PS25-</b><b id="orderID"></b></h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2">Edit</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">Download/Print</button>
                    </div>
                </div>
                <div class="card-body container-fluid py-3 scroll">
                    <div class="table-responsive">
                        <table class="table borderless">
                            <tr>
                                <td>
                                    From,
                                    <span class="d-block"><b id="client_name"></b></span>
                                    <span class="d-block" id="client_address"></span>
                                    <span class="d-block" id="client_phone"></span>
                                    <span class="d-block" id="client_email"></span>
                                </td>
                                <td class="text-end">
                                    <h4>Due: <b id="orderDue"></b></h4>
                                    <h5>Status: <b id="order_status">New</b></h5>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered" id="order_items">
                            <thead class="table-light">
                                <tr>
                                    <th width="6%" class="text-center">Qty</th>
                                    <th width="18%">Material</th>
                                    <th width="42%">Details</th>
                                    <th width="22%">Size (inches)</th>
                                    <th width="12%">Price</th>
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
                                <td width="66%" rowspan="5" style="vertical-align: top;"><b>Comments:</b>
                                    <span id="order_comments"></span>
                                </td>
                                <td width="22%">Total Tax (8.25%)</td>
                                <td width="12%" style="text-align: right;" id="order_tax"></td>
                            </tr>
                            <tr class="table-light">
                                <td width="22%"><b>Total</b></td>
                                <td width="12%" style="text-align: right;"><b id="order_total"></b></td>
                            </tr>
                            <tr>
                                <td width="22%">Discount</td>
                                <td width="12%" style="text-align: right;" id="order_discount"></td>
                            </tr>
                            <tr>
                                <td width="22%">Total Paid</td>
                                <td width="12%" style="text-align: right;" id="order_amount_paid"></td>
                            </tr>
                            <tr class="table-light">
                                <td width="22%"><b>Due</b></td>
                                <td width="12%" style="text-align: right;"><b id="order_amount_due"></b></td>
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