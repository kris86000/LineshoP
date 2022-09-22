-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 sep. 2022 à 11:30
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--


--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `name_article`, `image`, `price`, `description`,`type`,`categories_id`) VALUES
(1, 'Console Ps4', 'console-ps4.jpg', 299, 'Pour l\'achat d\'une console PS4 ou d\'un accessoire de la sélection profitez du jeu Destiny 2 offert si vous l\'ajoutez au panier !','new', 1),
(2, 'Console Wii U', 'Console-Wii-U.jpg', 489, 'Pack Nintendo Premium Console Wii U + Mario Kart 8 + Code Splatoon ', 'new', 1),
(3, 'Console-Xbox-360', 'Console-Xbox-360.jpg', 309, 'Console Xbox 360 4 Go Microsoft + capteur Kinect', 'old', 1),
(4, 'Assassin\'s Creed PS4', 'Aain-s-Creed-Origins-PS4.jpg', 56, 'Un nouvel opus de la saga Assassin\'s Creed qui regorge de nouveautés techniques.', 'new', 2),
(5, 'Dragon Ball Fighter', 'Dragon-Ball-Fighter-Z-Xbox-One.jpg', 55, 'DRAGON BALL FighterZ reprend les éléments qui ont fait le succès de la série DRAGON BALL : des combats spectaculaires avec des combattants aux pouvoirs incroyables. ','new',2),
(6, 'Zombi U - Wii U', 'Zombi-U-Wii-U.jpg', 19, 'Londres est au bord du chaos ! Etes-vous prêt ? Nous sommes en 2012 et la fin des temps est là. ','new', 2),
(40, 'Call of Duty modern warfare', '2560eec1a4ea3e8ed6f57941213dfd20', 69.95, 'Préparez-vous pour le retour de Modern Warfare® ! Dans un tout nouvel opus aux enjeux plus élevés que jamais, les joueurs incarneront des agents d’élite des forces spéciales pris dans l’engrenage hale',NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--


--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name_category`) VALUES
(1, 'Consoles'),
(2, 'Jeux');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--



--
-- Déchargement des données de la table `migration_versions`
--


-- --------------------------------------------------------

--
-- Structure de la table `orders`
--


--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `date_order`, `amount`, `status` ,`user_id`) VALUES
(23, '2019-09-05 11:30:14', 710, 'panier', 1);

-- --------------------------------------------------------

--
-- Structure de la table `orderslines`
--

--
-- Déchargement des données de la table `orderslines`
--

INSERT INTO `orderslines` (`id`, `order_id`,`quantity`,`article_id`) VALUES
(28, 23, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `name_user`, `firstname`, `address`, `postal_code`, `city`) VALUES
(1, 'mail@mail.fr', '[]', '$argon2i$v=19$m=65536,t=4,p=1$S3Z0YmRQeG93QlNCZDgvcQ$bQgyR+4TdrfeiCJbbb9NI0zkoLcbLuRCoNCYMTt43DY', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'admin@admin.fr', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$ekNTZm5TdE5BVjAzTE9vaQ$tw5c+gCOB60gzcNRX7tgI9OmA5ZJR1WJ2sJQcMASWNo', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'a@a.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$MWRhRDZFejVqMk9jbVphYQ$B5B1MgX1yRql+o0i1RJgOVT8oUUncJNEViKXjHJOcwg', NULL, NULL, NULL, NULL, NULL, NULL);

