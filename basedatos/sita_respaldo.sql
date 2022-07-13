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
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacto` (
  `cve_contacto` int(11) NOT NULL AUTO_INCREMENT,
  `correo_ins` varchar(100) NOT NULL,
  `correo_per` varchar(100) NOT NULL,
  `telefono` int(10) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_contacto`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docente` (
  `cve_docente` int(11) NOT NULL AUTO_INCREMENT,
  `puesto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `institucion` varchar(100) NOT NULL,
  `tipo_contratacion` varchar(50) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `num_empleado` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_cve` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_docente`),
  KEY `puesto` (`puesto`),
  KEY `user_cve` (`user_cve`),
  CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`puesto`) REFERENCES `puesto` (`cve_puesto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `docente_ibfk_2` FOREIGN KEY (`user_cve`) REFERENCES `usuario` (`cve_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domicilio`
--

DROP TABLE IF EXISTS `domicilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domicilio` (
  `cve_domicilio` int(11) NOT NULL AUTO_INCREMENT,
  `calle` varchar(50) NOT NULL,
  `num_ext` varchar(5) NOT NULL,
  `num_int` varchar(5) NOT NULL,
  `codigo_postal` int(5) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `doc_dom` varchar(255) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_domicilio`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `domicilio_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domicilio`
--

LOCK TABLES `domicilio` WRITE;
/*!40000 ALTER TABLE `domicilio` DISABLE KEYS */;
/*!40000 ALTER TABLE `domicilio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencia`
--

DROP TABLE IF EXISTS `experiencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencia` (
  `cve_experiencia` int(11) NOT NULL AUTO_INCREMENT,
  `actividad` varchar(50) NOT NULL,
  `institucion` varchar(100) NOT NULL,
  `periodo` varchar(10) NOT NULL,
  `intereses` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_cve` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_experiencia`),
  KEY `cve_docente` (`cve_docente`),
  KEY `user_cve` (`user_cve`),
  CONSTRAINT `experiencia_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `experiencia_ibfk_2` FOREIGN KEY (`user_cve`) REFERENCES `usuario` (`cve_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencia`
--

LOCK TABLES `experiencia` WRITE;
/*!40000 ALTER TABLE `experiencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formacion`
--

DROP TABLE IF EXISTS `formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formacion` (
  `cve_formacion` int(11) NOT NULL AUTO_INCREMENT,
  `nivel_estudio` varchar(50) NOT NULL,
  `siglas_estudio` varchar(20) NOT NULL,
  `institucion` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `disciplina` varchar(100) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_titulacion` date NOT NULL,
  `habilidades` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_cve` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_formacion`),
  KEY `cve_docente` (`cve_docente`),
  KEY `user_cve` (`user_cve`),
  CONSTRAINT `formacion_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `formacion_ibfk_2` FOREIGN KEY (`user_cve`) REFERENCES `usuario` (`cve_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formacion`
--

LOCK TABLES `formacion` WRITE;
/*!40000 ALTER TABLE `formacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informacion`
--

DROP TABLE IF EXISTS `informacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informacion` (
  `cve_info` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_nac` date NOT NULL,
  `doc_nac` varchar(255) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `doc_curp` varchar(255) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `doc_rfc` varchar(255) NOT NULL,
  `nss` int(11) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_info`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `informacion_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informacion`
--

LOCK TABLES `informacion` WRITE;
/*!40000 ALTER TABLE `informacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `informacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `premios`
--

DROP TABLE IF EXISTS `premios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premios` (
  `cve_premio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `institucion` varchar(100) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `cve_docente` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_cve` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_premio`),
  KEY `cve_docente` (`cve_docente`),
  KEY `user_cve` (`user_cve`),
  CONSTRAINT `premios_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `premios_ibfk_2` FOREIGN KEY (`user_cve`) REFERENCES `usuario` (`cve_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `cve_publicacion` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `titulo_articulo` varchar(100) NOT NULL,
  `titulo_revista` varchar(100) NOT NULL,
  `pagina_inicio` int(11) NOT NULL,
  `pagina_fin` int(11) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `editorial` varchar(50) NOT NULL,
  `volumen` varchar(50) NOT NULL,
  `issp` varchar(50) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `proposito` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cve_docente` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_cve` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_publicacion`),
  KEY `cve_docente` (`cve_docente`),
  KEY `user_cve` (`user_cve`),
  CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`user_cve`) REFERENCES `usuario` (`cve_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
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
-- Table structure for table `puesto`
--

DROP TABLE IF EXISTS `puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puesto` (
  `cve_puesto` int(11) NOT NULL AUTO_INCREMENT,
  `puesto` varchar(20) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_puesto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puesto`
--

LOCK TABLES `puesto` WRITE;
/*!40000 ALTER TABLE `puesto` DISABLE KEYS */;
INSERT INTO `puesto` VALUES (1,'Profesor',1),(2,'Administrativo',1),(3,'Cordinador',1);
/*!40000 ALTER TABLE `puesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `cve_tipo_usu` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_tipo_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Administrador',1),(2,'Editor',1),(3,'Consultor',1),(4,'Docente',1);
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
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cve_usuario`),
  KEY `cve_tipo_usu` (`tipo`),
  KEY `tipo` (`tipo`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo_usuario` (`cve_tipo_usu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'Administrador','admi01','admi02','Admin','0192023a7bbd73250516f069df18b500','admin.png','master@correo.com',1),(2,2,'Editor','Edit01','Edit02','Editor','202cb962ac59075b964b07152d234b70','default.png','editor@correo.com',1),(3,3,'Consultor','Cons01','Cons02','Consultor','202cb962ac59075b964b07152d234b70','default.png','consultor@correo.com',1),(4,4,'Docente01','01Doc1','01Doc2','Docente01','202cb962ac59075b964b07152d234b70','default.png','docente01@correo.com',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viaje`
--

DROP TABLE IF EXISTS `viaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viaje` (
  `cve_viaje` int(11) NOT NULL AUTO_INCREMENT,
  `disp_viaje` varchar(20) NOT NULL,
  `num_pasaporte` varchar(11) NOT NULL,
  `fecha_ven_pas` date NOT NULL,
  `cve_docente` int(11) NOT NULL,
  PRIMARY KEY (`cve_viaje`),
  KEY `cve_docente` (`cve_docente`),
  CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`cve_docente`) REFERENCES `docente` (`cve_docente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viaje`
--

LOCK TABLES `viaje` WRITE;
/*!40000 ALTER TABLE `viaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `viaje` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-13 11:16:17
