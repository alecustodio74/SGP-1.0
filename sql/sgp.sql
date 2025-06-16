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
-- Table structure for table `atividades`
--

DROP TABLE IF EXISTS `atividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projeto_id` int NOT NULL,
  `tarefa_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `data_tarefa` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_atividades_projetos` (`projeto_id`),
  KEY `fk_atividades_tarefas` (`tarefa_id`),
  KEY `fk_atividades_usuarios` (`usuario_id`),
  CONSTRAINT `fk_atividades_projetos` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_atividades_tarefas` FOREIGN KEY (`tarefa_id`) REFERENCES `tarefas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_atividades_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividades`
--

LOCK TABLES `atividades` WRITE;
/*!40000 ALTER TABLE `atividades` DISABLE KEYS */;
INSERT INTO `atividades` VALUES (1,3,1,46,'Em andamento',NULL,NULL,NULL,NULL),(2,1,1,46,'Em andamento',5,'2025-05-02',NULL,NULL),(3,2,4,51,'Desconhecido',4,'2025-06-02',NULL,'2025-06-10'),(5,2,4,49,'Concluído',3,'2025-06-02','2025-06-11','2025-06-06'),(6,3,4,8,'Em andamento',1,'2025-06-11',NULL,NULL),(7,5,5,6,'Em andamento',4,'2025-06-12',NULL,'2025-06-12');
/*!40000 ALTER TABLE `atividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Web Developer Front-End','Cria interfaces UX, UI, integra com Back-End e controla versões.'),(2,'Web Developer Back-End','Comunicação entre o site e o servidor, bancos de dados e outras tecnologias'),(3,'Web Developer Full-Stack','Atua desde a criação do front-end até o desenvolvimento do back-end.'),(4,'Desktop Software Developer','Cria e mantém softwares, como edição de texto, programas de automação e muito mais.'),(5,'Data Scientist (Big data developer)','Especialista em modelagem preditiva e aprendizado de máquina. '),(6,'Artificial Intelligence/Machine Learning Developer','Desenvolve softwares que aprendem e melhoram com base na experiência memorizada.'),(7,'Game Developer',''),(9,'Estagiário 1','Auxilia no Front End'),(10,'Estagiário geral','Auxilia todos os setores da empresa');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Westcont Assessoria Contábil','westcont@hotmail.com.br'),(3,'Unoeste','unoeste@unoeste.com'),(4,'Fatec PP','fatec@fatec.com'),(5,'Pizzaria Va Bene','vabene@vabene.com'),(6,'Cliente Fantasma','fantasma@mysterymachine.com');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projetos`
--

DROP TABLE IF EXISTS `projetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projetos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cliente_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_projeto` (`cliente_id`),
  CONSTRAINT `fk_cliente_projeto` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projetos`
--

LOCK TABLES `projetos` WRITE;
/*!40000 ALTER TABLE `projetos` DISABLE KEYS */;
INSERT INTO `projetos` VALUES (1,'Sistema Web Corporativo',NULL),(2,'Aplicativo Mobile',NULL),(3,'Site Institucional',NULL),(5,'Projetos Internos - Pesquisa e Desenvolvimento',NULL),(6,'Software sob Demanda (Educacional)',NULL),(10,'Testes (obsoleto)',NULL);
/*!40000 ALTER TABLE `projetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarefas`
--

DROP TABLE IF EXISTS `tarefas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarefas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_tarefa` (`cliente_id`),
  CONSTRAINT `fk_cliente_tarefa` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarefas`
--

LOCK TABLES `tarefas` WRITE;
/*!40000 ALTER TABLE `tarefas` DISABLE KEYS */;
INSERT INTO `tarefas` VALUES (1,'Escrever HTML','Desenvolver todos os textos e campos HTML','2025-06-01','2025-06-02',NULL),(4,'CSS','Estilizando o HTML com CSS','2025-05-01',NULL,NULL),(5,'Criar Banco de Dados','Escrever scripts SQL para criar tabelas...',NULL,NULL,NULL),(6,'Tarefa intrusa','...',NULL,NULL,NULL);
/*!40000 ALTER TABLE `tarefas` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2025-06-15 14:49:08
