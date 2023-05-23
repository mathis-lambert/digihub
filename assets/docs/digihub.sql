-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 23 mai 2023 à 20:41
-- Version du serveur : 8.0.27
-- Version de PHP : 8.2.4

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
-- Structure de la table `appartient_genre`
--

DROP TABLE IF EXISTS `appartient_genre`;
CREATE TABLE IF NOT EXISTS `appartient_genre` (
  `appartientGenreId` int NOT NULL,
  `appartientMediaId` int NOT NULL,
  `appartenanceId` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`appartenanceId`),
  KEY `genreId` (`appartientGenreId`),
  KEY `appartientMediaId` (`appartientMediaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appartient_media`
--

DROP TABLE IF EXISTS `appartient_media`;
CREATE TABLE IF NOT EXISTS `appartient_media` (
  `appartientMediaId` int NOT NULL AUTO_INCREMENT,
  `_mediaId` int NOT NULL,
  `_peopleId` int NOT NULL,
  `_departmentName` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `characterName` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`appartientMediaId`),
  KEY `_mediaId` (`_mediaId`),
  KEY `_peopleId` (`_peopleId`),
  KEY `_departmentId` (`_departmentName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `commentId` int NOT NULL,
  `commentUserid` int NOT NULL,
  `commentMediaId` int NOT NULL,
  `commentTitle` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `commentText` text COLLATE utf8mb4_general_ci NOT NULL,
  `commentRating` int NOT NULL,
  `commentStatus` varchar(32) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ok',
  `commentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `mediaId` (`commentMediaId`),
  KEY `userId` (`commentUserid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `favoriteId` int NOT NULL AUTO_INCREMENT,
  `favoriteMediaId` int NOT NULL,
  `favoriteUserId` int NOT NULL,
  PRIMARY KEY (`favoriteId`),
  KEY `favoriteMediaId` (`favoriteMediaId`),
  KEY `favoriteUserId` (`favoriteUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `genreId` int NOT NULL,
  `genreName` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`genreId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `logId` int NOT NULL AUTO_INCREMENT,
  `logMessage` text COLLATE utf8mb4_general_ci NOT NULL,
  `logContext` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `logDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `mediaId` int NOT NULL AUTO_INCREMENT,
  `mediaTypeId` int NOT NULL,
  `mediaName` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `mediaDescription` text COLLATE utf8mb4_general_ci,
  `mediaAddedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mediaPublishingDate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mediaYear` int DEFAULT NULL,
  `mediaStatus` varchar(128) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'available',
  `mediaCoverImage` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mediaBackgroundImage` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mediaVideoLink` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mediaTags` varchar(228) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '[]',
  PRIMARY KEY (`mediaId`),
  KEY `mediaType` (`mediaTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `peoples`
--

DROP TABLE IF EXISTS `peoples`;
CREATE TABLE IF NOT EXISTS `peoples` (
  `peopleId` int NOT NULL AUTO_INCREMENT,
  `peopleFirstname` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleLastname` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleFullname` varchar(160) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleBirthday` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleDeathday` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleBiography` text COLLATE utf8mb4_general_ci,
  `peoplePicture` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleBirthplace` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `peopleKnownForDepartment` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`peopleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `typeId` int NOT NULL AUTO_INCREMENT,
  `typeName` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `typeStatus` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'available',
  `typeIcon` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userFirstname` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `userLastname` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `userBirthdate` datetime NOT NULL,
  `userMail` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `userRole` int NOT NULL DEFAULT '0',
  `userStatus` varchar(32) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ok',
  `userPassword` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `userCreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userFavoriteMediaType` int DEFAULT '1',
  `userFavoriteBookTag` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '[]',
  `userFavoriteMovieTag` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '[]',
  PRIMARY KEY (`userId`),
  KEY `favMediaType` (`userFavoriteMediaType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartient_genre`
--
ALTER TABLE `appartient_genre`
  ADD CONSTRAINT `appartient_genre_ibfk_1` FOREIGN KEY (`appartientMediaId`) REFERENCES `medias` (`mediaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genreId` FOREIGN KEY (`appartientGenreId`) REFERENCES `genres` (`genreId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `appartient_media`
--
ALTER TABLE `appartient_media`
  ADD CONSTRAINT `appartient_media_ibfk_1` FOREIGN KEY (`_mediaId`) REFERENCES `medias` (`mediaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `appartient_media_ibfk_2` FOREIGN KEY (`_peopleId`) REFERENCES `peoples` (`peopleId`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `mediaId` FOREIGN KEY (`commentMediaId`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `userId` FOREIGN KEY (`commentUserid`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`favoriteMediaId`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`favoriteUserId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

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
