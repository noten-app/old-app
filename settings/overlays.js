const overlay_container = document.getElementById("overlay_container");
var overlay_open = "";

function open_overlay(overlay_id) {
    overlay_open = overlay_id;
    overlay_container.classList.add("has-overlay_active");
    document.getElementById(overlay_id).style.display = "block";
}

function close_overlay() {
    overlay_container.classList.remove("has-overlay_active");
    document.getElementById(overlay_open).style.display = "none";
    overlay_open = "";
}

// On overlay_container click, close overlay NOT IF CHILD IS CLICKED
overlay_container.addEventListener("click", (e) => { if (e.target == overlay_container) close_overlay() });

// 
// Overlays
// 

// Account

function changePW() {
    var oldpw = prompt("Enter old password");
    if (oldpw == null) return;
    var pw = prompt("Enter new password");
    if (pw == null) return;
    if (pw.length < 8) {
        alert("Password must be at least 8 characters long");
        return;
    }
    var pw2 = prompt("Confirm new password");
    if (pw2 == null) return;
    if (pw != pw2) {
        alert("Passwords do not match");
        return;
    }
    var data = {
        "oldpw": oldpw,
        "newpw": pw,
        "newpw2": pw2
    };
    $.ajax({
        type: "POST",
        url: "change_pw.php",
        data: data,
        success: function(response) {
            alert(response);
            location.assign("/");
        }
    });
}