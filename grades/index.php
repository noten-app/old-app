<?php 

    // Check login state
    session_start();
    require("../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

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

    // var_dump($classlist);
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
        <?php if(in_array("grades", $config_disabled_tabs)) echo "<!--" ?>
        <a href="/grades/" class="nav-link nav-active">
            <div class="navbar_icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </a>
        <?php if(in_array("grades", $config_disabled_tabs)) echo "-->" ?>
        <?php if(in_array("classes", $config_disabled_tabs)) echo "<!--" ?>
        <a href="/classes/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-book"></i>
            </div>
        </a>
        <?php if(in_array("classes", $config_disabled_tabs)) echo "-->" ?>
    </nav>
    <main id="main">
        <div class="class_list">
            <?php 
            foreach ($classlist as $class) {
                echo '<div class="class_entry';
                echo '" onclick="location.assign(\'./class/?class='.$class["id"].'\')" style="border-color:#'.$class["color"].'">';
                echo '<div class="class_entry-name">'.$class["name"].'</div>';
                if($class["average"] != 0) echo '<div class="class_entry-average"> &empty; '.number_format($class["average"], $_SESSION["setting_rounding"], '.', '').'</div>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
    <script src="/res/js/themes/themes.js"></script>
</body>

</html>