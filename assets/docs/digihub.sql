-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 26 jan. 2023 à 15:35
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `digihub`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `commentUserid` int(11) NOT NULL,
  `commentMediaId` int(11) NOT NULL,
  `commentTitle` varchar(256) NOT NULL,
  `commentText` text NOT NULL,
  `commentRating` int(1) NOT NULL,
  `commentStatus` varchar(32) NOT NULL DEFAULT 'ok',
  `commentDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `logId` int(11) NOT NULL,
  `logMessage` text NOT NULL,
  `logContext` varchar(128) NOT NULL,
  `logDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `mediaId` int(11) NOT NULL,
  `mediaTypeId` int(11) NOT NULL,
  `mediaName` varchar(128) NOT NULL,
  `mediaShortDesc` varchar(128) NOT NULL,
  `mediaLongDesc` text NOT NULL,
  `mediaAddedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `mediaPublishingDate` datetime NOT NULL,
  `mediaStatus` varchar(128) NOT NULL,
  `mediaCoverImage` varchar(128) NOT NULL,
  `mediaBackgroundImage` varchar(128) NOT NULL,
  `mediaAuthor` varchar(128) NOT NULL,
  `mediaTags` varchar(228) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `typeId` int(11) NOT NULL,
  `typeName` varchar(64) NOT NULL,
  `typeStatus` varchar(64) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`typeId`, `typeName`, `typeStatus`) VALUES
(1, 'Film', 'available'),
(2, 'Livre', 'available'),
(3, 'Bande Dessinée ', 'available');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userFirstname` varchar(64) NOT NULL,
  `userLastname` varchar(64) NOT NULL,
  `userBirthdate` datetime NOT NULL,
  `userMail` varchar(128) NOT NULL,
  `userRole` int(11) NOT NULL DEFAULT 0,
  `userStatus` varchar(32) NOT NULL DEFAULT 'ok',
  `userPassword` varchar(512) NOT NULL,
  `userCreationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `userFavoriteMediaType` int(11) NOT NULL,
  `userFavoriteBookTag` varchar(64) NOT NULL DEFAULT '[]',
  `userFavoriteMovieTag` varchar(64) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD KEY `mediaId` (`commentMediaId`),
  ADD KEY `userId` (`commentUserid`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logId`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`mediaId`),
  ADD KEY `mediaType` (`mediaTypeId`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`typeId`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `favMediaType` (`userFavoriteMediaType`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `mediaId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `mediaId` FOREIGN KEY (`commentMediaId`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `userId` FOREIGN KEY (`commentUserid`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `mediaType` FOREIGN KEY (`mediaTypeId`) REFERENCES `types` (`typeId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `favMediaType` FOREIGN KEY (`userFavoriteMediaType`) REFERENCES `types` (`typeId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
