-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 26 sep. 2024 à 14:13
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.20

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

CREATE TABLE `commentaire` (
  `idComment` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `contenuComment` text NOT NULL,
  `dateCreation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `like_post`
--

CREATE TABLE `like_post` (
  `idLike` int(11) NOT NULL,
  `idPost` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `dateLike` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `idPost` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `contenuPost` text NOT NULL,
  `dateCreation` timestamp NULL DEFAULT current_timestamp(),
  `imagePost` longblob DEFAULT NULL,
  `campusHashtag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUser` int(11) NOT NULL,
  `nomUser` varchar(50) DEFAULT NULL,
  `prenomUser` varchar(50) DEFAULT NULL,
  `mdpUser` varchar(255) DEFAULT NULL,
  `mailUser` varchar(50) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `photoProfil` longblob DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `like_post`
--
ALTER TABLE `like_post`
  ADD PRIMARY KEY (`idLike`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `like_post`
--
ALTER TABLE `like_post`
  MODIFY `idLike` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `like_post`
--
ALTER TABLE `like_post`
  ADD CONSTRAINT `like_post_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `publication` (`idPost`),
  ADD CONSTRAINT `like_post_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
