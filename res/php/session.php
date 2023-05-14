<?php 

function start_session($readonly = false) {

    if(session_status() == PHP_SESSION_ACTIVE) session_write_close();

    $session_life_time = 86400 * 30;
    $session_path = "/";
    $session_domain = implode(".",array_slice(explode(".",$_SERVER["HTTP_HOST"]), -2, 2));
    $session_secure = false;
    $session_httponly = true;

    session_set_cookie_params($session_life_time, $session_path, $session_domain, $session_secure, $session_httponly);
    
    $options = [];

    if($readonly) $options['read_and_close'] = true;
    
    session_start($options);
}

function restart_session($readonly = false) {
    if(session_status() == PHP_SESSION_ACTIVE) session_write_close();
    start_session($readonly);
}

function stop_session(){
    if(session_status() == PHP_SESSION_ACTIVE) session_write_close();
}

function destroy_session(){
    start_session();
    session_destroy();
}

function unset_session($close = false){
    start_session();
    session_unset();
    if($close) session_write_close();
}

?>