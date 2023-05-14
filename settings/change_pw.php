<?php 

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
    $oldpw = $_POST["oldpw"];
    $newpw = $_POST["newpw"];
    $newpw2 = $_POST["newpw2"];

    // Check if necessary input is given
    if(!isset($oldpw) || !isset($newpw) || !isset($newpw2)) die("One of the input fields is empty");
    if($newpw !== $newpw2) die("The new passwords are not the same");
    if(strlen($newpw) < 8) die("The new password is too short (min. 8 characters)");

    // Check if old password is correct
    if ($stmt = $con->prepare('SELECT password FROM '.config_table_name_accounts.' WHERE id = ?')) {
        $stmt->bind_param('s', $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        $stmt->close();
    } else die("Error with the Database");
    if(!password_verify($oldpw, $password)) die("The old password is incorrect");

    // Update password in DB
    if ($stmt = $con->prepare('UPDATE '.config_table_name_accounts.' SET password = ? WHERE id = ?')) {
        $stmt->bind_param('ss', password_hash($newpw, PASSWORD_DEFAULT), $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->close();
    } else die("Error with the Database");

    // DB Con close
    $con->close();

    // Delete session
    destroy_session();

    // Exit
    exit("Password changed successfully! Please log in again.");
?>