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
    $("#item_width, #item_height, #item_qty, #material_id, #process_time, #item_grommets, #item_hframes")
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
        const itemGrommets = parseFloat($('#item_grommets').val()) || 0;
        const itemHframes = parseFloat($('#item_hframes').val()) || 0;

        $.ajax({
            url: "ps-admin/get/material_price.php",
            type: "POST",
            data: {
                material_id: matId,
                details: itemDetails,
                width: itemWidth,
                height: itemHeight
            },
            dataType: "json",
            success: function (response) {

                let unitPrice = parseFloat(response.final_cost) || 0;
                let subtotal = unitPrice * itemQty;

                // GROMMETS
                let grommetCost = (itemGrommets === 1) ? (4 * itemQty) : 0;
                subtotal += grommetCost;

                // H-FRAMES
                let hframeCost = (itemHframes === 1) ? (3 * itemQty) : 0;
                subtotal += hframeCost;

                // RUSH LOGIC
                let val = parseInt($('#process_time').val()) || 1;
                let rush = val === 2 ? 0.3 : 0;

                let rushVal = subtotal * rush;
                if (rush > 0 && rushVal < 15) rushVal = 15;

                // FINAL TOTAL — FIXED
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