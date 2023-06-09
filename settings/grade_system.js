function setSystem(system) {
    $.ajax({
        type: "POST",
        url: "grade_system.php",
        data: { system: system },
        success: data => {
            if(data == "success") {
                window.location.reload();
            } else if (data == "warn") {
                document.querySelectorAll("#system_container div").forEach(e => {
                    e.classList.remove("button_divider-button_active");
                    if(e.innerText.toLowerCase() == system) e.classList.add("button_divider-button_active");
                });
                open_overlay("overlay_warn_system");
            } else {
                alert(data);
            }
        }
    });
}