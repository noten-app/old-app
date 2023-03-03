<?php 

    // Check login state
    session_start();
    require("./res/php/checkLogin.php");
    if(!checkLogin()) header("Location: ./account/login");

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
    <title>NotenApp</title>
    <link rel="icon" type="image/x-icon" href="/res/img/favicon.ico" />
    <link rel="stylesheet" href="/res/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/res/fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="/res/css/fonts.css">
    <link rel="stylesheet" href="/res/css/main.css">
    <link rel="stylesheet" href="/res/css/navbar.css">
    <link rel="stylesheet" href="/home/style.css">
</head>

<body>
    <nav>
        <a href="/" class="nav-link nav-active">
            <div class="navbar_icon">
                <i class="fas fa-home"></i>
            </div>
        </a>
        <a href="/calendar/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </a>
        <a href="/homework/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </a>
        <a href="/grades/" class="nav-link">
            <div class="navbar_icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </a>
        <a href="/classes/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-book"></i>
            </div>
        </a>
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