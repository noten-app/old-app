<?php

// Check login state
require("./res/php/session.php");
start_session();
require("./res/php/checkLogin.php");
if (!checkLogin()) header("Location: /account");

// Get config
require("./config.php");

// DB Connection
$con = mysqli_connect(
    config_db_host,
    config_db_user,
    config_db_password,
    config_db_name
);
if (mysqli_connect_errno()) exit("Error with the Database");

// Count homework status
// Count for status 0,1 or 2 seperately
if ($stmt = $con->prepare("SELECT status FROM " . config_table_name_homework . " WHERE user_id = ?")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($status);
    $status_list = [];
    while ($stmt->fetch()) {
        array_push($status_list, $status);
    }
    $stmt->close();
}
$status_count = array_count_values($status_list);
if (!isset($status_count[0])) $status_count[0] = 0;
if (!isset($status_count[1])) $status_count[1] = 0;
if (!isset($status_count[2])) $status_count[2] = 0;

// Get homework due tomorrow or earlier
if ($stmt = $con->prepare("SELECT * FROM " . config_table_name_homework . " WHERE user_id = ? AND deadline <= ? AND status = 0")) {
    // If day is sat or sun (and friday - AFTER 15 o clock), set to monday
    if (date("N") == 5 && date("H") >= 15) $tomorrow = date("Y-m-d", strtotime("+3 day"));
    else if (date("N") == 6) $tomorrow = date("Y-m-d", strtotime("+2 day"));
    else $tomorrow = date("Y-m-d", strtotime("+1 day"));
    $stmt->bind_param("ss", $_SESSION["user_id"], $tomorrow);
    $stmt->execute();
    $result = $stmt->get_result();
    $homework = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Get all classes
if ($stmt = $con->prepare("SELECT * FROM " . config_table_name_classes . " WHERE user_id = ?")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $classes = $result->fetch_all(MYSQLI_ASSOC);
}
// Count grades
if ($stmt = $con->prepare("SELECT COUNT(*) FROM " . config_table_name_grades . " WHERE user_id = ?")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($num_of_grades);
    $stmt->fetch();
    $stmt->close();
}

// Get last inserted grade
if ($stmt = $con->prepare("SELECT grade FROM " . config_table_name_grades . " WHERE user_id = ? ORDER BY id DESC LIMIT 1")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($last_grade);
    $stmt->fetch();
    $stmt->close();
}

// Calculate average
if ($stmt = $con->prepare("SELECT average FROM " . config_table_name_classes . " WHERE user_id = ?")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($average);
    $average_list = [];
    while ($stmt->fetch()) {
        if ($average != 0) array_push($average_list, $average);
    }
    $stmt->close();
    if (count($average_list) == 0) $average = 0;
    else $average = array_sum($average_list) / count($average_list);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Noten-App</title>
    <link rel="stylesheet" href="/res/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/res/fontawesome/css/regular.min.css">
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
    <meta name="apple-mobile-web-app-title" content="Noten-App">
    <meta name="application-name" content="Noten-App">
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
        <a href="/homework/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </a>
        <a href="/classes/" class="nav-link">
            <div class="navbar_icon">
                <i class="fas fa-book"></i>
            </div>
        </a>
    </nav>
    <main id="main">
        <div class="homework_overview card">
            <div class="homework">
                <canvas id="homework_status_chart"></canvas>
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
        <div class="grades_overview card">
            <div class="grade_average-value grades-value noborder"><?= number_format($average, $_SESSION["setting_rounding"], '.', '') ?></div>
            <div class="grade_average-label grades-label noborder">Total Average</div>
            <div class="num_of_grades-value grades-value"><?= $num_of_grades ?></div>
            <div class="num_of_grades-label grades-label">Number of Grades</div>
            <div class="last_grade-value grades-value"><?= number_format($last_grade, $_SESSION["setting_rounding"], '.', '') ?></div>
            <div class="last_grade-label grades-label">Last grade</div>
        </div>
        <?php if (count($homework) != 0) { ?>
            <div class="homework_due card">
                <div class="homework_list">
                <?php }
            if (count($homework) != 0) foreach ($homework as $hw_task) {
                echo '<div class="homework_entry">';
                echo '<div class="classname">';
                foreach ($classes as $class) if ($class["id"] == $hw_task["class"]) echo $class["name"];
                echo '</div><div class="task" onclick="location.assign(\'/homework/edit/?task=' . $hw_task["entry_id"] . '\')"><span>' . $hw_task["text"] . '</span></div>';
                echo '<div class="dot" id="dot-' . $hw_task["entry_id"] . '" onclick="toggleState(\'' . $hw_task["entry_id"] . '\')">';
                if ($hw_task["status"] == 0) echo '<i class="fa-regular fa-circle"></i></div>';
                else if ($hw_task["status"] == 2) echo '<i class="fa-regular fa-circle-xmark"></i></div>';
                else echo '<i class="fa-regular fa-check-circle"></i></div>';
                switch ($hw_task["type"]) {
                    case 'b':
                        echo '<div class="type_badge"><i class="fa-solid fa-book"></i></div>';
                        break;
                    case 'w':
                        echo '<div class="type_badge"><i class="fa-solid fa-sheet-plastic"></i></div>';
                        break;
                    case 'v':
                        echo '<div class="type_badge"><i class="fa-solid fa-language"></i></div>';
                        break;
                }
                echo '</div>';
            }
            if (count($homework) != 0) {
                ?>
                </div>
            </div>
        <?php } ?>
    </main>
    <script src="/res/js/themes/themes.js"></script>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
    <script src="/res/js/chartjs/chart.min.js"></script>
    <script src="/home/state.js"></script>
    <script>
        new Chart("homework_status_chart", {
            type: "doughnut",
            data: {
                labels: [
                    'To Do',
                    'Done',
                    'Skipped'
                ],
                datasets: [{
                    data: [<?= $status_count[0] ?>, <?= $status_count[1] ?>, <?= $status_count[2] ?>],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 235, 162)',
                        'rgb(54, 54, 54)'
                    ]
                }]
            },
            options: {
                borderWidth: 0,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: "Homework Status"
                    }
                }
            }
        });
    </script>
    <script>
        // Check which tasks are overflowing
        document.querySelectorAll(".task").forEach(task => {
            if (task.offsetWidth < task.querySelector("span").scrollWidth) task.querySelector("span").classList.add("scroll")
        });
    </script>
</body>

</html>