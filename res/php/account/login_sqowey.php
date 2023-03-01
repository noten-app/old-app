<?php

    // Start the PHP_session
    session_start();

    // Variables
    $db_config = require('../../../config.php');

    // Get input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conect to database
    $con = mysqli_connect($sqowey_db_host, $sqowey_db_user, $sqowey_db_pass, $sqowey_db_name);
    if (mysqli_connect_errno()) {
        exit("Failed to connect to MySQL: " . mysqli_connect_error());
    } 

    // Check if account exists
    $stmt = $con->prepare("SELECT id FROM accounts WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) exit("Account does not exist");  

    // Get id, salt and password hash from database
    if ($stmt = $con->prepare("SELECT id, salt, password, email, account_version, displayname FROM accounts WHERE username = ?")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $salt, $password_hash, $email, $account_version, $displayname);
        $stmt->fetch();

        // Add salt and password and check if right
        if ($account_version < 2) {
            $pw_with_hash = $password;
        } else {
            $pw_with_hash = $salt . $password;
        }

        // Check if password is right
        if (!password_verify($pw_with_hash, $password_hash)) exit("Wrong password"); 

        // Set session variables
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['displayname'] = $displayname;
        $_SESSION['email'] = $email;
        $_SESSION['auth_type'] = "sqowey";

        // Redirect to app
        header("Location: ../../../");
    }
?>