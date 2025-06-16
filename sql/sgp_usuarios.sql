CREATE DATABASE  IF NOT EXISTS `sgp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sgp`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: sgp
-- ------------------------------------------------------
-- Server version	9.2.0

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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cargo_id` int DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'Lorenzo DC','lorenzomdc2006@hotmail.com','$2y$10$DsfD.9wmhK2z54dfZXhqAu.JWAx5J76jJLF1wz6PWDJMMP6527hn6',1,NULL,NULL,3700.00),(5,'Isabela','isabelamdc@hotmail.com','$2y$10$lsqVKWoKJ6oDAuWP6UvZo.YQFIVXpD1YKqqXvPkog4sSugXyVNJwG',1,NULL,NULL,1850.00),(6,'Eliete Soares','elietesoaresly@gmail.com','$2y$10$5mr6aj0R/D7289z45AglHubb3uVD5C9aDJUMye3gKrtlsZ7zgAQuC',1,NULL,NULL,6000.00),(8,'Raphael','rapha@rapha.com','$2y$10$AlZ6iY2teSjbz7qzCaqimeNK1SIjLR91z.CxXhQbTO4BpD2zG3PU.',1,NULL,NULL,4500.00),(17,'Vivi','vivi@vivi.com','$2y$10$SNlR8uXvbW9UigE.71QyU.fzyAD4M87T.iHws9nZsfYTZHjOUoJtO',1,NULL,NULL,1850.00),(46,'Alexandre','arcs1234@hotmail.com','$2y$10$wNAR73XjxGW7pU/p19VDN.oQD3cjNetO1AdwGvN5iO2qa8Zzb6sk6',5,NULL,NULL,10000.00),(47,'Peter Parker','peter@parker.com','$2y$10$4YeHV.vtDUYlqrBHJb81yu0y/RvINGx7HkThSjclehCyCZ8b1/7b.',6,NULL,NULL,1680.00),(49,'Paul McCartney','paul@paul.com','$2y$10$hlA0.5beA.StcDxCRBmloOXtKjzsWalcE1TbpnaNAeiwf5Yh2ZiNu',1,NULL,NULL,2250.00),(50,'John Lennon','john@john.com','$2y$10$5AxjSKGmFyJrhmq5sy66RedG/dF.MEW27jK5KrhEf7/NVmT3/GL0K',5,NULL,NULL,2700.00),(51,'Ringo Starr','ringo@ringo.com','$2y$10$S3Q8A9WXCQAvsAQUdxpaG./WD.SLSkLQYmiyMgPN85afiKTGs9Zq2',3,NULL,NULL,1670.00),(52,'George Harrison','george@george.com','$2y$10$sShQp8wLn4FjoWr42SBLo.E/4SG6sSKU9u9SA/pjGkq7NIdXHh4tO',6,NULL,NULL,2780.00),(53,'Luke','luke@luke.com','$2y$10$oXo4bS1jbPMukCyRLtGkS.bPLhs9a3sGDHrJHXehb9yz8fIO8UP.2',3,NULL,NULL,2250.00),(54,'Darth Vader','vader@vader.com','$2y$10$uyT9PjLd4M5DRVthTMFYMeGs7RWz/BAaQtz8XBX9.JJmm1yVg2dky',2,NULL,NULL,15000.00);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-15 14:46:16
