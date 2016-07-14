# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.46-0ubuntu0.14.04.2)
# Database: mh
# Generation Time: 2016-01-25 03:08:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table stages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stages`;

CREATE TABLE `stages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `stages` WRITE;
/*!40000 ALTER TABLE `stages` DISABLE KEYS */;

INSERT INTO `stages` (`id`, `name`, `order`)
VALUES
	(1,'','0'),
	(2,'HIGH TIDE','2'),
	(3,'LOW TIDE','0'),
	(4,'MEDIUM TIDE','1'),
	(5,'MIST 0','0'),
	(6,'MIST 1-5','1'),
	(7,'MIST 19-20','3'),
	(8,'MIST 6-18','2'),
	(9,'WAVE 1','0'),
	(10,'WAVE 2','1'),
	(11,'WAVE 3','2'),
	(12,'WAVE 4','3'),
	(13,'1ST PHASE','0'),
	(14,'2ND PHASE','1'),
	(15,'3RD PHASE','2'),
	(16,'STATION','0'),
	(17,'0-300FT','0'),
	(18,'1601-1800FT','3'),
	(19,'1801-2000FT','4'),
	(20,'2000FT','5'),
	(21,'301-600FT','1'),
	(22,'601-1600FT','2'),
	(23,'GENERALS','6'),
	(24,'EPIC FEALTY','4'),
	(25,'EPIC SCHOLAR','7'),
	(26,'EPIC TECH','10'),
	(27,'INTERSECTIONS','13'),
	(28,'PLAIN FARMING','0'),
	(29,'PLAIN FEALTY','2'),
	(30,'PLAIN SCHOLAR','5'),
	(31,'PLAIN TECH','8'),
	(32,'PLAIN TREASURY','11'),
	(33,'SUPERIOR FARMING','1'),
	(34,'SUPERIOR FEALTY','3'),
	(35,'SUPERIOR SCHOLAR','6'),
	(36,'SUPERIOR TECH','9'),
	(37,'SUPERIOR TREASURY','12'),
	(38,'0-2KM','1'),
	(39,'10-15KM','3'),
	(40,'15-25KM','4'),
	(41,'2-10KM','2'),
	(42,'25KM+','5'),
	(43,'DOCKED','0'),
	(44,'CC 0-24','0'),
	(45,'CC 25-49','1'),
	(46,'CC 50','2'),
	(47,'DL 0-24','3'),
	(48,'DL 25-49','4'),
	(49,'DL 50','5'),
	(50,'GGT 0-24','6'),
	(51,'GGT 25-49','7'),
	(52,'GGT 50','8'),
	(53,'FARMING 0+','0'),
	(54,'FARMING 50+','1'),
	(55,'FEALTY 15+','2'),
	(56,'FEALTY 50+','3'),
	(57,'FEALTY 80+','4'),
	(58,'LAIR - EACH 30+','13'),
	(59,'SCHOLAR 15+','5'),
	(60,'SCHOLAR 50+','6'),
	(61,'SCHOLAR 80+','7'),
	(62,'TECH 15+','8'),
	(63,'TECH 50+','9'),
	(64,'TECH 80+','10'),
	(65,'TREASURY 15+','11'),
	(66,'TREASURY 50+','12');

/*!40000 ALTER TABLE `stages` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
