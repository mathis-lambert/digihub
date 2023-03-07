-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 07 mars 2023 à 12:08
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
-- Structure de la table `actors`
--

CREATE TABLE `actors` (
  `actorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appartient_actor`
--

CREATE TABLE `appartient_actor` (
  `appartientActorId` int(11) NOT NULL,
  `appartientActor_ID` int(11) NOT NULL,
  `appartientMedia_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appartient_author`
--

CREATE TABLE `appartient_author` (
  `appartenanceId` int(11) NOT NULL,
  `appartientMediaId` int(11) NOT NULL,
  `appartientAuthorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `appartient_genre`
--

CREATE TABLE `appartient_genre` (
  `appartientGenreId` int(11) NOT NULL,
  `appartientMediaId` int(11) NOT NULL,
  `appartenanceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE `authors` (
  `authorId` int(11) NOT NULL,
  `authorFirstname` varchar(80) DEFAULT NULL,
  `authorLastname` varchar(80) DEFAULT NULL,
  `authorBirthdate` varchar(30) DEFAULT NULL,
  `authorBiography` text DEFAULT NULL,
  `authorPicture` varchar(300) DEFAULT NULL,
  `authorDepartment` varchar(80) DEFAULT NULL,
  `authorBirthplace` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Structure de la table `favoritesMediasList`
--

CREATE TABLE `favoritesMediasList` (
  `favoriteId` int(11) NOT NULL,
  `favoriteMediaId` int(11) NOT NULL,
  `favoriteUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `genreId` int(11) NOT NULL,
  `genreName` varchar(60) NOT NULL
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
  `mediaDescription` text DEFAULT NULL,
  `mediaAddedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `mediaPublishingDate` varchar(30) NOT NULL DEFAULT '2000-01-01',
  `mediaYear` int(4) NOT NULL DEFAULT 2000,
  `mediaStatus` varchar(128) NOT NULL DEFAULT 'available',
  `mediaCoverImage` varchar(128) DEFAULT NULL,
  `mediaBackgroundImage` varchar(128) DEFAULT NULL,
  `mediaTags` varchar(228) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `typeId` int(11) NOT NULL,
  `typeName` varchar(64) NOT NULL,
  `typeStatus` varchar(64) NOT NULL DEFAULT 'available',
  `typeIcon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`typeId`, `typeName`, `typeStatus`, `typeIcon`) VALUES
(1, 'default', 'available', 'default'),
(2, 'Film', 'available', 'movie'),
(3, 'Livre', 'available', 'book'),
(4, 'Bande Dessinée ', 'available', 'book');

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
  `userFavoriteMediaType` int(11) DEFAULT 1,
  `userFavoriteBookTag` varchar(64) NOT NULL DEFAULT '[]',
  `userFavoriteMovieTag` varchar(64) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actorId`);

--
-- Index pour la table `appartient_actor`
--
ALTER TABLE `appartient_actor`
  ADD PRIMARY KEY (`appartientActorId`),
  ADD KEY `appartientActor_ID` (`appartientActor_ID`),
  ADD KEY `appartientMedia_ID` (`appartientMedia_ID`);

--
-- Index pour la table `appartient_author`
--
ALTER TABLE `appartient_author`
  ADD PRIMARY KEY (`appartenanceId`),
  ADD KEY `appartientMediaId` (`appartientMediaId`),
  ADD KEY `appartientAuthorId` (`appartientAuthorId`);

--
-- Index pour la table `appartient_genre`
--
ALTER TABLE `appartient_genre`
  ADD PRIMARY KEY (`appartenanceId`),
  ADD KEY `genreId` (`appartientGenreId`),
  ADD KEY `appartientMediaId` (`appartientMediaId`);

--
-- Index pour la table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`authorId`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD KEY `mediaId` (`commentMediaId`),
  ADD KEY `userId` (`commentUserid`);

--
-- Index pour la table `favoritesMediasList`
--
ALTER TABLE `favoritesMediasList`
  ADD PRIMARY KEY (`favoriteId`),
  ADD KEY `favoriteMediaId` (`favoriteMediaId`),
  ADD KEY `favoriteUserId` (`favoriteUserId`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genreId`);

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
-- AUTO_INCREMENT pour la table `actors`
--
ALTER TABLE `actors`
  MODIFY `actorId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `appartient_actor`
--
ALTER TABLE `appartient_actor`
  MODIFY `appartientActorId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `appartient_author`
--
ALTER TABLE `appartient_author`
  MODIFY `appartenanceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `appartient_genre`
--
ALTER TABLE `appartient_genre`
  MODIFY `appartenanceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favoritesMediasList`
--
ALTER TABLE `favoritesMediasList`
  MODIFY `favoriteId` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartient_actor`
--
ALTER TABLE `appartient_actor`
  ADD CONSTRAINT `appartient_actor_ibfk_1` FOREIGN KEY (`appartientActor_ID`) REFERENCES `actors` (`actorId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `appartient_actor_ibfk_2` FOREIGN KEY (`appartientMedia_ID`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `appartient_author`
--
ALTER TABLE `appartient_author`
  ADD CONSTRAINT `appartient_author_ibfk_1` FOREIGN KEY (`appartientMediaId`) REFERENCES `medias` (`mediaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appartient_author_ibfk_2` FOREIGN KEY (`appartientAuthorId`) REFERENCES `authors` (`authorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `appartient_genre`
--
ALTER TABLE `appartient_genre`
  ADD CONSTRAINT `appartient_genre_ibfk_1` FOREIGN KEY (`appartientMediaId`) REFERENCES `medias` (`mediaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genreId` FOREIGN KEY (`appartientGenreId`) REFERENCES `genres` (`genreId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `mediaId` FOREIGN KEY (`commentMediaId`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `userId` FOREIGN KEY (`commentUserid`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `favoritesMediasList`
--
ALTER TABLE `favoritesMediasList`
  ADD CONSTRAINT `favoritesmediaslist_ibfk_1` FOREIGN KEY (`favoriteMediaId`) REFERENCES `medias` (`mediaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favoritesmediaslist_ibfk_2` FOREIGN KEY (`favoriteUserId`) REFERENCES `users` (`userId`) ON UPDATE CASCADE;

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
