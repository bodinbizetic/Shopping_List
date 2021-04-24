CREATE DATABASE  IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mydb`;
-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

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

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group` (
  `idGroup` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `image` blob,
  PRIMARY KEY (`idGroup`),
  UNIQUE KEY `idGroup_UNIQUE` (`idGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingroup`
--

DROP TABLE IF EXISTS `ingroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingroup` (
  `type` int NOT NULL DEFAULT '0',
  `idGroup` int NOT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`idGroup`,`idUser`),
  KEY `FK_InGroup_Group_idx` (`idGroup`),
  KEY `FK_InGroup_User_idx` (`idUser`),
  CONSTRAINT `FK_InGroup_Group` FOREIGN KEY (`idGroup`) REFERENCES `group` (`idGroup`),
  CONSTRAINT `FK_InGroup_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingroup`
--

LOCK TABLES `ingroup` WRITE;
/*!40000 ALTER TABLE `ingroup` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

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

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemcategory`
--

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

--
-- Dumping data for table `itemcategory`
--

LOCK TABLES `itemcategory` WRITE;
/*!40000 ALTER TABLE `itemcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemprice`
--

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

--
-- Dumping data for table `itemprice`
--

LOCK TABLES `itemprice` WRITE;
/*!40000 ALTER TABLE `itemprice` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemprice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listcontains`
--

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

--
-- Dumping data for table `listcontains`
--

LOCK TABLES `listcontains` WRITE;
/*!40000 ALTER TABLE `listcontains` DISABLE KEYS */;
/*!40000 ALTER TABLE `listcontains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification` (
  `idNotification` int NOT NULL AUTO_INCREMENT,
  `Text` varchar(150) DEFAULT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`idNotification`),
  UNIQUE KEY `idNotification_UNIQUE` (`idNotification`),
  KEY `FK_Notification_User_idx` (`idUser`),
  CONSTRAINT `FK_Notification_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopchain`
--

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

--
-- Dumping data for table `shopchain`
--

LOCK TABLES `shopchain` WRITE;
/*!40000 ALTER TABLE `shopchain` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopchain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppinglist`
--

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

--
-- Dumping data for table `shoppinglist`
--

LOCK TABLES `shoppinglist` WRITE;
/*!40000 ALTER TABLE `shoppinglist` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppinglist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `fullName` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `type` int NOT NULL DEFAULT '0',
  `image` blob,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `idUser_UNIQUE` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-23 15:12:27
