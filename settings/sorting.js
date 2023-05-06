function setSorting(sorting) {
    $.ajax({
        type: "POST",
        url: "sorting.php",
        data: { sorting: sorting },
        success: function() {
            location.reload();
        }
    });
}