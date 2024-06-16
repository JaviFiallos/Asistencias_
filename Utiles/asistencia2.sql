-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: asistencia
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `dias`
--

DROP TABLE IF EXISTS `dias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dias` (
  `ID_DIA` int NOT NULL AUTO_INCREMENT,
  `ID_EMP_PER` int NOT NULL,
  `FECHA` date DEFAULT NULL,
  `TOTAL_DESC_POR_DIA` decimal(10,2) DEFAULT '0.00',
  `TOTAL_HORAS_POR_DIA` decimal(10,2) DEFAULT '0.00',
  `SALDO_TOTAL_DIARIO` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`ID_DIA`),
  KEY `FK_EMP_DIA_idx` (`ID_EMP_PER`),
  CONSTRAINT `FK_EMP_DIA` FOREIGN KEY (`ID_EMP_PER`) REFERENCES `empleados` (`ID_EMP`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias`
--

LOCK TABLES `dias` WRITE;
/*!40000 ALTER TABLE `dias` DISABLE KEYS */;
INSERT INTO `dias` VALUES (1,1,'2024-06-17',0.00,0.00,0.00),(2,1,'2024-06-18',0.00,0.00,0.00),(3,1,'2024-06-19',0.00,0.00,0.00),(4,1,'2024-06-20',0.00,0.00,0.00),(5,1,'2024-06-21',0.00,0.00,0.00);
/*!40000 ALTER TABLE `dias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `ID_EMP` int NOT NULL AUTO_INCREMENT,
  `NOM_EMP` varchar(25) DEFAULT NULL,
  `APE_APE` varchar(25) DEFAULT NULL,
  `CED_EMP` varchar(20) NOT NULL,
  `PASS_EMP` varchar(45) NOT NULL,
  `EST_EMP` tinyint DEFAULT '0',
  `ROL_EMP` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_EMP`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (1,'JOEL','DURAN','1801','1801',1,'ADMIN'),(2,'ANGELA','ARMIJOS','1802','1802',0,'DOCENTE');
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `ID_HOR` int NOT NULL AUTO_INCREMENT,
  `ENTRADA` time DEFAULT NULL,
  `SALIDA` time DEFAULT NULL,
  `JORNADA` varchar(45) DEFAULT NULL,
  `ID_EMP_PER` int NOT NULL,
  PRIMARY KEY (`ID_HOR`),
  KEY `FK_EMP_HOR_idx` (`ID_EMP_PER`),
  CONSTRAINT `FK_EMP_HOR` FOREIGN KEY (`ID_EMP_PER`) REFERENCES `empleados` (`ID_EMP`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios`
--

LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
INSERT INTO `horarios` VALUES (1,'08:00:00','13:00:00','MATUTINA',1),(2,'17:00:00','20:00:00','VISPERTINO',1),(3,'11:00:00','13:00:00','MATUTINA',2),(4,'14:00:00','20:00:00','VISPERTINA',2);
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_asistencia`
--

DROP TABLE IF EXISTS `registro_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_asistencia` (
  `ID_REG` int NOT NULL AUTO_INCREMENT,
  `JORNADA` varchar(20) DEFAULT NULL,
  `HORA_INGRESO` time DEFAULT NULL,
  `HORA_SALIDA` time DEFAULT NULL,
  `DESCUENTO` decimal(10,2) DEFAULT '0.00',
  `ID_DIA_PER` int NOT NULL,
  PRIMARY KEY (`ID_REG`),
  KEY `FK_DIA_REG_idx` (`ID_DIA_PER`),
  CONSTRAINT `FK_DIA_REG` FOREIGN KEY (`ID_DIA_PER`) REFERENCES `dias` (`ID_DIA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_asistencia`
--

LOCK TABLES `registro_asistencia` WRITE;
/*!40000 ALTER TABLE `registro_asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_asistencia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-16 16:35:00
