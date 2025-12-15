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
                                    <th width="4%" class="text-center"><i class="bi bi-brush"></i></th>
                                    <th width="4%" class="text-center"><i class="bi bi-printer"></i></th>
                                    <th width="4%" class="text-center">Qty</th>
                                    <th width="14%">Material</th>
                                    <th width="34%">Details</th>
                                    <th width="20%">Size (inches)</th>
                                    <th width="10%">Price</th>
                                    <th width="10%">Total</th>
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
                                <td width="66%" rowspan="7" style="vertical-align: top !important; position: relative; padding: 0;">
                                    <b style="display:block; padding:8px;">Comments:</b>

                                    <!-- Scrollable comment list -->
                                    <div id="comments_container" style="
                                        max-height: 160px; /* adjust as needed */
                                        overflow-y: auto;
                                        padding: 0 8px 8px;
                                        box-sizing: border-box;
                                    ">
                                        <ul class="order-comments-list list-unstyled mb-0"></ul>
                                    </div>

                                    <!-- Fixed input at bottom -->
                                    <div class="add-comment d-flex align-items-center p-2" style="
                                        position: absolute;
                                        bottom: 0;
                                        left: 0;
                                        width: 100%;
                                        background: #fff; /* match table background */
                                        box-sizing: border-box;
                                        border-top: 1px solid #ccc;
                                    ">
                                        <input type="text" name="order-comment-input" class="order-comment-input form-control" placeholder="Add a comment...">
                                        <button type="button" class="add-comment-btn btn btn-outline-primary ms-2" data-order-id="">
                                            <span class="bi bi-plus"></span>
                                        </button>
                                    </div>
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
                <div class="card-footer py-3 d-flex">
                    <span class="text-muted text-sm me-3">
                        STMA ID: <b id="stmaID"></b>
                    </span>
                    <span class="text-muted text-sm me-3">
                        Tax Exempt ID: <b id="taxExID"></b>
                    </span>

                    <span class="ms-auto">
                        Posted By:
                        <b id="user_info"></b>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>