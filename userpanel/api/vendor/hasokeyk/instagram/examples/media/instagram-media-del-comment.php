<?php
    
    use instagram\instagram;
    
    require "../../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $instagram->login->login();
    
    $login = $instagram->login->login_control();
    if($login){
        
        //DELETE COMMENT BY COMMENT ID
        $post = $instagram->medias->delete_comment_post('2546428212937660604','123456789');
        print_r($post);
        //DELETE COMMENT BY COMMENT ID
    
        //DELETE COMMENT AUTO FIND COMMENT ID
        $post = $instagram->medias->delete_comment_post('2546428212937660604',null, true);
        print_r($post);
        //DELETE COMMENT AUTO FIND COMMENT ID
        
    }else{
        echo 'Login Fail';
    }
