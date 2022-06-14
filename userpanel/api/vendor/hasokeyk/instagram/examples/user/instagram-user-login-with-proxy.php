<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username, $password);
    
    //PROXY LIST : https://spys.one/en/socks-proxy-list/
    
    $instagram->request->proxy = "http://18.118.167.224:5555";
    //$instagram->request->proxy = "https://xxx.xxx.xxx.xxx:xxxx";
    //$instagram->request->proxy = "socks5://xxx.xxx.xxx.xxx:xxxx";
    
    $login = $instagram->login->login();
    if($login){
        echo 'Login success';
    }else{
        echo 'Login Fail';
    }
    
    //LOGIN CONTROL
    $login_control = $instagram->login->login_control();
    if($login_control){
        echo 'Login is still';
    }else{
        echo 'Login False';
    }
    //LOGIN CONTROL

    