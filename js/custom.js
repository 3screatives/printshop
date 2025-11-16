$(document).ready(function () {

    function calculateFrontPrice() {
        let matId = $("#material_id").val();
        getMaterialPrice(matId);
    }

    // For static fields
    $("#item_width, #item_height, #item_qty")
        .on("change input", calculateFrontPrice);

    // For dynamic <select id="material_id">
    $(document).on("change", "#process_time", calculateFrontPrice);

    calculateFrontPrice();
});

function getMaterialPrice(matId) {

    const itemDetails = $('#item_details').val() || "";
    const itemWidth = parseFloat($('#item_width').val()) || 0;
    const itemHeight = parseFloat($('#item_height').val()) || 0;
    const itemQty = parseFloat($('#item_qty').val()) || 1;
    const orderProcess = parseFloat($('#process_time').val()) || 1;

    $.ajax({
        url: "ps-admin/get/material_price.php",
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
            const total = unitPrice * itemQty;

            $("#unit_price").val(unitPrice.toFixed(2));
            $("#total_price").val(total.toFixed(2));

            $("#result").text("Final Price: $" + total.toFixed(2));
        }
    });
}
