<?php

    // Start the PHP_session
    require("../../res/php/session.php");
    start_session();
    // Variables
    require('../../config.php');

    // Get input
    $displayname = $_POST['username'];
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    // Conect to database
    $con = mysqli_connect(config_db_host, config_db_user, config_db_password, config_db_name);
    if (mysqli_connect_errno()) exit("Error connecting to our database! Please try again later."); 

    // Check if account exists
    $stmt = $con->prepare("SELECT id FROM ".config_table_name_accounts." WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) exit("Account $username not found");

    // Get id, salt and password hash from database
    if ($stmt = $con->prepare("SELECT id, displayname, password, email, account_version, rounding, sorting, beta_tester FROM ".config_table_name_accounts." WHERE username = ?")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $displayname, $password_hash, $email, $account_version, $setting_rounding, $setting_sorting, $beta_tester);
        $stmt->fetch();

        // Add salt and password and check if right
        if ($account_version != 3) header("Location: https://accounttools.noten-app.de/version_updater/");

        // Check if password is right
        if (!password_verify($password, $password_hash)) exit("Wrong password"); 

        // Set session variables
        $_SESSION["login_method"] = "login";
        $_SESSION["user_name"] = $displayname;
        $_SESSION["user_id"] = $id;
        $_SESSION["user_email"] = $email;
        $_SESSION["setting_rounding"] = $setting_rounding;
        $_SESSION["setting_sorting"] = $setting_sorting;
        $_SESSION["beta_tester"] = $beta_tester;

        // Redirect to app
        if(redirect_beta_users != null && redirect_beta_users != false && $beta_tester == 1) {
            header("Location: ".redirect_beta_users);
            exit();
        }
        header("Location: /");
    }
?>