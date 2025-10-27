$(document).ready(function () {
    let statusOptions = [];

    $.getJSON('get/status_options.php')
        .done(function (statuses) {
            statusOptions = statuses;
            loadOrders();
        })
        .fail(function () {
            alert('Failed to load status options');
        });

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

    function renderOrders(orders) {
        let rows = '';

        orders.forEach(o => {
            const formattedDate = new Date(o.order_due).toLocaleDateString("en-US", {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

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

    $(document).on('focus mousedown', '.order-status', function () {
        const current = $(this).val();
        $(this).data('prev-status', current);
    });

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
                    showUndoBanner(orderId, newStatus, oldStatus, $dropdown);

                    const $mainDropdown = $(`.order-status[data-order-id="${orderId}"]`).not($dropdown);
                    if ($mainDropdown.length) {
                        $mainDropdown.val(newStatus);
                        $mainDropdown.data('prev-status', newStatus);
                    }
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

    function showUndoBanner(orderId, newStatus, oldStatus, $dropdown) {
        $('.undo-banner').remove();

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

        setTimeout(() => {
            $banner.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

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

                    $('#client_name').text(o.client_name);
                    $('#client_address').text(o.client_address);
                    $('#client_phone').text(o.client_phone);
                    $('#client_email').text(o.client_email);

                    const $statusSelect = $('#order_status_select');
                    $statusSelect.attr('data-order-id', o.order_id);
                    $statusSelect.empty();

                    statusOptions.forEach(status => {
                        const selected = String(status.status_id) === String(o.status_id) ? "selected" : "";
                        $statusSelect.append(`<option value="${status.status_id}" ${selected}>${status.status_name}</option>`);
                    });

                    $('#payment_method').text(o.payment_type);

                    $('#order_sub_total').text(o.before_tax);
                    $('#order_tax').text(o.tax);
                    $('#order_total').text(o.after_tax);
                    $('#order_discount').text(o.before_tax);
                    $('#order_amount_paid').text(o.paid);
                    $('#order_amount_due').text(o.due);

                    $('#order_comments').text(o.comment);

                    $('#stmaID').text(o.stmaID ? o.stmaID : '-');

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

    $('.close').on('click', function () {
        $('.order-details').hide();
    });

    const todayDate = new Date().toISOString().split('T')[0];
    $('#order_today_date').val(todayDate);

    function getAdjustedDate() {
        let date = new Date();
        date.setDate(date.getDate() + 2);

        const day = date.getDay();

        if (day === 6 || day === 0) {
            date.setDate(date.getDate() + 2);
        }

        return date.toISOString().split('T')[0];
    }

    const adjustedDate = getAdjustedDate();
    $('#order_due').val(adjustedDate);

    $(document).on('click', '#newOrder', function () {
        $('.create-order').show();
    })

    $('.close').on('click', function () {
        $('.create-order').hide();

        const $form = $('.create-order form');
        $form[0].reset();

        $form.find('textarea').val('');
        $form.find('input[type="number"]').val('');
        $form.find('select').prop('selectedIndex', 0);

        $form.find('#orderItems tbody tr:gt(0)').remove();
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

    $('#order_process').on('change', function () {
        $('.itemRow').each(function () {
            const rowId = $(this).data('row');
            const matId = $(this).find('input[name="order_material_id[]"]').val();
            if (matId) {
                getMaterialPrice(matId, rowId);
            }
        });
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

    $(document).on('input', '#order-discount, #order-paid , #order-credits', function () {
        calculateTotal();
    });

    function getMaterialPrice(matId, rowId) {
        const $row = $(`.itemRow[data-row="${rowId}"]`);

        const itemDetails = $row.find('textarea[name="order_item_details[]"]').val() || "";
        const itemWidth = parseFloat($row.find('input[name="order_item_width[]"]').val()) || 0;
        const itemHeight = parseFloat($row.find('input[name="order_item_height[]"]').val()) || 0;
        const itemQty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 1;
        const orderProcess = parseFloat($('#order_process').val()) || 1;

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
                const unitPrice = parseFloat(response.final_cost) || 0;
                const qty = parseFloat($row.find('input[name="order_item_qty[]"]').val()) || 1;
                const total = unitPrice * qty;

                $row.find('input[name="order_item_price[]"]').val(unitPrice.toFixed(2));
                $row.find('input[name="order_item_total[]"]').val(total.toFixed(2));
                // console.log('Material Cost per Linear Inch:', response.mat_cost_l + ' | Ink Cost Total: ' + response.ink_cost_total + ' | Cost per Print: ' + response.cost_per_print + ' | Total Cost: ' + response.total_cost + ' | Final Price: ' + response.final_price);
                calculateTotal();
            }
        });
    }

    function calculateTotal() {
        let subtotal = 0;

        $('input[name="order_item_total[]"]').each(function () {
            let val = parseFloat($(this).val()) || 0;
            subtotal += val;
        });

        $('#order-subtotal').val(subtotal.toFixed(2));

        let tax = subtotal * 0.0825;
        $('#order-tax').val(tax.toFixed(2));

        let discountPercent = parseFloat($('#order-discount').val()) || 0;
        let discountAmount = (subtotal + tax) * (discountPercent / 100);

        let total = (subtotal + tax) - discountAmount;

        let creditAmount = parseFloat($('#order-credits').val()) || 0;
        total -= creditAmount;

        $('#order-total').val(total.toFixed(2));

        let paid = parseFloat($('#order-paid').val()) || 0;
        let due = total - paid;

        $('#order-due').val(due.toFixed(2));

        if (total <= 0) {
            total = 0;
        }
        if (due <= 0) {
            due = 0;
        }
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
        const $input = $("#itemInput");
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
                                data-email="${client.contact_email || ''}">
                                ${client.business_name}
                            </button>`;
                        $suggestions.append(item);
                    });
                }
            });
        });

        // Fill fields when a suggestion is clicked
        $suggestions.on("click", ".list-group-item-action", function () {
            const $this = $(this);
            $("#c_client_id").val($this.data("id"));
            $("#itemInput").val($this.data("name"));
            $("#c_client_address").val($this.data("address"));
            $("#c_client_name").val($this.data("cname"));
            $("#c_client_phone").val($this.data("phone"));
            $("#c_client_email").val($this.data("email"));
            $suggestions.empty().hide();
        });

        // Hide suggestions when clicking outside or moving to another field
        $(document).on("click focusin", function (e) {
            if (!$(e.target).closest("#itemInput, #suggestions").length) {
                $suggestions.empty().hide();
            }
        });
    });

    $('#submitOrder').off('click').on('click', function (e) {
        e.preventDefault();
        let isValid = true;
        let rows = $('#orderItems tbody tr');
        let items = [];
        rows.each(function () {
            let item = {
                item_code: $(this).find('input[name="order_material_id[]"]').val(),
                details: $(this).find('textarea[name="order_item_details[]"]').val(),
                order_size_width: $(this).find('input[name="order_item_width[]"]')
                    .val(),
                order_size_height: $(this).find('input[name="order_item_height[]"]')
                    .val(),
                order_item_quantity: $(this).find('input[name="order_item_qty[]"]')
                    .val(),
                order_item_price: $(this).find('input[name="order_item_price[]"]')
                    .val(),
                order_item_final_amount: $(this).find(
                    'input[name="order_item_total[]"]').val()
            };

            items.push(item);
        });

        // Collect other form data
        // let orderData = {
        //     user_id: $('#user_id').val(),
        //     order_id: $('#order_id').val(),
        //     order_receiver_name: $('#order_receiver_name').val(),
        //     order_receiver_address: $('#order_receiver_address').val(),
        //     order_receiver_phone: $('#order_receiver_phone').val(),
        //     order_receiver_email: $('#order_receiver_email').val(),
        //     order_total_before_tax: $('#order_total_before_tax').val(),
        //     order_total_tax: $('#order_total_tax').val(),
        //     order_tax_per: $('#order_tax_per').val(),
        //     order_total_after_tax: $('#order_total_after_tax').val(),
        //     order_amount_paid: $('#order_amount_paid').val(),
        //     order_total_amount_due: $('#order_total_amount_due').val(),
        //     payment_id: $('#payment_id').val(),
        //     order_status: $('select[name="order_status"]').val(),
        //     client_id: $('#client_id').val(),
        //     order_due: $('#order_due').val(),
        //     items: items
        // };

        let orderData = {
            //ids
            user_id: 1,
            order_id: 0,
            //client
            client_name: $('#itemInput').val(),
            client_address: $('#c_client_address').val(),
            client_phone: $('#c_client_phone').val(),
            client_email: $('#c_client_email').val(),
            client_contact_name: $('#c_contact_name').val(),
            //order details
            order_date: $('#order_today_date').val(),
            order_process_time: $('#order_process').val(),
            order_payment_type: $('#paument_method').val(),
            order_subtotal: $('#order-subtotal').val(),
            order_tax: $('#order-tax').val(),
            order_discount: $('#order-discount').val(),
            order_credits: $('#order-credits').val(),
            order_total: $('#order-total').val(),
            order_paid: $('#order-paid').val(),
            order_due_amount: $('#order-due').val(),
            order_comments: $('#order_comments').val(),
            items: items
        }
        console.log(orderData);

        // if (!isValid) return;
        // $.ajax({
        //     url: 'invoice-save.php',
        //     type: 'POST',
        //     data: orderData,
        //     dataType: 'json',
        //     success: function (response) {
        //         console.log('Success:', response);
        //         alert(response.message);
        //         if (response.status === 'success') {
        //             window.location.href = 'index.php';
        //         }
        //     },
        //     error: function () {
        //         alert("Error submitting invoice.");
        //     }
        // });
    });

});