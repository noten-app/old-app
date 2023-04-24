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
    if(mysqli_connect_errno()) die("Error with the Database");

    // Get input
    $rounding = $_POST["rounding"];

    // If rounding is not 0, 1 or 2, set it to 0
    if($rounding !== "0" && $rounding !== "1" && $rounding !== "2") $rounding = "0";

    // Update rounding in DB
    if ($stmt = $con->prepare('UPDATE '.config_table_name_accounts.' SET rounding = ? WHERE id = ?')) {
        $stmt->bind_param('ss', $rounding, $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
    } else die("Error with the Database");

    // Set session variable
    $_SESSION["setting_rounding"] = $rounding;

    // DB Con close
    $con->close();
?>