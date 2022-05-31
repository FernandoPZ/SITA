-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sita
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docente` (
  `cve_docente` int(11) NOT NULL AUTO_INCREMENT,
  `cve_tipou` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_uno` varchar(50) NOT NULL,
  `apellido_dos` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `num_empleado` int(15) NOT NULL,
  `institucion_actual` varchar(50) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_docente`),
  KEY `cve_tipou` (`cve_tipou`),
  CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`cve_tipou`) REFERENCES `tipo_usuario` (`cve_tipou`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencias`
--

DROP TABLE IF EXISTS `experiencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencias` (
  `cve_exp` int(11) NOT NULL AUTO_INCREMENT,
  `act_puesto` varchar(50) NOT NULL,
  `institucion` varchar(50) NOT NULL,
  `periodo` varchar(9) NOT NULL,
  `intereses` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_exp`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `experiencias_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencias`
--

LOCK TABLES `experiencias` WRITE;
/*!40000 ALTER TABLE `experiencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formacion`
--

DROP TABLE IF EXISTS `formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formacion` (
  `cve_for` int(11) NOT NULL AUTO_INCREMENT,
  `asignaturas` text NOT NULL,
  `periodo_estudio` varchar(9) NOT NULL,
  `hras_teoricas` decimal(10,0) NOT NULL,
  `hras_practicas` decimal(10,0) NOT NULL,
  `periodo_impartido` varchar(9) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_for`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `formacion_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formacion`
--

LOCK TABLES `formacion` WRITE;
/*!40000 ALTER TABLE `formacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generales`
--

DROP TABLE IF EXISTS `generales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generales` (
  `cve_gen` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `iste` varchar(20) NOT NULL,
  `num_infonavit` varchar(20) NOT NULL,
  `disponibilidad` varchar(20) NOT NULL,
  `fecha_vig_pas` date NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_gen`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `generales_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generales`
--

LOCK TABLES `generales` WRITE;
/*!40000 ALTER TABLE `generales` DISABLE KEYS */;
/*!40000 ALTER TABLE `generales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logros`
--

DROP TABLE IF EXISTS `logros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logros` (
  `cve_logros` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `inst_otor` varchar(50) NOT NULL,
  `otra_inst` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_logros`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `logros_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logros`
--

LOCK TABLES `logros` WRITE;
/*!40000 ALTER TABLE `logros` DISABLE KEYS */;
/*!40000 ALTER TABLE `logros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personales`
--

DROP TABLE IF EXISTS `personales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personales` (
  `cve_per` int(11) NOT NULL AUTO_INCREMENT,
  `cve_tipoc` int(11) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `num_ext` varchar(5) NOT NULL,
  `num_int` varchar(5) NOT NULL,
  `edificio` varchar(10) NOT NULL,
  `colonia` varchar(80) NOT NULL,
  `codigo_postal` int(5) NOT NULL,
  `tipo_linea` varchar(20) NOT NULL,
  `telefono` int(10) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_per`),
  KEY `cve_tipoc` (`cve_tipoc`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `personales_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personales_ibfk_2` FOREIGN KEY (`cve_tipoc`) REFERENCES `tipo_calle` (`cve_tipoc`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personales`
--

LOCK TABLES `personales` WRITE;
/*!40000 ALTER TABLE `personales` DISABLE KEYS */;
/*!40000 ALTER TABLE `personales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `premios`
--

DROP TABLE IF EXISTS `premios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premios` (
  `cve_premios` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `inst_otor` varchar(50) NOT NULL,
  `otra_inst` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_premios`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `premios_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `premios`
--

LOCK TABLES `premios` WRITE;
/*!40000 ALTER TABLE `premios` DISABLE KEYS */;
/*!40000 ALTER TABLE `premios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicaciones`
--

DROP TABLE IF EXISTS `publicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicaciones` (
  `cve_pub` int(11) NOT NULL AUTO_INCREMENT,
  `cve_tipopub` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `tiempo_edicion` varchar(50) NOT NULL,
  `nivel_destino` varchar(50) NOT NULL,
  `anio_publicacion` date NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_pub`),
  KEY `cve_docente` (`cve_docente`),
  KEY `cve_tipopub` (`cve_tipopub`),
  CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`cve_tipopub`) REFERENCES `tipo_publicacion` (`cve_tipopub`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicaciones`
--

LOCK TABLES `publicaciones` WRITE;
/*!40000 ALTER TABLE `publicaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_calle`
--

DROP TABLE IF EXISTS `tipo_calle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_calle` (
  `cve_tipoc` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`cve_tipoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_calle`
--

LOCK TABLES `tipo_calle` WRITE;
/*!40000 ALTER TABLE `tipo_calle` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_calle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_publicacion`
--

DROP TABLE IF EXISTS `tipo_publicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_publicacion` (
  `cve_tipopub` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`cve_tipopub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_publicacion`
--

LOCK TABLES `tipo_publicacion` WRITE;
/*!40000 ALTER TABLE `tipo_publicacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_publicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `cve_tipou` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_tipou`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Administrador',1),(2,'Editor',1),(3,'Consultor',1),(4,'Visitante',1);
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `cve_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_usuario`),
  KEY `tipo` (`tipo`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo_usuario` (`cve_tipou`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'Admin','0192023a7bbd73250516f069df18b500',1),(2,1,'Fernando','de7e073d4d913c75d57491e447d1d850',1),(3,2,'Tester1','202cb962ac59075b964b07152d234b70',1),(4,3,'Tester2','202cb962ac59075b964b07152d234b70',1),(5,4,'Tester3','202cb962ac59075b964b07152d234b70',1),(6,4,'Tester4','202cb962ac59075b964b07152d234b70',1),(7,4,'Tester5','202cb962ac59075b964b07152d234b70',1),(8,4,'Tester6','202cb962ac59075b964b07152d234b70',1),(9,3,'Tester7','202cb962ac59075b964b07152d234b70',1),(10,2,'Tester8','202cb962ac59075b964b07152d234b70',1),(11,4,'Tester9','202cb962ac59075b964b07152d234b70',1),(12,4,'Tester10','202cb962ac59075b964b07152d234b70',1),(13,4,'TesterLastus','123',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-31 13:03:59
