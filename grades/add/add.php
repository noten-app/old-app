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
    $grade = $_POST["grade"];
    $gradeModifier = $_POST["gradeModifier"];
    $date = $_POST["date"];
    $note = $_POST["note"];
    $type = $_POST["type"];
    $class_id = $_POST["class"];

    // Check if necessary input is given
    if(!isset($grade)) die("missing-grade");
    if(!isset($date)) die("missing-date");
    if(!isset($type)) die("missing-type");
    if(!isset($class_id)) die("missing-class");

    // Check if class is owned by user
    if ($stmt = $con->prepare('SELECT user_id FROM '.config_table_name_classes.' WHERE id = ?')) {
        $stmt->bind_param('i', $class_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        if($user_id !== $_SESSION["user_id"]) die("not-authorized");
        $stmt->close();
    } else {
        die("error");
    }

    // Calculate grade to float
    if($gradeModifier === "full") $grade_float = $grade;
    else {
        $grade_float = $grade;
        if(strval($gradeModifier == "025")) $grade_float += 0.25;
        if(strval($gradeModifier == "050")) $grade_float += 0.5;
        if(strval($gradeModifier == "075")) $grade_float += 0.75;
    }

    // Check if grade is valid
    if($grade_float < 1 || $grade_float > 6) die("invalid-grade");

    // Check if date is valid
    if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $date)) die("invalid-date");

    // Check if type is valid (k,m,o,t)
    if(!preg_match("/^[kmot]$/", $type)) die("invalid-type");

    // Check if note is valid (max 25 chars)
    if(strlen($note) > 25) die("invalid-note");

    // Add grade
    if ($stmt = $con->prepare('INSERT INTO '.config_table_name_grades.' (user_id, class, note, type, date, grade) VALUES (?, ?, ?, ?, ?, ?)')) {
        $stmt->bind_param('sissss', $_SESSION["user_id"], $class_id, $note, $type, $date, $grade_float);
        $stmt->execute();
        $stmt->close();
        exit("success");
    } else {
        die("error");
    }

    // DB Con close
    $con->close();
?>