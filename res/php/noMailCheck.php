<?php 

    // Start the PHP_session
    if(!isset($_SESSION)) session_start();

    // Check if user email is set
    if(!isset($_SESSION['user_email'])) {
        echo "<link rel='stylesheet' href='/res/css/noMail.css'></script>";
        echo "<script src='/res/js/noMail.js'></script>";

        // If last clicked is less than 1 seconds ago add a script
        if(isset($_SESSION['last_clicked']) && time() - $_SESSION['last_clicked'] < 5) {
            echo "<script>window.addEventListener('load', function(){noMailOpen();});</script>";
        }
        $_SESSION['last_clicked'] = time();
    }

?>