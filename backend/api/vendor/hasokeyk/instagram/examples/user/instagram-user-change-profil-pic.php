<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
    
        $pic_path = __DIR__.'/filename.jpg';
        $change_profil_pic = $instagram->user->change_profil_pic($pic_path);
        if($change_profil_pic){
            echo 'Changed';
        }else{
            echo 'Not changed';
        }
        
    }else{
        echo 'Login Fail';
    }
