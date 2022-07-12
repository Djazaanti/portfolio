-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 24 fév. 2022 à 10:38
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_bin NOT NULL,
  `content` longtext COLLATE utf8_bin NOT NULL,
  `chapo` mediumtext COLLATE utf8_bin NOT NULL,
  `media` varchar(50) COLLATE utf8_bin NOT NULL,
  `isPublished` tinyint(1) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAT` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `chapo`, `media`, `isPublished`, `createdAt`, `updatedAT`, `User_id`) VALUES
(1, 'stage administratrice de BD', 'Un stagiaire en Administration de Bases de données doit effectuer les tâches suivantes:\r\n- gestion de systèmes d\'information\r\n- administration de bases de données\r\n- Surveillance de serveurs de bases de données\r\n- Rédaction de supports de formation\r\n', 'Un administrateur de bases de données doit d\'assurer du bon fonctionnement des bases de données et des serveurs de BD', 'dba.png', 0, '2022-02-23 14:35:09', '2022-02-23 14:35:09', 1),
(2, 'apprentie licence informatique', 'Une licence professionnelle permet d\'acquérir des compétences et les pratiquer en même temps. \r\nC\'est une meilleure façon d\'apprendre et appréhender le milieu du travail. \r\nL\'apprenti est souvent confronté aux mêmes imprévus qu\'un employé confirmé.', 'Une licence professionnelle permet d\'acquérir des compétences et les pratiquer en même temps.', 'licence_pro.png', 1, '2022-02-23 16:46:32', '2022-02-23 16:46:32', 1),
(3, 'formation développement d\'application', 'Formation à distance financée par la Région Île-De-France.\r\nCette formation, permet d\'acquérir les compétences nécessaires pour devenir développeur d\'application en Symfony.', 'Formation à distance financée par la Région Île-De-France.', 'symfony_competences.png', 0, '2022-02-23 17:18:35', '2022-02-23 17:18:35', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `isValidate` tinyint(4) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `vote` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `isValidate`, `createdAt`, `updatedAt`, `vote`, `User_id`, `Post_id`) VALUES
(1, 'cool !', 0, '2022-02-24 10:35:19', '2022-02-24 10:35:19', 0, 5, 2),
(2, 'quelles sont les matières apprises ?', 1, '2022-02-24 10:35:19', '2022-02-24 10:35:19', 0, 4, 3),
(3, 'commentaire à supprimer', 0, '2022-02-24 10:36:59', '2022-02-24 10:36:59', 0, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(45) COLLATE utf8_bin NOT NULL,
  `role` enum('admin','autre') COLLATE utf8_bin NOT NULL,
  `password` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `role`, `password`) VALUES
(1, 'Djazaanti', 'admin', 'Djazaanti@11'),
(2, 'Luna', 'autre', 'Luna@11'),
(3, 'Izi', 'autre', 'Izi@12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`,`User_id`),
  ADD KEY `fk_Post_User1_idx` (`User_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`User_id`,`Post_id`),
  ADD KEY `fk_Comment_User1_idx` (`User_id`),
  ADD KEY `fk_Comment_Post1_idx` (`Post_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_Post_User1` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_Comment_Post1` FOREIGN KEY (`Post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Comment_User1` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
