-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 18 fév. 2025 à 16:33
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `solirestaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nomCl` varchar(50) NOT NULL,
  `prenomCl` varchar(50) DEFAULT NULL,
  `telCl` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nomCl`, `prenomCl`, `telCl`) VALUES
(1, 'Afilal', 'Mohamed', '0612345678'),
(2, 'Bennani', 'Omar', '0612345679'),
(3, 'Tazi', 'Said', '0634567890'),
(4, 'Chraibi', 'Sara', '0666543210'),
(5, 'Amrani', 'Hind', '0621122334'),
(6, 'Mernissi', 'Yassine', '0678901234'),
(7, 'Fassi', 'Aya', '0611223344'),
(8, 'Haddad', 'Rania', '0641234567'),
(9, 'Naciri', 'Karim', '0609876543'),
(10, 'Qassimi', 'Ahmed', '0654321098'),
(11, 'El Alaoui', 'Fatima', '0619876543'),
(12, 'Mekouar', 'Nour', '0687654321');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `idCmd` char(4) NOT NULL,
  `dateCmd` datetime DEFAULT current_timestamp(),
  `Statut` varchar(100) DEFAULT 'en attente',
  `idCl` int(11) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`idCmd`, `dateCmd`, `Statut`, `idCl`) VALUES
('c101', '2025-01-16 08:01:00', 'en attente', 1),
('c102', '2025-01-01 00:00:00', 'en cours', 2),
('c103', '2025-01-01 00:00:00', 'en cours', 1),
('c104', '2025-01-01 00:00:00', 'expédiée', 3),
('c105', '2025-01-02 00:00:00', 'livrée', 12),
('c106', '2025-01-02 00:00:00', 'expédiée', 4),
('c107', '2025-01-02 00:00:00', 'annulée', 5),
('c108', '2025-01-03 00:00:00', 'annulée', 6),
('c109', '2025-01-03 08:53:00', 'livrée', 7),
('c110', '2025-01-03 16:12:00', 'annulée', 8),
('c111', '2025-01-04 15:21:00', 'en cours', 9),
('c112', '2025-01-04 14:47:00', 'en attente', 10),
('c113', '2025-01-04 13:34:00', 'livrée', 11),
('c114', '2025-01-05 11:14:00', 'expédiée', 12);

-- --------------------------------------------------------

--
-- Structure de la table `commande_plat`
--

CREATE TABLE `commande_plat` (
  `idPlat` int(11) NOT NULL,
  `idCmd` char(4) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_plat`
--

INSERT INTO `commande_plat` (`idPlat`, `idCmd`, `qte`) VALUES
(4, 'c113', 2),
(5, 'c113', 6),
(6, 'c113', 3),
(7, 'c101', 5),
(8, 'c111', 5);

-- --------------------------------------------------------

--
-- Structure de la table `plat`
--

CREATE TABLE `plat` (
  `idPlat` int(11) NOT NULL,
  `nomPlat` varchar(100) NOT NULL,
  `categoriePlat` varchar(100) NOT NULL,
  `TypeCuisine` varchar(250) NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `image` varchar(500) NOT NULL
) ;

--
-- Déchargement des données de la table `plat`
--

INSERT INTO `plat` (`idPlat`, `nomPlat`, `categoriePlat`, `TypeCuisine`, `prix`, `image`) VALUES
(4, 'Kefta Mkaouara', 'plat principal', 'Marocaine', 8.49, 'https://tasteofmaroc.com/wp-content/uploads/2018/02/kefta-tagine-oysy-bigstock-kofta-tajine-kefta-tagine-mo-65105917.jpg'),
(5, 'Mechoui', 'plat principal', 'Marocaine', 13.49, 'https://www.tangeraccueil.org/local/cache-vignettes/L600xH368/evenementon1957-17b12.jpg?1619980398'),
(6, 'Rfissa', 'plat principal', 'Marocaine', 12.49, 'https://patisseriegato.ma/wp-content/uploads/2023/08/rfissa-marocaine.webp'),
(7, 'Pastilla au Poulet', 'entrée', 'Marocaine', 11.99, 'https://www.sousou-kitchen.com/wp-content/uploads/2015/05/Pastilla-au-poulet..jpg'),
(8, 'Salade Marocaine', 'entrée', 'Marocaine', 4.99, 'https://abattoirdebondy.fr/wp-content/uploads/2020/10/bcdeb661911e43b996ca17953be67c83.jpg'),
(9, 'Briouates', 'entrée', 'Marocaine', 6.99, 'https://www.hervecuisine.com/wp-content/uploads/2016/11/recette-briouates-poulet.jpg'),
(10, 'Harira', 'entrée', 'Marocaine', 5.99, 'https://www.mesinspirationsculinaires.com/wp-content/uploads/2015/02/harira-recette-marocaine-1.jpg'),
(21, 'Paella', 'plat principal', 'Espagnole', 14.99, 'https://themediterraneanchick.com/wp-content/uploads/2020/09/IMG_0825-1-scaled.jpg'),
(22, 'Fideuà', 'plat principal', 'Espagnole', 13.49, 'https://imag.bonviveur.com/fideua-de-pescado-y-marisco.jpg'),
(23, 'Risotto aux Champignons', 'plat principal', 'Italienne', 12.99, 'https://m1.zeste.ca/serdy-m-dia-inc/image/upload/f_auto/fl_lossy/q_auto:eco/x_0,y_699,w_2721,h_1530,c_crop/w_1200,h_630,c_fill/v1541705178/foodlavie/prod/recettes/risotto-aux-champignons-4b5bce42'),
(24, 'Lasagnes', 'plat principal', 'Italienne', 11.99, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVhEF4ZxEU_LgV0CefrC5eb5iQRU039NDtCA&s'),
(27, 'Canard Laqué', 'plat principal', 'Chinoise', 16.99, 'https://images.squarespace-cdn.com/content/v1/532d9b45e4b0ff70f47a1674/1518795186833-PBID1LBYMIOSPCO41MOX/Canard+Laqu%C3%A9+Cyril+Rouquet-Pr%C3%A9vost'),
(28, 'Bœuf Sauté aux Légumes', 'plat principal', 'Chinoise', 12.99, 'https://m1.zeste.ca/serdy-m-dia-inc/image/upload/f_auto/fl_lossy/q_auto:eco/x_0,y_0,w_1279,h_720,c_crop/w_1200,h_630,c_scale/v1642452008/foodlavie/prod/articles/top-recettes-de-saute-de-boeuf-27ca7e85'),
(29, 'Dim Sum', 'plat principal', 'Chinoise', 10.99, 'https://cdn.britannica.com/55/234755-050-ED5FBC23/dim-sum-chopsticks.jpg'),
(30, 'Chow Mein', 'plat principal', 'Chinoise', 11.99, 'https://s.lightorangebean.com/media/20240914164843/chow-mein-fun-done.png'),
(31, 'Gazpacho', 'entrée', 'Espagnole', 5.99, 'https://castey.com/wp-content/uploads/2024/08/1-3.jpg'),
(32, 'Tapas Variés', 'entrée', 'Espagnole', 7.49, 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Tapas_01.jpg/420px-Tapas_01.jpg'),
(33, 'Bruschetta', 'entrée', 'Italienne', 6.99, 'https://saratogaoliveoil.com/cdn/shop/articles/TomatoBruchetta-300x250.jpg?v=1663185079'),
(34, 'Caprese', 'entrée', 'Italienne', 7.99, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuiNkkn-JbmLYL7TeBD3l7XNerf89TlNRAIg&s'),
(37, 'Rouleaux de Printemps', 'entrée', 'Chinoise', 5.99, 'https://img.cuisineaz.com/1024x576/2018/01/17/i135088-rouleau-de-printemps.webp'),
(38, 'Soupe Aigre-Douce', 'entrée', 'Chinoise', 6.99, 'https://www.la-viande.fr/sites/default/files/styles/slider_recettes/public/recettes/images/soupe-aigre-douce-chinoise-au-chevreau.jpg?itok=SLa5WzO6'),
(39, 'Gyoza', 'entrée', 'Chinoise', 7.49, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7ZCE9uPWOv3g-gbpx_xCq3xTbdhZgD72c3g&s'),
(40, 'La Tartiflette.', 'plat principal', 'Francaise', 7.49, 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSwoJzeDgpE3alNWl6yc6ei6rYGv5EBUTr5svesrE6a8Mehb8O5vdkg_BclSbk1cTfbVMOfH-esLB7oiDpjJEvL9epEC_7LnJmeDAXDGjw');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `telCl` (`telCl`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCmd`),
  ADD KEY `idCl` (`idCl`);

--
-- Index pour la table `commande_plat`
--
ALTER TABLE `commande_plat`
  ADD PRIMARY KEY (`idPlat`,`idCmd`),
  ADD KEY `idCmd` (`idCmd`);

--
-- Index pour la table `plat`
--
ALTER TABLE `plat`
  ADD PRIMARY KEY (`idPlat`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `plat`
--
ALTER TABLE `plat`
  MODIFY `idPlat` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idCl`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `commande_plat`
--
ALTER TABLE `commande_plat`
  ADD CONSTRAINT `commande_plat_ibfk_1` FOREIGN KEY (`idPlat`) REFERENCES `plat` (`idPlat`),
  ADD CONSTRAINT `commande_plat_ibfk_2` FOREIGN KEY (`idCmd`) REFERENCES `commande` (`idCmd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
