[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<br />
<p align="center">
<a href="https://github.com/suphiyasin/instagram-advanced-user-finder/">
<img src="https://cdn.cdnlogo.com/logos/i/4/instagram.svg" alt="Logo" width="80" height="80" />
</a>

<h3 align="center">Instagram Advanced User Finder V1.0.0</h3>

<p align="center">
    Bu PHP scripti ile instagram'da kullanıcıları bulabilir ve onlara mesaj atabilirsiniz.
    <br>
    <a href="https://github.com/suphiyasin/instagram-advanced-user-finder/issues">Feedback</a>
    <br>
    <a href="https://github.com/suphiyasin/instagram-advanced-user-finder/blob/main/README.md" style="font-size:24px">English</a>
</p>

# Lisans Satın Alın

Aylık lisans almak için lütfen <a href="https://t.me/suphi007">@suphi007</a> ile iletişime geçin.
<br>

### <font style="color:#00ff00">Hafta sonları ücretsiz lisans</font>

## Proje Hakkında

Instagram'da aradığınız özelliklerle bir kullanıcıdan onbinlerce kullanıcıyı toplayabilir, biyografilerinden, iletişimlerinden telefon numaralarını veya e-posta adreslerini toplayabilir, ardından onlara istediğiniz metin/HTML ile mesaj gönderebilirsiniz.

### Gereksinimler

- PHP 7.4 veya üzeri

## Repoyu indirerek kullanma

1. <a href="https://github.com/suphiyasin/instagram-advanced-user-finder/archive/refs/heads/main.zip">Buradan</a> scripti indirin
2. "richoto" isminde bir veritabanı oluşturun.
3. Aşağıdaki dosyalarda veritabanı bilgilerini girin.
```phpt
backend/api/req.php:17
backend/panel/sis.php:3
```
4. Aşağıdaki dosyadan instagram cookie bilginizi girin.
```phpt
backend/api/req.php:30
```

## Cookie nasıl alınır?

Instaram cookie alma işlemi için bu videoyu izleyebilirsiniz.

<a href="https://t.me/otoaraclar/78">INSTAGRAM COOKIE ALMA VIDEOSU</a>

# Panel Nasıl Kullanılır?

### 1- Veri Toplama

#### a. Kullanıcı Toplama
1. "Collector" menüsü altındaki "find recommended" menüsüne tıklayın
2. Çıkan formdaki "Kullanıcı Adı" kısmına aradığınız benzer özellikteki bir tane kullanıcı adını yazınız.
3. Başlat butonuna basın. Ardından.
4. "Collector" menüsü altında "auto find recommended" menüsüne tıklayın.
5. Çıkan formda bir işlem yapmadan "Başlat" butonuna basın ve bekleyin. Arama işlemini durdurmak için sayfadan çıkmanız yeterli.

### Veri Tarama

#### a. Mail Bulma

1. "Scanner" menüsü altındaki "Mail scan from bio" menüsüne tıklayın
2. Mavi tikli hesapları aramasını isterseniz "Hesap türü seçiniz" kısmından seçim yapabilirsiniz.
3. Bulunacak mail türü için "Mail türü" kısmından seçim yapabilirsiniz.
4. Seçimlerinizi yaptıktan sonra "Başlat" butonuna basıp bekleyiniz.

### Mesaj Gönderme

#### a. Mail Yollama

SMTP Ayarları
1. "Mail settings" menüsüne girin.
2. Çıkan formdaki bilgileri girin ve "Kayıt et" butonuna basın.

Yollama işlemi

3. "Sender" menüsünün altındaki "Auto mail sender" menüsüne tıklayın.
4. Mail yaptıktan sonra "Başlat" butonuna basın ve bekleyin.

#### a. Instagram DM yollama

1. "Sender" menüsünün altındaki "Auto dm sender" menüsüne tıklayın.
2. Çıkan ekranda "Taslak" kısmında gönderilecek mesajı yazın.
3. "Hesaplarınızı Girin" kısmında mesaj atacağınız instagram kullanıcı ve şifrenizi aralarında : (ikinokta üstüste) olacak şekilde girin
4. Tüm işlemleri yaptıktan sonra "Başlat" butonuna basın ve bekleyin.

#### a. Whatsapp ile mesaj yollama

1. "Sender" menüsünün altındaki "Auto wp sender" menüsüne tıklayın.
2. Çıkan ekranda "Wali API KEY" kısmına wali.chat ile üye olduğunuz hesabın API KEY'ini girin.
3. "NO LISTESI GIRIN" kısmında mesaj yollanacak kişilerin telefon numaralarını aralarında boşluk olacak şekilde girin.
4. "TASLAK" kısmında yollanacak mesajı girin.
5. Tüm işlemleri yaptıktan sonra "Başlat" butonuna basın ve bekleyin.

# Ekran Görüntüleri

![image](https://user-images.githubusercontent.com/65618247/173745092-02f5186d-bf5a-427c-b78b-f73eb88eb9c9.png)
![image](https://user-images.githubusercontent.com/65618247/173745165-805ea1b4-9bab-4f09-bae5-14a5eecc4716.png)
![image](https://user-images.githubusercontent.com/65618247/173745202-bbe547dd-1df3-4807-abe8-1f42991e8c79.png)


[contributors-shield]: https://img.shields.io/github/contributors/suphiyasin/instagram-advanced-user-finder.svg?style=for-the-badge
[contributors-url]: https://github.com/suphiyasin/instagram-advanced-user-finder/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/suphiyasin/instagram-advanced-user-finder.svg?style=for-the-badge
[forks-url]: https://github.com/hasokeyk/instagram/network/members
[stars-shield]: https://img.shields.io/github/stars/suphiyasin/instagram-advanced-user-finder.svg?style=for-the-badge
[stars-url]: https://github.com/suphiyasin/instagram-advanced-user-finder/stargazers
[issues-shield]: https://img.shields.io/github/issues/suphiyasin/instagram-advanced-user-finder.svg?style=for-the-badge
[issues-url]: https://github.com/suphiyasin/instagram-advanced-user-finder/issues
