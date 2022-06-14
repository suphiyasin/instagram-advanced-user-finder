<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
    
        //INBOX SEND TEXT
        $user = $instagram->user->send_inbox_text('yazilimvegirisim','Hi! How are you?');
        print_r($user);
        //INBOX SEND TEXT
    
        //INBOX SEND TEXT FIRE
        $user = $instagram->user->send_inbox_text_fire('yazilimvegirisim','Hi! How are you?');
        print_r($user);
        //INBOX SEND TEXT FIRE
        
        //INBOX SEND TEXT GIFT
        $user = $instagram->user->send_inbox_text_gift('yazilimvegirisim','Hi! How are you?');
        print_r($user);
        //INBOX SEND TEXT GIFT
        
        //INBOX SEND TEXT CONFETTI
        $user = $instagram->user->send_inbox_text_confetti('yazilimvegirisim','Hi! How are you?');
        print_r($user);
        //INBOX SEND TEXT CONFETTI
        
        //INBOX SEND TEXT HEART
        $user = $instagram->user->send_inbox_text_heart('yazilimvegirisim','Hi! How are you?');
        print_r($user);
        //INBOX SEND TEXT HEART
        
        //INBOX SEND IMAGE
        $file_path = 'image.jpg';
        $user = $instagram->user->send_inbox_photo('yazilimvegirisim',$file_path);
        print_r($user);
        //INBOX SEND IMAGE
        
        //INBOX SEND LIKE
        $user = $instagram->user->send_inbox_like('yazilimvegirisim');
        print_r($user);
        //INBOX SEND LIKE
        
    }else{
        echo 'Login Fail';
    }
