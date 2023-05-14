<?php 

    // Check login state
    require("../res/php/session.php");
    start_session();
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

    // Delete all grades
    if($stmt = $con->prepare("DELETE FROM ".config_table_name_grades." WHERE user_id = ?")) {
        $stmt->bind_param("s", $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
    }

    // Set all averages to 0
    if($stmt = $con->prepare("UPDATE ".config_table_name_classes." SET average = 0 WHERE user_id = ?")) {
        $stmt->bind_param("s", $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
    }
    $con->close();

    // Redirect
    header("Location: /settings");
?>