[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![Hasan Yüksetepe][linkedin-shield]][linkedin-url]
[![@hasokeyk][instagram-shield]][instagram-url]

<!-- PROJECT LOGO -->
<br />
<p align="center">
<a href="https://github.com/hasokeyk/instagram/">
<img src="https://cdn.cdnlogo.com/logos/i/4/instagram.svg" alt="Logo" width="80" height="80" />
</a>

<h3 align="center">Hasokeyk / Instagram</h3>

<p align="center">
    With this PHP library, you can use all features of the instagram Mobile App
    <br />
    <a href="#">Demo</a>
    ·
    <a href="https://github.com/hasokeyk/instagram/issues">Feedback</a>
    <br>
    <a href="https://github.com/Hasokeyk/instagram/blob/main/README-TR.md" style="font-size:24px">Türkçe doküman için tıklayın</a>
</p>

## Donation

| Coin | Wallet |
| ------------- | ------------- |
| ETH | 0x2091be5b1840b10a841376c366ec0475771b4ec8 |
| BTC | 12Set9KZGXWD64pbeGsdqZCJZofxyK77LP |

## FAQ
<a href="https://github.com/hasokeyk/instagram/blob/docs/en/faq.md">GO FAQ</a>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h2 style="display: inline-block">Contents</h2></summary>
  <ol>
    <li>
      <a href="#about-project">About Project</a>
    </li>
    <li>
      <a href="#get-started">Get Started</a>
      <ul>
        <li><a href="#requirements">Requirements</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#road-map">Road Map</a></li>
    <li><a href="#contributors">Contributors</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact-us">Contant Us</a></li>
  </ol>
</details>

## About Project

This project is made in PHP library of all instagram mobile app features. This library can send exactly same queries like mobile app
and returns server responses.

<!-- GETTING STARTED -->

## Getting Started

Please read carefully.

### Requirements

- You must have to "composer" application on your PC. For installation  https://getcomposer.org/download/
- PHP 7.4 or above

### File permissions

Give permission to the following files and folders with chmod 777.

`/vendor/hasokeyk/`

## Setup via Composer

* you must determine your root(working) folder after that open console ( terminal )
  ```sh
  composer require hasokeyk/instagram
  ```

## Installing via download Repository

1. Firsty download repository
   ```sh
   git clone https://github.com/hasokeyk/instagram.git
   ```
2. Use the command below to download the required libraries.
   ```sh
   composer install
   ```

<!-- USAGE EXAMPLES -->

## Examples

# Login

You must login before each operation. In your first login operation, the system will be cached and your operation will run faster.

```php
<?php

    use instagram\instagram;
    
    require "/vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    $login = $instagram->login->login();
    if($login){
        echo 'Login success';
    }else{
        echo 'Login Fail';
    }
    
    //LOGIN CONTROL
    $login_control = $instagram->login->login_control();
    if($login_control){
        echo 'Login True';
    }else{
        echo 'Login False';
    }
    //LOGIN CONTROL

```

# Two factor authorization

In your first login attemp, if two factor authorization are enabled, instagram will send you a code. If you enter the code into the input area, yout login operation will be completed automatically.
After your next logins, if yout IP is not changed, you can login without asking code.

```php
<?php

    use instagram\instagram;
    
    require "/vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram    = new instagram($username, $password);
    
    if(isset($_REQUEST['two_factor_login_code'], $_REQUEST['two_factor_identifier']) and !empty($_REQUEST['two_factor_login_code']) and !empty($_REQUEST['two_factor_identifier'])){
        $code             = trim($_REQUEST['two_factor_login_code']);
        $token            = trim($_REQUEST['two_factor_identifier']);
        $two_factor_login = $instagram->login->two_factor_login($code, $token);
        print_r($two_factor_login);
    }else{
        $login        = $instagram->login->login();
        if(isset($login->two_factor_identifier) and !empty($login->two_factor_identifier)){
            echo <<<END
        <form action="" method="post">
            <input type="hidden" name="two_factor_identifier" value="$login->two_factor_identifier">
            <input type="text" name="two_factor_login_code">
            <input type="submit" value="Login">
        </form>
        END;
        }
        else if($instagram->login->login_control()){
            echo 'Login Success';
        }
        else{
            echo 'Login Fail';
        }
    }

```

# Getting user posts

When you run the below code, you will get last 50 posts of user you are logged into. 
If you want another accounts posts get_user_posts('hasokeyk') please use this.

```php
<?php
    
    use instagram\instagram;
    
    require "../vendor/autoload.php";
    
    $username = 'username';
    $password = 'password';
    
    $instagram = new instagram($username,$password);
    
    $login = $instagram->login->login_control();
    if($login){
    
        $user_posts = $instagram->user->get_user_posts();
        print_r($user_posts);
        
    }else{
        echo 'Login Fail';
    }

```

<!-- ROADMAP -->

## Road Map

## User operations

| Operation                                      | Working | Example File                                                                                                                                       |
|------------------------------------------------| ------------- |----------------------------------------------------------------------------------------------------------------------------------------------------|
| Login                                          | :heavy_check_mark: | [instagram-user-login.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-login.php)                                 | 
| 2-Factor Auth Login                            | :heavy_check_mark: | [instagram-user-two-factor-login.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-two-factor-login.php)           | 
| Login width proxy                              | :heavy_check_mark: | [instagram-user-login-with-proxy.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-login-with-proxy.php)           | 
| Getting posts of logged in account             | :heavy_check_mark: | [instagram-user-info.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-info.php)                                   |
| Getting statictics of logged in account        | :heavy_check_mark: | [instagram-user-statistics.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-statistics.php)                       |
| Getting least Viewed of logged in account      | :heavy_check_mark: | [instagram-user-least-interacted-with.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-least-interacted-with.php) |
| Getting most Viewed Users by Logged In         | :heavy_check_mark: | [instagram-user-my-most-seen-in-feed.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-least-interacted-with.php)  |
| Changing profile image                         | :heavy_check_mark: | [instagram-user-change-profil-pic.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-change-profil-pic.php)         |
| Follow an account                              | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                               |
| Unffollow an account                           | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                               |
| Unfollow the Account Itself                    | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                               |
| Getting notification list of logged in account | :heavy_check_mark: | [instagram-user-my-notification.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-notification.php)             |
| Getting message request of logged in account   | :heavy_check_mark: | [instagram-user-my-pending-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-pending-inbox.php)           |
| Getting message inbox of logged in account     | :heavy_check_mark: | [instagram-user-my-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-inbox.php)                           |
| Getting my account followers                   | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-followers.php)                   |
| Getting my account gollowing                   | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-following.php)                   |
| Getting user followers                         | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-followers.php)                      |
| Getting user following                         | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-following.php)                      |
| Getting Post                                   | :heavy_check_mark: | [instagram-user-get-posts.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-get-posts.php)                         |


## Post share operations

| Operation  | Work | Example                                                                                                                                                |
| ------------- | ------------- |--------------------------------------------------------------------------------------------------------------------------------------------------------|
| Getting share statistics | :heavy_check_mark: | [instagram-user-get-posts-statistics.php](https://github.com/Hasokeyk/instagram/blob/main/examples/statistics/instagram-user-get-posts-statistics.php) |
| Image Share  | :heavy_check_mark: | [instagram-media-share-photo.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-share-photo.php)                      |
| Video Share  | :x: | [COMING SOON](https://github.com/Hasokeyk/instagram/blob/main/examples/media/)                                                                         |
| Story Share  | :x: | [COMING SOON](https://github.com/Hasokeyk/instagram/blob/main/examples/media/)                                                                         |
| Carousel Share  | :x: | [COMING SOON](https://github.com/Hasokeyk/instagram/blob/main/examples/media/)                                                                         |
| Share Likes  | :heavy_check_mark: | [instagram-media-like.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-like.php)                                    |
| Share Unlike  | :heavy_check_mark: | [instagram-media-unlike.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-unlike.php)                                |
| Share Save  | :heavy_check_mark: | [instagram-media-save.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-save.php)                                    |
| Share Unsave  | :heavy_check_mark: | [instagram-media-unsave.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-unsave.php)                                |
| Share Comment  | :heavy_check_mark: | [instagram-media-send-comment.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-send-comment.php)                    |
| Share delete comment  | :heavy_check_mark: | [instagram-media-del-comment.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-del-comment.php)                      |
| Send share to message  | :heavy_check_mark: | [instagram-media-send-media-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-send-media-inbox.php)            |

## Messaging Operation

| Operation  | Work | Example                                                                                                                        |
| ------------- | ------------- |--------------------------------------------------------------------------------------------------------------------------------|
| Send message as Text  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Send message as Link   | :x: | [COMING SOON](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-login.php)                          |
| Send Heart  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Send Image  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Flame Text  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Message with present  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Message with confetti  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Message with heart  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |

## Smart Operation

| Operation  | Work | Example |
| ------------- | ------------- | ------------- |
| Fake followeing detection | :heavy_check_mark: | [instagram-smart-get-fake-followers-profile.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-fake-followers-profile.php) |
| Fake followers detection | :heavy_check_mark: | [instagram-smart-get-fake-following-profile.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-fake-following-profile.php) |
| Accounts You Should Follow  | :heavy_check_mark: | [instagram-smart-get-my-must-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-my-must-follow.php) |
| Secret Followers  | :heavy_check_mark: | [instagram-smart-get-my-secret-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-my-secret-followers.php) |

## Contributors
Asım Murat YILMAZ - [GITHUB](https://github.com/asiminnesli)

## License

You can download and use it as long as this project is under development. If used for other purposes
The person who wrote the codes is not responsible. By downloading and using this project, you agree to this.

## Donate

patreon: https://www.patreon.com/hasokeyk


## Contact

Hasan Yüksektepe - [INSTAGRAM](https://instagram.com/hasokeyk)

Website : [https://hayatikodla.net](https://hayatikodla.net)


[contributors-shield]: https://img.shields.io/github/contributors/hasokeyk/instagram.svg?style=for-the-badge

[contributors-url]: https://github.com/hasokeyk/instagram/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/hasokeyk/instagram.svg?style=for-the-badge

[forks-url]: https://github.com/hasokeyk/instagram/network/members

[stars-shield]: https://img.shields.io/github/stars/hasokeyk/instagram.svg?style=for-the-badge

[stars-url]: https://github.com/hasokeyk/instagram/stargazers

[issues-shield]: https://img.shields.io/github/issues/hasokeyk/instagram.svg?style=for-the-badge

[issues-url]: https://github.com/hasokeyk/instagram/issues

[license-shield]: https://img.shields.io/github/license/hasokeyk/instagram.svg?style=for-the-badge

[license-url]: https://github.com/Hasokeyk/instagram/blob/main/LICENSE

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555

[linkedin-url]: https://www.linkedin.com/in/hasan-yuksektepe/

[instagram-shield]: https://img.shields.io/badge/-Instagram-black.svg?style=for-the-badge&logo=Instagram&colorB=555

[instagram-url]: https://instagram.com/hasokeyk/