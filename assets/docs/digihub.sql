-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 14 fév. 2023 à 11:53
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
  `authorBiography` text NOT NULL,
  `authorPicture` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `authors`
--

INSERT INTO `authors` (`authorId`, `authorFirstname`, `authorLastname`, `authorBirthdate`, `authorBiography`, `authorPicture`) VALUES
(1, 'Georges', 'Lucas', '1944-05-14 00:00:00', 'George Lucas /d͡ʒɔːɹd͡ʒ lukəs/Note 1 est un réalisateur, scénariste et producteur américain né le 14 mai 1944 à Modesto en Californie.\r\n\r\nIssu de l\'école de cinéma de l\'université de Californie du Sud à Los Angeles, il cofonde avec son ami Francis Ford Coppola le studio American Zoetrope puis crée sa propre société de production : Lucasfilm. Il commence sa carrière de réalisateur avec les films THX 1138 en 1971 et American Graffiti en 1973. Il connaît ensuite la consécration avec les deux premières trilogies cinématographiques Star WarsNote 2.', ''),
(2, 'Jeffrey Jacob', 'Abrams', '1966-06-27 00:00:00', 'Jeffrey Jacob Abrams [ˈʤɛfri ˈʤeɪkəb ˈeɪbrəmz], plus connu comme J. J. Abrams [ˈʤeɪ. ʤeɪ. ˈeɪbrəmz], né le 27 juin 1966 à New York, est un scénariste, réalisateur, producteur, compositeur et acteur américain connu pour son travail dans les genres de l\'action, du drame et de la science-fiction.', ''),
(3, 'Christopher', 'Nolan', '1970-07-30 00:00:00', 'Christopher Nolan, né le 30 juillet 1970 à Westminster, est un réalisateur, scénariste, monteur et producteur de cinéma britannico-américain. Ses films ont rapporté plus de 5 milliards de dollars dans le monde et ont obtenu onze Oscars sur trente-six nominations.', ''),
(4, 'Stephen', 'King', '1947-09-21 00:00:00', 'Stephen King [ˈstiːvən kɪŋ]N 1, né le 21 septembre 1947 à Portland dans le Maine, est un écrivain américain.\r\n\r\nIl publie son premier roman en 1974 et devient rapidement célèbre pour ses contributions dans le domaine de l\'horreur mais écrit également des livres relevant d\'autres genres comme le fantastique, la fantasy, la science-fiction et le roman policier. Tout au long de sa carrière, il écrit et publie plus de soixante romans, dont sept sous le nom de plume de Richard Bachman, et plus de deux cents nouvelles, dont plus de la moitié sont réunies dans douze recueils de nouvelles. Après son grave accident en 1999, il ralentit son rythme d\'écriture. Ses livres se sont vendus à plus de 350 millions d\'exemplaires à travers le monde1 et il établit de nouveaux records de ventes dans le domaine de l\'édition durant les années 1980, décennie où sa popularité atteint son apogée.', '');

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
  `mediaShortDesc` varchar(300) NOT NULL,
  `mediaLongDesc` text NOT NULL,
  `mediaAddedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `mediaPublishingDate` datetime NOT NULL,
  `mediaYear` int(4) NOT NULL,
  `mediaStatus` varchar(128) NOT NULL,
  `mediaCoverImage` varchar(128) NOT NULL,
  `mediaBackgroundImage` varchar(128) NOT NULL,
  `mediaAuthorId` int(11) NOT NULL,
  `mediaTags` varchar(228) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`mediaId`, `mediaTypeId`, `mediaName`, `mediaShortDesc`, `mediaLongDesc`, `mediaAddedDate`, `mediaPublishingDate`, `mediaYear`, `mediaStatus`, `mediaCoverImage`, `mediaBackgroundImage`, `mediaAuthorId`, `mediaTags`) VALUES
(1, 1, 'Star Wars, épisode IV : Un nouvel espoir', 'La Guerre des étoiles est un film américain de science-fiction sorti en 1977 écrit et réalisé par George Lucas.', 'La Guerre des étoiles (Star Wars) est un film américain de science-fiction de type space opera sorti en 1977 écrit et réalisé par George Lucas. À partir de 1981, il est exploité sous le nom Star Wars, épisode IV : Un nouvel espoir (Star Wars: Episode IV – A New Hope).\r\n\r\nC\'est le premier opus de la saga Star Wars par sa date de sortie, mais le quatrième selon l\'ordre chronologique de l\'histoire. Il est le premier volet de la trilogie originale qui est constituée également des films L\'Empire contre-attaque et Le Retour du Jedi. Ce film est aussi le troisième long métrage réalisé par Lucas.\r\n\r\nL\'histoire de cet épisode se déroule presque dix-neuf ansNote 1 après les événements de La Revanche des Sith (sorti en 2005), et juste après ceux de Rogue One (sorti en 2016). L\'intrigue se concentre sur l\'Alliance rebelle, une organisation qui tente de détruire la station spatiale Étoile noire, l\'arme absolue du très autoritaire Empire galactique. Mêlé malgré lui à ce conflit galactique, le jeune ouvrier agricole Luke Skywalker s\'engage au sein des forces rebelles après le massacre de sa famille par des soldats impériaux. Initié aux pouvoirs de la Force par son mentor Obi-Wan Kenobi, trop tôt assassiné par le maléfique Dark Vador, Luke utilise ses nouveaux dons pour détruire l\'Étoile noire à la fin du film.', '2023-02-10 23:41:37', '1977-01-01 00:00:00', 1977, 'available', 'star-wars-un-nouvel-espoir.jpeg', 'star-wars-4.jpg', 1, '[\"star wars\", \"george lucas\", \"un nouvel espoir\", 1977, \"star wars 4\"]'),
(2, 1, 'Star Wars, épisode IX : L\'Ascension de Skywalker', 'Star Wars IX : L\'Ascension de Skywalker est un film de science-fiction américain réalisé par J. J. Abrams, sorti en 2019.', 'Star Wars, épisode IX : L\'Ascension de Skywalker (Star Wars: Episode IX – The Rise of Skywalker) est un film de science-fiction américain de type space opera coécrit et réalisé par J. J. Abrams, sorti en 2019.\r\n\r\nNeuvième et dernier opus de la saga Star Wars (famille Skywalker), il fait suite à l\'épisode VIII : Les Derniers Jedi. Colin Trevorrow était attaché à l\'écriture et à la réalisation de ce film depuis 2015, jusqu\'à son départ en septembre 2017. Lucasfilm a dès lors fait revenir le réalisateur du premier épisode de cette nouvelle trilogie. Ce neuvième et dernier épisode de la saga Skywalker est celui du combat final entre la Résistance et les Sith, emmenés par l\'Empereur Sheev Palpatine qui a survécu après avoir été projeté dans un puits d\'énergie de l\'Étoile de la Mort par Dark Vador dans l\'épisode VI. Rey, qui a poursuivi sa formation de Jedi auprès de Leia Organa, apprend qu\'elle est la petite-fille de Sheev Palpatine, ce qui explique pourquoi la Force est si puissante en elle. À travers de nombreuses péripéties et son combat avec Kylo Ren, elle va devoir affronter l\'Empereur et le vaincre pour ramener la paix dans la galaxie.', '2023-02-11 17:16:37', '2019-12-21 00:00:00', 2019, 'available', 'star-wars-9-cover.jpg', 'star-wars-9.jpg', 2, '[\"star wars\", 9, \"JJ Abrams\", \"SF\", \"Science fiction\", 2019]'),
(3, 1, 'Interstellar', 'Une équipe d\'astronautes franchit un trou de ver apparu près de Saturne et conduisant à une autre galaxie.', 'Interstellar, ou Interstellaire1 au Québec et au Nouveau-Brunswick, est un film de science-fiction britannico-américain produit, écrit et réalisé par Christopher Nolan, sorti en 2014.\r\n\r\nIl met en scène Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine, Casey Affleck et Matt Damon.\r\n\r\nAlors que la Terre se meurt, une équipe d\'astronautes franchit un trou de ver apparu près de Saturne et conduisant à une autre galaxie, afin d\'explorer un nouveau système stellaire dans l\'espoir de trouver une planète habitable et d\'y établir une colonie spatiale pour sauver l\'humanité.', '2023-02-11 17:24:06', '2014-07-11 00:00:00', 2014, 'available', 'interstellar.jpg', 'interstellar.jpeg', 3, '[\"interstellar\", \"nolan\", 2014, \"sf\", \"espace\", \"voyage\", \"interstellaire\"]'),
(4, 2, 'La Ligne verte (roman)', 'La Ligne verte (titre original : The Green Mile), est un roman-feuilleton fantastique écrit par Stephen King et édité initialement en six épisodes en 1996.', 'La Ligne verte (titre original : The Green Mile), est un roman-feuilleton fantastique écrit par Stephen King et édité initialement en six épisodes en 1996. L\'histoire se déroule dans les années 1930 et est celle de Paul Edgecombe, responsable du couloir de la mort dans une prison, et de sa rencontre avec John Caffey (Coffey dans la version originale), un condamné à mort qui dispose d\'extraordinaires pouvoirs guérisseurs. Ce roman, qui est aussi une réflexion sur la peine de mort, a remporté le prix Bram Stoker 1996. Stephen King a voulu, avec ce livre, renouer avec le style un peu disparu du roman-feuilleton et a entrepris cette expérience sans aucune idée ni du nombre d\'épisodes qu\'il allait écrire, ni de la tournure qu\'allait prendre l\'histoire.', '2023-02-13 16:31:32', '1996-08-01 00:00:00', 1996, 'available', 'la-ligne-verte.jpeg', 'la-ligne-verte.jpeg', 4, '[\"bestseller\", \"roman\", \"the green mile\", \"stephen king\", \"fantastique\", \"sf\", \"science fiction\"]');

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
(1, 'Film', 'available', 'movie'),
(2, 'Livre', 'available', 'book'),
(3, 'Bande Dessinée ', 'available', 'book');

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
  MODIFY `authorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `mediaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
