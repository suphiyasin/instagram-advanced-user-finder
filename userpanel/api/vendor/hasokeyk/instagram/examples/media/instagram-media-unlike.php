<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
        $post = $instagram->medias->unlike('2546428212937660604');
        print_r($post);
    }else{
        echo 'Login Fail';
    }
