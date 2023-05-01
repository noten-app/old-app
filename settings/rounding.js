function setRounding(rounding) {
    $.ajax({
        type: "POST",
        url: "rounding.php",
        data: { rounding: rounding },
        success: function() {
            location.reload();
        }
    });
}