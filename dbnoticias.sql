-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dbnoticias
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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (18,'Android'),(14,'automação'),(19,'back-end'),(9,'Cinema'),(13,'Cybersecurity'),(17,'Esporte'),(20,'front-end'),(8,'Mobile'),(7,'Programação'),(6,'Tecnologia'),(1,'Teste'),(10,'teste update2'),(2,'teste update7'),(4,'teste3'),(5,'Teste4'),(11,'web');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `conteudo` text NOT NULL,
  `data_publicacao` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (3,10,'testando update12','Esse e o conteudo da terceira noticia para testar o update9\r\n\r\nestando a barra invertida\r\nlocal \\\\servidor\\teste\\barra\\invertida','2022-07-06'),(4,2,'Quarta noticia de teste','Esse é o conteudo da quarta noticia para teste','2022-07-06'),(5,11,'WEB 3.0','conteudo noticia web 3.0 bla bla bla bla bla bla','2022-07-09'),(6,11,'WEB 2.0','conteudo noticia web 2.0 bla bla bla bla bla bla','2022-07-09'),(7,11,'HTML5','conteudo noticia web 2.0 de HTML5 bla bla bla bla bla bla','2022-07-09'),(8,11,'HTML5 e CSS3','conteudo noticia web 2.0 de HTML5 e CSS3 bla bla bla bla bla bla','2022-07-09'),(9,11,'HTML5 e CSS3, JS','conteudo noticia web 2.0 de HTML5 e CSS3, JS bla bla bla bla bla bla','2022-07-09'),(10,11,'HTML5 e CSS3, JS, T','conteudos noticia web 2.0 de HTML5 e CSS3, JS bla bla bla bla bla bla','2022-07-09'),(11,11,'Flutter para web','conteudos noticia web 2.0, FLUTTER  bla bla bla bla bla bla','2022-07-09'),(13,8,'Flutter para android',' FLUTTER e android  bla bla bla bla bla.','2022-07-09'),(14,8,'Kotlin ou Flutter','Esse é o conteúdo da notícia Kotlin ou Flutter, nativo ou uma tecnologia Cross plataforma? ','2022-07-10'),(15,13,'Phishing, novo golpe que vai roubar seus dados','O novo golpe que está em alta e roubando dados de diversas pessoas ao redor do mundo, Phishing.','2022-07-10'),(16,8,'Utilização de sensores na plataforma Android','Um sensor é um dispositivo que responde a um estímulo físico. Alguns exemplos são sensores de: luz, som, temperatura, biometria, pressão e proximidade. Sua presença é muito comum nos celulares atuais.\r\n\r\nTodas as classes necessárias para interação com os sensores presentes em um dispositivo Android podem ser encontradas no pacote android.hardware.*. Esse pacote também contém classes para gerenciamento do uso da câmera, como as classes Camera, Camera.Size, Camera.Parameters e Camera.CameraInfo, além das interfaces Camera.AutoFocusCallback, Camera.ErrorCallback, Camera.OnZoomChangeListener, Camera.PictureCallback, Camera.PreviewCallback e Camera.ShutterCallback.\r\n\r\nPrimeiro passo: Sensor Manager\r\nO primeiro passo em seu projeto é instanciar a primeira classe apresentada, a SensorManager. A grande maioria dos aplicativos Android será formada por algumas Activities, que podem ser imaginadas como telas do software. Por exemplo, uma tela de login, uma tela de cadastro ou uma tela onde o usuário visualiza os dados recuperados de um sensor de presença, de proximidade, de temperatura e assim por diante.','2022-07-20'),(17,18,'sensores no Android','O uso de sensores em aplicativos móveis é cada vez mais comum. Eles tornam possível o monitoramento de uma série de variáveis, como movimentação, velocidade, posicionamento, entre outras. Este artigo apresenta como podemos trabalhar com sensores na plataforma Android, abordando de forma prática o uso de uma tecnologia com tendência crescente de uso.\r\n\r\nExistem basicamente três classes de vital importância para nós programadores:\r\nSensorManager (android.hardware.SensorManager): permite que acessemos os sensores dos dispositivos;\r\nSensor (android.hardware.Sensor): representa um dos sensores propriamente dito;\r\nSensorEvent (android.hardware.SensorEvent): encapsula as informações de um evento ocasionado por um sensor. Por exemplo, no sensor de luz, quando a leitura indica uma alteração na luminosidade do ambiente, o sensor acusará um evento. Cabe então ao programa trabalhar com os novos valores.','2022-07-20');
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfis`
--

DROP TABLE IF EXISTS `perfis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfis`
--

LOCK TABLES `perfis` WRITE;
/*!40000 ALTER TABLE `perfis` DISABLE KEYS */;
INSERT INTO `perfis` VALUES (1,'adm'),(2,'usuário');
/*!40000 ALTER TABLE `perfis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perfil` (`id_perfil`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,'nome qualquer','teste@teste.com.br','123456','123456'),(2,1,'nome qualquer','teste@teste2.com.br','7c4a8d09ca3762af61e59520943dc26494f8941b',''),(3,1,'nome qualquer','teste@teste3.com.br','7c4a8d09ca3762af61e59520943dc26494f8941b',''),(4,1,'nome qualquer','teste@teste4.com.br','7c4a8d09ca3762af61e59520943dc26494f8941b',''),(5,1,'nome qualquer','teste@teste5.com.br','7c4a8d09ca3762af61e59520943dc26494f8941b','cbac4c021e410ac16a3ba7e39ec6f506e7c03177'),(6,2,'nome qualquer para user','teste@teste6.com.br','7c4a8d09ca3762af61e59520943dc26494f8941b','');
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

-- Dump completed on 2022-07-30 18:13:20
