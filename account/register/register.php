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
    $password_rep = $_POST['password_rep'];

    // Functions to generate an ID
    function generateIDsection($length){
        $id_charset = "abcdefghijklmnopqrstuvwxyz123465789";
        $generated = "";
        for ($i=0; $i < $length; $i++) { 
            $new_char = substr($id_charset, mt_rand(0, strlen($id_charset)),1);
            $generated .= $new_char;
        }
        return $generated;
    }
    function generateID(){
        $gen_id = generateIDsection(8) . "-";
        $gen_id .= generateIDsection(4) . "-";
        $gen_id .= generateIDsection(4) . "-";
        $gen_id .= generateIDsection(4) . "-";
        $gen_id .= generateIDsection(12);
        return $gen_id;
    }

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

    // Check if username is valid
    if (strlen($username) < 4) exit("Username must be at least 4 characters long!");

    // Check if password is valid
    if (strlen($password) < 8) exit("Password must be at least 8 characters long!");
    if (strlen($password) > 72) exit("Password must be at most 72 characters long!");
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).*$/" , $password)) exit("Password must contain at least one lowercase letter, one uppercase letter, one number and one special character!");

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Generate ID
    $id = generateID();

    // Check if ID does not already exist
    while (true) {
        $stmt = $con->prepare("SELECT id FROM ".config_table_name_accounts." WHERE id = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) break;
        $id = generateID();
    }

    // Insert account into database
    if($stmt = $con->prepare("INSERT INTO ".config_table_name_accounts." (username, id, password, displayname, account_version, sorting) VALUES (?, ?, ?, ?, 3, 'average')")) {
        $stmt->bind_param('ssss', $username, $id, $password, $displayname);
        $stmt->execute();
        $stmt->close();

        // Set session variables
        $_SESSION["login_method"] = "login";
        $_SESSION["user_name"] = $displayname;
        $_SESSION["user_id"] = $id;
        $_SESSION["setting_rounding"] = 2;
        $_SESSION["setting_sorting"] = 'average';
        $_SESSION["beta_tester"] = 0;

        // Redirect
        header("Location: /");
    } else exit("Error inserting account into database! Please try again later.");
?>