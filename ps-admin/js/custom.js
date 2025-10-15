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

    // show banner with undo - returns banner jQuery element
    function showUndoBanner(orderId, newStatus, oldStatus, $dropdown) {
        // remove any existing banner
        $('.undo-banner').remove();

        // create banner (class-based to avoid id collisions)
        const $banner = $(`
            <div class="undo-banner" style="
                position:fixed; top:12px; left:50%; transform:translateX(-50%);
                background:#343a40; color:#fff; padding:6px 12px; border-radius:6px;
                box-shadow:0 6px 18px rgba(0,0,0,0.2); z-index:99999; display:flex; gap:12px; align-items:center; font-size: 14px;">
                <span>Order ${orderId} updated to status ${newStatus}</span>
                <button class="undo-btn" style="
                    background:#fff; color:#343a40; border:none; padding:6px 10px; border-radius:4px; cursor:pointer;">
                    Undo
                </button>
                <button class="dismiss-btn" style="
                    background:transparent; color:#fff; border:1px solid rgba(255,255,255,0.15);
                    padding:6px 8px; border-radius:4px; cursor:pointer;">
                    X
                </button>
            </div>
        `);

        $('body').append($banner);

        // set a timer to "commit" after 6s
        const timer = setTimeout(function () {
            console.log(`Auto-committing status ${newStatus} for order ${orderId}`);
            // optional: call commit endpoint if you want a second confirm step
            // commitStatusChange(orderId, newStatus);
            $banner.fadeOut(200, function () { $(this).remove(); });
        }, 6000);

        // Undo handler (scoped to this banner)
        $banner.on('click', '.undo-btn', function (e) {
            e.preventDefault();
            clearTimeout(timer); // stop auto commit
            console.log('Undo clicked for order', orderId, 'reverting to', oldStatus);

            // if no known oldStatus, just remove banner and do nothing (safety)
            if (oldStatus === null || oldStatus === undefined) {
                console.warn('No oldStatus available — cannot revert.');
                $banner.fadeOut(200, function () { $(this).remove(); });
                return;
            }

            // Send revert request to same endpoint
            $.ajax({
                url: 'get/update_order_status.php',
                method: 'POST',
                data: { order_id: orderId, status_id: oldStatus, undo: 1 }, // optional `undo` flag
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        // update dropdown UI and its stored prev value
                        $dropdown.val(oldStatus);
                        $dropdown.data('prev-status', oldStatus);
                        console.log(`Reverted order ${orderId} to status ${oldStatus}`);
                    } else {
                        alert('Failed to revert status on server.');
                        console.error('Server response on revert:', res);
                    }
                    $banner.fadeOut(200, function () { $(this).remove(); });
                },
                error: function (xhr, status, err) {
                    alert('Error reverting status.');
                    console.error('AJAX error on revert:', status, err);
                    $banner.fadeOut(200, function () { $(this).remove(); });
                }
            });
        });

        // Dismiss button (just hides banner without reverting)
        $banner.on('click', '.dismiss-btn', function (e) {
            e.preventDefault();
            clearTimeout(timer);
            $banner.fadeOut(200, function () { $(this).remove(); });
        });

        // return for possible external use
        return $banner;
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
                    $('#order_status').text(o.status_name);
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
    let items = [];
    var count = $(".itemRow").length;

    // Add item row dynamically
    $('#addItem').off('click').on('click', function () {
        count++;

        let itemHtml = `
        <tr class="calculate itemRow">
            <td>
                <select class="form-control form-control-sm" name="order_material_id[]"
                    id="order_material_id${count}">
                    <option value="0" selected>Select</option>
                    <option value="101">Poster</option>
                    <option value="102">Banner</option>
                    <option value="103">Adhesive</option>
                    <option value="104">Clear Adhesive</option>
                    <option value="105">Static Cling</option>
                    <option value="106">Backlit</option>
                </select>
            </td>
            <td>
                <textarea name="order_item_details[]" class="form-control form-control-sm"
                    rows="1" id="order_item_details${count}" placeholder="Details"></textarea>
            </td>
            <td>
                <div class="input-group">
                    <input dir="rtl" type="number" name="order_item_width[]"
                        id="order_item_width${count}" class="form-control form-control-sm"
                        placeholder="Width">
                    <span class="input-group-text">in</span>
                    <input dir="rtl" type="number" name="order_item_height[]"
                        id="order_item_height${count}" class="form-control form-control-sm"
                        placeholder="Height">
                    <span class="input-group-text">in</span>
                </div>
            </td>
            <td class="text-center">
                <input type="number" name="order_item_qty[]" id="order_item_qty${count}"
                    class="form-control form-control-sm">
            </td>
            <td class="text-end">
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input dir="rtl" type="number" name="order_item_price[]"
                        id="order_item_price${count}" class="form-control form-control-sm">
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input dir="rtl" type="number" name="order_item_total[]"
                        id="order_item_total${count}" class="form-control form-control-sm" disabled>
                </div>
            </td>
            <td><button type="button" class="removeItem form-control btn btn-sm btn-danger">X</button></td>
        </tr>`;

        $('#orderItems tbody').append(itemHtml);
    });


    // Remove item row dynamically
    $(document).on('click', '.removeItem', function () {
        $(this).closest('tr').remove();
    });
});
