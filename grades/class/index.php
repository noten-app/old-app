<?php 

    // Check if class url-parameter is given
    if(!isset($_GET["class"])) header("Location: /grades");
    $class_id = $_GET["class"];

    // Check login state
    session_start();
    require("../../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account/login");

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

    // Get class
    if ($stmt = $con->prepare('SELECT name, color, user_id, last_used, grade_k, grade_m, grade_s FROM classes WHERE id = ?')) {
        $stmt->bind_param('s', $class_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($class_name, $class_color, $user_id, $last_used, $grade_k, $grade_m, $grade_s);
        $stmt->fetch();
        if($user_id !== $_SESSION["user_id"]){
            $name = "";
            $color = "";
            $user_id = "";
            $last_used = "";
            exit("ERROR2");
        }
        $stmt->close();
    } else {
        exit("ERROR1");
    }

    // Get grades
    $grades = array(); 
    if ($stmt = $con->prepare('SELECT id, user_id, class, note, type, date, grade FROM grades WHERE class = ?')) {
        $stmt->bind_param('s', $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        foreach($result as $row) {
            array_push($grades, $row);
        }
        if($user_id !== $_SESSION["user_id"]){
            $name = "";
            $user_id = "";
            $id = "";
            $class = "";
            $note = "";
            $date = "";
            $grade = "";
            exit("ERROR2");
        }
        $stmt->close();
    } else {
        exit("ERROR1");
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
        <a href="/grades/" class="nav-link">
            <div class="navbar_icon">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="class_title">
            <h1><?=$class_name?></h1>
        </div>
        <div class="class_edit">
            <i id="view_toggle" class="fa-solid fa-chart-simple" onclick="toggle_stats_view()"></i>
            <i class="fas fa-edit"></i>
        </div>
        <div class="class-main_content">
            <div class="gradelist">  
                <?php 
                    foreach ($grades as $grade) {
                        echo '<div class="grade_entry">';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="statistics"></div>
        </div>
        <div class="grade_add">
            <div>Add grade <i class="fas fa-plus"></i></div>
        </div>
    </main>
    <script src="/res/js/themes/themes.js"></script>
    <script src="./view-cycler.js"></script>
</body>

</html>