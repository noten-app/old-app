function toggleState(entry_id) {
    // Toggle UI state
    const element = document.getElementById("dot-" + entry_id);
    if (element.innerHTML.toString().includes("fa-circle")) {
        element.innerHTML = element.innerHTML.replace("fa-circle", "fa-check-circle");
        var checked = 1;
    } else if (element.innerHTML.toString().includes("fa-check-circle")) {
        element.innerHTML = element.innerHTML.replace("fa-check-circle", "fa-circle");
        var checked = 0;
    } else console.log("toggleState: error");
    // Insert into DB
    $.ajax({
        url: '/homework/state.php',
        type: 'POST',
        data: {
            checked: checked,
            entry_id: entry_id
        },
        success: (data) => { if (data != "success") console.log(data); }
    });
}