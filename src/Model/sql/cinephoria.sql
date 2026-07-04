-- MySQL 8.0+
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 28 sep. 2025 à 16:01
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13
-- Version de MySQL : 8.2.0 (8.0.16+)

SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_AUTO_VALUE_ON_ZERO,NO_ENGINE_SUBSTITUTION' ; -- modes par défaut souvent différents
START TRANSACTION ; 
SET time_zone = "+00:00" ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `Roles` ;
CREATE TABLE `Roles` (
  `Id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) NOT NULL UNIQUE,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB ;

INSERT INTO Roles (`Name`) VALUES
('Client'),
('Employe'),
('Admin') ;


DROP TABLE IF EXISTS `Client` ; -- Supprime la table client si elle existe déjà
CREATE TABLE `Client` ( -- Début de la table client
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, -- uniquement positif et obligatoire
  `Name` VARCHAR(20) NOT NULL,
  `Surname` VARCHAR(20) NOT NULL,
  `Username` VARCHAR(20) NOT NULL,
  `Password` VARCHAR(254) NOT NULL,
  `Email` VARCHAR(60) NOT NULL UNIQUE, -- Unicité de l'email
  `Date_Registration` DATE DEFAULT (CURRENT_DATE),
  `Role_Id` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT fk_Client_Role
    FOREIGN KEY (`Role_Id`) REFERENCES Roles(`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;


DROP TABLE IF EXISTS `Booking` ;
CREATE TABLE `Booking` (
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Client_Id` BIGINT UNSIGNED NOT NULL,
  `Movie_Id` INT UNSIGNED NOT NULL,
  `Seats` INT UNSIGNED NOT NULL,
  `Horaire` VARCHAR(20) NOT NULL,
  `Date_Reservation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  CONSTRAINT fk_Booking_Client
    FOREIGN KEY (`Client_Id`) REFERENCES Client(`Id`)
      ON DELETE CASCADE
) ENGINE=InnoDB ;


DROP TABLE IF EXISTS `Cookies` ;
CREATE TABLE `Cookies` (
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, -- une seule auto_increment la clé primaire
  `Client_Cookies_Id` BIGINT UNSIGNED,
  `Consent` VARCHAR(5) DEFAULT 'false',
  `Cookie_Name` VARCHAR(200) DEFAULT 'Cinephoria',  
  `Username` VARCHAR(200) NOT NULL DEFAULT 'Client',
  `Device` VARCHAR(200),
  `Platform` VARCHAR(200),
  `Browser` VARCHAR(200),
  `BrowserVersion` VARCHAR(200),
  `Language` VARCHAR(4) NOT NULL,
  `Timezone` VARCHAR(200) NOT NULL,
  `Country` VARCHAR(60), -- DEFAULT 60 : 'Royaume-Uni de Grande-Bretagne et d’Irlande du Nord',
  `City` VARCHAR(200), -- DEFAULT 200 : 'Krung Thep Maha Nakhon Amon Rattanakosin Mahinthara Ayutthaya Mahadilok Phop Noppharat Ratchathani Burirom Udomratchaniwet Mahasathan Amon Piman Awatan Sathit Sakkathattiya Witsanukam Prasit (Bangkok)',
  `Isp` VARCHAR(60),
  `Latitude` DECIMAL(10,7),
  `Longitude` DECIMAL(10,7),
  `Ip` VARCHAR(39), 
  `Events` VARCHAR(254),
  `Visits` INT UNSIGNED DEFAULT 1,
  `Role` VARCHAR(39) DEFAULT 'Visiteur',
  `Cookie_Date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  CONSTRAINT fk_Cookies_Client
    FOREIGN KEY (`Client_Cookies_Id`) REFERENCES Client(`Id`)
      ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;
COMMIT;
