$(document).ready(function () {
    let statusOptions = [];

    $.getJSON('get/status_options.php')
        .done(function (statuses) {
            statusOptions = statuses;

            const $statusFilter = $('#statusFilter');
            statusOptions.forEach(status => {
                $statusFilter.append(`<option value="${status.status_id}">${status.status_name}</option>`);
            });

            loadOrders();
        })
        .fail(function () {
            alert('Failed to load status options');
        });

    function formatUSPhone(phone) {
        phone = phone.replace(/\D/g, "");
        return phone.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
    }

    function renderOrders(orders) {
        let rows = '';

        orders.forEach(o => {
            function formatOrderDate(dateString) {
                if (!dateString) return "";

                const [year, month, day] = dateString.split("-");
                const date = new Date(year, month - 1, day);

                return date.toLocaleDateString("en-US", {
                    year: "numeric",
                    month: "short",
                    day: "numeric"
                });
            }
            const formattedDate = formatOrderDate(o.order_date);
            const formattedDue = formatOrderDate(o.order_due);

            let statusSelect = `
                <select class="form-select form-select-sm order-status" data-order-id="${o.order_id}">
            `;

            statusOptions.forEach(status => {
                const selected = status.status_id === o.status_id ? "selected" : "";
                const color = status.status_color || "#ffffff";

                statusSelect += `
                <option value="${status.status_id}" 
                        data-color="${color}" 
                        style="background-color:${color};"
                        ${selected}>
                    ${status.status_name}
                </option>`;
            });

            statusSelect += `</select>`;
            rows += `
                <tr>
                    <td>PS#25-${o.order_id}</td>
                    <td>${formattedDate}</td>
                    <td>${formattedDue}</td>
                    <td>
                        <span class="client-filter" 
                            style="cursor:pointer;" 
                            data-client="${o.client_name}">
                            ${o.client_name ?? '—'}
                        </span>
                        <i style="color: #999999;">(${o.contact_name})</i>
                    </td>
                    <td class="copy-phone" data-phone="${o.contact_phone}" style="cursor:pointer;">${formatUSPhone(o.contact_phone)}</td>
                    <td>$${parseFloat(o.order_after_tax || 0).toFixed(2)}</td>
                    <td>${statusSelect}</td>
                    <td class="text-center">
                        <button class="btn btn-outline-secondary btn-sm me-2 view-order" data-order-id="${o.order_id}">
                            <span class="bi bi-search"></span>
                        </button>
                        <button class="btn btn-outline-primary btn-sm me-2 edit-order" data-order-id="${o.order_id}">
                            <span class="bi bi-pencil"></span>
                        </button>
                        <button class="btn btn-outline-danger btn-sm delete-order" data-order-id="${o.order_id}">
                            <span class="bi bi-trash"></span>
                        </button>
                    </td>
                </tr>`;
        });

        $('#orderListMain tbody').html(rows);

        $('.order-status').each(function () {
            applySelectColor($(this));
        });
    }

    $(document).on("click", ".copy-phone", function () {
        const rawPhone = $(this).data("phone"); // ensure digits only

        navigator.clipboard.writeText(rawPhone).then(() => {
            // console.log("Copied:", rawPhone);
            showUndoBanner("Copied: " + rawPhone);
        });
    });

    $(document).on('click', '.client-filter', function () {
        const client = $(this).data('client') || '';
        $('#orderSearch').val(client);

        applyFilters();
    });

    function applySelectColor(select) {
        const selectedOption = select.find(':selected');
        const color = selectedOption.data('color') || '#ffffff';
        select.css('background-color', color);
    }

    // Apply color on change
    $(document).on('change', '.order-status', function () {
        applySelectColor($(this));
    });

    // Apply color on initial load (after rendering)
    $('.order-status').each(function () {
        applySelectColor($(this));
    });

    let allOrders = []; // store all orders for filtering

    function loadOrders() {
        $.getJSON('get/order_list.php')
            .done(function (response) {
                if (response.orders && response.orders.length > 0) {
                    allOrders = response.orders; // keep for filtering
                    applyFilters(); // render filtered version
                } else {
                    $('#orderListMain tbody').html('<tr><td colspan="7" class="text-center">No orders found</td></tr>');
                }
            })
            .fail(function () {
                alert('Failed to load orders');
            });
    }

    function applyFilters() {
        const searchTerm = ($('#orderSearch').val() || '').toLowerCase().trim();
        const selectedStatus = $('#statusFilter').val();

        const filtered = (allOrders || []).filter(o => {
            const orderNum = (`PS#25-${o?.order_id || ''}`).toLowerCase();
            const business = (o?.client_name || '').toLowerCase();
            const contact = (o?.contact_name || '').toLowerCase();
            const amount = (parseFloat(o?.order_after_tax || 0)).toFixed(2);
            const material = (o?.materials || '').toLowerCase();

            const matchesSearch =
                orderNum.includes(searchTerm) ||
                business.includes(searchTerm) ||
                contact.includes(searchTerm) ||
                amount.includes(searchTerm) ||
                material.includes(searchTerm);

            const matchesStatus =
                !selectedStatus || String(o?.status_id || '') === String(selectedStatus);

            return matchesSearch && matchesStatus;
        });

        renderOrders(filtered);
    }


    // Search & filter live updates
    $(document).on('input', '#orderSearch', function () {
        applyFilters();
    });

    $(document).on('change', '#statusFilter', function () {
        applyFilters();
    });

    $('#refreshOrders').on('click', function () {
        $('#orderSearch').val('');
        $('#statusFilter').val('');
        loadOrders();
    });

    // Handle order status change ** UPDATE **
    $(document).on('change', '.order-status', function () {
        const $dropdown = $(this);
        const orderId = $dropdown.data('order-id');
        const newStatus = $dropdown.val();
        const oldStatus = $dropdown.data('prev-status') ?? $dropdown.data('old-status') ?? null;

        $dropdown.data('prev-status', newStatus);

        $.ajax({
            url: 'get/update_order_status.php',
            method: 'POST',
            data: { order_id: orderId, status_id: newStatus },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    showUndoBanner("Status Updated Successfully!");

                    const $allDropdowns = $(`.order-status[data-order-id="${orderId}"]`);
                    $allDropdowns.each(function () {
                        $(this).val(newStatus);
                        $(this).data('prev-status', newStatus);
                        applySelectColor($(this));
                    });

                    loadOrders();
                } else {
                    alert('Failed to update order status on server. Reverting UI.');
                    if (oldStatus !== null) {
                        $dropdown.val(oldStatus);
                        $dropdown.data('prev-status', oldStatus);
                    }
                }
            },
            error: function (xhr, status, err) {
                alert('Error updating order status. Reverting UI.');
                if (oldStatus !== null) {
                    $dropdown.val(oldStatus);
                    $dropdown.data('prev-status', oldStatus);
                }
            }
        });
    });
    // CLose - Handle order Status change

    // Show undo banner
    function showUndoBanner(showText) {
        $('.undo-banner').remove();

        const $banner = $(`
        <div class="undo-banner" style="
            position:fixed; top:12px; left:50%; transform:translateX(-50%);
            background:#343a40; color:#fff; padding:6px 12px; border-radius:6px;
            box-shadow:0 6px 18px rgba(0,0,0,0.2); z-index:99999;
            display:flex; align-items:center; font-size:14px;">
            <span>${showText}</span>
        </div>
    `);

        $('body').append($banner);

        setTimeout(() => {
            $banner.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }
    // Close - Show undo banner

    // View Order Details
    $(document).on('click', '.view-order', function () {
        var orderID = $(this).data('order-id');
        $(".download-pdf").data("oid", orderID);
        $.ajax({
            url: 'get/order.php',
            method: 'GET',
            data: { order_id: orderID },
            dataType: 'json',
            success: function (response) {
                if (response.order) {
                    const o = response.order;
                    $('.edit-order').data('order-id', o.order_id);
                    $('#orderID').text(o.order_id);
                    $('#orderDue').text(o.order_due);

                    $('.order-details').show();

                    $('#business_name').text(o.business_name);
                    $('#business_address').text(o.business_address);
                    $('#client_name').text(o.client_name);
                    $('#client_phone').text(o.client_phone);
                    $('#client_email').text(o.client_email);

                    const $statusSelect = $('#order_status_select');
                    $statusSelect.data('order-id', o.order_id);
                    $statusSelect.empty();

                    statusOptions.forEach(status => {
                        const selected = String(status.status_id) === String(o.status_id) ? "selected" : "";
                        $statusSelect.append(`<option value="${status.status_id}" ${selected}>${status.status_name}</option>`);
                    });

                    // $('#payment_method').text(o.payment_type);
                    let paymentText = {
                        1: 'Credit/Debit Card',
                        2: 'Cash',
                        3: 'Account'
                    }[o.payment_type] || '—';

                    $('#payment_method').text(paymentText);

                    $('#order_sub_total').text('$' + o.before_tax);
                    $('#order_t_tax').text('$' + o.tax);
                    $('#order_t_total').text('$' + o.after_tax);
                    $('#order_t_credits').text('$' + (o.credits || '0.00'));
                    $('#order_t_discount').text((o.discount || '0') + '%');
                    $('#order_t_rush').text('$' + (o.rush || '0'));
                    $('#order_t_amount_paid').text('$' + o.paid);
                    $('#order_t_amount_due').text('$' + o.due);
                    $('#order_t_comments').html((o.comment || '').replace(/\n/g, '<br>'));

                    $('#stmaID').text(o.stmaID ? o.stmaID : '-');
                    $('#taxExID').text(o.taxExID ? o.taxExID : '-');
                    $('#user_info').text(o.userName ? o.userName : '-')

                    let rows = "";
                    response.items.forEach(item => {
                        let rowClass = "";
                        if (item.is_design == 1 && item.is_printed == 1) {
                            rowClass = "done";
                        } else if (item.is_design == 1) {
                            rowClass = "design";
                        } else if (item.is_printed == 1) {
                            rowClass = "print";
                        }
                        rows += `<tr class="${rowClass}" data-item-id="${item.item_id}">
                        <td class="text-center"><input class="form-check-input" type="checkbox" name="item_is_design[]" ${item.is_design == 1 ? 'checked' : ''}></td>
                        <td class="text-center"><input class="form-check-input" type="checkbox" name="item_is_printed[]" ${item.is_printed == 1 ? 'checked' : ''}></td>
                        <td class="text-center">${item.quantity}</td>
                        <td>${item.material}</td>
                        <td>${item.details}</td>
                        <td>${item.size_width} x ${item.size_height}</td>
                        <td class="text-end">$${item.price}</td>
                        <td class="text-end">$${item.total}</td>
                    </tr>`;
                    });
                    $('#order_items tbody').html(rows);
                } else {
                    alert(response.error || 'Something went wrong');
                }
            },
            error: function () {
                alert('Failed to load order');
            }
        });
    });

    $('.close').on('click', function () {
        $('.order-details').hide();
    });
    // Close - View Order Details

    // Create / Edit Order
    const todayDate = new Date().toISOString().split('T')[0];
    $('#order_today_date').val(todayDate);

    $(document).on('click', '#newOrder', function () {
        $('.create-order').show();
    });

    $('.close').on('click', function () {
        $('.create-order').hide();

        const $form = $('.create-order form');
        if ($form.length === 0) return;

        $form[0].reset();

        $form.find('textarea').val('');
        $form.find('input[type="text"], input[type="number"], input[type="hidden"]').val('');
        $form.find('span').text('');

        $form.find('select').each(function () {
            this.selectedIndex = 0;
        });

        $('#process_time').val('1').trigger('change');

        const $tbody = $form.find('#orderItems tbody');
        if ($tbody.find('tr').length > 1) {
            $tbody.find('tr').not(':first').remove();
            $tbody.find('tr:first').find('input, select').val('');
        } else {
            $tbody.empty();
        }
        count = 0;
        $('.create-order h5').text('New Order');
        // $('#submitOrder').text('Submit Invoice').data('order-id', o.order_id);
        $('#submitOrder').text('Submit Invoice').removeData('order-id');
    });

    $(document).on('click', '.edit-order', function () {
        const orderID = $(this).data('order-id');

        $.ajax({
            url: 'get/order.php',
            method: 'GET',
            data: { order_id: orderID },
            dataType: 'json',
            success: function (response) {
                if (response.order) {
                    const o = response.order;
                    $('.overlay.create-order').fadeIn();

                    $('#order_today_date').val(o.order_date);
                    $('#process_time').val(o.process_time);

                    $('#payment_t_method option').prop('selected', false); // clear selection
                    $('#payment_t_method option[value="' + o.payment_type + '"]').prop('selected', true);

                    $('#order_id').val(o.order_id);

                    $('#client_id').val(o.client_id);
                    $('#c_business').val(o.business_name);
                    $('#c_address').val(o.business_address);
                    $('#c_name').val(o.client_name);
                    $('#c_phone').val(o.client_phone);
                    $('#c_email').val(o.client_email);

                    $('#o_subtotal').val(o.before_tax);
                    $('#o_tax').val(o.tax);
                    $('#o_discount').val(o.discount);
                    $('#o_credits').val(o.credits);
                    $('#o_total').val(o.after_tax);
                    $('#o_paid').val(o.paid);
                    $('#o_due').val(o.due);

                    $('#o_comments').val(o.comment || '');

                    $('#orderItems tbody').empty();

                    // Rebuild items
                    response.items.forEach(item => {
                        count++;
                        let id = count;

                        const rowHtml = `
                        <tr class="itemRow" data-row="${id}">
                        <td class="text-center"><input type="hidden" name="item_is_design[]" value="0"><input class="form-check-input" type="checkbox" name="item_is_design[]" value="1" ${item.is_design == 1 ? 'checked' : ''}></td>
                        <td class="text-center"><input type="hidden" name="item_is_printed[]" value="0"><input class="form-check-input" type="checkbox" name="item_is_printed[]" value="1" ${item.is_printed == 1 ? 'checked' : ''}></td>
                            <td class="position-relative">
                                <div class="custom-dropdown">
                                    <input type="text" class="form-control form-control-sm mat-search"
                                        placeholder="Search Material..." autocomplete="off" value="${item.material}">
                                    <div class="dropdown-list border position-absolute bg-white w-100 shadow-sm"
                                        style="display:none; max-height:180px; overflow-y:auto; z-index:1000;"></div>
                                    <input type="hidden" name="order_material_id[]" value="${item.mat_id}">
                                    <input type="hidden" name="item_row_id[]" value="${id}">
                                    <input type="hidden" name="item_id[]" value="${item.item_id}">
                                </div>
                            </td>
                            <td><textarea name="order_item_details[]" class="form-control form-control-sm" rows="1">${item.details}</textarea></td>
                            <td><div class="input-group">
                                <input dir="rtl" type="number" name="order_item_width[]" class="form-control form-control-sm" placeholder="Width" value="${item.size_width}">
                                <input dir="rtl" type="number" name="order_item_height[]" class="form-control form-control-sm" placeholder="Height" value="${item.size_height}">
                            </div></td>
                            <td class="text-center"><input type="number" name="order_item_qty[]" min="1" class="form-control form-control-sm" value="${item.quantity}"></td>
                            <td class="text-end"><div class="input-group"><span class="input-group-text">$</span>
                                <input dir="rtl" type="number" name="order_item_price[]" class="form-control form-control-sm" readonly value="${item.price}"></div></td>
                            <td><div class="input-group"><span class="input-group-text">$</span>
                                <input dir="rtl" type="number" name="order_item_total[]" class="form-control form-control-sm" disabled value="${item.total}"></div></td>
                            <td><button type="button" class="removeItem form-control btn btn-sm btn-danger">X</button></td>
                        </tr>
                    `;
                        $('#orderItems tbody').append(rowHtml);
                    });

                    $('.create-order h5').text('Edit Order');
                    $('#submitOrder').text('Update Invoice').data('order-id', o.order_id);
                } else {
                    alert(response.error || 'Something went wrong while loading order.');
                }
            },
            error: function () {
                alert('Failed to load order data for editing.');
            }
        });
    });

    //Create Element
    let materials = [];
    let count = 0;

    $.getJSON('get/materials.php')
        .done(function (data) {
            materials = data;
        })
        .fail(function () {
            alert('Failed to load materials.');
        });

    $('#addItem').off('click').on('click', function () {
        count++;
        let rowId = count;

        let itemHtml = `
    <tr class="calculate itemRow" data-row="${rowId}">
        <td class="text-center"><input class="form-check form-check-sm" type="checkbox" name="item_is_design[]"></td>
        <td class="text-center"><input class="form-check form-check-sm" type="checkbox" name="item_is_printed[]"></td>
        <td class="position-relative">
            <div class="custom-dropdown">
                <input type="text" class="form-control form-control-sm mat-search"
                       placeholder="Search Material..." autocomplete="off">
                <div class="dropdown-list border position-absolute bg-white w-100 shadow-sm"
                     style="display:none; max-height:180px; overflow-y:auto; z-index:1000;"></div>
                <input type="hidden" name="order_material_id[]">
                <input type="hidden" name="item_row_id[]" value="${rowId}">
            </div>
        </td>
        <td><textarea name="order_item_details[]" class="form-control form-control-sm" rows="1"></textarea></td>
        <td><div class="input-group">
            <input dir="rtl" type="number" name="order_item_width[]" class="form-control form-control-sm" placeholder="Width">
            <input dir="rtl" type="number" name="order_item_height[]" class="form-control form-control-sm" placeholder="Height">
        </div></td>
        <td class="text-center"><input type="number" name="order_item_qty[]" min="1" value="1" class="form-control form-control-sm"></td>
        <td class="text-end"><div class="input-group"><span class="input-group-text">$</span>
            <input dir="rtl" type="number" name="order_item_price[]" class="form-control form-control-sm" readonly></div></td>
        <td><div class="input-group"><span class="input-group-text">$</span>
            <input dir="rtl" type="number" name="order_item_total[]" class="form-control form-control-sm" disabled></div></td>
        <td><button type="button" class="removeItem form-control btn btn-sm btn-danger">X</button></td>
    </tr>`;

        $('#orderItems tbody').append(itemHtml);
    });

    $(document).on('input focus', '.mat-search', function () {
        const $row = $(this).closest('.itemRow');
        const rowId = $row.data('row');
        const searchVal = $(this).val().toLowerCase();
        const dropdown = $(this).siblings('.dropdown-list');
        dropdown.empty().show();

        const filtered = materials.filter(m =>
            m.name.toLowerCase().includes(searchVal) ||
            (m.category && m.category.toLowerCase().includes(searchVal))
        );

        if (filtered.length === 0) {
            dropdown.append('<div class="p-2 text-muted small">No matches found</div>');
            return;
        }

        filtered.forEach(m => {
            dropdown.append(`
            <div class="dropdown-item px-2 py-1 hover-bg" data-id="${m.id}" data-row="${rowId}" style="cursor:pointer;">
                 <b>${m.name}</b>
            </div>`);
        });

        dropdown.find('.dropdown-item:first').addClass('active');
    });

    $(document).on('click', '.dropdown-item', function () {
        const matName = $(this).text().trim();
        const matId = $(this).data('id');
        const rowId = $(this).data('row');
        const $row = $(`.itemRow[data-row="${rowId}"]`);

        $row.find('.mat-search').val(matName);
        $row.find('input[name="order_material_id[]"]').val(matId);
        $row.find('.dropdown-list').hide();

        getMaterialPrice(matId, rowId);
    });

    $(document).on('change input',
        'input[name="order_item_width[]"], input[name="order_item_height[]"], input[name="order_item_qty[]"]',
        function () {
            const $row = $(this).closest('.itemRow');
            const rowId = $row.data('row');
            const matId = $row.find('input[name="order_material_id[]"]').val();

            if (matId) {
                getMaterialPrice(matId, rowId); // recalc live
            }
        }
    );

    $('#process_time').on('change', function () {
        let val = $(this).val();
        calculateTotal(val);
    });

    $(document).on('input change',
        'input[name="order_item_qty[]"], input[name="order_item_price[]"], input[name="order_item_width[]"], input[name="order_item_height[]"]',
        function () {
            const $row = $(this).closest('.itemRow');

            const qty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 0;
            const price = parseFloat($row.find('input[name="order_item_price[]"]').val()) || 0;
            $row.find('input[name="order_item_total[]"]').val((qty * price).toFixed(2));

            calculateTotal();
        }
    );

    $(document).on('input', '#o_discount, #o_paid , #o_credits', function () {
        calculateTotal();
    });

    function getMaterialPrice(matId, rowId) {
        const $row = $(`.itemRow[data-row="${rowId}"]`);

        const itemDetails = $row.find('textarea[name="order_item_details[]"]').val() || "";
        const itemWidth = parseFloat($row.find('input[name="order_item_width[]"]').val()) || 0;
        const itemHeight = parseFloat($row.find('input[name="order_item_height[]"]').val()) || 0;
        const itemQty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 1;
        const orderProcess = parseFloat($('#process_time').val()) || 1;

        $.ajax({
            url: "get/material_price.php",
            type: "POST",
            data: {
                material_id: matId,
                details: itemDetails,
                width: itemWidth,
                height: itemHeight,
                quantity: itemQty,
                process_time: orderProcess
            },
            dataType: "json",
            success: function (response) {
                if (response.breakdown) {
                    $('.errorBox').html(response.breakdown);
                    $row.addClass('bg-red-light');

                    $row.find('input[name="order_item_price[]"]').val("0.00");
                    $row.find('input[name="order_item_total[]"]').val("0.00");

                    calculateTotal();
                    return;
                }
                $('.errorBox').html("");
                $row.removeClass('bg-red-light');


                const unitPrice = parseFloat(response.final_cost) || 0;
                const qty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 1;
                const total = unitPrice * qty;

                $row.find('input[name="order_item_price[]"]').val(unitPrice.toFixed(2));
                $row.find('input[name="order_item_total[]"]').val(total.toFixed(2));
                calculateTotal();
            }
        });
    }

    function calculateTotal() {
        let subtotal = 0;
        let rush = 0;

        // Sum all item totals
        $('input[name="order_item_total[]"]').each(function () {
            let itotal = parseFloat($(this).val()) || 0;
            subtotal += itotal;
        });

        $('#o_subtotal').val(subtotal.toFixed(2));

        let val = parseInt($('#process_time').val()) || 1;
        if (val === 2) rush = 0.3;

        let rushVal = subtotal * rush;
        if (rush > 0 && rushVal < 15) rushVal = 15;
        $('#o_rush').val(rushVal.toFixed(2));

        // Discount + credits
        let discountPercent = parseFloat($('#o_discount').val()) || 0;
        let creditAmount = parseFloat($('#o_credits').val()) || 0;
        let discountAmount = subtotal * (discountPercent / 100);

        // ((subtotal - discount) + rush) - credits
        let taxableBase = (subtotal - discountAmount + rushVal) - creditAmount;

        if (taxableBase < 0) taxableBase = 0; // prevent negative tax base

        let isExempt = $('#taxEx').val().trim() === "1";
        let tax = 0;

        if (!isExempt) {
            tax = taxableBase * 0.0825;
            $('#o_tax').val(tax.toFixed(2));
        } else {
            $('#o_tax').val('0.00');
        }

        // Calculate total
        let total = taxableBase + tax;
        $('#o_total').val(total.toFixed(2));

        // Calculate due
        let paid = parseFloat($('#o_paid').val()) || 0;
        let due = total - paid;

        $('#o_due').val(due.toFixed(2));
    }


    $(document).on('click', function (e) {
        if (!$(e.target).closest('.custom-dropdown').length) {
            $('.dropdown-list').hide();
        }
    });

    $(document).on('click', '.removeItem', function () {
        $(this).closest('tr').remove();
        calculateTotal();
    });

    $(document).on('keydown', '.mat-search', function (e) {
        const dropdown = $(this).siblings('.dropdown-list');
        const items = dropdown.find('.dropdown-item');
        let active = dropdown.find('.active');

        if (!dropdown.is(':visible') || items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (active.length === 0) {
                items.first().addClass('active');
            } else {
                let next = active.removeClass('active').nextAll('.dropdown-item:first');
                if (next.length) next.addClass('active');
                else items.first().addClass('active');
            }

            let newActive = dropdown.find('.active');
            dropdown.scrollTop(
                newActive.position().top + dropdown.scrollTop() - dropdown.height() / 2
            );
        }

        else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (active.length === 0) {
                items.last().addClass('active');
            } else {
                let prev = active.removeClass('active').prevAll('.dropdown-item:first');
                if (prev.length) prev.addClass('active');
                else items.last().addClass('active');
            }

            let newActive = dropdown.find('.active');
            dropdown.scrollTop(
                newActive.position().top + dropdown.scrollTop() - dropdown.height() / 2
            );
        }

        else if (e.key === 'Enter') {
            e.preventDefault();
            if (active.length) {
                active.trigger('click');
            }
        }

        else if (e.key === 'Escape') {
            dropdown.hide();
        }
    });

    $(document).ready(function () {
        const $input = $("#c_business");
        const $suggestions = $("#suggestions");

        // Live search
        $input.on("keyup", function () {
            const term = $(this).val().trim();

            if (term.length < 2) {
                $suggestions.empty().hide();
                return;
            }

            $.getJSON("get/search_clients.php", { term: term }, function (data) {
                $suggestions.empty();

                if (data.length === 0) {
                    // No results → just hide suggestions
                    $suggestions.hide();
                } else {
                    $suggestions.show();
                    data.forEach(function (client) {
                        const item = `
                        <button type="button" class="list-group-item list-group-item-action"
                            data-id="${client.client_id}"
                            data-name="${client.business_name}"
                            data-address="${client.business_address || ''}"
                            data-cname="${client.contact_name || ''}"
                            data-phone="${client.contact_phone || ''}"
                            data-email="${client.contact_email || ''}"
                            data-taxex="${client.tax_exempt || ''}"
                            >
                            ${client.business_name + ' (' + client.contact_name + ')'}
                        </button>`;
                        $suggestions.append(item);
                    });
                }
            });
        });

        // Fill fields when a suggestion is clicked
        $suggestions.on("click", ".list-group-item-action", function () {
            const $this = $(this);
            $("#client_id").val($this.data("id"));
            $("#c_business").val($this.data("name"));
            $("#c_address").text($this.data("address"));
            $("#c_name").text($this.data("cname"));
            $("#c_phone").text($this.data("phone"));
            $("#c_email").text($this.data("email"));
            $("#taxEx").val($this.data("taxex") || '');
            $suggestions.empty().hide();
            calculateTotal();
        });

        // Hide suggestions when clicking outside or moving to another field
        $(document).on("click focusin", function (e) {
            if (!$(e.target).closest("#c_business, #suggestions").length) {
                $suggestions.empty().hide();
            }
        });
    });

    $(document).on('click', '#submitOrder', function (e) {
        e.preventDefault();

        let items = [];
        $('#orderItems tbody tr').each(function () {
            items.push({
                item_id: $(this).find('input[name="item_id[]"]').val() || 0, // existing item id (if editing)
                material_id: $(this).find('input[name="order_material_id[]"]').val(),
                item_details: $(this).find('textarea[name="order_item_details[]"]').val(),
                item_quantity: $(this).find('input[name="order_item_qty[]"]').val(),
                item_size_width: $(this).find('input[name="order_item_width[]"]').val(),
                item_size_height: $(this).find('input[name="order_item_height[]"]').val(),
                item_price: $(this).find('input[name="order_item_price[]"]').val(),
                item_total: $(this).find('input[name="order_item_total[]"]').val(),
                item_is_design: $(this).find('input[name="item_is_design[]"]').is(':checked') ? 1 : 0,
                item_is_printed: $(this).find('input[name="item_is_printed[]"]').is(':checked') ? 1 : 0
            });
        });

        let orderData = {
            // user_id: $('#user_id').val() || 0,
            order_id: $('#order_id').val() || 0,
            client_id: $('#client_id').val(),
            order_date: $('#order_today_date').val(),
            process_time: $('#process_time').val(),
            order_before_tax: $('#o_subtotal').val(),
            order_tax: $('#o_tax').val(),
            order_discount: $('#o_discount').val(),
            order_credits: $('#o_credits').val(),
            order_after_tax: $('#o_total').val(),
            order_amount_paid: $('#o_paid').val(),
            order_amount_due: $('#o_due').val(),
            payment_type_id: $('#payment_t_method').val() || 1,
            status_id: $('#o_status').val() || 1,
            order_comments: $('#o_comments').val(),
            items: items
        };

        $.ajax({
            url: 'get/invoice-save.php',
            type: 'POST',
            data: JSON.stringify(orderData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);

                    // Reset form if new order, or just reload if edit
                    if (orderData.order_id === 0) {
                        $('#order_id').val(0);
                        $('#orderItems tbody').empty();
                    }

                    window.location.href = 'index.php';
                } else {
                    alert(response.message || 'Failed to save order.');
                }
            },
            error: function () {
                alert("Error submitting invoice.");
            }
        });
    });

    // Delete order
    $(document).on('click', '.delete-order', function () {
        const orderID = $(this).data('order-id');

        if (!confirm(`Are you sure you want to delete order PS#25-${orderID}?`)) return;

        $.ajax({
            url: 'get/invoice-delete.php', // adjust path if needed
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'delete',
                order_id: orderID
            }),
            success: function (response) {
                if (response.status === 'success') {
                    // alert('Order deleted successfully.');
                    loadOrders();
                } else {
                    alert('❌ ' + (response.message || 'Failed to delete order.'));
                }
            },
            error: function (xhr, status, error) {
                alert('Server error deleting order.');
            }
        });
    });

    loadClients();

    $("#newMember").click(function () {
        $("#clientForm")[0].reset();
        $("#client_id").val('');
        $(".modal-title").text("Add Client");
        $("#clientModal").modal("show");
    });

    $("#clientForm").submit(function (e) {
        e.preventDefault();

        $.post("get/client_action.php", $(this).serialize() + "&action=save", function (res) {
            alert(res);
            $("#clientModal").modal("hide");
            setTimeout(loadClients, 300);
        });
    });

    function loadClients() {
        $.post("get/client_action.php", { action: "fetch" }, function (data) {
            $("#clientsTable tbody").html(data);
        });
    }

    $(document).on("click", ".editClient", function () {
        var id = $(this).data("id");

        $.post("get/client_action.php", { action: "get", client_id: id }, function (data) {
            var client = JSON.parse(data);

            $("#n_client_id").val(client.client_id);
            $("#mbusiness_name").val(client.business_name);
            $("#mbusiness_address").val(client.business_address);
            $("#contact_name").val(client.contact_name);
            $("#contact_phone").val(client.contact_phone);
            $("#contact_email").val(client.contact_email);
            $("#client_stma_id").val(client.client_stma_id);
            $("#tax_exempt_id").val(client.tax_exempt_id);

            $(".modal-title").text("Edit Client");
            $("#clientModal").modal("show");
        });
    });

    $(document).on("click", ".deleteClient", function () {
        if (confirm("Are you sure you want to delete this client?")) {
            var id = $(this).data("id");
            $.post("get/client_action.php", { action: "delete", client_id: id }, function (res) {
                alert(res);
                loadClients();
            });
        }
    });

    //download pdf
    $(document).on('click', '.download-pdf', function () {
        const orderId = $(this).data('oid');
        window.open('get/order_pdf.php?order_id=' + orderId, '_blank');
    });


    //Materials
    loadMaterials();

    $("#newMaterial").click(function () {
        loadCategories();
        $("#materialForm")[0].reset();
        $("#mat_id").val('');
        $(".modal-title").text("Add Material");
        $("#materialModal").modal("show");
    });

    $("#materialForm").submit(function (e) {
        e.preventDefault();
        $.post("get/material_action.php", $(this).serialize() + "&action=save", function (res) {
            alert(res);
            $("#materialModal").modal("hide");
            loadMaterials();
        });
    });

    function loadMaterials() {
        $.post("get/material_action.php", { action: "fetch" }, function (data) {
            $("#materialsTable tbody").html(data);
        });
    }

    $(document).on("click", ".editMaterial", function () {
        var id = $(this).data("id");

        $.post("get/material_action.php", { action: "get", mat_id: id }, function (data) {

            var mat = JSON.parse(data);

            $("#mat_id").val(mat.mat_id);
            $("#mat_vendor").val(mat.mat_vendor);
            $("#mat_name").val(mat.mat_name);
            $("#mat_details").val(mat.mat_details);
            $("#mat_roll_size").val(mat.mat_roll_size);
            $("#mat_length").val(mat.mat_length);
            $("#mat_size").val(mat.mat_size);
            $("#mat_cost").val(mat.mat_cost);
            $("#ink_cost").val(mat.ink_cost);

            // Load categories then pre-select
            loadCategories(function () {
                if (mat.categories) {
                    $("#cat_ids").val(mat.categories).change();
                }
            });

            $(".modal-title").text("Edit Material");
            $("#materialModal").modal("show");
        });
    });

    $(document).on("click", ".deleteMaterial", function () {
        if (confirm("Are you sure you want to delete this material?")) {
            var id = $(this).data("id");
            $.post("get/material_action.php", { action: "delete", mat_id: id }, function (res) {
                alert(res);
                loadMaterials();
            });
        }
    });

    function loadCategories(callback) {
        $.post("get/category_list.php", { action: "fetch" }, function (data) {
            $("#cat_ids").html(data);
            if (callback) callback();
        });
    }

    document.getElementById("o_comments").addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault(); // stop normal Enter behavior

            let textarea = this;
            let cursorPos = textarea.selectionStart;
            let value = textarea.value;

            // Insert newline + new bullet
            let newValue = value.substring(0, cursorPos) + "\n• " + value.substring(cursorPos);

            textarea.value = newValue;

            // Move cursor after the bullet
            textarea.selectionStart = textarea.selectionEnd = cursorPos + 3;
        }
    });

    // Add a bullet automatically if textarea is empty
    document.getElementById("o_comments").addEventListener("focus", function () {
        if (this.value.trim() === "") {
            this.value = "• ";
        }
    });

    // Delegate to tbody for dynamic rows
    $('#order_items').on('change', 'input[name="item_is_design[]"], input[name="item_is_printed[]"]', function () {
        const $row = $(this).closest('tr');
        const index = $row.index(); // row index
        const isDesign = $row.find('input[name="item_is_design[]"]').is(':checked') ? 1 : 0;
        const isPrinted = $row.find('input[name="item_is_printed[]"]').is(':checked') ? 1 : 0;

        // Get item_id (assuming you have it stored as data attribute)
        const itemId = $row.data('item-id');
        const orderId = $('#orderID').text(); // current order id

        if (!itemId) return; // safety

        // Update DB via AJAX
        $.ajax({
            url: 'get/update_item.php',
            method: 'POST',
            data: {
                item_id: itemId,
                order_id: orderId,
                item_is_design: isDesign,
                item_is_printed: isPrinted
            },
            success: function (res) {
                if (res.status === 'success') {
                    // Update row class
                    if (isDesign && isPrinted) {
                        $row.removeClass('design print').addClass('done');
                    } else if (isDesign) {
                        $row.removeClass('done print').addClass('design');
                    } else if (isPrinted) {
                        $row.removeClass('done design').addClass('print');
                    } else {
                        $row.removeClass('done design print');
                    }
                } else {
                    alert('Failed to update item: ' + res.message);
                }
            },
            error: function () {
                alert('Error updating item.');
            }
        });
    });

});