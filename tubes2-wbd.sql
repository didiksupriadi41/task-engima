-- MySQL dump 10.13  Distrib 8.0.18, for Linux (x86_64)
--
-- Host: localhost    Database: tubes2-wbd
-- ------------------------------------------------------
-- Server version	8.0.18-0ubuntu0.19.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Cookie`
--

DROP TABLE IF EXISTS `Cookie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cookie` (
  `idCookie` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  `expiredDate` datetime NOT NULL,
  PRIMARY KEY (`idCookie`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `Cookie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cookie`
--

LOCK TABLES `Cookie` WRITE;
/*!40000 ALTER TABLE `Cookie` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cookie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Review`
--

DROP TABLE IF EXISTS `Review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Review` (
  `idReview` int(11) NOT NULL AUTO_INCREMENT,
  `idMovie` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `value` int(11) DEFAULT '-1',
  `text` varchar(225) NOT NULL,
  PRIMARY KEY (`idReview`),
  KEY `idMovie` (`idMovie`),
  KEY `idUser` (`idBook`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Review`
--

LOCK TABLES `Review` WRITE;
/*!40000 ALTER TABLE `Review` DISABLE KEYS */;
/*!40000 ALTER TABLE `Review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Schedule`
--

DROP TABLE IF EXISTS `Schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Schedule` (
  `idSchedule` int(11) NOT NULL AUTO_INCREMENT,
  `idMovie` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `seatsLeft` int(2) NOT NULL DEFAULT '30',
  PRIMARY KEY (`idSchedule`),
  KEY `idMovie` (`idMovie`),
  KEY `dateTime` (`dateTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Schedule`
--

LOCK TABLES `Schedule` WRITE;
/*!40000 ALTER TABLE `Schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `Schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'abc','a@a.com','1234567890','a','img/avatar.jpg');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-21 18:11:56
