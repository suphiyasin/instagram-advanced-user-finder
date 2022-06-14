<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
        $post = $instagram->smart->get_my_secret_followers();
        print_r($post);
    }else{
        echo 'Login Fail';
    }
