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

//Select Custom Input field
$(document).ready(function () {
    function toggleCustomInputs() {
        $('.toggle-custom-input').each(function () {
            const $select = $(this);
            const target = $select.data('target');

            if ($select.val() === 'custom') {
                $(target).show();
            } else {
                $(target).hide();
            }
        });
    }

    // Initial load
    toggleCustomInputs();

    // On change
    $(document).on('change', '.toggle-custom-input', function () {
        toggleCustomInputs();
    });
});
//Closed


$(document).ready(function () {
    calculate();
    // Load materials dynamically
    $.get("calc/get_materials.php", function (data) {
        $("#material_id").append(data);
    });

    function calculate() {
        $.ajax({
            url: "ps-admin/get/material_price.php",
            type: "POST",
            data: $("#calcForm").serialize(),
            dataType: "json",
            success: function (response) {
                console.log(response)
                $("#result").html("Final Price: $" + response.final_price);
                $("#breakdown").html(response.breakdown);
            }
        });
    }

    // Trigger calculation on input changes
    $("#calcForm input, #calcForm select").on("input change", function () {
        calculate();
    });
});