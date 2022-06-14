<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
    
        //MY INFO
        $me = $instagram->user->get_user_info_by_username();
        print_r($me);
        //MY INFO
    
        //OTHER USER INFO
        $user = $instagram->user->get_user_info_by_username('yazilimvegirisim');
        print_r($user);
        //OTHER USER INFO
        
    }else{
        echo 'Login Fail';
    }
