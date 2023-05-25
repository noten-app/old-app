<?php 

    // Check login state
    require("../../res/php/session.php");
    start_session();
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

    // Get taskID
    $task_id = $_POST["task_id"];

    // Update task in DB
    if ($stmt = $con->prepare('DELETE FROM '.config_table_name_homework.' WHERE entry_id = ? AND user_id = ?')) {
        $stmt->bind_param('is', $task_id, $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
        exit("success");
    } else die("Error with the Database");

    // DB Con close
    $con->close();
?>