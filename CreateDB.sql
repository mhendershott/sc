-- CREATE routines for player database and tables
-- A user will need to be created for access and 
-- credentials should be stored in the config.php file
-- Changes to this schema are not recommended

DROP DATABASE IF EXISTS `player`;
CREATE DATABASE `player` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `player`;
CREATE TABLE `commandQueue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `command` varchar(45) DEFAULT NULL,
  `param` varchar(45) DEFAULT NULL,
  `viewerID` varchar(45) DEFAULT NULL,
  `seq` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=782 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `scene` (
  `streamID` varchar(45) NOT NULL,
  `currentScene` varchar(45) DEFAULT NULL,
  `lastScene` varchar(45) DEFAULT NULL,
  `nextScene` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`streamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `viewers` (
  `idviewers` int(11) NOT NULL AUTO_INCREMENT,
  `viewerID` varchar(45) DEFAULT NULL,
  `viewerLastSeen` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idviewers`),
  UNIQUE KEY `viewerID` (`viewerID`)
) ENGINE=InnoDB AUTO_INCREMENT=22110 DEFAULT CHARSET=utf8mb4;
