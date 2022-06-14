<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username, $password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
        $user = $instagram->user->get_my_inbox();
        print_r($user);
    }
    else{
        echo 'Login Fail';
    }
