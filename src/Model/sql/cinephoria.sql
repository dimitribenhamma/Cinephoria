-- SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 28 sep. 2025 à 16:01
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13
-- Version de MySQL : 8.2.0 (8.0.16+)

SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_AUTO_VALUE_ON_ZERO,NO_ENGINE_SUBSTITUTION'; -- modes par défaut souvent différents
START TRANSACTION;
SET time_zone = "+00:00";




--
-- Base de données : `cinephoria`
--

CREATE DATABASE cinephoria;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL CHECK (LENGTH(`nom`) > 2 AND LENGTH(`nom`) < 20),
  `prenom` varchar(20) NOT NULL CHECK (LENGTH(`prenom`) > 2 AND LENGTH(`prenom`) < 20),
  `user` varchar(20) NOT NULL CHECK (LENGTH(`user`) > 3 AND LENGTH(`user`) < 20),
  `password` varchar(60) NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci CHECK (`password` > 8 AND `password` < 20),-- codé et haché sur 60 caractères
  `email` varchar(254) NOT NULL UNIQUE, -- email comme login
  `date` date NOT NULL DEFAULT CURRENT_DATE,
  `role` varchar(20) NOT NULL DEFAULT 'client' CHECK (`role` IN ('client', 'admin', 'employe')),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

--
-- Déchargement des données de la table `membres`
--

/* 
   INSERT INTO `membres` (`id`, `nom`, `prenom`, `user`, `password`, `email`, `date`, `role`) VALUES
  (1, 'admin', 'admin', 'admin', '$2y$10$YvKThdFwLeNTwkKIr54e0.E0CfEUV.B5R9oIHWKx1/CjOWaMTPf3G', 'admin@cinephoria.com', '1987-05-15', 'admin'),
  (2, 'employe', 'employe', 'employe', '$2y$10$0ihwDXP6DP7s.php5tE33u5yonknMvM/jpCFN6mYAAobI1KxNdQg.', 'employe@cinephoria.com', '1987-05-15', 'employe'),
  (3, 'client', 'client', 'client', '$2y$10$q8URJpq.4YPURJ8bY1Ksq.coG1Xpk8LF8tZ14Usygcd4EPKxfuypK', 'client@cinephoria.com', '1987-04-01', 'client');
  COMMIT; 
*/

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
