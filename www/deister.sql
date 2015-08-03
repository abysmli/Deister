-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: deister
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `log_nr` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actor_id` int(10) unsigned NOT NULL,
  `action` text,
  `ip` bigint(20) unsigned DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_nr`),
  KEY `FK_user_id` (`actor_id`),
  CONSTRAINT `FK_user_id` FOREIGN KEY (`actor_id`) REFERENCES `administration` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
INSERT INTO `admin_log` VALUES (1,1,'Login',2130706433,'2013-11-26 23:13:49'),(2,1,'Login',2130706433,'2013-11-26 23:37:36'),(3,1,'Login',2130706433,'2013-11-26 23:40:14'),(4,1,'Login',2130706433,'2013-11-26 23:42:39'),(5,1,'Logout',2130706433,'2013-11-27 00:25:46'),(6,1,'Login',2130706433,'2013-11-27 00:25:50'),(7,1,'Add User         | User ID: 3, User Name: admin, User Group: admins',2130706433,'2013-11-27 00:29:02'),(8,1,'Add User         | User ID: 4, User Name: test, User Group: users',2130706433,'2013-11-27 00:34:01'),(9,1,'Edit User        | User ID: 4, User Name: test_test, User Group: users',2130706433,'2013-11-27 00:34:16'),(10,1,'Delete User      | User ID: 4, User Name: test_test, User Group: users',2130706433,'2013-11-27 00:34:19'),(11,1,'Logout',2130706433,'2013-11-27 00:36:35'),(12,1,'Login',2130706433,'2013-11-27 00:37:59'),(13,1,'Login',2130706433,'2013-11-27 00:39:10'),(14,1,'Logout',2130706433,'2013-11-27 00:39:15'),(15,1,'Login',2130706433,'2013-11-27 00:40:00'),(16,1,'Logout',2130706433,'2013-11-27 00:40:05'),(17,1,'Login',2130706433,'2013-11-27 00:51:21'),(18,1,'Login',2130706433,'2013-11-27 10:38:09'),(19,1,'Deactiv Mandant  | Mandant ID: 1, Mandant User Name: abysmli, Mandant Company: Microsoft, Mandant Address: American, Mandant Contact: 888-888888',2130706433,'2013-11-27 11:08:01'),(20,1,'Deactiv Mandant  | Mandant ID: 1, Mandant User Name: abysmli, Mandant Company: Microsoft, Mandant Address: American, Mandant Contact: 888-888888',2130706433,'2013-11-27 11:12:28'),(21,1,'Activ Mandant    | Mandant ID: 1, Mandant User Name: abysmli, Mandant Company: Microsoft, Mandant Address: American, Mandant Contact: 888-888888',2130706433,'2013-11-27 11:16:19'),(22,1,'Add Mandant      | Mandant ID: 2, Mandant User Name: abysmli1, Mandant Company: Apple, Mandant Address: American, Mandant Contact: 456-78913',2130706433,'2013-11-27 11:22:34'),(23,1,'Edit Mandant     | Mandant ID: 2, Mandant User Name: abysmli1, Mandant Company: Apple, Mandant Address: American, Mandant Contact: 456-78913',2130706433,'2013-11-27 11:23:18'),(24,1,'Active Client    | For Mandant ID: 1, Client ID: 1, Client MAC: cdnie12jim1j23',2130706433,'2013-11-27 11:50:14'),(25,1,'Deactiv Client   | For Mandant ID: 1, Client ID: 1, Client MAC: cdnie12jim1j23',2130706433,'2013-11-27 11:52:56'),(26,1,'Active Client    | For Mandant ID: 1, Client ID: 1, Client MAC: cdnie12jim1j23',2130706433,'2013-11-27 11:53:00'),(27,1,'Add Client       | For Mandant ID: 2, Client ID: 3, Client MAC: nivmijijeifsdfa',2130706433,'2013-11-27 11:53:17'),(28,1,'Add Client       | For Mandant ID: 1, Client ID: 4, Client MAC: jijpoiqewfasdf',2130706433,'2013-11-27 11:54:07'),(29,1,'Deactiv Client   | For Mandant ID: 2, Client ID: 3, Client MAC: nivmijijeifsdfa',2130706433,'2013-11-27 12:03:19'),(30,1,'Active Client    | For Mandant ID: 2, Client ID: 3, Client MAC: nivmijijeifsdfa',2130706433,'2013-11-27 12:03:25'),(31,1,'Login',2130706433,'2013-11-28 11:12:03'),(32,1,'Add Client       | For Mandant ID: 1, Client ID: 5, Client MAC: niijeifjiejif',2130706433,'2013-11-28 11:25:46'),(33,1,'Login',2130706433,'2013-11-28 17:02:03'),(34,1,'Login',2130706433,'2013-11-28 21:09:46'),(35,1,'Login',2130706433,'2013-11-28 21:32:40'),(36,1,'Login',2130706433,'2013-11-29 13:36:17'),(37,1,'Login',2130706433,'2013-12-10 18:26:13'),(38,1,'Login',2130706433,'2013-12-14 16:12:58');
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administration`
--

DROP TABLE IF EXISTS `administration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administration` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` enum('admins','users') NOT NULL DEFAULT 'users',
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administration`
--

LOCK TABLES `administration` WRITE;
/*!40000 ALTER TABLE `administration` DISABLE KEYS */;
INSERT INTO `administration` VALUES (1,'abysmli','$2y$08$gzllcrNhjW35se4faB6tZ.EcJjhSRF72RAnm/lBdpkJIQaLZlyGM.','admins','1','2013-11-26 23:13:44'),(2,'user','$2y$08$3qNdyNcUocKeKiinKhwNFu99TEqRAR.EL1G21Arq3oO.KGKwPjmqC','users','1','2013-11-27 00:24:18'),(3,'admin','$2y$08$IZN8mHxyNcWVdKHyw3Zydu6hUUCxlM6fL8V0xItVXv0io4pK7J8ii','admins','1','2013-11-27 00:29:02');
/*!40000 ALTER TABLE `administration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `client_id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `mandant_id` int(10) unsigned NOT NULL,
  `client_mac` char(32) NOT NULL,
  `client_active` enum('-1','0','1') NOT NULL DEFAULT '0',
  `date_insert` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_mac` (`client_mac`),
  KEY `FK_client_1` (`mandant_id`),
  CONSTRAINT `FK_client_1` FOREIGN KEY (`mandant_id`) REFERENCES `mandant` (`mandant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,1,'nimahannihuijia','1','2013-11-27 10:43:30','2013-11-28 16:18:06'),(3,2,'nivmijijeifsdfa','1','2013-11-27 11:53:17','2013-11-27 12:03:24'),(4,1,'jijpoiqewfasdf','1','2013-11-27 11:54:07','2013-11-28 16:17:55'),(5,1,'niijeifjiejif','1','2013-11-28 11:25:45','2013-12-14 16:32:11');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_permission`
--

DROP TABLE IF EXISTS `client_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_permission` (
  `client_id_s` int(16) unsigned NOT NULL,
  `client_id_r` int(16) unsigned NOT NULL,
  `permission` enum('read','fetch','delete') NOT NULL,
  UNIQUE KEY `Index_3` (`client_id_s`,`client_id_r`),
  KEY `FK_Client_Permission_2` (`client_id_r`),
  CONSTRAINT `FK_Client_Permission_1` FOREIGN KEY (`client_id_s`) REFERENCES `client` (`client_id`),
  CONSTRAINT `FK_Client_Permission_2` FOREIGN KEY (`client_id_r`) REFERENCES `client` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_permission`
--

LOCK TABLES `client_permission` WRITE;
/*!40000 ALTER TABLE `client_permission` DISABLE KEYS */;
INSERT INTO `client_permission` VALUES (1,4,'read'),(1,5,'delete'),(4,1,'read'),(4,5,'delete'),(5,1,'fetch'),(5,4,'fetch');
/*!40000 ALTER TABLE `client_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_log`
--

DROP TABLE IF EXISTS `error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_log` (
  `log_nr` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actor` enum('client','unknown') NOT NULL,
  `actor_id` int(10) unsigned DEFAULT NULL,
  `ip` bigint(20) unsigned DEFAULT NULL,
  `error_code` int(10) unsigned DEFAULT NULL,
  `action` enum('insert','read','fetch','delete') DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_nr`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_log`
--

LOCK TABLES `error_log` WRITE;
/*!40000 ALTER TABLE `error_log` DISABLE KEYS */;
INSERT INTO `error_log` VALUES (1,'client',1,3239651122,192,'insert','2013-11-27 10:45:44'),(2,'client',1,3239651122,193,'read','2013-11-27 10:46:17'),(3,'client',1,3239651122,193,'read','2013-11-27 10:46:17'),(4,'client',1,3239651122,193,'read','2013-11-27 10:46:18'),(5,'client',1,3239651122,196,'delete','2013-11-27 10:46:25'),(6,'unknown',0,0,1,'insert','2013-11-27 10:47:27'),(7,'unknown',0,0,1,'insert','2013-11-27 10:47:27'),(8,'unknown',0,0,1,'insert','2013-11-27 10:47:28'),(9,'unknown',0,0,1,'insert','2013-11-27 10:47:28'),(10,'unknown',0,0,1,'insert','2013-11-27 10:47:28');
/*!40000 ALTER TABLE `error_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_log`
--

DROP TABLE IF EXISTS `event_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_log` (
  `log_nr` int(20) NOT NULL AUTO_INCREMENT,
  `message_id` varchar(20) NOT NULL,
  `client_id` int(16) unsigned NOT NULL,
  `client_ip` bigint(20) unsigned NOT NULL,
  `action` enum('insert','read','fetch','delete') NOT NULL,
  `useragent` text,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_nr`),
  KEY `FK_event_log_1` (`client_id`),
  CONSTRAINT `FK_event_log_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_log`
--

LOCK TABLES `event_log` WRITE;
/*!40000 ALTER TABLE `event_log` DISABLE KEYS */;
INSERT INTO `event_log` VALUES (1,'1',1,3239651122,'insert','1234','2013-11-27 12:10:37'),(2,'1',4,3239651122,'read','3214','2013-11-27 12:10:37'),(3,'1',4,3239651122,'read','1345','2013-11-27 12:11:29'),(4,'1',4,3239651122,'delete','1654','2013-11-27 12:11:29'),(5,'2',1,3239651122,'insert','1234','2013-11-28 11:21:08'),(6,'2',5,323951122,'read','11234','2013-11-28 11:26:03'),(7,'2',5,323951122,'read','21234','2013-11-28 11:26:28'),(8,'2',5,323951122,'read','2234','2013-11-28 11:26:32'),(9,'2',4,323951122,'delete','2234','2013-11-28 11:26:49'),(10,'3',1,323951122,'insert','22634','2013-11-28 11:27:13'),(11,'3',4,323951122,'read','22634','2013-11-28 11:27:21'),(12,'3',4,323951122,'read','22634','2013-11-28 11:27:22'),(13,'3',4,323951122,'delete','22634','2013-11-28 11:27:27'),(14,'4',4,323951122,'insert','22634','2013-11-28 11:27:42'),(15,'5',5,323951122,'insert','22634','2013-11-28 11:27:46'),(16,'6',4,323951122,'insert','22634','2013-11-28 11:28:23'),(17,'6',5,323951122,'read','22634','2013-11-28 11:28:30'),(18,'6',1,323951122,'read','22634','2013-11-28 11:28:36'),(19,'6',1,323951122,'delete','22634','2013-11-28 11:28:39');
/*!40000 ALTER TABLE `event_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mandant`
--

DROP TABLE IF EXISTS `mandant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mandant` (
  `mandant_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mandant_firmname` varchar(100) NOT NULL,
  `mandant_address` text NOT NULL,
  `mandant_contact` text NOT NULL,
  `mandant_active` enum('0','1') NOT NULL DEFAULT '1',
  `date_insert` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mandant_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mandant`
--

LOCK TABLES `mandant` WRITE;
/*!40000 ALTER TABLE `mandant` DISABLE KEYS */;
INSERT INTO `mandant` VALUES (1,1,'abysmli','$2y$08$AARRSpmfCI9dRD1OsuqG.eYFcsHeu1Eg6Kbu0IdaQV9JSe9MFFDAe','Microsoft','American','888-888888','1','0000-00-00 00:00:00','2013-11-27 11:16:19'),(1,2,'abysmli2','$2y$08$ddGKb.K.DL7t1F2ilFKNB.JQassLuVU6JYBUtf26Mt97kXgq47406','Microsoft','American','888-888888','1','2013-11-28 16:18:49','2013-11-28 16:19:39'),(2,1,'abysmli1','$2y$08$5oz9Ft4zt6EjPBvhGzS9TO9p2cAisPy0BDmFpuEE4Mxg7p4vJvoJi','Apple','American','456-78913','1','2013-11-27 11:22:34','2013-11-27 11:23:18');
/*!40000 ALTER TABLE `mandant` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-14 21:38:56
