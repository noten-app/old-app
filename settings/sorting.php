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
    if(mysqli_connect_errno()) die("Error with the Database");

    // Get input
    $sorting = $_POST["sorting"];

    // If sorting is not average, alphabet or lastuse
    if($sorting !== "average" && $sorting !== "alphabet" && $sorting !== "lastuse") $sorting = "average";

    // Update sorting in DB
    if ($stmt = $con->prepare('UPDATE '.config_table_name_accounts.' SET sorting = ? WHERE id = ?')) {
        $stmt->bind_param('ss', $sorting, $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
    } else die("Error with the Database");

    // Set session variable
    $_SESSION["setting_sorting"] = $sorting;

    // DB Con close
    $con->close();
?>