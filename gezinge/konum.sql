-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Mar 2018, 00:19:57
-- Sunucu sürümü: 10.1.30-MariaDB
-- PHP Sürümü: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `konum`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `file`
--

CREATE TABLE `file` (
  `dosya` varchar(40) NOT NULL,
  `temp` varchar(40) NOT NULL,
  `kontrol` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `file`
--

INSERT INTO `file` (`dosya`, `temp`, `kontrol`) VALUES
('deneme.txt', 'C:xampp	mpphp98AE.tmp', '0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `indirgenmis`
--

CREATE TABLE `indirgenmis` (
  `enlem2` varchar(30) NOT NULL,
  `boylam2` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `indirgenmis`
--

INSERT INTO `indirgenmis` (`enlem2`, `boylam2`) VALUES
('-33.820154', '151.157509'),
('-33.820154', '151.287478'),
('-33.890542', '151.274856'),
('-33.923036', '151.157509'),
('-33.950198', '151.259302'),
('-34.028249', '151.157509');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `koordinat`
--

CREATE TABLE `koordinat` (
  `enlem` varchar(30) NOT NULL,
  `boylam` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `koordinat`
--

INSERT INTO `koordinat` (`enlem`, `boylam`) VALUES
('-33.820154', '151.157509'),
('-33.801524', '151.190556'),
('-33.801524', '151.210451'),
('-33.820154', '151.287478'),
('-33.890542', '151.274856'),
('-33.923036', '151.157509'),
('-33.950198', '151.259302'),
('-34.028249', '151.157509');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `zamanoran`
--

CREATE TABLE `zamanoran` (
  `zaman` varchar(15) NOT NULL,
  `oran` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `zamanoran`
--

INSERT INTO `zamanoran` (`zaman`, `oran`) VALUES
('0.012251117', '25.0\n');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
