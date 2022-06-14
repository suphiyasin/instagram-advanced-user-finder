<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
    
        //MY STATISTIC
        $user = $instagram->user->get_my_statistic();
        print_r($user);
        //MY STATISTIC
        
    }else{
        echo 'Login Fail';
    }
