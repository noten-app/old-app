<?php 

    if(!isset($_SESSION)) session_start();

    // Not logged in
    function checkLogin(){
        return !(
            !isset($_SESSION['login_method']) ||
            !isset($_SESSION['user_name']) ||
            !isset($_SESSION['user_id']) ||
            !isset($_SESSION['user_email']) 
        );
    }

?>