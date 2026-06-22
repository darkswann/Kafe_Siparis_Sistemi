-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 Haz 2026, 17:03:32
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kafe_siparis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim`
--

CREATE TABLE `iletisim` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `durum` tinyint(4) DEFAULT 0,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullaniciadi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullaniciadi`, `sifre`, `rol`) VALUES
(1, 'admin', '$2y$10$LrW/MPSgpc.cTcZzEzEgB.Qah0hGLF5VTOSvkBgZ49cckkhzF/wqW', 'admin'),
(3, 'husynlll', '$2y$10$tPZD6fUj635zO41IH/0RNeQSuWPNJ2w.zFxzsHNfxNwiwNcc0iILa', 'user'),
(10, 'huso', '$2y$10$6wk9gD7pKq5.soSf7bvi5uNELUCH5nXUuCBa33uxXNoOxRUJt4v.u', 'user');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `id` int(11) NOT NULL,
  `kullaniciadi` varchar(50) DEFAULT NULL,
  `toplam_fiyat` decimal(10,2) DEFAULT NULL,
  `durum` varchar(30) DEFAULT 'Hazırlanıyor',
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`id`, `kullaniciadi`, `toplam_fiyat`, `durum`, `olusturma_tarihi`) VALUES
(32, 'huso', 125.00, 'Hazır', '2026-06-22 11:19:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_detay`
--

CREATE TABLE `siparis_detay` (
  `id` int(11) NOT NULL,
  `siparis_id` int(11) DEFAULT NULL,
  `urun_id` int(11) DEFAULT NULL,
  `adet` int(11) DEFAULT NULL,
  `fiyat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `resim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `ad`, `fiyat`, `resim`) VALUES
(1, 'Türk Kahvesi', 45.00, NULL),
(2, 'Double Türk Kahvesi', 60.00, NULL),
(3, 'Damla Sakızlı Türk Kahvesi', 55.00, NULL),
(4, 'Menengiç Kahvesi', 65.00, NULL),
(5, 'Espresso', 55.00, NULL),
(6, 'Double Espresso', 70.00, NULL),
(7, 'Americano', 65.00, NULL),
(8, 'Latte', 80.00, NULL),
(9, 'Caramel Latte', 90.00, NULL),
(10, 'Vanilla Latte', 90.00, NULL),
(11, 'Cappuccino', 80.00, NULL),
(12, 'Mocha', 95.00, NULL),
(13, 'White Mocha', 100.00, NULL),
(14, 'Flat White', 85.00, NULL),
(15, 'Macchiato', 75.00, NULL),
(16, 'Affogato', 110.00, NULL),
(17, 'Cold Brew', 95.00, NULL),
(18, 'Ice Latte', 95.00, NULL),
(19, 'Ice Americano', 75.00, NULL),
(20, 'Ice Mocha', 100.00, NULL),
(21, 'Çay', 20.00, NULL),
(22, 'Fincan Çay', 25.00, NULL),
(23, 'Demleme Çay', 30.00, NULL),
(24, 'Elma Çayı', 35.00, NULL),
(25, 'Ihlamur', 35.00, NULL),
(26, 'Adaçayı', 35.00, NULL),
(27, 'Yeşil Çay', 35.00, NULL),
(28, 'Sıcak Çikolata', 75.00, NULL),
(29, 'Kahve Sütlü', 50.00, NULL),
(30, 'Coca Cola', 50.00, NULL),
(31, 'Coca Cola Zero', 50.00, NULL),
(32, 'Fanta', 45.00, NULL),
(33, 'Sprite', 45.00, NULL),
(34, 'Ice Tea Şeftali', 45.00, NULL),
(35, 'Ice Tea Limon', 45.00, NULL),
(36, 'Ayran', 25.00, NULL),
(37, 'Maden Suyu', 20.00, NULL),
(38, 'Limonata', 55.00, NULL),
(39, 'Portakal Suyu', 60.00, NULL),
(40, 'Milkshake Çikolata', 95.00, NULL),
(41, 'Milkshake Çilek', 95.00, NULL),
(42, 'Milkshake Vanilya', 95.00, NULL),
(43, 'Kaşarlı Tost', 70.00, NULL),
(44, 'Sucuklu Tost', 80.00, NULL),
(45, 'Karışık Tost', 85.00, NULL),
(46, 'Tavuklu Sandviç', 95.00, NULL),
(47, 'Ton Balıklı Sandviç', 100.00, NULL),
(48, 'Club Sandwich', 120.00, NULL),
(49, 'Hamburger', 130.00, NULL),
(50, 'Cheeseburger', 145.00, NULL),
(51, 'Double Burger', 180.00, NULL),
(52, 'Chicken Burger', 125.00, NULL),
(53, 'BBQ Burger', 150.00, NULL),
(54, 'Wrap Tavuk', 110.00, NULL),
(55, 'Hot Dog', 90.00, NULL),
(56, 'Patates Kızartması', 60.00, NULL),
(57, 'Soğan Halkası', 70.00, NULL),
(58, 'Chicken Nuggets', 85.00, NULL),
(59, 'Mozzarella Stick', 95.00, NULL),
(60, 'Cips Tabak', 50.00, NULL),
(61, 'Cheesecake', 110.00, NULL),
(62, 'San Sebastian Cheesecake', 130.00, NULL),
(63, 'Tiramisu', 115.00, NULL),
(64, 'Brownie', 95.00, NULL),
(65, 'Sufle', 100.00, NULL),
(66, 'Waffle', 140.00, NULL),
(67, 'Magnolia', 110.00, NULL),
(68, 'Profiterol', 105.00, NULL),
(69, 'Çikolatalı Pasta Dilimi', 90.00, NULL),
(70, 'Meyveli Pasta Dilimi', 90.00, NULL),
(71, 'Ekler', 35.00, NULL),
(72, 'Trileçe', 95.00, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `iletisim`
--
ALTER TABLE `iletisim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparis_detay`
--
ALTER TABLE `siparis_detay`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `iletisim`
--
ALTER TABLE `iletisim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `siparis_detay`
--
ALTER TABLE `siparis_detay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
