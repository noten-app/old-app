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
    $grade_id = $_POST["grade_id"];

    // Check if grade is owned by user
    if ($stmt = $con->prepare('SELECT user_id FROM '.config_table_name_grades.' WHERE id = ?')) {
        $stmt->bind_param('i', $grade_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        if($user_id !== $_SESSION["user_id"]) die("not-authorized");
        $stmt->close();
    } else {
        die("error");
    }

    // Delete grade
    if ($stmt = $con->prepare('DELETE FROM '.config_table_name_grades.' WHERE id = ?')) {
        $stmt->bind_param('s', $grade_id);
        $stmt->execute();
        $stmt->close();

        // Change class last used
        if ($stmt = $con->prepare('UPDATE '.config_table_name_classes.' SET last_used = ? WHERE id = ?')) {
            $stmt->bind_param('si', $date, $class_id);
            $stmt->execute();
            $stmt->close();
            exit("success");
        } else {
            die("error");
        }
    } else {
        die("error");
    }

    // DB Con close
    $con->close();
?>