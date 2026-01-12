//On Scroll Actions
$(window).scroll(function () {
    if ($(this).scrollTop() > 96) {
        $("header").css("margin-top", "-96px");
        $('.search-bar').addClass('short');
    } else {
        $("header").css("margin-top", "0px");
        $('.search-bar').removeClass('short');
    }
});
//Closed

$(document).ready(function () {

    const priceInputs = "#item_width, #item_height, #item_qty, #material_id, #process_time, #item_grommets, #item_hframes, #item_sides, input[name='have_design']";
    $(priceInputs).on("change input", calculateFrontPrice);

    calculateFrontPrice();

    function calculateFrontPrice() {
        let matId = $("#material_id").val();

        let selectedImage = $("#material_id option:selected").data("image");
        $("#material_image").attr("src", selectedImage);

        getMaterialPrice(matId);
    }

    function getMaterialPrice(matId) {

        const itemWidth = parseFloat($('#item_width').val()) || 0;
        const itemHeight = parseFloat($('#item_height').val()) || 0;
        const itemQty = parseInt($('#item_qty').val()) || 1;
        const itemGrommets = parseInt($('#item_grommets').val()) || 0;
        const itemHframes = parseInt($('#item_hframes').val()) || 0;
        const itemSides = parseInt($('#item_sides').val()) || 0;
        const hasDesign = $('#design_yes').is(':checked') ? 1 : 0;

        $.ajax({
            url: "ps-admin/get/material_price.php",
            type: "POST",
            dataType: "json",
            data: {
                material_id: matId,
                width: itemWidth,
                height: itemHeight,
                quantity: itemQty,
                sides: $('#item_sides').val() || 'single',
                color: $('#item_color').val() || 0,
                is_cost_price: 0
            },
            success: function (response) {
                if (response.sizeError) {
                    $('.errorBox').html(response.sizeError);

                    $('[name="item_width"], [name="item_height"]').removeClass('border-red');

                    if (response.field === 'both') {
                        $('[name="item_width"], [name="item_height"]').addClass('border-red');
                    } else if (response.field) {
                        $(`[name="item_${response.field}"]`).addClass('border-red');
                    }
                    return;
                }
                $('.errorBox').html('');
                $('.order-form-wrap')
                    .find('input[name="item_width"], input[name="item_height"]')
                    .removeClass('border-red');

                let unitPrice = parseFloat(response.final_cost) || 0;
                let subtotal = unitPrice * itemQty;

                if (itemGrommets === 1) subtotal += (4 * itemQty);
                if (itemHframes === 1) subtotal += (3 * itemQty);
                if (itemSides === 1) subtotal += (2 * itemQty);
                if (hasDesign === 1) subtotal += 35;

                let rush = ($('#process_time').val() == 2) ? 0.3 : 0;
                let rushVal = subtotal * rush;
                if (rush > 0 && rushVal < 15) rushVal = 15;

                let finalTotal = subtotal + rushVal;

                $("#unit_price").val(unitPrice.toFixed(2));
                $("#total_price").val(finalTotal.toFixed(2));
                $("#o_rush").val(rushVal.toFixed(2));

                $("#unit_price_display").text("$" + unitPrice.toFixed(2));
                $("#design_fee_display").text("$" + (hasDesign === 1 ? 35 : 0) + ".00");
                $("#result").text("Final Price: $" + finalTotal.toFixed(2));
            }
        });
    }

    $("#material_id").on("change", function () {
        const imageKey = $("#material_id option:selected").data("image");

        if (imageKey) {
            $("#item_image").attr("src", "img/product-" + imageKey + ".jpg");
        }
    });

    // Toggle upload field
    // ===== Toggle Logo Upload =====
    $('input[name="have_logo"]').on('change', function () {
        if ($(this).val() === '1') {
            $('#logo_upload').removeClass('d-none');
        } else {
            $('#logo_upload').addClass('d-none');
            $('#logo_file').val('');
            $('#file_preview').html('');
        }
    });

    // ===== Toggle Design Upload =====
    $('input[name="have_design"]').on('change', function () {
        if ($('#design_yes').is(':checked')) {
            $('#design_upload').addClass('d-none');
            $('#design_file').val('');           // clear file input
            $('#design_file_preview').html('');  // clear preview
        } else {
            $('#design_upload').removeClass('d-none');
        }
    });


    // ===== File Preview Function =====
    function showPreview(input, previewDiv) {
        const file = input.files[0];
        const preview = $(previewDiv);
        preview.html('');

        if (!file) return;

        // Image preview
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.html(`
                    <img src="${e.target.result}"
                         class="img-thumbnail"
                         style="max-width:150px;">
                `);
            };
            reader.readAsDataURL(file);

            // PDF preview
        } else if (file.type === 'application/pdf') {
            preview.html(`
                <div class="border rounded p-2">
                    <strong>${file.name}</strong>
                </div>
            `);
        } else {
            preview.html('<small class="text-danger">Unsupported file type</small>');
        }
    }

    // ===== Logo Preview =====
    $('#logo_file').on('change', function () {
        showPreview(this, '#file_preview');
    });

    // ===== Design Preview =====
    $('#design_file').on('change', function () {
        showPreview(this, '#design_file_preview');
    });

    // Add to Cart
    // Add to Cart
    $('#add_to_cart').on('click', function () {
        const data = {
            mat_id: $('#material_id').val(),
            item_qty: parseInt($('#item_qty').val()) || 1,
            width: parseFloat($('#item_width').val()) || 0,
            height: parseFloat($('#item_height').val()) || 0,
            item_grommets: parseInt($('#item_grommets').val()) || 0,
            item_hframes: parseInt($('#item_hframes').val()) || 0,
            item_sides: parseInt($('#item_sides').val()) || 0,
            have_design: $('#design_yes').is(':checked') ? 1 : 0,
            unit_price: parseFloat($('#unit_price').val()) || 0,
            total_price: parseFloat($('#total_price').val()) || 0
        };

        $.post('cart/cart_add.php', data, loadCart);
    });

    // Load cart (updates offcanvas + header)
    function loadCart() {
        $.getJSON('cart/cart_get.php', function (data) {
            $('#cart_items').html(data.html);              // offcanvas items
            $('#cart_total').text(data.total);            // footer total
            $('#cart_summary').html(`${data.count} Item(s) | $${data.total} <i class="bi bi-cart3 ms-2"></i>`); // header
        });
    }

    // Remove item
    $(document).on('click', '.remove-item', function () {
        $.post('cart/cart_remove.php', { key: $(this).data('key') }, loadCart);
    });

    // Update quantity (live)
    $(document).on('change', '.cart-qty', function () {
        $.post('cart/cart_update.php', { key: $(this).data('key'), qty: $(this).val() }, loadCart);
    });

    // Clear cart (optional)
    $('#clear_cart').on('click', function () {
        $.post('cart/cart_clear.php', {}, loadCart);
    });

    // Initial load
    loadCart();

});
