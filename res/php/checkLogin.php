<?php 

    // Not logged in
    function checkLogin(){
        return !(
            !isset($_SESSION['login_method']) ||
            !isset($_SESSION['user_name']) ||
            !isset($_SESSION['user_id'])
        );
    }

?>