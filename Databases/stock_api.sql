# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.29)
# Database: stock_api
# Generation Time: 2020-06-09 14:57:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table orderedProducts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orderedProducts`;

CREATE TABLE `orderedProducts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(255) NOT NULL DEFAULT '',
  `sku` varchar(255) NOT NULL DEFAULT '',
  `numberProductOrdered` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `orderedProducts` WRITE;
/*!40000 ALTER TABLE `orderedProducts` DISABLE KEYS */;

INSERT INTO `orderedProducts` (`id`, `orderNumber`, `sku`, `numberProductOrdered`)
VALUES
	(1,'TESTORDER6','UGGBBPUR06',1),
	(2,'TESTORDER6','UGGBBPUR07',2),
	(3,'TESTORDER6','UGGBBPUR08',3),
	(4,'TESTORDER6','UGGBBPUR09',4),
	(5,'TESTORDER6','UGGBBPUR10',5);

/*!40000 ALTER TABLE `orderedProducts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(255) NOT NULL DEFAULT '',
  `CustomerEmail` varchar(255) NOT NULL DEFAULT '',
  `shippingAddress1` varchar(255) NOT NULL DEFAULT '',
  `shippingAddress2` varchar(255) NOT NULL DEFAULT '',
  `shippingCity` varchar(255) NOT NULL DEFAULT '',
  `shippingPostcode` varchar(255) NOT NULL DEFAULT '',
  `shippingCountry` varchar(255) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`orderNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `orderNumber`, `CustomerEmail`, `shippingAddress1`, `shippingAddress2`, `shippingCity`, `shippingPostcode`, `shippingCountry`, `deleted`, `completed`)
VALUES
	(1,'TESTORDER6','test@example.com','21 Test Lane','','Teston','AB12 BA21','UK',0,0);

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` varchar(255) NOT NULL DEFAULT '',
  `stockLevel` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `sku`, `name`, `price`, `stockLevel`, `deleted`)
VALUES
	(1,'abcdef123456','test_name_1','99.99',1,0),
	(2,'abcdef123457','test_name_2','89.99',5,0),
	(3,'abcdef123458','test_name_3','79.99',10,0),
	(4,'UGA-BB-PUR-06','testing2','0.99',12,0),
	(6,'UGG-BB-PUR-06','testing','0.99',12,0),
	(7,'UGB-BB-PUR-06','testing','0.99',12,0),
	(8,'UGC-BB-PUR-06','testing','0.99',12,0),
	(9,'UGD-BB-PUR-06','','0.99',12,0),
	(10,'UGE-BB-PUR-06','testing','0.99',12,0),
	(11,'UGF-BB-PUR-06','testing','0.99',12,0),
	(12,'UGH-BB-PUR-06','testing','0.99',12,0),
	(13,'UGI-BB-PUR-06','testing','0.99',12,0),
	(14,'UGJ-BB-PUR-06','testing','0.99',12,0),
	(15,'UGABBPUR06','testing','0.99',14,0),
	(16,'UGGBBPUR06','test_name','0.99',14,0),
	(17,'UGGBBPUR07','test_name','0.99',2,0),
	(18,'UGGBBPUR08','test_name','0.99',2,0),
	(19,'UGGBBPUR09','test_name','0.99',0,0),
	(20,'UGGBBPUR10','test_name','0.99',2,0);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
