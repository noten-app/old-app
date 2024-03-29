<?php

// Check login state
require("../res/php/session.php");
start_session();
require("../res/php/checkLogin.php");
if (!checkLogin()) header("Location: /account");

// Get config
require("../config.php");

// Get point system transformer
require($_SERVER["DOCUMENT_ROOT"] . "/res/php/point-system.php");

// DB Connection
$con = mysqli_connect(
    config_db_host,
    config_db_user,
    config_db_password,
    config_db_name
);
if (mysqli_connect_errno()) exit("Error with the Database");

// Get sorting
$sorting = $_SESSION["setting_sorting"];
if ($sorting == "average") $sorting_appendix = " ORDER BY average ASC";
else if ($sorting == "alphabet") $sorting_appendix = " ORDER BY name ASC";
else if ($sorting == "lastuse") $sorting_appendix = " ORDER BY last_used DESC";

// Get all classes
$classlist = array();
if ($stmt = $con->prepare("SELECT name, color, id, last_used, average FROM " . config_table_name_classes . " WHERE user_id = ?" . $sorting_appendix)) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($class_name, $class_color, $class_id, $class_last_used, $class_grade_average);
    while ($stmt->fetch()) {
        $classlist[] = array(
            "name" => $class_name,
            "color" => $class_color,
            "id" => $class_id,
            "last_used" => $class_last_used,
            "average" => $class_grade_average
        );
    }
    $stmt->close();
}

// DB Con close
$con->close();

// var_dump($classlist);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes | Noten-App</title>
    <link rel="stylesheet" href="/res/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/res/fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="/res/css/fonts.css">
    <link rel="stylesheet" href="/res/css/main.css">
    <link rel="stylesheet" href="/res/css/navbar.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/res/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/res/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/res/img/favicon-16x16.png">
    <link rel="mask-icon" href="/res/img/safari-pinned-tab.svg" color="#eb660e">
    <link rel="shortcut icon" href="/res/img/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Noten-App">
    <meta name="application-name" content="Noten-App">
    <meta name="msapplication-TileColor" content="#282c36">
    <meta name="msapplication-TileImage" content="/res/img/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="/app.webmanifest">
    <meta name="msapplication-config" content="/browserconfig.xml">
</head>

<body>
    <nav>
        <a href="/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-home"></i>
            </div>
        </a>
        <a href="/homework/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </a>
        <a href="/classes/" class="nav-link nav-active">
            <div class="navbar_icon">
                <i class="fas fa-book"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="class_list">
            <?php
            foreach ($classlist as $class) {
                echo '<div class="class_entry';
                echo '" onclick="location.assign(\'./grades/?class=' . $class["id"] . '\')" style="border-color:#' . $class["color"] . '">';
                echo '<div class="class_entry-name">' . $class["name"] . '</div>';
                if ($class["average"] != 0) {
                    echo '<div class="class_entry-average"> &empty; ';
                    if (systemRun("punkte")) echo (number_format(calcToPoints(false, $class["average"]), $_SESSION["setting_rounding"], '.', ''));
                    else echo number_format($class["average"], $_SESSION["setting_rounding"], '.', '');
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="class_add" onclick="location.assign('/classes/add/')">
            <div>Create class <i class="fas fa-plus"></i></div>
        </div>
    </main>
    <script src="/res/js/themes/themes.js"></script>
</body>

</html>