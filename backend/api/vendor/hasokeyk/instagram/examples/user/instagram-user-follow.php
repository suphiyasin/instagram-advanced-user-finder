<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
    
        //FOLLOW
        $user = $instagram->user->follow('yazilimvegirisim');
        print_r($user);
        //FOLLOW
        
        //UNFOLLOW
        $user = $instagram->user->unfollow('yazilimvegirisim');
        print_r($user);
        //UNFOLLOW
        
        //UNFOLLOW ME
        $user = $instagram->user->unfollow_me('yazilimvegirisim');
        print_r($user);
        //UNFOLLOW ME
        
    }else{
        echo 'Login Fail';
    }
