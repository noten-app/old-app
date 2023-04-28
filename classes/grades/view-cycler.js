var stats_view_active = false;
const stats_view = document.querySelector(".statistics");
const gradelist_view = document.querySelector(".gradelist");
const view_toggle = document.getElementById("view_toggle");

function toggle_stats_view() {
    if (stats_view_active) {
        stats_view.style.display = "none";
        gradelist_view.style.display = "block";
        view_toggle.style.color = "inherit";
    } else {
        stats_view.style.display = "block";
        gradelist_view.style.display = "none";
        view_toggle.style.color = "var(--accent-color)";
    }
    stats_view_active = !stats_view_active;
}