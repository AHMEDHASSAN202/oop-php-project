-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2017 at 03:52 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codecourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Standard user', ''),
(2, 'Administrator', '{ "admin": 1,"moderator": 1 }');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `code` varchar(100) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `code`, `joined`, `group`) VALUES
(1, 'ahmed_hassan@gmail.com', 'ahmed hasan', '$2y$10$vs.jjcKeezvtRzu7UFfLgu.ibW0wCXH73tzzE.0.NWgYs3brO.ZXK', '1d8b83c6f23159c99a553de7229ace3f6e14a55a', '2017-07-01 03:10:47', 2),
(2, 'anas@gmail.com', 'anas hassan', '$2y$10$UYuFHdG82gC/byYmnZD07eIN1nwiSqvbsoFjCJSA5VbvGY1/AWO4O', '1564482465b830d709495ca1097962dbf6323589', '2017-07-01 22:38:11', 1),
(3, 'sayed_hassan@yahoo.com', 'sayed Elbhai', '$2y$10$PE0Lk5LSh2Nv3CdhzUr6/.KUE3aBJVXXA6H.KD1GG/E.l4WfDN8fa', '3ae4d45c9d559da0ecb130fa5bbaeec2cc6c0aec', '2017-07-02 00:17:59', 2),
(4, 'nisan@gmail.com', 'nisan elsayed', '$2y$10$J42YKfI9i3pPuul1v3sIceSikDr94pZR4n5dVFEi6WAfaDGmn0lmS', '9b87a789c56d8c1e1ceb87d0a36f88a95217a70d', '2017-07-02 04:25:01', 1),
(5, 'ahmed_0@gmail.com', 'ahmed hassan', '$2y$10$/hAlr1CL/KGFZlDnkrtkA.nNDTpLN9v18a06HN2v2syZMdJ92UsW6', 'f81bc43e651fa0f63e8d204a947ff6fcd44a053c', '2017-07-03 03:12:37', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
