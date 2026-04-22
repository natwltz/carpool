-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 19 déc. 2025 à 15:16
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `carpool`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL,
  `admin_mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `admin_pwd` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_mail` (`admin_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `passager`
--

DROP TABLE IF EXISTS `passager`;
CREATE TABLE IF NOT EXISTS `passager` (
  `passager_id` int NOT NULL,
  `passager_trajet_id` int NOT NULL,
  `passager_un_users_id` int DEFAULT NULL,
  `passager_deux_users_id` int DEFAULT NULL,
  `passager_trois_users_id` int DEFAULT NULL,
  `passager_quatre_users_id` int DEFAULT NULL,
  PRIMARY KEY (`passager_id`),
  UNIQUE KEY `passager_trajet_id` (`passager_trajet_id`),
  UNIQUE KEY `passager_un_users_id` (`passager_un_users_id`),
  UNIQUE KEY `passager_deux_users_id` (`passager_deux_users_id`),
  UNIQUE KEY `passager_trois_users_id` (`passager_trois_users_id`),
  UNIQUE KEY `passager_quatre_users_id` (`passager_quatre_users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
  `trajet_id` int NOT NULL,
  `trajet_ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `trajet_date` date NOT NULL,
  `trajet_heure` time NOT NULL,
  `trajet_users_id` int NOT NULL,
  `trajet_nbpassager_max` int NOT NULL,
  `trajet_date_publication` datetime DEFAULT NULL,
  PRIMARY KEY (`trajet_id`),
  UNIQUE KEY `trajet_users_id` (`trajet_users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int NOT NULL,
  `users_mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_firstname` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_lastname` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_pwd` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_ville` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `users_contact` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `users_mail` (`users_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
