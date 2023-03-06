<?php 

    // Check login state
    session_start();
    require("../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account/login");

    // Get config
    require("../config.php");

    // DB Connection
    $con = mysqli_connect(
        config_db_host,
        config_db_user,
        config_db_password,
        config_db_name
    );
    if(mysqli_connect_errno()) exit("Error with the Database");

    // DB Con close
    $con->close();
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
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <nav>
        <a href="/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-home"></i>
            </div>
        </a>
        <div class="nav-link">
            <div class="navbar_icon navbar_icon-save">
                <i class="fa-solid fa-floppy-disk"></i>
            </div>
        </div>
    </nav>
    <main id="main">
        <div class="group_container" id="account-settings">            
            <div class="account-greeting">
                <span id="account_greeting-naa">Naaa,</span>
                <span id="account_greeting-name"><?=$_SESSION["user_name"]?></span>
            </div>
            <div class="account-icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <span class="container-title">Grading</span>
        <div class="group_container" id="grade-settings">
            <div class="container_item">
                <div class="button_divider">
                    <div class="button_divider-button1 button_divider-button_active">
                        Grades<br>1,0 - 6,0
                    </div>
                    <div class="button_divider-button2">
                        Points<br>0 - 15
                    </div>
                </div>
            </div>
            <div class="container_item">
                Decimals (Rounding)
                <div class="button_divider">
                    <div class="button_divider-button_active">
                        No<br>
                        2
                    </div>
                    <div>
                        One<br>
                        1,7
                    </div>
                    <div>
                        Two<br>1,72
                    </div>
                </div>
            </div>
            <div class="container_item">
                Show Date
                <div class="button_divider">
                    <div class="button_divider-button1 button_divider-button_active">
                        Yes
                    </div>
                    <div class="button_divider-button2">
                        No
                    </div>
                </div>
            </div>
        </div>
        <span class="container-title">Location-based settings</span>
        <div class="group_container" id="location-settings">
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Language
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Region
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Off-days
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
        <span class="container-title">Advanced settings</span>
        <div class="group_container" id="location-settings">
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Export grades
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fa-solid fa-file-arrow-down"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    About this version
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
        <span class="container-title">More Help</span>
        <div class="group_container" id="location-settings">
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Website
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Help & FAQ
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Support
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Terms of Service
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="dropdown_container container_item">
                <div class="dropdown_container-name">
                    Privacy policy
                </div>
                <div class="dropdown_container-dropdown_icon">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer_container">
                <p>Made with ❤️ in Germany.</p>
                <p><?php echo config_version_name; ?></p>
            </div>
        </footer>
    </main>
    <script src="/res/js/themes/themes.js"></script>
</body>

</html>