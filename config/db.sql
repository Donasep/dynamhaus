-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 oct. 2024 à 15:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dynamhaus`
--

-- --------------------------------------------------------

--
-- Structure de la table `ad`
--

CREATE DATABASE dynamhaus;

CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL,
  `adress` varchar(320) NOT NULL,
  `price` int(11) NOT NULL,
  `surface` int(11) NOT NULL,
  `gear` int(11) DEFAULT NULL,
  `application fee` int(11) DEFAULT NULL,
  `charges` int(11) DEFAULT NULL,
  `warranty` int(11) DEFAULT NULL,
  `availability date` datetime DEFAULT NULL,
  `description` varchar(2000) NOT NULL,
  `titre` varchar(350) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `furnished` tinyint(4) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `picture_picture_id` int(11) NOT NULL,
  `User_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `alert`
--

CREATE TABLE `alert` (
  `alert_id` int(11) NOT NULL,
  `adress` varchar(320) NOT NULL,
  `minimal_price` int(11) NOT NULL,
  `maximal_price` int(11) NOT NULL,
  `minimal_surface` int(11) NOT NULL,
  `maximal_surface` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `offert_type` int(11) NOT NULL,
  `appartement type` int(11) NOT NULL,
  `User_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `message` varchar(3200) NOT NULL,
  `read_state` tinyint(4) NOT NULL,
  `Conversation_conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `picture_id` int(11) NOT NULL,
  `picture_url` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `role` enum('STUDENT','ADMIN','AGENCY','RESIDENCE','INDIVIDUAL') NOT NULL DEFAULT 'STUDENT',
  `verified` tinyint(4) NOT NULL,
  `profilPicture` varchar(320) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_has_ad`
--

CREATE TABLE `user_has_ad` (
  `User_user_id` int(11) NOT NULL,
  `ad_ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_has_conversation`
--

CREATE TABLE `user_has_conversation` (
  `User_user_id` int(11) NOT NULL,
  `Conversation_conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ad`
--
ALTER TABLE `ad`
  ADD PRIMARY KEY (`ad_id`,`User_user_id`),
  ADD KEY `fk_ad_picture1_idx` (`picture_picture_id`),
  ADD KEY `fk_ad_User1_idx` (`User_user_id`);

--
-- Index pour la table `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`alert_id`,`User_user_id`),
  ADD KEY `fk_alert_User1_idx` (`User_user_id`);

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_message_Conversation1_idx` (`Conversation_conversation_id`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`picture_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `idUser_UNIQUE` (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Index pour la table `user_has_ad`
--
ALTER TABLE `user_has_ad`
  ADD PRIMARY KEY (`User_user_id`,`ad_ad_id`),
  ADD KEY `fk_User_has_ad_ad1_idx` (`ad_ad_id`),
  ADD KEY `fk_User_has_ad_User1_idx` (`User_user_id`);

--
-- Index pour la table `user_has_conversation`
--
ALTER TABLE `user_has_conversation`
  ADD PRIMARY KEY (`User_user_id`,`Conversation_conversation_id`),
  ADD KEY `fk_User_has_Conversation_Conversation1_idx` (`Conversation_conversation_id`),
  ADD KEY `fk_User_has_Conversation_User1_idx` (`User_user_id`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ad`
--
ALTER TABLE `ad`
  ADD CONSTRAINT `fk_ad_User1` FOREIGN KEY (`User_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ad_picture1` FOREIGN KEY (`picture_picture_id`) REFERENCES `picture` (`picture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `alert`
--
ALTER TABLE `alert`
  ADD CONSTRAINT `fk_alert_User1` FOREIGN KEY (`User_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_Conversation1` FOREIGN KEY (`Conversation_conversation_id`) REFERENCES `conversation` (`conversation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_has_ad`
--
ALTER TABLE `user_has_ad`
  ADD CONSTRAINT `fk_User_has_ad_User1` FOREIGN KEY (`User_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_has_ad_ad1` FOREIGN KEY (`ad_ad_id`) REFERENCES `ad` (`ad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_has_conversation`
--
ALTER TABLE `user_has_conversation`
  ADD CONSTRAINT `fk_User_has_Conversation_Conversation1` FOREIGN KEY (`Conversation_conversation_id`) REFERENCES `conversation` (`conversation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_has_Conversation_User1` FOREIGN KEY (`User_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;