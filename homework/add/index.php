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
    
    // Get all classes
    $classlist = array();
    if($stmt = $con->prepare("SELECT name, color, id, last_used, average FROM ".config_table_name_classes." WHERE user_id = ?")) {
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
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add your Homework | Noten-App</title>
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
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="class-main_content">
            <div class="class">
                <div class="class-title">
                    Class
                </div>
                <div class="class-container">
                    <select name="class-selector" id="class-selector">
                        <?php
                            foreach($classlist as $class) {
                                echo '<option value="'.$class["id"].'">'.$class["name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="homework_type">
                <div class="homework_type-title">
                    Homework Type
                </div>
                <div class="homework_type-switch">
                    <div class="button_divider">
                        <div class="button_divider-button button_divider-button_active" type-letter="b">
                            Book
                        </div>
                        <div class="button_divider-button" type-letter="v">
                            Vocabulary
                        </div>
                        <div class="button_divider-button" type-letter="w">
                            Worksheet
                        </div>
                        <div class="button_divider-button" type-letter="o">
                            Other
                        </div>
                    </div>
                </div>
            </div>
            <div class="task">
                <div class="task-title">
                    Task
                </div>
                <div class="task-container">
                    <input type="text" id="task-input" maxlength="75">
                </div>
            </div>
            <div class="date">
                <div class="date-title">
                    Due-Date
                </div>
                <div class="date-input">
                    <input type="date" id="date_input-input" value="<?=date("Y-m-d", time() + (60*60*24))?>">
                </div>
            </div>
        </div>
        <div class="class_add">
            <div>Create task <i class="fas fa-plus"></i></div>
        </div>
        <div id="class_id" style="display: none;"><?=$_GET["class"]?></div>
    </main>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
    <script src="/res/js/themes/themes.js"></script>
    <script src="./type-switch.js"></script>
    <script src="./add-class.js"></script>
</body>
</html>