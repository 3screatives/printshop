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

    $("#item_width, #item_height, #item_qty, #material_id, #process_time, #item_grommets, #item_hframes")
        .on("change input", calculateFrontPrice);

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

                let unitPrice = parseFloat(response.final_cost) || 0;
                let subtotal = unitPrice * itemQty;

                if (itemGrommets === 1) subtotal += (4 * itemQty);
                if (itemHframes === 1) subtotal += (3 * itemQty);

                let rush = ($('#process_time').val() == 2) ? 0.3 : 0;
                let rushVal = subtotal * rush;
                if (rush > 0 && rushVal < 15) rushVal = 15;

                let finalTotal = subtotal + rushVal;

                $("#unit_price").val(unitPrice.toFixed(2));
                $("#total_price").val(finalTotal.toFixed(2));
                $("#o_rush").val(rushVal.toFixed(2));

                $("#unit_price_display").text("$" + unitPrice.toFixed(2));
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
});
