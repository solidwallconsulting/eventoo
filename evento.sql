-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 jan. 2022 à 08:49
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `evento`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `functionnality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_index` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `client_name`, `civility`, `functionnality`, `country_index`, `logo_url`) VALUES
(1, 2, 'Jason stathem', 'Mr', 'actor', '+216', '/assets/img/clients/61c42eae6d0e1.png'),
(2, 3, 'Jason stathem', 'Mr', 'actor', '+216', '/assets/img/clients/logos/61c4421c631a7.png'),
(3, 4, 'chourabiDev', 'Mr', 'Dev', '+216', '/assets/img/clients/logos/61c99820d0f0e.png');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211115081325', '2021-11-15 09:13:27', 5142),
('DoctrineMigrations\\Version20211115084015', '2021-11-15 09:40:20', 1105),
('DoctrineMigrations\\Version20211115084154', '2021-11-15 09:42:00', 1307),
('DoctrineMigrations\\Version20211115112732', '2021-11-15 12:27:36', 957),
('DoctrineMigrations\\Version20211115113531', '2021-11-15 12:35:33', 669),
('DoctrineMigrations\\Version20211115131134', '2021-11-15 14:11:39', 972),
('DoctrineMigrations\\Version20211115131341', '2021-11-15 14:13:44', 722),
('DoctrineMigrations\\Version20211221090502', '2021-12-21 10:05:04', 257),
('DoctrineMigrations\\Version20211221100446', '2021-12-21 11:04:51', 1702),
('DoctrineMigrations\\Version20211221111030', '2021-12-21 12:10:36', 1408),
('DoctrineMigrations\\Version20211221130823', '2021-12-21 14:08:27', 681),
('DoctrineMigrations\\Version20211221130958', '2021-12-21 14:10:02', 1805),
('DoctrineMigrations\\Version20211222115707', '2021-12-22 12:57:12', 244),
('DoctrineMigrations\\Version20211222124411', '2021-12-22 13:44:16', 284),
('DoctrineMigrations\\Version20211222124842', '2021-12-22 13:48:46', 1435),
('DoctrineMigrations\\Version20211222131334', '2021-12-22 14:13:47', 288),
('DoctrineMigrations\\Version20211222133041', '2021-12-22 14:30:46', 1550),
('DoctrineMigrations\\Version20211222134809', '2021-12-22 14:48:14', 1588),
('DoctrineMigrations\\Version20211222142032', '2021-12-22 15:20:35', 297),
('DoctrineMigrations\\Version20211222142521', '2021-12-22 15:25:23', 1530),
('DoctrineMigrations\\Version20211223083857', '2021-12-23 09:39:06', 507),
('DoctrineMigrations\\Version20211223091323', '2021-12-23 10:13:27', 100),
('DoctrineMigrations\\Version20211223100520', '2021-12-23 11:05:23', 2370),
('DoctrineMigrations\\Version20220110113303', '2022-01-10 12:33:11', 75),
('DoctrineMigrations\\Version20220110120547', '2022-01-10 13:05:51', 41),
('DoctrineMigrations\\Version20220110121128', '2022-01-10 13:11:31', 73),
('DoctrineMigrations\\Version20220110125343', '2022-01-10 13:53:48', 69),
('DoctrineMigrations\\Version20220110130830', '2022-01-10 14:08:34', 32),
('DoctrineMigrations\\Version20220110132937', '2022-01-10 14:29:45', 86);

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_subscribers_number` int(11) NOT NULL,
  `events_length_in_days` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `type_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streaming_platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `steaming_link` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `access_type_id` int(11) DEFAULT NULL,
  `event_accessibility_id` int(11) DEFAULT NULL,
  `will_be_available_for_nmonths_id` int(11) DEFAULT NULL,
  `event_lng_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `name`, `total_subscribers_number`, `events_length_in_days`, `start_date`, `end_date`, `type_zone`, `location`, `client_id`, `description`, `photo_url`, `streaming_platform`, `steaming_link`, `type_id`, `access_type_id`, `event_accessibility_id`, `will_be_available_for_nmonths_id`, `event_lng_id`) VALUES
(1, 'The expandables 4', 300, 4, '2021-12-22 12:35:00', '2021-11-18 12:35:00', 'Africa/Abidjan', 'Tunis hotel africa', 1, '<p>hi</p>', '/assets/img/clients/logos/61c4a816b74f5.png', '1', '<iframe width=\"683\" height=\"384\" src=\"https://www.youtube.com/embed/0n_67bM-WMw?list=RD0n_67bM-WMw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', NULL, NULL, NULL, NULL, NULL),
(2, 'MamaMia', 1, 7, '2021-11-15 14:12:00', '2021-11-15 14:12:00', 'Africa/Freetown', 'Tunis hotel africa', 1, '<p>hi</p>', '/assets/img/clients/logos/6194c780bfb00.png', '1', '<iframe width=\"683\" height=\"384\" src=\"https://www.youtube.com/embed/0n_67bM-WMw?list=RD0n_67bM-WMw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', NULL, NULL, NULL, NULL, NULL),
(3, 'demo', 3000, 3, '2021-11-17 15:06:00', '2021-11-20 15:05:00', 'Africa/Douala', 'Tunis hotel africa', 1, '<p>test</p>\r\n\r\n<ul>\r\n	<li>xwxwx</li>\r\n	<li>wx</li>\r\n	<li>wxwxw</li>\r\n</ul>\r\n\r\n<p><strong>sdsdsdsdsd qsqsqs</strong></p>', '/assets/img/clients/logos/61950d1773858.png', '1', '<iframe width=\"683\" height=\"384\" src=\"https://www.youtube.com/embed/0n_67bM-WMw?list=RD0n_67bM-WMw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', NULL, NULL, NULL, NULL, NULL),
(4, 'last demo', 5, 5, '2021-12-22 10:27:00', '2021-12-22 10:28:00', 'Africa/Algiers', 'Tunis hotel africa', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'OMG', 3, 6, '2021-12-22 10:42:00', '2021-12-22 10:42:00', 'Africa/Asmara', 'Tunis hotel africa', 1, '<p>hi</p>', NULL, '1', '<iframe width=\"683\" height=\"384\" src=\"https://www.youtube.com/embed/0n_67bM-WMw?list=RD0n_67bM-WMw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', NULL, NULL, NULL, NULL, NULL),
(6, 'The expandables 4', 1, 4, '2021-12-23 10:47:00', '2021-12-23 10:47:00', 'Africa/Abidjan', 'Tunis hotel africa', 2, '<p>hi</p>', '/assets/img/clients/logos/61c445f737611.png', '1', '<iframe width=\"683\" height=\"384\" src=\"https://www.youtube.com/embed/0n_67bM-WMw?list=RD0n_67bM-WMw\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 1, 1, 2, 1, 1),
(7, 'OMG', 500, 3, '2021-12-27 11:44:00', '2021-12-30 11:44:00', 'Africa/Abidjan', 'tunis', 3, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `events_accessibility`
--

CREATE TABLE `events_accessibility` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events_accessibility`
--

INSERT INTO `events_accessibility` (`id`, `name`) VALUES
(1, 'Public'),
(2, 'Private'),
(3, 'hidden');

-- --------------------------------------------------------

--
-- Structure de la table `events_access_types`
--

CREATE TABLE `events_access_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events_access_types`
--

INSERT INTO `events_access_types` (`id`, `name`) VALUES
(1, 'Payed'),
(2, 'Free'),
(3, 'Free & payed');

-- --------------------------------------------------------

--
-- Structure de la table `events_durations`
--

CREATE TABLE `events_durations` (
  `id` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events_durations`
--

INSERT INTO `events_durations` (`id`, `duration`) VALUES
(1, 3),
(2, 0),
(3, 6),
(4, 12);

-- --------------------------------------------------------

--
-- Structure de la table `events_languages`
--

CREATE TABLE `events_languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events_languages`
--

INSERT INTO `events_languages` (`id`, `name`) VALUES
(1, 'French'),
(2, 'English'),
(3, 'Arabe');

-- --------------------------------------------------------

--
-- Structure de la table `event_profile_feilds`
--

CREATE TABLE `event_profile_feilds` (
  `id` int(11) NOT NULL,
  `label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `lingne_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event_profile_feilds`
--

INSERT INTO `event_profile_feilds` (`id`, `label_fr`, `label_en`, `required`, `event_id`, `lingne_order`) VALUES
(8, 'Télephone', 'Phone number', 0, 2, 1),
(9, 'Télephone', 'Phone number', 0, 3, 1),
(10, 'Nom', 'Name', 0, 1, 1),
(11, 'type', 'type', 1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `event_profile_feild_value`
--

CREATE TABLE `event_profile_feild_value` (
  `id` int(11) NOT NULL,
  `event_feild_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event_profile_feild_value`
--

INSERT INTO `event_profile_feild_value` (`id`, `event_feild_id`, `value`) VALUES
(1, 11, 'Type A'),
(2, 11, 'Type A');

-- --------------------------------------------------------

--
-- Structure de la table `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event_types`
--

INSERT INTO `event_types` (`id`, `name`) VALUES
(1, 'Hybride'),
(2, 'Physique'),
(3, 'Virtuel');

-- --------------------------------------------------------

--
-- Structure de la table `exposer`
--

CREATE TABLE `exposer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `exposer`
--

INSERT INTO `exposer` (`id`, `name`, `website`, `logo_url`, `event_id`) VALUES
(3, 'Fatna', '#', '/assets/img/events/exposers/61c1ef0eb67b7.png', 1),
(4, 'Fatna', '#', '/assets/img/events/exposers/61c1e68a0890e.png', 1),
(5, 'coca cola', '#', '/assets/img/events/exposers/61c1e9f1d960f.png', 1),
(6, 'Fatna', '#', '/assets/img/events/exposers/61c3018409958.png', 5);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `is_admin_note` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `client_id`, `category_id`, `content`, `date`, `is_admin_note`) VALUES
(1, 1, 2, 'this is an urgent note !!', '2021-12-22 13:23:15', 1),
(2, 1, 3, 'this is a test', '2021-12-22 13:33:07', 1),
(3, 2, 2, 'hi', '2021-12-23 10:36:08', 1),
(4, 1, 2, 'test', '2021-12-23 11:54:43', 0),
(5, 1, 4, 'test note', '2021-12-27 05:30:22', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notes_categories`
--

CREATE TABLE `notes_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notes_categories`
--

INSERT INTO `notes_categories` (`id`, `name`, `color_code`) VALUES
(2, 'Urgent', '#fdafaf'),
(3, 'OK', '#bcffb8'),
(4, 'test', '#a8fff9');

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sponsors`
--

INSERT INTO `sponsors` (`id`, `type_id`, `name`, `website`, `logo_url`, `event_id`) VALUES
(2, 2, 'Fanta', '#', '/assets/img/events/sponsors/61c1cc184bd0d.png', 1),
(3, 2, 'Coca cola', '#', '/assets/img/events/sponsors/61c1cdf5352f5.png', 1),
(4, 3, 'Coca cola', '#', '/assets/img/events/sponsors/61c2e32a7890f.png', 1),
(5, 2, 'Coca cola', '#', '/assets/img/events/sponsors/61c2e689897f7.png', 1),
(6, 2, 'Coca cola', '#', '/assets/media/users/blank.png', 1),
(7, 2, 'Coca cola', '#', '/assets/media/users/blank.png', 1),
(8, 2, 'Coca cola', '#', '/assets/media/users/blank.png', 1),
(9, 2, 'Coca cola', '#', '/assets/media/users/blank.png', 1),
(10, 2, 'Coca cola', '#', '/assets/img/events/sponsors/61c3016a8f75a.png', 5),
(11, 2, 'Coca cola', '#', '/assets/img/events/sponsors/61c44ade20f48.png', 6);

-- --------------------------------------------------------

--
-- Structure de la table `sponsors_types`
--

CREATE TABLE `sponsors_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sponsors_types`
--

INSERT INTO `sponsors_types` (`id`, `name`) VALUES
(1, 'Silver'),
(2, 'Gold'),
(3, 'Official');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `photo_url`, `firstname`, `lastname`, `phone`) VALUES
(1, 'admin@evento.com', '[\"ROLE_ADMIN\"]', '$2y$13$wnXLQeRDxvXmo/Af1TZCwu48mbyeoHxuUeClR7KxNs5w1wO/Krb9i', '/assets/img/clients/default.png', 'Admin', 'Evento', '22334455'),
(2, 'jason@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$SEIeClb0PORpRPh2GIcjG.FwsyixfzzkqIK1AfU1s7ZzDdEOpAJVa', '/assets/img/clients/6192198968233.png', 'jason', 'stathem', '22334455'),
(3, 'test@evento.com', '[\"ROLE_CLIENT\"]', '$2y$13$mm0REaZBgMicoZQW2vMzRe.ozvWFbVf/cmwV42EzVEfyBzTcNJLD6', '/assets/img/clients/61c4421c4e409.png', 'jason', 'stathem', '93863732'),
(4, 'tchourabi@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$xLvvnDYTh9xGybrgKxOW8uYeFMOyZQMMuPjzdb30UwFR0QFT0L/5O', '/assets/img/clients/61c99820ce22a.png', 'taher', 'chourabi', '93863732');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C82E74A76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5387574A19EB6921` (`client_id`),
  ADD KEY `IDX_5387574AC54C8C93` (`type_id`),
  ADD KEY `IDX_5387574AD695686` (`access_type_id`),
  ADD KEY `IDX_5387574AA9FECF68` (`event_accessibility_id`),
  ADD KEY `IDX_5387574A2406EF21` (`will_be_available_for_nmonths_id`),
  ADD KEY `IDX_5387574AE59E0364` (`event_lng_id`);

--
-- Index pour la table `events_accessibility`
--
ALTER TABLE `events_accessibility`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events_access_types`
--
ALTER TABLE `events_access_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events_durations`
--
ALTER TABLE `events_durations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events_languages`
--
ALTER TABLE `events_languages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event_profile_feilds`
--
ALTER TABLE `event_profile_feilds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_46AD602571F7E88B` (`event_id`);

--
-- Index pour la table `event_profile_feild_value`
--
ALTER TABLE `event_profile_feild_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_289DECBEB2B9446F` (`event_feild_id`);

--
-- Index pour la table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exposer`
--
ALTER TABLE `exposer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C9326DF171F7E88B` (`event_id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_11BA68C19EB6921` (`client_id`),
  ADD KEY `IDX_11BA68C12469DE2` (`category_id`);

--
-- Index pour la table `notes_categories`
--
ALTER TABLE `notes_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8157AA0FA76ED395` (`user_id`);

--
-- Index pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9A31550FC54C8C93` (`type_id`),
  ADD KEY `IDX_9A31550F71F7E88B` (`event_id`);

--
-- Index pour la table `sponsors_types`
--
ALTER TABLE `sponsors_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `events_accessibility`
--
ALTER TABLE `events_accessibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `events_access_types`
--
ALTER TABLE `events_access_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `events_durations`
--
ALTER TABLE `events_durations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `events_languages`
--
ALTER TABLE `events_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `event_profile_feilds`
--
ALTER TABLE `event_profile_feilds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `event_profile_feild_value`
--
ALTER TABLE `event_profile_feild_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `exposer`
--
ALTER TABLE `exposer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `notes_categories`
--
ALTER TABLE `notes_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `sponsors_types`
--
ALTER TABLE `sponsors_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `FK_C82E74A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FK_5387574A19EB6921` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `FK_5387574A2406EF21` FOREIGN KEY (`will_be_available_for_nmonths_id`) REFERENCES `events_durations` (`id`),
  ADD CONSTRAINT `FK_5387574AA9FECF68` FOREIGN KEY (`event_accessibility_id`) REFERENCES `events_accessibility` (`id`),
  ADD CONSTRAINT `FK_5387574AC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `event_types` (`id`),
  ADD CONSTRAINT `FK_5387574AD695686` FOREIGN KEY (`access_type_id`) REFERENCES `events_access_types` (`id`),
  ADD CONSTRAINT `FK_5387574AE59E0364` FOREIGN KEY (`event_lng_id`) REFERENCES `events_languages` (`id`);

--
-- Contraintes pour la table `event_profile_feilds`
--
ALTER TABLE `event_profile_feilds`
  ADD CONSTRAINT `FK_46AD602571F7E88B` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Contraintes pour la table `event_profile_feild_value`
--
ALTER TABLE `event_profile_feild_value`
  ADD CONSTRAINT `FK_289DECBEB2B9446F` FOREIGN KEY (`event_feild_id`) REFERENCES `event_profile_feilds` (`id`);

--
-- Contraintes pour la table `exposer`
--
ALTER TABLE `exposer`
  ADD CONSTRAINT `FK_C9326DF171F7E88B` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `FK_11BA68C12469DE2` FOREIGN KEY (`category_id`) REFERENCES `notes_categories` (`id`),
  ADD CONSTRAINT `FK_11BA68C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `FK_8157AA0FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD CONSTRAINT `FK_9A31550F71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_9A31550FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `sponsors_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
