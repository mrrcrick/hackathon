-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2018 at 07:31 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `therapybox`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `email`) VALUES
(1, 'a', 'a', 'a'),
(2, 'd', 'd', 'd'),
(3, 'f', 'f', 'f'),
(4, 'H', 'H', 'H'),
(5, 'K', 'K', 'K'),
(6, 'AAA', 'AAA', 'AAA'),
(7, 'QQQ', 'QQQ', 'QQQ'),
(8, 'YYY', 'YYY', 'YYY'),
(9, 'hhhhh', 'jjjjjj', 'hhhh'),
(10, 'op', 'jj', 'op'),
(11, 'xx', 'xx', 'xxx'),
(12, 'sd', 'sd', 'ds'),
(13, 'ccc', 'ccc', 'ccc');

-- --------------------------------------------------------

--
-- Table structure for table `user_pics`
--

CREATE TABLE `user_pics` (
  `id` int(10) NOT NULL,
  `picturepath` varchar(255) DEFAULT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_pics`
--

INSERT INTO `user_pics` (`id`, `picturepath`, `user_id`) VALUES
(1, 'userpictures/8/arnie.jpg', 8),
(2, 'userpictures/9/blackguy.jpeg', 9),
(3, 'userpictures/11/', 11),
(4, 'userpictures/12/', 12),
(5, 'userpictures/13/', 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pics`
--
ALTER TABLE `user_pics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_pics`
--
ALTER TABLE `user_pics`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
