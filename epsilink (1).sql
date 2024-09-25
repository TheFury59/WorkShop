-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 25 sep. 2024 à 12:24
-- Version du serveur : 9.0.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `epsilink`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `idComment` int NOT NULL AUTO_INCREMENT,
  `idPost` int NOT NULL,
  `idUser` int NOT NULL,
  `contenuComment` text NOT NULL,
  `dateCreation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idComment`),
  KEY `idPost` (`idPost`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `like_post`
--

DROP TABLE IF EXISTS `like_post`;
CREATE TABLE IF NOT EXISTS `like_post` (
  `idLike` int NOT NULL AUTO_INCREMENT,
  `idPost` int NOT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`idLike`),
  KEY `idPost` (`idPost`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

DROP TABLE IF EXISTS `publication`;
CREATE TABLE IF NOT EXISTS `publication` (
  `idPost` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `contenuPost` text NOT NULL,
  `dateCreation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPost`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`idPost`, `idUser`, `contenuPost`, `dateCreation`) VALUES
(1, 49, 'wesh bien ?', '2024-09-25 11:31:29');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `nomUser` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenomUser` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mdpUser` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mailUser` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tel` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUser`, `nomUser`, `prenomUser`, `mdpUser`, `mailUser`, `tel`, `Description`) VALUES
(1, 'beaucheron', 'martin', 'test', 'beaucheronmartin@gmail.com', NULL, 'test test etst'),
(2, 'debay', 'teo', 'test', 'debayteo@gmail.com', NULL, 'tetst tets te tqlbrqrgh'),
(49, 'Debay', 'téo', '$2y$10$jz/XDP7eROlWJ64SlC8vvOcevblwauy5JdlSgxeTsRVeDvzP59qqK', 'teodebaypro@gmail.com', '0894089857', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
