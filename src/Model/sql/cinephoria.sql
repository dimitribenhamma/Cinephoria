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


--
-- Base de données : `cinephoria`
--

-- Base de données
CREATE DATABASE IF NOT EXISTS cinephoria
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci ;

USE cinephoria ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `roles` ;
CREATE TABLE `roles` (
  `Id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;

INSERT INTO roles (`Name`) VALUES
('Client'),
('Employee'),
('Admin') ;


DROP TABLE IF EXISTS `client` ; -- Supprime la table client si elle existe déjà
CREATE TABLE `client` ( -- Début de la table client
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, -- uniquement positif et obligatoire
  `Name` VARCHAR(20) NOT NULL,
  `Surname` VARCHAR(20) NOT NULL,
  `User` VARCHAR(20) NOT NULL,
  `Password` VARCHAR(254) NOT NULL,
  `Email` VARCHAR(60) NOT NULL UNIQUE, -- Unicité de l'email
  `Date_registration` DATE DEFAULT (CURRENT_DATE),
  `Role_id` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_client_role
    FOREIGN KEY (`role_id`) REFERENCES roles(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;


DROP TABLE IF EXISTS `booking` ;
CREATE TABLE `booking` (
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Client_id` BIGINT UNSIGNED NOT NULL,
  `Movie_id` INT UNSIGNED NOT NULL,
  `Seats` INT UNSIGNED NOT NULL,
  `Horaire` VARCHAR(20) NOT NULL,
  `Date_reservation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  CONSTRAINT fk_booking_client
    FOREIGN KEY (`Client_id`) REFERENCES client(`Id`)
      ON DELETE CASCADE
) ENGINE=InnoDB ;


DROP TABLE IF EXISTS `cookies` ;
CREATE TABLE `cookies` (
  `Id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, -- une seule auto_increment la clé primaire
  `Client_cookies_id` BIGINT UNSIGNED,
  `Consent` VARCHAR(5) DEFAULT 'false',
  `Cookie_name` VARCHAR(200) DEFAULT 'cinephoria',  
  `Username` VARCHAR(200) NOT NULL DEFAULT 'client',
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
  `Role` VARCHAR(39) DEFAULT 'visiteur',
  `Cookie_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  CONSTRAINT fk_cookies_client
    FOREIGN KEY (`Client_cookies_id`) REFERENCES client(`Id`)
      ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;
COMMIT;



-- créer l'utilisateur s'il n'existe pas
CREATE USER IF NOT EXISTS 'dimitri'@'127.0.0.1' IDENTIFIED BY 'dimitri' ;
-- donner tous les privilèges sur la base cinephoria
GRANT ALL PRIVILEGES ON cinephoria.* TO 'dimitri'@'127.0.0.1' ;
-- appliquer les privilèges
FLUSH PRIVILEGES ;

INSERT INTO `client` 
(`Id`, `Name`, `Surname`, `User`, `Password`, `Email`, `Date_registration`, `Role_id`) 
VALUES
(1, 'Admin', 'Admin', 'admin', 'Admin123', 'admina@gmail.com', CURRENT_DATE, 3),
(2, 'Cinephoria', 'Contact', 'suivi-cinephoria', 'Contact123', 'suivi-cinephoria@gmail.com', CURRENT_DATE, 2),
(3, 'Bertrand', 'Lucas', 'lbernard', 'Contact123', 'lucas@gmail.com', CURRENT_DATE, 1) ;