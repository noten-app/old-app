<?php 

    // This PHP-Script will later connect to the Sqowey-OAuth2-Connection point to receive data
    // For now it just sets session vars

    session_start();
    $_SESSION["login_method"] = "sqowey";
    $_SESSION["user_name"] = "CuzImBisonratte";
    $_SESSION["user_id"] = "5negptbo-lt6v-9qos-ws1a-1s5qxe36k3op";
    $_SESSION["user_email"] = "test@cuzimbisonratte.de";

    header("Location: /");
    exit();

?>