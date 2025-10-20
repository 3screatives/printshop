$(document).ready(function () {
    let statusOptions = [];

    // Step 1: Load Status Options
    $.getJSON('get/status_options.php')
        .done(function (statuses) {
            statusOptions = statuses;
            loadOrders(); // proceed to next step
        })
        .fail(function () {
            alert('Failed to load status options');
        });

    // Step 2: Load Orders
    function loadOrders() {
        $.getJSON('get/order_list.php')
            .done(function (response) {
                if (response.orders && response.orders.length > 0) {
                    renderOrders(response.orders);
                } else {
                    $('#orderListMain tbody').html('<tr><td colspan="6" class="text-center">No orders found</td></tr>');
                }
            })
            .fail(function () {
                alert('Failed to load orders');
            });
    }

    // Step 3: Render Orders Table
    function renderOrders(orders) {
        let rows = '';

        orders.forEach(o => {
            const formattedDate = new Date(o.order_due).toLocaleDateString("en-US", {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            // Build dropdown
            let statusSelect = `<select class="form-select form-select-sm order-status" data-order-id="${o.order_id}">`;
            statusOptions.forEach(status => {
                const selected = status.status_id === o.status_id ? "selected" : "";
                statusSelect += `<option value="${status.status_id}" ${selected}>${status.status_name}</option>`;
            });
            statusSelect += `</select>`;

            rows += `
                <tr>
                    <td>PS#25-${o.order_id}</td>
                    <td>${formattedDate}</td>
                    <td>${o.client_name ?? '—'}</td>
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
    }

    // Step 4: Handle Status Change (Live Update)
    $(document).on('focus mousedown', '.order-status', function () {
        const current = $(this).val();
        $(this).data('prev-status', current);
    });

    // main change handler
    $(document).on('change', '.order-status', function () {
        const $dropdown = $(this);
        const orderId = $dropdown.data('order-id');
        const newStatus = $dropdown.val();
        const oldStatus = $dropdown.data('prev-status') ?? $dropdown.data('old-status') ?? null;

        // console.log('Change detected. orderId=', orderId, 'oldStatus=', oldStatus, 'newStatus=', newStatus);
        $dropdown.data('prev-status', newStatus);

        $.ajax({
            url: 'get/update_order_status.php',
            method: 'POST',
            data: { order_id: orderId, status_id: newStatus },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    showUndoBanner(orderId, newStatus, oldStatus, $dropdown);

                    const $mainDropdown = $(`.order-status[data-order-id="${orderId}"]`).not($dropdown);
                    if ($mainDropdown.length) {
                        $mainDropdown.val(newStatus);
                        $mainDropdown.data('prev-status', newStatus);
                    }
                } else {
                    alert('Failed to update order status on server. Reverting UI.');
                    // revert UI immediately
                    if (oldStatus !== null) {
                        $dropdown.val(oldStatus);
                        $dropdown.data('prev-status', oldStatus);
                    }
                }
            },
            error: function (xhr, status, err) {
                // console.error('AJAX error updating status:', status, err);
                alert('Error updating order status. Reverting UI.');
                if (oldStatus !== null) {
                    $dropdown.val(oldStatus);
                    $dropdown.data('prev-status', oldStatus);
                }
            }
        });
    });

    //Show banner
    function showUndoBanner(orderId, newStatus, oldStatus, $dropdown) {
        // remove any existing banner
        $('.undo-banner').remove();

        // create simple confirmation banner
        const $banner = $(`
        <div class="undo-banner" style="
            position:fixed; top:12px; left:50%; transform:translateX(-50%);
            background:#343a40; color:#fff; padding:6px 12px; border-radius:6px;
            box-shadow:0 6px 18px rgba(0,0,0,0.2); z-index:99999;
            display:flex; align-items:center; font-size:14px;">
            <span>Status Updated Successfully! </span>
            <button class="dismiss-btn" style=" background:transparent; color:#fff; border:1px solid rgba(255,255,255,0.15); padding:6px 8px; border-radius:4px; cursor:pointer;"> X </button>
        </div>
    `);

        $('body').append($banner);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            $banner.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

    // Step 5: View Order
    $(document).on('click', '.view-order', function () {
        var orderID = $(this).data('order-id');
        $.ajax({
            url: 'get/order.php',
            method: 'GET',
            data: { order_id: orderID },
            dataType: 'json',
            success: function (response) {
                if (response.order) {
                    console.log(response);
                    const o = response.order;
                    $('#orderID').text(o.order_id);
                    $('#orderDue').text(new Date(o.order_due).toLocaleDateString());
                    $('.order-details').show();

                    //client Info
                    $('#client_name').text(o.client_name);
                    $('#client_address').text(o.client_address);
                    $('#client_phone').text(o.client_phone);
                    $('#client_email').text(o.client_email);

                    //Order Details
                    // $('#order_status').text(o.status_name);
                    const $statusSelect = $('#order_status_select');
                    $statusSelect.attr('data-order-id', o.order_id);
                    $statusSelect.empty();

                    statusOptions.forEach(status => {
                        const selected = String(status.status_id) === String(o.status_id) ? "selected" : "";
                        $statusSelect.append(`<option value="${status.status_id}" ${selected}>${status.status_name}</option>`);
                    });

                    // - X
                    $('#payment_method').text(o.payment_type);

                    $('#order_sub_total').text(o.before_tax);
                    $('#order_tax').text(o.tax);
                    $('#order_total').text(o.after_tax);
                    $('#order_discount').text(o.before_tax);
                    $('#order_amount_paid').text(o.paid);
                    $('#order_amount_due').text(o.due);

                    $('#order_comments').text(o.comment);

                    $('#stmaID').text(o.stmaID ? o.stmaID : '-');

                    // Fill Items
                    let rows = "";
                    response.items.forEach(item => {
                        rows += `<tr>
                        <td class="text-center">${item.quantity}</td>
                        <td>${item.material}</td>
                        <td>${item.details}</td>
                        <td>${item.size}</td>
                        <td class="text-end">${item.price}</td>
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

    //close View Order
    $('.close').on('click', function () {
        $('.order-details').hide();
    });

    //Step 6: Create Order
    //Add current date to create order form
    const todayDate = new Date().toISOString().split('T')[0];  // "YYYY-MM-DD"
    $('#order_today_date').val(todayDate);

    //Due Date
    function getAdjustedDate() {
        let date = new Date();
        date.setDate(date.getDate() + 2);

        const day = date.getDay(); // 0 = Sunday, 6 = Saturday

        if (day === 6 || day === 0) {
            // Saturday or Sunday → push 2 more days
            date.setDate(date.getDate() + 2);
        }

        return date.toISOString().split('T')[0]; // Format as YYYY-MM-DD
    }

    const adjustedDate = getAdjustedDate();
    $('#order_due').val(adjustedDate);

    $(document).on('click', '#newOrder', function () {
        $('.create-order').show();
    })

    //Close Create Order
    $('.close').on('click', function () {
        $('.create-order').hide();

        const $form = $('.create-order form');
        $form[0].reset(); // standard reset

        // Optional cleanup:
        $form.find('textarea').val('');
        $form.find('input[type="number"]').val('');
        $form.find('select').prop('selectedIndex', 0);

        // If you added rows dynamically, remove them (except first row maybe)
        $form.find('#orderItems tbody tr:gt(0)').remove(); // keep only the first row
    });

    //Create Order
    let materials = [];
    let count = 0;

    // Load materials once globally
    $.getJSON('get/materials.php')
        .done(function (data) {
            materials = data;
        })
        .fail(function () {
            alert('Failed to load materials.');
        });

    // Add item row dynamically
    $('#addItem').off('click').on('click', function () {
        count++;
        let rowId = count;

        let itemHtml = `
    <tr class="calculate itemRow" data-row="${rowId}">
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
        <td class="text-center"><input type="number" name="order_item_qty[]" class="form-control form-control-sm"></td>
        <td class="text-end"><div class="input-group"><span class="input-group-text">$</span>
            <input dir="rtl" type="number" name="order_item_price[]" class="form-control form-control-sm"></div></td>
        <td><div class="input-group"><span class="input-group-text">$</span>
            <input dir="rtl" type="number" name="order_item_total[]" class="form-control form-control-sm" disabled></div></td>
        <td><button type="button" class="removeItem form-control btn btn-sm btn-danger">X</button></td>
    </tr>`;

        $('#orderItems tbody').append(itemHtml);
    });


    // Search materials
    $(document).on('input focus', '.mat-search', function () {
        const $row = $(this).closest('.itemRow');
        const rowId = $row.data('row');  // ✅ rowId is now defined
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


    // Select material
    $(document).on('click', '.dropdown-item', function () {
        const matName = $(this).text().trim();
        const matId = $(this).data('id');
        const rowId = $(this).data('row');  // ✅ always defined
        const $row = $(`.itemRow[data-row="${rowId}"]`);

        $row.find('.mat-search').val(matName);
        $row.find('input[name="order_material_id[]"]').val(matId);
        $row.find('.dropdown-list').hide();

        getMaterialPrice(matId, rowId);
    });

    $(document).on('change', '.itemRow input, .itemRow textarea', function () {
        const $row = $(this).closest('.itemRow'); // get the current row
        const rowId = $row.find('input[name="item_row_id[]"]').data(); // from data-rid
        const matId = $row.find('input[name="order_material_id[]"]').val(); // from hidden input value

        if (matId && rowId) {
            getMaterialPrice(matId, rowId);
        }
    });

    // When user edits qty, price, width, or height
    $(document).on('input change',
        'input[name="order_item_qty[]"], input[name="order_item_price[]"], input[name="order_item_width[]"], input[name="order_item_height[]"], #order-discount, #order-paid',
        function () {
            const $row = $(this).closest('.itemRow');

            // Update item total for this row
            const qty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 0;
            const price = parseFloat($row.find('input[name="order_item_price[]"]').val()) || 0;
            $row.find('input[name="order_item_total[]"]').val((qty * price).toFixed(2));

            // Recalculate grand totals
            calculateTotal();
        }
    );

    // Discount or payment change
    $(document).on('input', '#order-discount, #order-paid', function () {
        calculateTotal();
    });


    function getMaterialPrice(matId, rowId) {
        $.ajax({
            url: "get/material_price.php",
            type: "POST",
            data: {
                material_id: matId,
                details: 'details',
                width: 24,
                height: 36,
                quantity: 1
            },
            dataType: "json",
            success: function (response) {
                const $row = $(`.itemRow[data-row="${rowId}"]`);
                $row.find('input[name="order_item_price[]"]').val(response.final_cost);
                const quantity = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 1;
                $row.find('input[name="order_item_total[]"]').val((response.final_cost * quantity).toFixed(2));
                calculateTotal();
            }
        });
    }

    function calculateTotal() {
        let subtotal = 0;

        // Sum all item totals
        $('input[name="order_item_total[]"]').each(function () {
            let val = parseFloat($(this).val()) || 0;
            subtotal += val;
        });

        // Update Subtotal
        $('#order-subtotal').val(subtotal.toFixed(2));

        // Calculate Tax (8.25%)
        let tax = subtotal * 0.0825;
        $('#order-tax').val(tax.toFixed(2));

        // Apply Discount
        let discountPercent = parseFloat($('#order-discount').val()) || 0;
        let discountAmount = (subtotal + tax) * (discountPercent / 100);

        // Final Total
        let total = (subtotal + tax) - discountAmount;

        // Update total input reliably
        $('#order-total').val(total.toFixed(2));

        // Paid & Due
        let paid = parseFloat($('#order-paid').val()) || 0;
        let due = total - paid;
        $('#order-due').val(total.toFixed(2));
    }

    // Hide dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.custom-dropdown').length) {
            $('.dropdown-list').hide();
        }
    });

    // Remove item
    $(document).on('click', '.removeItem', function () {
        $(this).closest('tr').remove();
        calculateTotal();
    });

    // Keyboard navigation for dropdown
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
                else items.first().addClass('active'); // loop
            }

            // Scroll to keep visible
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
                else items.last().addClass('active'); // loop
            }

            // Scroll to keep visible
            let newActive = dropdown.find('.active');
            dropdown.scrollTop(
                newActive.position().top + dropdown.scrollTop() - dropdown.height() / 2
            );
        }

        else if (e.key === 'Enter') {
            e.preventDefault();
            if (active.length) {
                active.trigger('click'); // simulate click
            }
        }

        else if (e.key === 'Escape') {
            dropdown.hide();
        }
    });

});
