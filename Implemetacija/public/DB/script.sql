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
INSERT INTO `user` (`idUser`, `username`, `password`, `fullName`, `email`, `image`, `phone`, `type`) VALUES
(3, 'admin', 'admin123', 'Bodin Bizetic', 'admin@etf.bg.ac.rs', NULL, NULL , 1),
(2, 'drazen', 'drazen123',  'Drazen Draskovic', 'drazen@etf.bg.ac.rs', NULL, NULL, 0);


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

INSERT INTO `group` (`idGroup`, `name`, `description`, `image`) VALUES
(1, 'Porodica', 'Group for family', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `notification`
--
-- type (JOIN_GROUP, NEW_MEMBERS, REMOVE_FROM_GROUP, LIST_STATUS)
-- DROP TABLE IF EXISTS `notification`;

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


DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
                            `idCategory` int NOT NULL AUTO_INCREMENT,
                            `name` varchar(45) NOT NULL,
                            PRIMARY KEY (`idCategory`),
                            UNIQUE KEY `idCategory_UNIQUE` (`idCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `ingroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingroup` (
                           `type` int NOT NULL DEFAULT '0',
                           `idInGroup` int NOT NULL,
                           `idGroup` int NOT NULL,
                           `idUser` int NOT NULL,
                           PRIMARY KEY (`idInGroup`)
                           CONSTRAINT `FK_InGroup_Group` FOREIGN KEY (`idGroup`) REFERENCES `group` (`idGroup`),
                           CONSTRAINT `FK_InGroup_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item` (
                        `idItem` int NOT NULL AUTO_INCREMENT,
                        `name` varchar(45) NOT NULL,
                        `quantity` varchar(45) NOT NULL,
                        `metrics` varchar(45) NOT NULL,
                        PRIMARY KEY (`idItem`),
                        UNIQUE KEY `idItems_UNIQUE` (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `itemcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemcategory` (
                                `idCategory` int NOT NULL,
                                `idItem` int NOT NULL,
                                PRIMARY KEY (`idCategory`,`idItem`),
                                KEY `FK_ItemCategory_Item_idx` (`idItem`),
                                KEY `FK_ItemCategory_Category_idx` (`idCategory`),
                                CONSTRAINT `FK_ItemCategory_Category` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`),
                                CONSTRAINT `FK_ItemCategory_Item` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `shopchain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopchain` (
                             `idShopChain` int NOT NULL AUTO_INCREMENT,
                             `name` varchar(45) NOT NULL,
                             PRIMARY KEY (`idShopChain`),
                             UNIQUE KEY `idShopChain_UNIQUE` (`idShopChain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `shoppinglist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppinglist` (
                                `idShoppingList` int NOT NULL AUTO_INCREMENT,
                                `idGroup` int NOT NULL,
                                `name` varchar(45) NOT NULL,
                                `idShop` int DEFAULT NULL,
                                `active` tinyint NOT NULL,
                                PRIMARY KEY (`idShoppingList`),
                                UNIQUE KEY `idShoppingList_UNIQUE` (`idShoppingList`),
                                KEY `FK_ShoppingList_Group_idx` (`idGroup`),
                                KEY `FK_ShoppingList_ShopChain_idx` (`idShop`),
                                CONSTRAINT `FK_ShoppingList_Group` FOREIGN KEY (`idGroup`) REFERENCES `group` (`idGroup`),
                                CONSTRAINT `FK_ShoppingList_ShopChain` FOREIGN KEY (`idShop`) REFERENCES `shopchain` (`idShopChain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `listcontains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listcontains` (
                                `idShoppingList` int NOT NULL,
                                `idItem` int NOT NULL,
                                `bought` int NOT NULL DEFAULT '0',
                                PRIMARY KEY (`idShoppingList`,`idItem`),
                                KEY `FK_ListContains_ShoppingList_idx` (`idShoppingList`),
                                KEY `FK_ListContains_Item_idx` (`idItem`),
                                CONSTRAINT `FK_ListContains_Item` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`),
                                CONSTRAINT `FK_ListContains_ShoppingList` FOREIGN KEY (`idShoppingList`) REFERENCES `shoppinglist` (`idShoppingList`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



DROP TABLE IF EXISTS `itemprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemprice` (
                             `idItem` int NOT NULL,
                             `idShopChain` int NOT NULL,
                             `price` int DEFAULT NULL,
                             PRIMARY KEY (`idItem`,`idShopChain`),
                             KEY `FK_ItemPrice_Item_idx` (`idItem`),
                             KEY `FK_ShopChain_idx` (`idShopChain`),
                             CONSTRAINT `FK_ItemPrice_Item` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`),
                             CONSTRAINT `FK_ShopChain` FOREIGN KEY (`idShopChain`) REFERENCES `shopchain` (`idShopChain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;