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
    if(mysqli_connect_errno()) die("Error with the Database");

    // Get input
    $class = $_POST["class"];
    $type = $_POST["type"];
    $date_due = $_POST["date_due"];
    $task = $_POST["task"];
    $task_id = $_POST["task_id"];

    // Check if necessary input is given
    if(!isset($class) || strlen($class) == 0) die("missing-class");
    if(!isset($type)) die("missing-type");
    if(!($type == "b" || $type == "v" || $type == "w" || $type == "o")) die("invalid-type");
    if(!isset($date_due) || strlen($date_due) == 0) die("missing-date_due");
    if(!isset($task) || strlen($task) == 0) die("missing-task");
    if(strlen($task) > 75) die("too-long-task");

    // Encode task
    $task = htmlentities($task);

    // Create given-date
    $date_given = date("Y-m-d");

    // Update task in DB
    if ($stmt = $con->prepare('UPDATE '.config_table_name_homework.' SET class = ?, given = ?, deadline = ?, text = ?, type = ? WHERE entry_id = ? AND user_id = ?')) {
        $stmt->bind_param('sssssis', $class, $date_given, $date_due, $task, $type, $task_id, $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
        exit("success");
    } else die("Error with the Database");

    // DB Con close
    $con->close();
?>