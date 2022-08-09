-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 10 août 2022 à 01:54
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
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `isValidate` tinyint(1) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `isValidate`, `createdAt`, `updatedAt`, `user_id`, `post_id`) VALUES
(2, 'quelles sont les matières apprises ?', 1, '2022-02-24 10:35:19', '2022-02-24 10:35:19', 2, 3),
(10, 'Mon premier commentaire', 1, '2022-06-28 11:12:30', '2022-06-28 11:12:30', 1, 2),
(32, 'Oui, Twig est superbe pour gérer les vues !', 0, '2022-07-24 13:34:15', '2022-07-24 13:34:15', 1, 100),
(33, 'Comment initialiser un objet ?', 1, '2022-07-25 01:48:07', '2022-07-25 01:48:07', 1, 101),
(34, 'commentaire à valider', 1, '2022-07-25 01:53:53', '2022-07-25 01:53:53', 1, 101),
(35, 'commentaire non validé', 0, '2022-07-25 01:54:37', '2022-07-25 01:54:37', 1, 101);

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
  `updatedAt` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `chapo`, `media`, `isPublished`, `createdAt`, `updatedAt`, `user_id`) VALUES
(1, 'stage administratrice de BD', 'Un stagiaire en Administration de Bases de données doit effectuer les tâches suivantes:\r\n- gestion de systèmes d\'information\r\n- administration de bases de données\r\n- Surveillance de serveurs de bases de données\r\n- Rédaction de supports de formation\r\n', 'Un administrateur de bases de données doit d\'assurer du bon fonctionnement des bases de données et des serveurs de BD', 'dba.png', 1, '2022-02-23 14:35:09', '2022-07-09 00:14:09', 3),
(2, 'apprentie licence informatique ', 'Une licence professionnelle permet d\'acquérir des compétences et les pratiquer en même temps. \r\nC\'est une meilleure façon d\'apprendre et appréhender le milieu du travail. \r\nL\'apprenti est souvent confronté aux mêmes imprévus qu\'un employé confirmé.', 'Une licence professionnelle permet d\'acquérir des compétences et les pratiquer en même temps.', 'licence_pro.png', 1, '2022-02-23 16:46:32', '2022-07-28 14:22:11', 2),
(3, 'formation développement d\'application', 'Formation à distance financée par la Région Île-De-France.\r\nCette formation, permet d\'acquérir les compétences nécessaires pour devenir développeur d\'application en Symfony.', 'Formation à distance financée par la Région Île-De-France.', 'symfony_competences.png', 1, '2022-02-23 17:18:35', '2022-02-23 17:18:35', 1),
(25, 'Installer Wampserver en local', 'L\'installaion de wampserver se fait ...', 'installation de wampserver', '21_06_2022_12_00_19.png', 0, '0000-00-00 00:00:00', '2022-07-22 15:45:30', 1),
(99, 'Comment installer WampServer sur Windows 10', 'WAMP (Windows, Apache, MySQL et PHP) est une plateforme de développement web open source qui utilise Apache2, MySQL, MariaDB et PHP pour développer des applications web dynamiques sur le système d’exploitation Windows. D’ailleurs, WAMP peut être utilisé pour des tests internes et peut également servir à créer des sites web. La pile WAMP comporte quatre éléments clés d’un serveur Web qui comprend un système d’exploitation, une base de données, un serveur Web et un logiciel de script pour les développeurs. Donc, dans ce tutoriel, nous allons voir comment installer le serveur WAMP pour Windows 10. XAMPP est un autre alternatif de WAMP et c’est une distribution Apache facile à installer contenant MariaDB, PHP et Perl. Vous pouvez l’installer en suivant notre tutoriel d’installation. Etape 1- Télécharger Wampserver sur le site officiel Vous pouvez télécharger l’installateur du WAMP à partir du site officiel du WAMP sur www.wampserver.com.  Récemment, j’ai pu constater que le site officiel est souvent en panne. Si le site officiel du serveur WAMP ne s’ouvre pas, vous pouvez utiliser ce lien direct pour télécharger l’installateur depuis le site sourceforge.net. Etape 2- Faites défiler la page d’accueil de WampServer jusqu’à la section de téléchargement. Selon votre système, choisissez la version 32 bits ou 64 bits de l’installateur. Je choisis la version 64 bit, PHP 7 car c’est la dernière version de PHP. Ces captures d’écran ne seront pas les mêmes car elles changeront en fonction de la sortie de la version mise à jour du serveur WAMP. Actuellement, la dernière version de WAMP est la 3.2.0.', 'WAMP (Windows, Apache, MySQL et PHP) est une plateforme de développement web open source', '04_08_2022_17_22_12.jpg', 1, '2022-07-19 13:19:50', '2022-08-04 17:22:12', 1),
(100, 'Dynamisez vos vues à l\'aide de Twig', 'Voici pourquoi Twig est plus adapté que le PHP en tant que moteur de gabarit :il a une syntaxe beaucoup plus concise et claire;par défaut, il supporte de nombreuses fonctionnalités utiles, telles que la notion d\'héritage ; et il sécurise automatiquement vos variables.', 'Twig est un moteur de gabarit développé en PHP inclus par défaut avec le framework Symfony 5.', '04_08_2022_17_22_00.jpg', 1, '2022-07-19 13:27:45', '2022-08-04 17:22:00', 1),
(101, 'Les objets', 'Pour créer un nouvel objet, utilisez le mot clé new afin d\'instancier une classe :\r\n\r\n&lt;?php\r\nclass foo\r\n{\r\n    function do_foo()\r\n    {\r\n        echo &quot;Doing foo.&quot;;\r\n    }\r\n}\r\n\r\n$bar = new foo;\r\n$bar-&gt;do_foo();\r\n?&gt;', 'Initialisation des objets ', '19_07_2022 à 13_32_52.png', 0, '2022-07-19 13:32:52', '2022-07-28 14:55:23', 1),
(105, 'super globals', 'super globals', 'super globals', '28_07_2022_15_05_48.png', 1, '2022-07-25 01:38:47', '2022-07-28 15:05:48', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(45) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `role` enum('admin','user') COLLATE utf8_bin NOT NULL,
  `password` varchar(120) COLLATE utf8_bin NOT NULL,
  `isValidate` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `role`, `password`, `isValidate`) VALUES
(1, 'Djazaanti', 'djazaanti@gmail.com', 'admin', '$2y$10$Um0LJzZ1NMext25vIOg0jOGVv1RIBYlnmW9bbjLOfz9HnKY0Ku3kC', 1),
(2, 'Luna', 'luna@gmail.com', 'user', '$2y$10$F2MaI2tvMUnRnmbpr/E2U.ll1BFHHEwNrIQ9hRzieq7m6kOiz4d0y', 1),
(3, 'Izi', 'izi@gmail.com', 'user', '$2y$10$faI/8wk3OzIp1QWIxwdI5u2vmdNiHkxJKbMvwubRClFSOYc4xUpkS', 1),
(7, 'Durand', 'durand@gmail.com', 'user', 'durand11', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`user_id`,`post_id`),
  ADD KEY `fk_Comment_User1_idx` (`user_id`),
  ADD KEY `fk_Comment_Post1_idx` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_Post_User1_idx` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_Comment_Post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Comment_User1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_Post_User1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
