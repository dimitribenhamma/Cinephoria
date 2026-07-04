-- MySQL 8.0+
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 28 sep. 2025 à 16:01
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13
-- Version de MySQL : 8.2.0 (8.0.16+)
--
-- Base de données : `Cinephoria`
--

-- Base de données
CREATE DATABASE "Cinephoria";

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS Roles ;
CREATE TABLE Roles (
  Id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  Name VARCHAR(20) NOT NULL UNIQUE
);

INSERT INTO Roles (Name) VALUES
('Client'),
('Employe'),
('Admin') ;


DROP TABLE IF EXISTS Client ; -- Supprime la table client si elle existe déjà
CREATE TABLE Client ( -- Début de la table client
   Id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY, -- uniquement positif et obligatoire
   Name VARCHAR(20) NOT NULL,
   Surname VARCHAR(20) NOT NULL,
   Username VARCHAR(20) NOT NULL,
   Password VARCHAR(254) NOT NULL,
   Email VARCHAR(60) NOT NULL UNIQUE, -- Unicité de l'email
   Date_Registration DATE DEFAULT (CURRENT_DATE),
   Role_Id INTEGER NOT NULL DEFAULT 1,
  CONSTRAINT fk_Client_Role
    FOREIGN KEY (Role_Id) REFERENCES roles(Id)
) ;


DROP TABLE IF EXISTS Booking ;
CREATE TABLE Booking (
  Id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  Client_Id INTEGER NOT NULL,
  Movie_Id INT NOT NULL,
  Seats INT NOT NULL,
  Horaire VARCHAR(20) NOT NULL,
  Date_Reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_Booking_Client
    FOREIGN KEY (Client_Id) REFERENCES client(Id)
      ON DELETE CASCADE
) ;


DROP TABLE IF EXISTS Cookies ;
CREATE TABLE Cookies (
  Id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY, -- une seule auto_increment la clé primaire
  Client_Cookies_Id INTEGER,
  Consent VARCHAR(5) DEFAULT 'false',
  Cookie_Name VARCHAR(200) DEFAULT 'Cinephoria',  
  Username VARCHAR(200) NOT NULL DEFAULT 'Client',
  Device VARCHAR(200),
  Platform VARCHAR(200),
  Browser VARCHAR(200),
  BrowserVersion VARCHAR(200),
  Language VARCHAR(4) NOT NULL,
  Timezone VARCHAR(200) NOT NULL,
  Country VARCHAR(60), -- DEFAULT 60 : 'Royaume-Uni de Grande-Bretagne et d’Irlande du Nord',
  City VARCHAR(200), -- DEFAULT 200 : 'Krung Thep Maha Nakhon Amon Rattanakosin Mahinthara Ayutthaya Mahadilok Phop Noppharat Ratchathani Burirom Udomratchaniwet Mahasathan Amon Piman Awatan Sathit Sakkathattiya Witsanukam Prasit (Bangkok)',
  Isp VARCHAR(60),
  Latitude DECIMAL(10,7),
  Longitude DECIMAL(10,7),
  Ip VARCHAR(39), 
  Events VARCHAR(254),
  Visits INT DEFAULT 1,
  Role VARCHAR(39) DEFAULT 'Visiteur',
  Cookie_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_Cookies_Client
    FOREIGN KEY (Client_Cookies_Id) REFERENCES client(Id)
      ON DELETE CASCADE
) ;



-- créer l'utilisateur s'il n'existe pas
CREATE USER dimitri WITH PASSWORD 'dimitri';
-- donner tous les privilèges sur la base cinephoria (PAS le droit de faire DROP DATABASE , sinon GRANT ALL PRIVILEGES ON *.* ...)
GRANT ALL PRIVILEGES ON DATABASE "Cinephoria" TO dimitri;
GRANT ALL ON SCHEMA public TO dimitri;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO dimitri;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO dimitri;