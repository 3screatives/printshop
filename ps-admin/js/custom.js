$(document).ready(function () {
    var $loading = $('#loadingDiv').hide()
    $(document)
        .ajaxStart(function () {
            $loading.show()
        })
        .ajaxStop(function () {
            $loading.hide()
        })

    let statusOptions = [];

    // First, load all status options
    $.ajax({
        url: 'get_status_options.php',
        method: 'GET',
        dataType: 'json',
        success: function (statuses) {
            statusOptions = statuses;
            console.log(statusOptions);
            // Then load orders
            $.ajax({
                url: 'get_order_list.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.orders) {
                        let rows = "";

                        response.orders.forEach(o => {
                            const formattedDate = new Date(o.order_due).toLocaleDateString("en-US", {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });

                            // Build select dropdown
                            let statusSelect = `<select class="form-select form-select-sm" data-order-id="${o.order_id}">`;
                            statusOptions.forEach(status => {
                                const selected = status.status_name === o.status_name ? "selected" : "";
                                statusSelect += `<option value="${status.status_id}" ${selected}>${status.status_name}</option>`;
                            });
                            statusSelect += `</select>`;

                            rows += `<tr>
                            <td>PS#25-${o.order_id}</td>
                            <td>${formattedDate}</td>
                            <td>${o.client_name}</td>
                            <td>$${o.order_after_tax}</td>
                            <td>${statusSelect}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-secondary btn-sm me-2 view-order"
                                    data-order-id="${o.order_id}">
                                    <span class="bi bi-search"></span>
                                </button>
                                <button class="btn btn-outline-primary btn-sm me-2">
                                    <span class="bi bi-pencil"></span>
                                </button>
                                <button class="btn btn-outline-danger btn-sm">
                                    <span class="bi bi-trash"></span>
                                </button>
                            </td>
                        </tr>`;
                        });

                        $('#orderListMain tbody').html(rows);
                    } else {
                        alert('No orders found');
                    }
                },
                error: function () {
                    alert('Failed to load orders');
                }
            });
        },
        error: function () {
            alert('Failed to load status options');
        }
    });

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

    // Trigger search on input
    $('#itemInput').on('input', function () {
        var query = $(this).val().trim();

        if (query.length >= 1) {
            $.ajax({
                url: 'get_client_data.php',
                method: 'GET',
                data: { q: query },
                dataType: 'json',
                success: function (data) {
                    var suggestionBox = $('#suggestions');
                    suggestionBox.empty();

                    if (data.length > 0) {
                        $.each(data, function (index, item) {
                            suggestionBox.append(
                                '<div class="suggestion-item" ' +
                                'data-id="' + item.client_id + '" ' +
                                'data-name="' + item.client_name + '" ' +
                                'data-address="' + item.client_address + '" ' +
                                'data-phone="' + item.client_phone + '" ' +
                                'data-email="' + item.client_email + '">' +
                                item.client_name +
                                '</div>'
                            );
                        });
                        suggestionBox.show();
                    } else {
                        suggestionBox.hide();
                    }
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });

    // When user clicks on a suggestion
    $(document).on('click', '.suggestion-item', function () {
        const $this = $(this);

        $('#itemInput').val($this.data('name'));
        $('#c_client_id').val($this.data('id'));
        $('#c_client_address').text($this.data('address'));
        $('#c_client_phone').val($this.data('phone'));
        $('#c_client_email').val($this.data('email'));
        $('#suggestions').hide();
    });

    // Hide suggestion box if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#itemInput, #suggestions').length) {
            $('#suggestions').hide();
        }
    });

    //View Order
    $(document).on('click', '.view-order', function () {
        var orderID = $(this).data('order-id');

        $.ajax({
            url: 'get_order.php',
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

    //Create Order
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

        // Load material options via AJAX for the new row
        // $.ajax({
        //     url: 'get-material-options.php',
        //     method: 'GET',
        //     success: function (data) {
        //         $('#item_code' + count).html(data);
        //     },
        //     error: function () {
        //         alert("Failed to load materials.");
        //     }
        // });
    });


    // Remove item row dynamically
    $(document).on('click', '.removeItem', function () {
        $(this).closest('tr').remove();
    });

    // Form submit
    $('#submitOrder').off('click').on('click', function (e) {
        e.preventDefault();
        let rows = $('#itemTable tbody tr');
        let items = [];
        rows.each(function () {
            let item = {
                item_code: $(this).find('select[name="order_material_id[]"]').val(),
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
        let orderData = {
            user_id: $('#user_id').val(),
            client_id: $('#c_client_id').val(),
            order_receiver_name: $('#c_client_address').val(),
            order_receiver_address: $('#c_client_address').val(),
            order_receiver_phone: $('#c_client_phone').val(),
            order_receiver_email: $('#c_client_email').val(),
            order_total_before_tax: $('#order_subtotal').val(),
            order_total_tax: $('#order_tax').val(),
            order_total_after_tax: $('#order_total').val(),
            order_discount: $('#order_discount').val(),
            order_amount_paid: $('#order_amount_paid').val(),
            order_total_amount_due: $('#order_amount_due').val(),
            payment_type: $('#payment_type').val(),
            items: items
        };

        console.log(orderData);

        // $.ajax({
        //     url: 'save_order.php',
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

    //Show Design Tool
    $(document).on('click', '#createDraft', function () {
        $('.design-tool').show();
    })
});