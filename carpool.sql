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
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `admin_pwd` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_mail` (`admin_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `passager`
--

DROP TABLE IF EXISTS `passager`;
CREATE TABLE IF NOT EXISTS `passager` (
  `passager_id` int NOT NULL AUTO_INCREMENT,
  `passager_trajet_id` int NOT NULL,
  `passager_un_users_id` int DEFAULT NULL,
  `passager_deux_users_id` int DEFAULT NULL,
  `passager_trois_users_id` int DEFAULT NULL,
  `passager_quatre_users_id` int DEFAULT NULL,
  PRIMARY KEY (`passager_id`),
  UNIQUE KEY `passager_trajet_id` (`passager_trajet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
  `trajet_id` int NOT NULL AUTO_INCREMENT,
  `trajet_ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `trajet_date` date NOT NULL,
  `trajet_heure` time NOT NULL,
  `trajet_users_id` int NOT NULL,
  `trajet_nbpassager_max` int NOT NULL,
  `trajet_date_publication` datetime DEFAULT NULL,
  PRIMARY KEY (`trajet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int NOT NULL AUTO_INCREMENT,
  `users_mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_firstname` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_lastname` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `users_pwd` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `users_ville` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `users_contact` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `users_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `users_mail` (`users_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


INSERT INTO `users` (`users_id`, `users_mail`, `users_firstname`, `users_lastname`, `users_pwd`, `users_ville`, `users_contact`, `users_is_admin`) VALUES
(1, 'admin@carpool.com', 'Admin', 'Super', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Paris', '0600000000', 1),
(2, 'jean.dupont@mail.com', 'Jean', 'Dupont', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Lyon', '0612345678', 0),
(3, 'marie.curie@mail.com', 'Marie', 'Curie', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Marseille', '0623456789', 0),
(4, 'lucas.martin@mail.com', 'Lucas', 'Martin', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Toulouse', '0634567890', 0),
(5, 'sophie.bernard@mail.com', 'Sophie', 'Bernard', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Bordeaux', '0645678901', 0),
(6, 'paul.durand@mail.com', 'Paul', 'Durand', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Nantes', '0656789012', 0),
(7, 'emma.petit@mail.com', 'Emma', 'Petit', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Strasbourg', '0667890123', 0),
(8, 'thomas.richard@mail.com', 'Thomas', 'Richard', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Lille', '0678901234', 0),
(9, 'julie.garcia@mail.com', 'Julie', 'Garcia', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Rennes', '0689012345', 0),
(10, 'nicolas.moreau@mail.com', 'Nicolas', 'Moreau', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Montpellier', '0690123456', 0),
(11, 'lea.laurent@mail.com', 'Léa', 'Laurent', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Reims', '0601234567', 0),
(12, 'antoine.simon@mail.com', 'Antoine', 'Simon', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Le Havre', '0611111111', 0),
(13, 'chloe.michel@mail.com', 'Chloé', 'Michel', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Saint-Étienne', '0622222222', 0),
(14, 'maxime.lefebvre@mail.com', 'Maxime', 'Lefebvre', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Toulon', '0633333333', 0),
(15, 'camille.leroy@mail.com', 'Camille', 'Leroy', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Grenoble', '0644444444', 0);

INSERT INTO `trajet` (`trajet_id`, `trajet_ville`, `trajet_date`, `trajet_heure`, `trajet_users_id`, `trajet_nbpassager_max`, `trajet_date_publication`) VALUES
(1, 'Lyon', '2025-01-10', '08:00:00', 2, 3, '2024-12-19 10:00:00'),
(2, 'Paris', '2025-01-12', '09:30:00', 3, 4, '2024-12-19 10:15:00'),
(3, 'Marseille', '2025-01-15', '07:45:00', 4, 2, '2024-12-19 10:30:00'),
(4, 'Toulouse', '2025-01-18', '18:00:00', 5, 3, '2024-12-19 11:00:00'),
(5, 'Bordeaux', '2025-01-20', '06:30:00', 6, 1, '2024-12-19 12:00:00'),
(6, 'Nantes', '2025-01-22', '17:15:00', 7, 4, '2024-12-19 13:00:00'),
(7, 'Strasbourg', '2025-01-25', '08:30:00', 8, 3, '2024-12-19 14:00:00'),
(8, 'Lille', '2025-01-28', '19:00:00', 9, 2, '2024-12-19 15:00:00'),
(9, 'Rennes', '2025-02-02', '07:00:00', 10, 4, '2024-12-19 16:00:00'),
(10, 'Montpellier', '2025-02-05', '16:45:00', 11, 3, '2024-12-19 17:00:00'),
(11, 'Lyon', '2025-02-08', '08:15:00', 12, 2, '2024-12-19 18:00:00'),
(12, 'Paris', '2025-02-10', '09:00:00', 13, 4, '2024-12-19 19:00:00'),
(13, 'Marseille', '2025-02-12', '18:30:00', 14, 3, '2024-12-19 20:00:00'),
(14, 'Toulouse', '2025-02-15', '07:30:00', 15, 1, '2024-12-19 21:00:00'),
(15, 'Bordeaux', '2025-02-18', '17:45:00', 2, 4, '2024-12-19 22:00:00'),
(16, 'Nice', '2025-03-01', '09:00:00', 2, 3, '2024-12-19 22:10:00'),
(17, 'Nantes', '2025-03-05', '14:00:00', 2, 2, '2024-12-19 22:20:00'),
(18, 'Dijon', '2025-03-10', '10:30:00', 2, 4, '2024-12-19 22:30:00'),
(19, 'Brest', '2025-03-15', '08:15:00', 2, 1, '2024-12-19 22:40:00'),
(20, 'Amiens', '2025-03-20', '16:45:00', 2, 3, '2024-12-19 22:50:00'),
(21, 'Lille', '2025-04-02', '07:00:00', 3, 2, '2024-12-19 23:00:00'),
(22, 'Rennes', '2025-04-08', '11:30:00', 3, 4, '2024-12-19 23:10:00'),
(23, 'Toulouse', '2025-04-12', '13:00:00', 3, 3, '2024-12-19 23:20:00'),
(24, 'Bordeaux', '2025-04-16', '09:45:00', 3, 2, '2024-12-19 23:30:00'),
(25, 'Marseille', '2025-04-20', '15:20:00', 3, 1, '2024-12-19 23:40:00');

INSERT INTO `passager` (`passager_id`, `passager_trajet_id`, `passager_un_users_id`, `passager_deux_users_id`, `passager_trois_users_id`, `passager_quatre_users_id`) VALUES
(1, 1, 4, 5, NULL, NULL),
(2, 2, 6, 7, 8, NULL),
(3, 3, 2, NULL, NULL, NULL),
(4, 4, 9, 10, NULL, NULL),
(5, 5, 11, NULL, NULL, NULL),
(6, 6, 12, 13, 14, 15),
(7, 7, 2, 3, NULL, NULL),
(8, 8, 4, NULL, NULL, NULL),
(9, 9, 5, 6, 7, NULL),
(10, 10, 8, 9, NULL, NULL),
(11, 11, 10, NULL, NULL, NULL),
(12, 12, 11, 14, 15, NULL),
(13, 13, 2, 4, NULL, NULL),
(14, 14, 6, NULL, NULL, NULL),
(15, 15, 7, 8, 9, 10),
(16, 16, 4, 5, NULL, NULL),
(17, 17, 6, NULL, NULL, NULL),
(18, 18, 7, 8, 9, NULL),
(19, 19, 10, NULL, NULL, NULL),
(20, 20, 11, 12, NULL, NULL),
(21, 21, 13, NULL, NULL, NULL),
(22, 22, 14, 15, 4, NULL),
(23, 23, 5, 6, NULL, NULL),
(24, 24, 7, NULL, NULL, NULL),
(25, 25, 8, NULL, NULL, NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
