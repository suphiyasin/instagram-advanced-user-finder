<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $login = $instagram->login->login();
    
    //LOGIN CONTROL
    $login_control = $instagram->login->login_control();
    if($login_control){
    
        //EMOJILIST : https://www.utf8-chartable.de/unicode-utf8-table.pl?start=128512
        
        $action = $instagram->user->set_status('I love Code','😡');
        if($action->status == 'ok'){
            echo 'Status changed';
        }else{
            echo 'Status change error';
        }
        
    }else{
        echo 'Login False';
    }
    //LOGIN CONTROL

    