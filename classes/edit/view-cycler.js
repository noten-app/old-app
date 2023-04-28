const button_view_settings = document.getElementById("view_settings");
const button_view_statistics = document.getElementById("view_statistics");
const main_view_statistics = document.getElementById("main_view-statistics");
const main_view_settings = document.getElementById("main_view-settings");

button_view_settings.addEventListener("click", function() {
    main_view_settings.style.display = "block";
    main_view_statistics.style.display = "none";
    button_view_settings.style.color = "var(--accent-color)";
    button_view_statistics.style.color = "var(--text-color)";
});

button_view_statistics.addEventListener("click", function() {
    main_view_statistics.style.display = "block";
    main_view_settings.style.display = "none";
    button_view_statistics.style.color = "var(--accent-color)";
    button_view_settings.style.color = "var(--text-color)";
});