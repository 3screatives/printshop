$(document).ready(function () {
    let statusOptions = [];

    // Step 1: Load Status Options
    $.getJSON('get_status_options.php')
        .done(function (statuses) {
            statusOptions = statuses;
            loadOrders(); // proceed to next step
        })
        .fail(function () {
            alert('Failed to load status options');
        });

    // Step 2: Load Orders
    function loadOrders() {
        $.getJSON('get_order_list.php')
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
    $(document).on('change', '.order-status', function () {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();

        $.ajax({
            url: 'update_order_status.php',
            method: 'POST',
            data: { order_id: orderId, status_id: newStatus },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    console.log(`✅ Order ${orderId} updated to status ${newStatus}`);
                } else {
                    alert('Failed to update order status');
                }
            },
            error: function () {
                alert('Error updating order status');
            }
        });
    });

    // Step 5: View Order
    $(document).on('click', '.view-order', function () {
        var orderID = $(this).data('order-id');
        $.ajax({
            url: 'get_order.php',
            method: 'GET',
            data: { order_id: orderID },
            dataType: 'json',
            success: function (response) {
                console.log(response);
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
});
