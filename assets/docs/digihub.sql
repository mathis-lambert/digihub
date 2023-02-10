-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 11 fév. 2023 à 00:40
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
-- Structure de la table `authors`
--

CREATE TABLE `authors` (
  `authorId` int(11) NOT NULL,
  `authorFirstname` varchar(80) NOT NULL,
  `authorLastname` varchar(80) NOT NULL,
  `authorBirthdate` datetime NOT NULL,
  `authorBiography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `authors`
--

INSERT INTO `authors` (`authorId`, `authorFirstname`, `authorLastname`, `authorBirthdate`, `authorBiography`) VALUES
(1, 'Georges', 'Lucas', '1944-05-14 00:00:00', 'George Lucas /d͡ʒɔːɹd͡ʒ lukəs/Note 1 est un réalisateur, scénariste et producteur américain né le 14 mai 1944 à Modesto en Californie.\r\n\r\nIssu de l\'école de cinéma de l\'université de Californie du Sud à Los Angeles, il cofonde avec son ami Francis Ford Coppola le studio American Zoetrope puis crée sa propre société de production : Lucasfilm. Il commence sa carrière de réalisateur avec les films THX 1138 en 1971 et American Graffiti en 1973. Il connaît ensuite la consécration avec les deux premières trilogies cinématographiques Star WarsNote 2.');

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
  `mediaAuthorId` int(11) NOT NULL,
  `mediaTags` varchar(228) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`mediaId`, `mediaTypeId`, `mediaName`, `mediaShortDesc`, `mediaLongDesc`, `mediaAddedDate`, `mediaPublishingDate`, `mediaStatus`, `mediaCoverImage`, `mediaBackgroundImage`, `mediaAuthorId`, `mediaTags`) VALUES
(1, 1, 'Star Wars, épisode IV : Un nouvel espoir', 'La Guerre des étoiles est un film américain de science-fiction sorti en 1977 écrit et réalisé par George Lucas.', 'La Guerre des étoiles (Star Wars) est un film américain de science-fiction de type space opera sorti en 1977 écrit et réalisé par George Lucas. À partir de 1981, il est exploité sous le nom Star Wars, épisode IV : Un nouvel espoir (Star Wars: Episode IV – A New Hope).\r\n\r\nC\'est le premier opus de la saga Star Wars par sa date de sortie, mais le quatrième selon l\'ordre chronologique de l\'histoire. Il est le premier volet de la trilogie originale qui est constituée également des films L\'Empire contre-attaque et Le Retour du Jedi. Ce film est aussi le troisième long métrage réalisé par Lucas.\r\n\r\nL\'histoire de cet épisode se déroule presque dix-neuf ansNote 1 après les événements de La Revanche des Sith (sorti en 2005), et juste après ceux de Rogue One (sorti en 2016). L\'intrigue se concentre sur l\'Alliance rebelle, une organisation qui tente de détruire la station spatiale Étoile noire, l\'arme absolue du très autoritaire Empire galactique. Mêlé malgré lui à ce conflit galactique, le jeune ouvrier agricole Luke Skywalker s\'engage au sein des forces rebelles après le massacre de sa famille par des soldats impériaux. Initié aux pouvoirs de la Force par son mentor Obi-Wan Kenobi, trop tôt assassiné par le maléfique Dark Vador, Luke utilise ses nouveaux dons pour détruire l\'Étoile noire à la fin du film.', '2023-02-10 23:41:37', '1977-01-01 00:00:00', 'available', './assets/img/cover/star-wars-un-nouvel-espoir.jpg', './assets/img/bg_img/star-wars-un-nouvel-espoir-bg.jpg', 1, '[\"star wars\", \"george lucas\", \"un nouvel espoir\", 1977]');

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
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logId`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`mediaId`),
  ADD KEY `mediaType` (`mediaTypeId`),
  ADD KEY `AuthorId` (`mediaAuthorId`);

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
-- AUTO_INCREMENT pour la table `authors`
--
ALTER TABLE `authors`
  MODIFY `authorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `mediaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `AuthorId` FOREIGN KEY (`mediaAuthorId`) REFERENCES `authors` (`authorId`) ON UPDATE CASCADE,
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
