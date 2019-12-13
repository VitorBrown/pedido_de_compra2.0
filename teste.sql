# Host: localhost  (Version 5.5.5-10.1.24-MariaDB)
# Date: 2019-12-13 01:33:03
# Generator: MySQL-Front 6.0  (Build 2.12)


#
# Structure for table "categorias"
#

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "categorias"
#

INSERT INTO `categorias` VALUES (1,'Eletrônico'),(2,'Comida'),(3,'Refeição'),(4,'Automotivo'),(5,'Frutas'),(6,'Roupas'),(7,'Educação');

#
# Structure for table "clientes"
#

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `cpf` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

#
# Data for table "clientes"
#

INSERT INTO `clientes` VALUES (33,'Paula','a','5523369872'),(44,'Sthella','adm','4789652');

#
# Structure for table "produtos"
#

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL DEFAULT '0',
  `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cliente_id` int(11) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `produtos_ibfk_2` (`cliente_id`),
  KEY `produtos_ibfk_1` (`categoria_id`),
  CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Data for table "produtos"
#

INSERT INTO `produtos` VALUES (1,'Macbook',1,5000.00,33,'2019-08-20 01:16:27'),(5,'iPhone',1,1.00,33,'2019-08-01 01:16:27'),(6,'Carros',4,1000.00,33,'2019-08-30 01:16:27'),(7,'Casaco',6,502.00,33,'2019-08-26 01:16:27'),(9,'Televisão',1,700.00,33,'2019-08-26 01:16:27'),(11,'Leite',7,1002.00,33,'2019-08-26 01:16:27'),(12,'Radio',2,1300.00,33,'2019-05-26 01:16:27'),(13,'Teste',5,12.00,44,'2019-08-26 01:16:27'),(14,'Sofa',6,1200.00,44,'2019-08-26 01:16:27'),(16,'Notebook',1,500.00,44,'2019-08-26 01:16:27'),(18,'Headphone',1,800.00,44,'2019-06-26 01:16:27'),(20,'Playstation',1,55.00,44,'2019-08-26 01:19:20'),(22,'Skullcandy',1,11.00,44,'2013-12-19 05:12:39');

#
# Structure for table "compras"
#

DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL DEFAULT '0',
  `cliente_id` int(11) NOT NULL DEFAULT '0',
  `quantidade` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT '2',
  `criado_em` datetime DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `compras_ibfk_1` (`produto_id`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

#
# Data for table "compras"
#

INSERT INTO `compras` VALUES (30,1,44,5,'0','2019-12-13 05:12:43',25000),(31,20,33,2,'1','2019-12-13 05:12:47',110),(33,6,44,5,'2','2019-12-13 05:12:43',5000);

#
# Structure for table "usuarios"
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

#
# Data for table "usuarios"
#

INSERT INTO `usuarios` VALUES (19,'paula@teste.com','123',33),(35,'sthella@teste.com','123',44);
