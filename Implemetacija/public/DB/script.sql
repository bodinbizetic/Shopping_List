-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 09, 2020 at 07:13 AM
-- Server version: 5.7.28
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jel_ti_usput`
--

CREATE DATABASE IF NOT EXISTS `jel_ti_usput` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `jel_ti_usput`;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

-- DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fullName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `image` BLOB DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--
--
-- INSERT INTO `user` (`idUser`, `username`, `password`, `fullName`, `email`, `image`, `phone`, `type`) VALUES
-- (3, 'admin', 'admin123', 'Bodin Bizetic', 'admin@etf.bg.ac.rs', NULL, NULL , 1),
-- (2, 'drazen', 'drazen123',  'Drazen Draskovic', 'drazen@etf.bg.ac.rs', NULL, NULL, 0);


-- --------------------------------------------------------

--
-- Table structure for table `group`
--
-- type (JOIN_GROUP, NEW_MEMBERS, REMOVE_FROM_GROUP, LIST_STATUS)
-- DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
    `idGroup` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
    `description` varchar(60) COLLATE utf8_unicode_ci,
    `image` BLOB DEFAULT NULL,
    PRIMARY KEY (`idGroup`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `group`
--

-- INSERT INTO `group` (`idGroup`, `name`, `description`, `image`) VALUES
-- (1, 'Porodica', 'Group for family', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `notification`
--
-- type (JOIN_GROUP, NEW_MEMBERS, REMOVE_FROM_GROUP, LIST_STATUS)
DROP TABLE IF EXISTS `notification`;

CREATE TABLE IF NOT EXISTS `notification` (
    `idNotification` int(11) NOT NULL AUTO_INCREMENT,
    `text` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
    `idUser` int(11) NOT NULL,
    `idGroup` int(11) NOT NULL,
    `type` tinyint(1) NOT NULL DEFAULT '0',
    `isRead` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`idNotification`),
    KEY `user` (`idUser`),
    KEY `group` (`idGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`idNotification`, `text`, `idUser`, `idGroup`, `type`, `isRead`) VALUES
(1, 'Join group Porodica', 1, 1, 0, 1),
(2, 'New member group Porodica', 1, 1, 2, 0),
(3, 'List status Porodica List1', 1, 1, 3, 0);




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;