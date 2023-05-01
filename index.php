<?php 

    // Check login state
    session_start();
    require("./res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

    // Get config
    require("./config.php");

    // DB Connection
    $con = mysqli_connect(
        config_db_host,
        config_db_user,
        config_db_password,
        config_db_name
    );
    if(mysqli_connect_errno()) exit("Error with the Database");
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - NotenApp</title>
    <link rel="stylesheet" href="/res/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/res/fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="/res/css/fonts.css">
    <link rel="stylesheet" href="/res/css/main.css">
    <link rel="stylesheet" href="/res/css/navbar.css">
    <link rel="stylesheet" href="/home/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/res/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/res/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/res/img/favicon-16x16.png">
    <link rel="mask-icon" href="/res/img/safari-pinned-tab.svg" color="#eb660e">
    <link rel="shortcut icon" href="/res/img/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="NotenApp">
    <meta name="application-name" content="NotenApp">
    <meta name="msapplication-TileColor" content="#282c36">
    <meta name="msapplication-TileImage" content="/res/img/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="/app.webmanifest">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <?php require("./res/php/noMailCheck.php"); ?>
</head>

<body>
    <nav>
        <a href="/" class="nav-link nav-active">
            <div class="navbar_icon">
                <i class="fas fa-home"></i>
            </div>
        </a>
        <?php if(in_array("calendar", $config_disabled_tabs)) echo "<!--" ?>
        <a href="/calendar/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </a>
        <?php if(in_array("calendar", $config_disabled_tabs)) echo "-->" ?>
        <?php if(in_array("homework", $config_disabled_tabs)) echo "<!--" ?>
        <a href="/homework/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </a>
        <?php if(in_array("homework", $config_disabled_tabs)) echo "-->" ?>
        <?php if(in_array("classes", $config_disabled_tabs)) echo "<!--" ?>
        <a href="/classes/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-book"></i>
            </div>
        </a>
        <?php if(in_array("classes", $config_disabled_tabs)) echo "-->" ?>
    </nav>
    <main id="main">
        <div class="homework_overview">
            <div class="homework">
                <img src="https://fakeimg.pl/1200x600/000,000/fff,255">
            </div>
            <div class="homework_sidebutton homework_button-settings" onclick="location.assign('/settings/');">
                <div>
                    <i class="fa-solid fa-gear"></i>
                </div>
            </div>
            <div class="homework_sidebutton homework_button-theme" id="theme-icon" onclick="cycleTheme();">
                <div>
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </div>
            </div>
        </div>
    </main>
    <script src="/res/js/themes/themes.js"></script>
</body>

</html>