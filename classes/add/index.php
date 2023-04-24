<?php 

    // Check login state
    session_start();
    require("../../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

    // Get config
    require("../../config.php");

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
    <meta name="apple-mobile-web-app-title" content="NotenApp">
    <meta name="application-name" content="NotenApp">
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
        <a href="/classes/" class="nav-link">
            <div class="navbar_icon">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="class-main_content">
            <div class="name">
                <div class="name-title">
                    Classname
                </div>
                <div class="name-container">
                    <input type="text" id="name-input" placeholder="Classname">
                </div>
            </div>
            <div class="grading">
                <div class="grading-title">
                    Grading - General
                </div>
                <div class="grading-options">
                    <div class="grading-option">
                        <div class="grading-option-title">Exams</div>
                        <div class="grading-option-input">
                            <input type="number" id="grading_option-type_k" value="2"/>
                        </div>
                    </div>
                    <div class="grading-option">
                        <div class="grading-option-title">Verbal</div>
                        <div class="grading-option-input">
                        <input type="number" id="grading_option-type_m" value="1"/>
                        </div>
                    </div>
                    <div class="grading-option" id="grading-option_tests">
                        <div class="grading-option-title">Tests</div>
                        <div class="grading-option-input">
                            <input type="number" id="grading_option-type_t" value="1"/>
                        </div>
                    </div>
                    <div class="grading-option">
                        <div class="grading-option-title">Other</div>
                        <div class="grading-option-input">
                            <input type="number" id="grading_option-type_s" value="0"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="test-behaviour">
                <div class="test-behaviour-title">
                    Grading - Test Behaviour
                </div>
                <div class="test-behaviour-switch">
                    <div class="button_divider">
                        <div class="button_divider-button_active" id="test-behaviour-switch_all1">
                            All Tests<br>1 Exam
                        </div>
                        <div id="test-behaviour-switch_custom">
                            Custom
                        </div>
                    </div>
                </div>
            </div>
            <div class="color">
                <div class="color-title">
                    Class-Color
                </div>
                <div class="color-input">
                    <!-- Random color lighter than #444444 -->
                    <input type="color" id="color_input-input" value="<?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)); ?>">
                </div>
            </div>
        </div>
        <div class="class_add">
            <div>Create class <i class="fas fa-plus"></i></div>
        </div>
        <div id="class_id" style="display: none;"><?=$_GET["class"]?></div>
    </main>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
    <script src="/res/js/themes/themes.js"></script>
    <script src="./test-switch.js"></script>
    <script src="./add-class.js"></script>
</body>

</html>