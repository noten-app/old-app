<?php 

    // Check if class url-parameter is given
    if(!isset($_GET["class"])) header("Location: /grades");
    $class_id = $_GET["class"];

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
                        echo '<div class="grade_entry" onclick="location.assign(\'/grades/edit/?grade='.$grade["id"].'\')">';
                        echo '<div class="grade">';
                        echo $grade["grade"];
                        echo '</div><div class="grade_type">';
                        switch (strtolower($grade["type"])){
                            case "k":
                                echo "Exam";
                                break;
                            case "m":
                                echo "Oral";
                                break;
                            case "t":
                                echo "Test";
                                break;
                            case "o":
                                echo "Other";
                                break;
                            default:
                                echo "Unspecified";
                                break;
                        }                        
                        echo '</div><div class="grade_date">';
                        echo date("d.m.Y", strtotime($grade["date"]));
                        echo '</div></div>';
                    }
                    if(count($grades) == 0) echo '<div class="nogrades">No grades yet</div>';
                ?>
            </div>
            <div class="statistics"></div>
        </div>
        <div class="grade_add" onclick="location.assign('/grades/add/?class=<?=$_GET['class']?>')">
            <div>Add grade <i class="fas fa-plus"></i></div>
        </div>
    </main>
    <script src="/res/js/themes/themes.js"></script>
    <script src="./view-cycler.js"></script>
</body>

</html>