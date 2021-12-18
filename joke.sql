-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ijdb
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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `authorname` varchar(255) NOT NULL,
  `authoremail` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'Kelvin Yank','thatguy@kevinyank.com',NULL),(2,'Tom Kate','tom@gmail.com',NULL),(8,'Abimbola Felix','abimbola.felix@gmail.com','$2y$10$/6hBdXt/HI0PjLoyjAZEkuxv2v/qqTUROC.mFYvQ67n/0slKXvXIO');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jokes`
--

DROP TABLE IF EXISTS `jokes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jokes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `joketext` varchar(500) NOT NULL,
  `jokedate` datetime NOT NULL,
  `authorid` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jokes`
--

LOCK TABLES `jokes` WRITE;
/*!40000 ALTER TABLE `jokes` DISABLE KEYS */;
INSERT INTO `jokes` VALUES (4,'A programmer\'s wife tells him to go to the store to and get \"get a gallon of milk, and if they have eggs, get a dozen.\"He returns with 13 gallons of milk...','2021-11-14 00:00:00',1),(6,'Why did the programmer quit his job? He didn\'t get an arrays..','2021-10-07 00:00:00',1),(7,'Why was the empty array stuck outside? it didn\'t have any keys..','2021-10-07 00:00:00',2),(8,'Everything is working perfect, so glad my jokes are great..','2021-10-07 00:00:00',2),(9,'This shouldn\'t be funny, but somehow it is..','2021-10-07 07:30:44',2),(10,'!false - it\'s funny because it\'s true.','2021-10-07 08:35:56',2),(11,'How many programmers does it take to screw in a light-bulb? None, it\'s a hardware problem.','2021-11-09 00:00:00',1),(14,'This is the reason PHP remains the king of the web.','2021-10-08 04:29:26',2),(18,'It\'s interesting to know that we are in the best par of human existence, but humans remain a threat to nature.','0000-00-00 00:00:00',2),(20,'A man threw some cheese milk at me. How dairy!','2021-11-07 00:00:00',1),(21,'A man threw some cheese milk at me. How dairy!','2021-11-07 00:00:00',1),(37,'hello world\r\n','2021-11-18 00:00:00',8);
/*!40000 ALTER TABLE `jokes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03 10:49:51
