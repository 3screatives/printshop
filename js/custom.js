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
    // Recalculate price when inputs change
    $("#item_width, #item_height, #item_qty, #material_id, #process_time")
        .on("change input", calculateFrontPrice);

    calculateFrontPrice();

    function calculateFrontPrice() {
        let matId = $("#material_id").val();

        // Update image based on selected material
        let selectedImage = $("#material_id option:selected").data("image");
        $("#material_image").attr("src", selectedImage);

        getMaterialPrice(matId);
    }

    function getMaterialPrice(matId) {

        const itemDetails = $('#item_details').val() || "";
        const itemWidth = parseFloat($('#item_width').val()) || 0;
        const itemHeight = parseFloat($('#item_height').val()) || 0;
        const itemQty = parseFloat($('#item_qty').val()) || 1;

        $.ajax({
            url: "ps-admin/get/material_price.php",
            type: "POST",
            data: {
                material_id: matId,
                details: itemDetails,
                width: itemWidth,
                height: itemHeight,
                quantity: itemQty
            },
            dataType: "json",
            success: function (response) {

                let unitPrice = parseFloat(response.final_cost) || 0;
                let subtotal = unitPrice * itemQty;

                // RUSH LOGIC
                let val = parseInt($('#process_time').val()) || 1;
                let rush = 0;
                if (val === 2) rush = 0.3;

                let rushVal = subtotal * rush;
                if (rush > 0 && rushVal < 15) rushVal = 15;

                let finalTotal = subtotal + rushVal;

                // Update fields
                $("#unit_price").val(unitPrice.toFixed(2));
                $("#total_price").val(finalTotal.toFixed(2));
                $("#o_rush").val(rushVal.toFixed(2));

                $("#unit_price_display").text("$" + unitPrice.toFixed(2));
                $("#result").text("Final Price: $" + finalTotal.toFixed(2));
            }
        });
    }
});