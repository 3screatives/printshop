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

    const priceInputs = "#item_width, #item_height, #item_qty, #material_id, #item_grommets, #item_hframes, #item_sides, input[name='have_design'], #item_print_size";
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

        const designVal = $('input[name="have_design"]:checked').val();
        const hasDesign = designVal === '1' ? 1 : (designVal === '0' ? 0 : null);

        const printSize = parseFloat($('#item_print_size').val()) || 1;

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
                printSize: printSize,
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
                if (hasDesign === 0) subtotal += 35;

                // let rush = ($('#process_time').val() == 1) ? 0.3 : 0;
                // let rushVal = subtotal * rush;
                // if (rush > 0 && rushVal < 15) rushVal = 15;
                // let finalTotal = subtotal + rushVal;

                let finalTotal = subtotal;

                $("#unit_price").val(unitPrice.toFixed(2));
                $("#total_price").val(finalTotal.toFixed(2));
                // $("#o_rush").val(rushVal.toFixed(2));

                $("#unit_price_display").text("$" + unitPrice.toFixed(2));
                const designFee = hasDesign === 0 ? 35 : 0;
                $("#design_fee_display").text(`$${designFee}.00`);
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
            $('#design_upload').removeClass('d-none');
        } else {
            $('#design_upload').addClass('d-none');
            $('#design_file').val('');           // clear file input
            $('#design_file_preview').html('');  // clear preview
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
    $('#add_to_cart').on('click', function (e) {
        e.preventDefault();

        const orientation = $('input[name="item_orientation"]:checked').val();

        const data = {
            mat_id: $('#material_id').val(),
            catName: $('#cat_name_cart').val(),
            catImage: $('#cat_img_name').val(),
            matType: $('#material_id option:selected').data('mat-type'),
            item_qty: Number($('#item_qty').val()) || 1,
            width: Number($('#item_width').val()) || 0,
            height: Number($('#item_height').val()) || 0,

            item_orientation: Number(orientation),

            item_print_size: $('#item_print_size option:selected').text(),
            item_sides: $('#item_sides').length ? Number($('#item_sides').val()) : 0,
            item_grommets: $('#item_grommets').length ? Number($('#item_grommets').val()) : 0,
            item_hframes: $('#item_hframes').length ? Number($('#item_hframes').val()) : 0,

            // process_time: Number($('#process_time').val()),

            have_design: $('input[name="have_design"]:checked').val(),

            unit_price: Number($('#unit_price').val()) || 0,
            total_price: Number($('#total_price').val()) || 0
        };

        $.post('cart/cart_add.php', data, function (res) {
            loadCart(res);

            // show success popup
            const $alert = $('#cartSuccess');
            $alert.removeClass('d-none').fadeIn();

            setTimeout(() => {
                $alert.fadeOut(() => $alert.addClass('d-none'));
            }, 2000);
        });
    });

    function updateCartButton(data = null) {

        const path = window.location.pathname;
        const $cartBtn = $('#cart_summary');

        // On CHECKOUT → go back to VIEW CART
        if (path.includes('checkout.php')) {
            $cartBtn
                .attr('href', 'view-cart.php')
                .html(`<i class="bi bi-arrow-left me-2"></i> Back to Cart`);

            return;
        }

        // On VIEW CART → go back to SHOP
        if (path.includes('view-cart.php')) {
            $cartBtn
                .attr('href', 'index.php')
                .html(`<i class="bi bi-arrow-left me-2"></i> Back to Shop`);

            return;
        }

        // Everywhere else → normal cart summary
        if (data) {
            $cartBtn
                .attr('href', 'view-cart.php')
                .html(`${data.count} Item(s) | $${data.sub_total} <i class="bi bi-cart3 ms-2"></i>`);
        }
    }

    // Load cart (updates offcanvas + header)
    function loadCart() {
        $.getJSON('cart/cart_get.php', function (data) {
            $('#cart_container').html(data.html);
            //$('#cart_summary').html(`${data.count} Item(s) | $${data.total} <i class="bi bi-cart3 ms-2"></i>`); // header
            updateCartButton(data);

            if (data.count > 0) {
                $('#cart_total_footer').text(`$${data.sub_total}`);
                $('#rush_charge_val').text(`$${data.rush}`);
                $('#cart_tax').text(`$${data.tax}`);
                $('#cart_total').text(`$${data.total}`);
            } else {
                $('#cart_calc').html('');
            }

            $(document).on('change', '#process_time', function () {

                const isRush = $(this).val();

                // Save rush selection to session
                $.post('cart/cart_set_rush.php', {
                    process_time: isRush
                }, function () {
                    loadCart(); // reload cart with updated totals
                });
            });

        });
    }

    // Remove item
    $(document).on('click', '.remove-item', function () {
        const key = $(this).data('key');

        $.post('cart/cart_remove.php', { key }, function () {
            loadCart(); // force fresh fetch AFTER removal
        }, 'json');
    });

    // Clear cart (optional)
    $(document).on('click', '#clear_cart', function () {
        $.post('cart/cart_clear.php', {}, function () {
            loadCart();
        }, 'json');
    });

    // Initial load
    loadCart();


    // Add to Cart Validation
    $(function () {

        const $form = $('.order-form-wrap');
        const $btn = $('#add_to_cart');

        // Capture initial state
        const initialState = $form.find('input, select, textarea')
            .serialize();

        function checkForChanges() {
            const currentState = $form.find('input, select, textarea')
                .serialize();

            if (currentState !== initialState) {
                $btn.prop('disabled', false);
            } else {
                $btn.prop('disabled', true);
            }
        }

        // Watch all inputs
        $form.on('change input', 'input, select, textarea', checkForChanges);
    });
});
