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
    Bu PHP kütüphanesi ile instagram mobil uygulamasının tüm özelliklerini kullanabilirsiniz.
    <br />
    <a href="#">Demo</a>
    ·
    <a href="https://github.com/hasokeyk/instagram/issues">Geri Bildirim</a>
<br>
<a href="https://github.com/Hasokeyk/instagram/blob/main/README.md" style="font-size:24px">Click for english document</a>
</p>

## Bağış

| Coin | Cüzdan |
| ------------- | ------------- |
| ETH | 0x2091be5b1840b10a841376c366ec0475771b4ec8 |
| BTC | 12Set9KZGXWD64pbeGsdqZCJZofxyK77LP |

https://www.patreon.com/hasokeyk

## SIKÇA SORULAN SORULAR
<a href="https://github.com/hasokeyk/instagram/blob/docs/tr/sikca-sorulan-sorular.md.md">SSS'YE GİT</a>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h2 style="display: inline-block">Başlıklar</h2></summary>
  <ol>
    <li>
      <a href="#proje-hakkında">Proje Hakkında</a>
    </li>
    <li>
      <a href="#kullanmaya-başlayın">Kullanmaya Başlayın</a>
      <ul>
        <li><a href="#gereksinimler">Gereksinimler</a></li>
        <li><a href="#yetkilendirme">Yetkilendirme</a></li>
      </ul>
    </li>
    <li><a href="#kullanım">Kullanım</a></li>
    <li><a href="#yol-haritası">Yol Haritası</a></li>
    <li><a href="#katkı-sağlayanlar">Katkı Sağlayanlar</a></li>
    <li><a href="#lisans">Lisans</a></li>
    <li><a href="#iletişim">İletişim</a></li>
    <li><a href="#donation">Bağış Yapın</a></li>
  </ol>
</details>

## Proje Hakkında

Bu proje instagram mobil uygulamasının kabiliyetlerini PHP kütüphanesinde kullanabilmek amacıyla yapılmıştır. Mobil
uygulamadaki sorguların birebir kopyalanarak instagram sunucularına sorgu yapıp cevapları almaktadır.

<!-- GETTING STARTED -->

## Kullanmaya Başlayın

Lütfen burayı dikkatle okunuyun.

### Gereksinimler

- Bilgisayarınızda "composer" uygulaması kurulu olması gerekmektedir. Kurulum için https://getcomposer.org/download/
- PHP 7.4 ve üstü

### Yetkilendirme

Aşağıdaki dosya ve klasörleri chmod 777 ile yetkilendirin.

`/vendor/hasokeyk/`

## Composer ile kurulum

* Çalışma klasörünüzü belirledikten sonra o klasörde terminal açıp aşağıdaki komutu yazıp entere basın.
  ```sh
  composer require hasokeyk/instagram
  ```

## Repoyu indirerek kullanma

1. İlk önce repoyu indirin
   ```sh
   git clone https://github.com/hasokeyk/instagram.git
   ```
2. Gerekli kütüphaneleri indirmek için aşağıdaki komutu kullanın.
   ```sh
   composer install
   ```

<!-- USAGE EXAMPLES -->

## Örnek Kodlar

# Login/Giriş işlemi

Her işlemden önce kullanıcı girişi yapmalısınız. 1 Kere giriş yaptıktan sonra sistem önbelleğe alacaktır ve bundan
sonraki işlemleriniz daha hızlı bir şekilde çalışacaktır.

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

# İki Adımlı Login/Giriş işlemi

Instagrama ilk giriş denemenizde 2 adımlı doğrulama açıksa size bir kod gelecektir. Kodu ekranda çıkan inputa girip "Login" butonuna basarsanız giriş işleminiz otomatik olarak tamamlanacaktır.
Bir dahaki girişlerde eğer ipniz değişmediyse kod sormadan giriş yapabilirsiniz.

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

# Kullanıcı Paylaşımlarını Getirme

Aşağıdaki kodları çalıştırğınızda giriş yaptığınız kullanıcının son 50 paylaşımını getireceksiniz. Başka birinin
paylaşımlarını getirmek için get_user_posts('hasokeyk') yazmanız yeterlidir.

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

## Yol Haritası

## Kullanıcı İşlemleri

| İşlemler                                                        | Çalışıyor | Örnek Dosya                                                                                                                                  |
|-----------------------------------------------------------------| ------------- |----------------------------------------------------------------------------------------------------------------------------------------------|
| Kullanıcı Girişi                                                | :heavy_check_mark: | [instagram-user-login.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-login.php)                           | 
| iki Adımlı Kullanıcı Girişi                                     | :heavy_check_mark: | [iinstagram-user-two-factor-login.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-two-factor-login.php)    | 
| Giriş Yapmış Kullanıcı Bilgisi Getirme                          | :heavy_check_mark: | [instagram-user-info.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-info.php)                             |
| Giriş Yapmış Kullanıcı İstatistik Getirme                       | :heavy_check_mark: | [instagram-user-statistics.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-statistics.php)                 |
| Giriş Yapmış Kullanıcının En Az Etkileşimde Olduğu Kullanıcılar | :heavy_check_mark: | [instagram-user-least-interacted-with.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-least-interacted-with.php) |
| Giriş Yapmış Kullanıcının En Çok Gördüğü Kullanıcılar           | :heavy_check_mark: | [instagram-user-my-most-seen-in-feed.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-least-interacted-with.php) |
| Profil Resmi Değiştirme                                         | :heavy_check_mark: | [instagram-user-change-profil-pic.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-change-profil-pic.php)   |
| Kullanıcı Takip Etme                                            | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                         |
| Kullanıcı Takipten Çıkma                                        | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                         |
| Kullanıcının Kendisini Takipten Çıkma                           | :heavy_check_mark: | [instagram-user-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-follow.php)                         |
| Kullanıcı Bildirim Listesi Getirme                              | :heavy_check_mark: | [instagram-user-my-notification.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-notification.php)       |
| Kullanıcı Mesaj İsteklerini Getirme                             | :heavy_check_mark: | [instagram-user-my-pending-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-pending-inbox.php)     |
| Kullanıcı Mesaj Kutusunu Getirme                                | :heavy_check_mark: | [instagram-user-my-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-inbox.php)                     |
| Giriş Yapan Kullanıcının Takipçilerini Getirme                  | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-followers.php)             |
| Giriş Yapan Kullanıcının Takip Ettiklerini Getirme              | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-my-following.php)             |
| Herhangi Bir Kullanıcının Takipçilerini Getirme                 | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-followers.php)                |
| Herhangi Bir Kullanıcının Takip Ettiklerini Getirme             | :heavy_check_mark: | [instagram-user-my-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-following.php)                |
| Paylaşım Getirme                                                | :heavy_check_mark: | [instagram-user-get-posts.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-get-posts.php)                   |


## Paylaşım İşlemleri

| İşlemler  | Çalışıyor | Örnek Dosya |
| ------------- | ------------- | ------------- |
| Paylaşım İstatistikleri Getirme  | :heavy_check_mark: | [instagram-user-get-posts-statistics.php](https://github.com/Hasokeyk/instagram/blob/main/examples/statistics/instagram-user-get-posts-statistics.php) |
| Görsel Paylaşma  | :heavy_check_mark: | [instagram-media-share-photo.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-share-photo.php) |
| Video Paylaşma  | :x: | [HAZIRLANIYOR](https://github.com/Hasokeyk/instagram/blob/main/examples/media/) |
| Story Paylaşma  | :x: | [HAZIRLANIYOR](https://github.com/Hasokeyk/instagram/blob/main/examples/media/) |
| Carousel Paylaşma  | :x: | [HAZIRLANIYOR](https://github.com/Hasokeyk/instagram/blob/main/examples/media/) |
| Paylaşım Beğenme  | :heavy_check_mark: | [instagram-media-like.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-like.php) |
| Paylaşım Beğenmekten Çıkma  | :heavy_check_mark: | [instagram-media-unlike.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-unlike.php) |
| Paylaşım Kayıt Etme  | :heavy_check_mark: | [instagram-media-save.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-save.php) |
| Paylaşım Kayıt Etmekten Çıkma  | :heavy_check_mark: | [instagram-media-unsave.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-unsave.php) |
| Paylaşıma Yorum Yazma  | :heavy_check_mark: | [instagram-media-send-comment.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-send-comment.php) |
| Paylaşıma Yorum Silme  | :heavy_check_mark: | [instagram-media-del-comment.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-del-comment.php) |
| Paylaşım Mesaj Olarak Yollama  | :heavy_check_mark: | [instagram-media-send-media-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/media/instagram-media-send-media-inbox.php) |

## Mesajlaşma İşlemleri

| İşlemler  | Çalışıyor | Örnek Dosya |
| ------------- | ------------- | ------------- |
| Yazı Olarak Mesaj Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Link Olarak Mesaj Atma  | :x: | [HAZIRLANIYOR](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-user-login.php) |
| Kalp Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Görsel Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Alevli Mesaj Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Hediyeli Mesaj Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Konfeti Mesaj Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |
| Kalplli Mesaj Atma  | :heavy_check_mark: | [instagram-users-send-inbox.php](https://github.com/Hasokeyk/instagram/blob/main/examples/user/instagram-users-send-inbox.php) |

## Akıllı İşlemler

| İşlemler  | Çalışıyor | Örnek Dosya |
| ------------- | ------------- | ------------- |
| Sahte Takipçi Tespiti  | :heavy_check_mark: | [instagram-smart-get-fake-followers-profile.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-fake-followers-profile.php) |
| Sahte Takip Edilen Tespiti  | :heavy_check_mark: | [instagram-smart-get-fake-following-profile.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-fake-following-profile.php) |
| Takip Etmeniz Gereken Hesaplar  | :heavy_check_mark: | [instagram-smart-get-my-must-follow.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-my-must-follow.php) |
| Gizli Takipçileriniz  | :heavy_check_mark: | [instagram-smart-get-my-secret-followers.php](https://github.com/Hasokeyk/instagram/blob/main/examples/smart/instagram-smart-get-my-secret-followers.php) |

## Katkı Sağlayanlar
Asım Murat YILMAZ - [GITHUB](https://github.com/asiminnesli)

## Lisans

Bu proje geliştirme aşamasında olduğu sürece indirebilir ve kullanabilirsiniz. Başka amaçlar için kullanılırsa bu
kodları yazan kişinin sorumluluğu bulunmamaktadır. Bu projeyi indirip kullanıdığınızda bunu kabul etmiş sayılırsınız.


## İletişim

Hasan Yüksektepe - [INSTAGRAM](https://instagram.com/hasokeyk)

Web Sitem : [https://hayatikodla.net](https://hayatikodla.net)

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
