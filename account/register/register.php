<?php

    // Start the PHP_session
    session_start();

    // Variables
    require('../../config.php');

    // Get input
    $displayname = $_POST['username'];
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $password_rep = $_POST['password_rep'];

    // Conect to database
    $con = mysqli_connect(config_db_host, config_db_user, config_db_password, config_db_name);
    if (mysqli_connect_errno()) exit("Error connecting to our database! Please try again later."); 

    // Check if account exists
    $stmt = $con->prepare("SELECT id FROM ".config_table_name_accounts." WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows != 0) exit("Account $username already exists!");

    // Check if passwords match
    if ($password != $password_rep) exit("Passwords do not match!");

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert account into database
    if($stmt = $con->prepare("INSERT INTO ".config_table_name_accounts." (username, password, displayname, account_version) VALUES (?, ?, ?, 3)")) {
        $stmt->bind_param('sss', $username, $password, $displayname);
        $stmt->execute();
        $stmt->close();
    } else exit("Error inserting account into database! Please try again later.");
?>