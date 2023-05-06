<?php 

    // Check if class url-parameter is given
    if(!isset($_GET["grade"])) header("Location: /grades");
    $grade_id = $_GET["grade"];

    // Check login state
    session_start();
    require("../../../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

    // Get config
    require("../../../config.php");

    // DB Connection
    $con = mysqli_connect(
        config_db_host,
        config_db_user,
        config_db_password,
        config_db_name
    );
    if(mysqli_connect_errno()) exit("Error with the Database");

    // Get grade
    if ($stmt = $con->prepare('SELECT user_id, class, note, type, date, grade FROM '.config_table_name_grades.' WHERE id = ?')) {
        $stmt->bind_param('s', $grade_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $class, $note, $type, $date, $grade);
        $stmt->fetch();
        if($user_id !== $_SESSION["user_id"]) exit("ERROR2"); 
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
    <title>Edit grade - <?=$class_name?> | Noten-App</title>
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
        <a onclick="history.back()" class="nav-link">
            <div class="navbar_icon">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="class_title">
            <h1 style="color: #<?=$class_color?>">Editing Grade</h1>
        </div>
        <div class="class-main_content">
            <div class="type">
                <div class="type-title">
                    Type
                </div>
                <div class="type-container">
                    <div class="type_k" id="type_k">Exam</div>
                    <div class="type_m" id="type_m">Verbal</div>
                    <div class="type_t" id="type_t">Test</div>
                    <div class="type_s" id="type_s">Other</div>
                </div>
            </div>
            <div class="grade">
                <div class="grade-title">
                    Grade
                </div>
                <div class="grade-container_1-6">
                    <div class="gr1">1</div>
                    <div class="gr2">2</div>
                    <div class="gr3">3</div>
                    <div class="gr4">4</div>
                    <div class="gr5">5</div>
                    <div class="gr6">6</div>
                </div>
                <div class="grade-modifier_container">
                    <div class="gr-full"><span id="gr-full_grade"></span></div>
                    <div class="gr-025"><span id="gr-025_grade"></span></div>
                    <div class="gr-050"><span id="gr-050_grade"></span></div>
                    <div class="gr-075"><span id="gr-075_grade"></span></div>
                    <i class="fa-solid fa-rotate-left" onclick="resetGradeModifier();"></i>
                </div>
            </div>
            <div class="note">
                <div class="note-title">
                    Note
                </div>
                <div class="note-container">
                    <input type="text" id="note-input" maxlength="25" value="<?=htmlspecialchars($note)?>">
                </div>
            </div>
            <div class="date">
                <div class="date-title">
                    Date
                </div>
                <div class="date-input">
                    <input type="date" id="date_input-input" value="<?=$date?>">
                </div>
            </div>
        </div>
        <div class="grade_add">
            <div id="grade_save"><i class="fas fa-floppy-disk"></i></div>
            <div onclick="location.reload()"><i class="fa-solid fa-rotate-left"></i></div>
            <div id="grade_delete"><i class="fa-solid fa-trash-can"></i></div>
        </div>
        <div id="grade_id" style="display: none;"><?=$grade_id?></div>
    </main>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
    <script src="/res/js/themes/themes.js"></script>
    <script src="./choose-type.js"></script>
    <script src="./choose-grade.js"></script>
    <script src="./add-grade.js"></script>
    <script src="./delete-grade.js"></script>
    <script>
        <?php 
        
            // Choose Type from DB
            echo "chooseType('$type');";

            // Choose Grade from DB
            echo "chooseGrade(".substr(strval($grade), 0, 1).");";
            switch (substr(strval($grade), 1)) {
                case ".25":
                    echo "chooseGradeModifier('025');";
                    break;
                case ".5":
                    echo "chooseGradeModifier('050');";
                    break;
                case ".75":
                    echo "chooseGradeModifier('075');";
                    break;
                default:
                    echo "chooseGradeModifier('full');";
                    break;
            }
            // exit(substr(strval($grade), 1));
        ?>
    </script>
</body>

</html>