-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 14 Haz 2022, 20:44:06
-- Sunucu sürümü: 8.0.27
-- PHP Sürümü: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `richoto`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `domains`
--

DROP TABLE IF EXISTS `domains`;
CREATE TABLE IF NOT EXISTS `domains` (
  `Domain` text NOT NULL,
  `UserID` text NOT NULL,
  `Statu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `Tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `Islem` text NOT NULL,
  `IP` text NOT NULL,
  `Tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ipban`
--

DROP TABLE IF EXISTS `ipban`;
CREATE TABLE IF NOT EXISTS `ipban` (
  `IP` text NOT NULL,
  `Sebeb` text NOT NULL,
  `Tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

DROP TABLE IF EXISTS `kullanici`;
CREATE TABLE IF NOT EXISTS `kullanici` (
  `kullanici_id` int NOT NULL AUTO_INCREMENT,
  `kullanici_admin` text NOT NULL,
  `kullanici_password` text NOT NULL,
  `kullanici_ip` text NOT NULL,
  PRIMARY KEY (`kullanici_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `kullanici_admin`, `kullanici_password`, `kullanici_ip`) VALUES
(1, '1', '1', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mailsettings`
--

DROP TABLE IF EXISTS `mailsettings`;
CREATE TABLE IF NOT EXISTS `mailsettings` (
  `UserID` text NOT NULL,
  `adress` text NOT NULL,
  `passwords` text NOT NULL,
  `port` text NOT NULL,
  `smtplink` text NOT NULL,
  `GozukcekAd` text NOT NULL,
  `taslakTitle` text NOT NULL,
  `taslak` text NOT NULL,
  `Statu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `MenuAdi` text NOT NULL,
  `MenuLink` text NOT NULL,
  `MenuCat` text NOT NULL,
  `Statu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `menu`
--

INSERT INTO `menu` (`MenuAdi`, `MenuLink`, `MenuCat`, `Statu`, `ID`) VALUES
('find recommended', 'onerilenler.php', '0', 0, 1),
('auto find recommended', 'onerilenliste.php', '0', 0, 2),
('Collect hashtag', 'hastagtopla.php', '0', 0, 3),
('collect from hashtag', 'hastag.php', '0', 0, 4),
('auto collect from hashtag', 'hastagliste.php', '0', 0, 5),
('Mail scan from bio', 'mailtara.php', '1', 0, 6),
('Random 4L Generator', 'check4l.php', '0', 0, 7),
('Mail scan for 4L', 'mail4l.php', '1', 0, 8),
('Auto mail sender', 'mailbas.php', '2', 0, 9),
('Mail scan for  min max follower', 'mailminmax.php', '1', 0, 10),
('auto dm sender', 'dmbas.php', '2', 0, 11),
('auto wp sender', 'wpbas.php', '2', 0, 12),
('Domain Bul', 'domainara.php', '3', 0, 13),
('Script Sihirbazı', 'scsihirbazi.php', '3', 0, 14),
('Anlık SubDomain Oluştur', 'subcreate.php', '3', 0, 15),
('No scanner from contact', 'notopla.php', '1', 0, 16),
('Iban Cozumle (for TR)', 'iban.php', 'x', 0, 17),
('Mail scanner from contact', 'maililetisim.php', '1', 0, 18),
('Mail settings', 'mailsettings.php', 'x', 0, 19),
('Auto mail sender (name:mail)', 'mailbasv2.php', '2', 0, 20),
('Oto Messenger Bas', 'messbas.php', '2', 0, 21),
('Messenger Tara', 'fbtara.php', '1', 0, 22),
('Cookie Settings', 'cokset.php', 'x', 0, 23);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `scripts`
--

DROP TABLE IF EXISTS `scripts`;
CREATE TABLE IF NOT EXISTS `scripts` (
  `scname` text NOT NULL,
  `scfolder` text NOT NULL,
  `scprice` text NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `scripts`
--

INSERT INTO `scripts` (`scname`, `scfolder`, `scprice`, `ID`) VALUES
('telifv1', '../scripts/telifv1/', 'Ücretsiz', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
  `Cookie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `UserID` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Statu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `Elo` text NOT NULL,
  `Gun` text NOT NULL,
  `IP` text NOT NULL,
  `IP2` text NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Statu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`Username`, `Password`, `Elo`, `Gun`, `IP`, `IP2`, `RegDate`, `Statu`, `ID`) VALUES
('userpanel', 'apikey', 'Diamond', '999999', ':::1', ':::1', '2022-06-14 09:11:54', 0, 23);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
