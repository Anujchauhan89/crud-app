-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 01:11 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contacts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `last_name`, `phone`) VALUES
(1, 'anuj', 'anujchauhanmca19@gmail.com', '997697686'),
(3, 'ritu', 'ritu@gmail.com', '999765654'),
(4, 'ritu', 'ritu@gmail.com', '999765654'),
(5, 'aada', 'a1@g.com', '4545'),
(12, 'Kökten', 'Adal', '+90 333 8859342'),
(13, 'Hamma', 'Abdurrezak', '+90 333 1563682'),
(14, 'Güleycan', 'Şensal', '+90 333 2557114'),
(15, 'Suadiye', 'Ratip', '+90 333 9163726'),
(16, 'Barik', 'Nurşide', '+90 333 3323749'),
(17, 'Hanifi', 'Emineeylem', '+90 333 2763531'),
(18, 'Nakiye', 'Oğulkan', '+90 333 6168924'),
(19, 'Hamsiye', 'Cerit', '+90 333 3544579'),
(20, 'Mahfi', 'Hülâgü', '+90 333 8937773'),
(21, 'Esmeray', 'Nurihayat', '+90 333 1688759'),
(22, 'Şennur', 'Nazifer', '+90 333 5326326'),
(23, 'Çetinok', 'Seden', '+90 333 1614182'),
(24, 'Vuslat', 'Erimşah', '+90 333 9551194'),
(25, 'Şeküre', 'Ruhiye', '+90 333 8792165'),
(26, 'İmran', 'Ümmehan', '+90 333 6971156'),
(27, 'Yavuzbay', 'Hiçsönmez', '+90 333 8839473'),
(28, 'Nevzete', 'Abdulgafur', '+90 333 1453851'),
(29, 'Aksüyek', 'Sal', '+90 333 2481491'),
(30, 'Ferhat', 'Kılıçaslan', '+90 333 6861354'),
(31, 'Fereç', 'Tomurcuk', '+90 333 4141534'),
(32, 'Balkız', 'Alabegüm', '+90 333 8826359'),
(33, 'Adulle', 'Nesim', '+90 333 5364556'),
(34, 'Sevdal', 'Bilhan', '+90 333 8634743'),
(35, 'Hariz', 'Budunal', '+90 333 1193335'),
(36, 'Alnıak', 'Atız', '+90 333 5676454'),
(37, 'Haşmet', 'Taşgan', '+90 333 6185991'),
(38, 'Salli', 'Necife', '+90 333 6692117'),
(39, 'Türeli', 'Selçen', '+90 333 5588146'),
(40, 'Boray', 'Ümit', '+90 333 7741455'),
(41, 'Aktemür', 'Akbora', '+90 333 4139141'),
(42, 'Yediveren', 'Muhammetali', '+90 333 8483755'),
(43, 'Baltaş', 'Tonguç', '+90 333 3724797'),
(44, 'Tepegöz', 'Ferize', '+90 333 9528318'),
(45, 'Selen', 'Arısal', '+90 333 9524786'),
(46, 'Abdulcabbar', 'Mahizar', '+90 333 6782359'),
(47, 'İyem', 'Emre', '+90 333 8238835'),
(48, 'Muazzam', 'Lâmia', '+90 333 1348678'),
(49, 'İlten', 'Eripek', '+90 333 3758172'),
(50, 'Zerrin', 'Resul', '+90 333 9276424'),
(51, 'İlalan', 'Telmize', '+90 333 3563723'),
(52, 'Hamise', 'Sertan', '+90 333 8263265'),
(53, 'Zubeyde', 'Berk', '+90 333 7281496'),
(54, 'Feda', 'Balsarı', '+90 333 4969618'),
(55, 'Müsemme', 'Civanşir', '+90 333 2556491'),
(56, 'Aydınyol', 'Fitnet', '+90 333 7783478'),
(57, 'Çoğa', 'Bigüm', '+90 333 4133666'),
(58, 'Şehrinaz', 'Raşide', '+90 333 2677248'),
(59, 'Naif', 'Rukhiya', '+90 333 8252766'),
(60, 'Azat', 'Nilden', '+90 333 9324656'),
(61, 'Gamze', 'Korday', '+90 333 9442367');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
