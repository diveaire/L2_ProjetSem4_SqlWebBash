-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 01 avr. 2023 à 15:42
-- Version du serveur : 8.0.32
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SAE4`
--

-- --------------------------------------------------------

--
-- Structure de la table `Atelier`
--

CREATE TABLE `Atelier` (
  `IdA` int NOT NULL,
  `nomA` varchar(32) DEFAULT NULL,
  `IdZ` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Atelier`
--

INSERT INTO `Atelier` (`IdA`, `nomA`, `IdZ`) VALUES
(1, 'La base sous marine', 1),
(2, 'La forge des airs', 2),
(3, 'L établi', 3),
(4, 'Entrepôt', 3);

-- --------------------------------------------------------

--
-- Structure de la table `Bilan`
--

CREATE TABLE `Bilan` (
  `NomM` varchar(32) NOT NULL,
  `NumSS` decimal(15,0) NOT NULL,
  `DateB` date NOT NULL,
  `frequentation` int DEFAULT NULL,
  `demi_journee` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Bilan`
--

INSERT INTO `Bilan` (`NomM`, `NumSS`, `DateB`, `frequentation`, `demi_journee`) VALUES
('Balade des hypocampes', 177092774664744, '2023-03-14', 350, 'AM'),
('Balade des hypocampes', 177092774664744, '2023-03-14', 280, 'PM'),
('Buffalo', 177094416301428, '2023-03-14', 264, 'AM'),
('Buffalo', 184010670392524, '2023-03-14', 352, 'PM'),
('L envol des troglodytes', 170055426428642, '2023-03-14', 230, 'AM'),
('L envol des troglodytes', 170055426428642, '2023-03-14', 299, 'PM'),
('L hirrondelle', 192080610253029, '2023-03-14', 452, 'PM'),
('L hirrondelle', 273129489402427, '2023-03-14', 360, 'AM'),
('L oeil', 160120623950185, '2023-03-14', 315, 'AM'),
('L oeil', 177094416301428, '2023-03-14', 315, 'PM'),
('La chute d Icare', 160120623950185, '2023-03-14', 512, 'PM'),
('La chute d Icare', 192080610253029, '2023-03-14', 480, 'AM'),
('La danse des dauphins', 259057174363269, '2023-03-14', 478, 'AM'),
('La danse des dauphins', 273129489402427, '2023-03-14', 514, 'PM'),
('La racine', 259057174363269, '2023-03-14', 580, 'PM'),
('La racine', 262017839201528, '2023-03-14', 512, 'AM'),
('Le moulin', 160120623950185, '2023-04-01', 300, 'AM'),
('Mille-Patte', 184010670392524, '2023-03-14', 421, 'AM'),
('Mille-Patte', 269019550295812, '2023-03-14', 354, 'PM'),
('Wave', 259057174363269, '2023-03-14', 612, 'PM'),
('Wave', 269019550295812, '2023-03-14', 564, 'AM');

-- --------------------------------------------------------

--
-- Structure de la table `Boutique`
--

CREATE TABLE `Boutique` (
  `IdB` int NOT NULL,
  `nomB` varchar(32) DEFAULT NULL,
  `typeB` varchar(32) DEFAULT NULL,
  `IdZ` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Boutique`
--

INSERT INTO `Boutique` (`IdB`, `nomB`, `typeB`, `IdZ`) VALUES
(1, 'Macdo', 'restaurant', 3),
(2, 'BK', 'restaurant', 2),
(3, 'KFC', 'restaurant', 1),
(4, 'Le sculpteur Joe', 'souvenir', 3),
(5, 'Le nuage de l amour', 'souvenir', 2),
(6, 'Au coeur de l épave', 'souvenir', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Competences`
--

CREATE TABLE `Competences` (
  `NumSS` decimal(15,0) NOT NULL,
  `IdF` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Competences`
--

INSERT INTO `Competences` (`NumSS`, `IdF`) VALUES
(160120623950185, 1),
(177092774664744, 1),
(192080610253029, 1),
(192082736647756, 1),
(269019550295812, 1),
(273129489402427, 1),
(192080610253029, 2),
(273129489402427, 2),
(177092774664744, 3),
(184010670392524, 3),
(192080610253029, 3),
(269019550295812, 3),
(273129489402427, 3),
(160120623950185, 4),
(177092774664744, 4),
(192080610253029, 4),
(259057174363269, 4),
(273129489402427, 4),
(160120623950185, 5),
(259057174363269, 5),
(273129489402427, 5),
(177094416301428, 6),
(184010670392524, 6),
(273129489402427, 6),
(160120623950185, 7),
(177094416301428, 7),
(184010670392524, 7),
(273129489402427, 7);

-- --------------------------------------------------------

--
-- Structure de la table `Equipe`
--

CREATE TABLE `Equipe` (
  `NumSS` decimal(15,0) NOT NULL,
  `IdM` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Equipe`
--

INSERT INTO `Equipe` (`NumSS`, `IdM`) VALUES
(183125910395284, 1),
(285062730491825, 1),
(188109516634135, 2),
(189027865394675, 2),
(285062730491825, 2),
(188109516634135, 3),
(189027865394675, 3),
(189027865394675, 4),
(189027865394675, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Famille`
--

CREATE TABLE `Famille` (
  `IdF` int NOT NULL,
  `libelleF` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Famille`
--

INSERT INTO `Famille` (`IdF`, `libelleF`) VALUES
(1, 'Carrousel'),
(2, 'Tour'),
(3, 'Chenille'),
(4, 'Grand-huit'),
(5, 'Train'),
(6, 'Auto-tamponeuse'),
(7, 'Roue');

-- --------------------------------------------------------

--
-- Structure de la table `Maintenance`
--

CREATE TABLE `Maintenance` (
  `IdM` int NOT NULL,
  `DateDeb` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL,
  `NomM` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Maintenance`
--

INSERT INTO `Maintenance` (`IdM`, `DateDeb`, `DateFin`, `NomM`) VALUES
(1, '2023-05-25', '2023-05-30', 'Le moulin'),
(2, '2023-05-25', '2023-05-25', 'La racine'),
(3, '2022-03-12', '2022-03-12', 'Splash'),
(4, '2023-04-28', '2023-04-29', 'High-Speed'),
(5, '2023-03-31', NULL, 'Balade des hypocampes');

-- --------------------------------------------------------

--
-- Structure de la table `Manege`
--

CREATE TABLE `Manege` (
  `NomM` varchar(32) NOT NULL,
  `tailleMin` int DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `IdF` int DEFAULT NULL,
  `IdZ` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Manege`
--

INSERT INTO `Manege` (`NomM`, `tailleMin`, `description`, `IdF`, `IdZ`) VALUES
('Balade des hypocampes', 125, 'carrousel pour enfant immergé dans l eau', 1, 1),
('Big Noise', 120, 'Chenille bruyante', 3, 2),
('Buffalo', 150, 'Auto-tamponeuse en forme de buffle', 6, 3),
('High-Speed', 145, 'Un grand huit à haute vitesse', 4, 2),
('L envol des troglodytes', 120, 'Manège circulaire aérien pour enfant', 3, 2),
('L hirrondelle', 145, 'Chaises volante ascendante', 2, 2),
('L oeil', 0, 'Tour de grande roue', 7, 2),
('La chute d Icare', 155, 'Attraction à sensation forte', 4, 2),
('La danse des dauphins', 155, 'Attraction à sensation forte', 4, 1),
('La racine', 155, 'Attraction à sensation forte', 4, 3),
('Le moulin', 0, 'Petit carrousel', 1, 3),
('Mille-Patte', 120, 'Petit train pour enfant', 3, 3),
('Splash', 145, 'Attraction qui éclabousse', 5, 1),
('Wave', 150, 'Descente à haute vitesse, avec chute d eau et cascade', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Metier`
--

CREATE TABLE `Metier` (
  `Metier` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Metier`
--

INSERT INTO `Metier` (`Metier`) VALUES
('Chargé de manège'),
('Directeur'),
('Serveur'),
('Technicien'),
('Vendeur');

-- --------------------------------------------------------

--
-- Structure de la table `Objet`
--

CREATE TABLE `Objet` (
  `IdO` int NOT NULL,
  `nomO` varchar(32) DEFAULT NULL,
  `IdB` int DEFAULT NULL,
  `IdT` int DEFAULT NULL,
  `DateVente` date DEFAULT NULL,
  `Prix` decimal(4,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Objet`
--

INSERT INTO `Objet` (`IdO`, `nomO`, `IdB`, `IdT`, `DateVente`, `Prix`) VALUES
(1, 'Bague', 4, 4, NULL, 35.00),
(2, 'Porte_clef', 4, 5, NULL, 5.00),
(3, 'Cheval en bois', 4, 7, NULL, 50.00),
(4, 'Clef USB', 4, 2, '2023-04-01', 3.00),
(5, 'Chouchou', 5, 1, NULL, 5.00),
(6, 'Pomme d amour', 5, 1, '2023-04-01', 6.59),
(7, 'Nounours', 5, 3, NULL, 50.00),
(8, 'Pistolet à eau', 6, 7, NULL, 25.00),
(9, 'Dauphin', 6, 3, NULL, 35.00),
(10, 'T-shirt Wave', 6, 6, NULL, 23.00),
(11, 'Orque', 6, 3, NULL, 35.00),
(12, 'Phoque 30 cm', 6, 3, '2023-03-22', 26.00),
(13, 'Débardeur Joe', 4, 6, '2023-04-12', 23.00),
(14, 'Boite de chocolat', 5, 1, '2023-02-15', 8.00),
(15, 'Bonnet de Père Noel', 4, 6, '2022-12-10', 4.00),
(16, 'Lot de Frites', 1, 8, NULL, 25.00),
(17, 'Poulet', 3, 8, NULL, 35.00),
(18, 'Lot de Frites', 3, 8, NULL, 23.00),
(19, 'Burger', 3, 8, NULL, 35.00),
(20, 'Burger', 2, 8, '2023-03-25', 6.00),
(21, 'Burger', 1, 8, '2023-05-11', 6.00),
(22, 'Soda Pepsi', 1, 9, '2023-02-11', 3.00),
(23, 'Lot de Frites', 1, 8, '2022-12-12', 2.00);

-- --------------------------------------------------------

--
-- Structure de la table `Personnel`
--

CREATE TABLE `Personnel` (
  `NumSS` decimal(15,0) NOT NULL,
  `nomP` varchar(32) DEFAULT NULL,
  `prenomP` varchar(32) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `passwd` varchar(32) DEFAULT NULL,
  `Metier` varchar(32) DEFAULT NULL,
  `remplace` decimal(15,0) DEFAULT NULL,
  `IdA` int DEFAULT NULL,
  `chef` decimal(1,0) DEFAULT NULL,
  `IdB` int DEFAULT NULL,
  `responsable` decimal(1,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Personnel`
--

INSERT INTO `Personnel` (`NumSS`, `nomP`, `prenomP`, `date_naissance`, `passwd`, `Metier`, `remplace`, `IdA`, `chef`, `IdB`, `responsable`) VALUES
(159119710789325, 'Labonté', 'Robert', '1959-11-14', '2d69e1c367bc8a2113a0b2556b74ac62', 'Serveur', NULL, NULL, 0, 3, 1),
(160120623950185, 'Harbin', 'Langlois', '1960-12-30', 'cc35af59c2eb6a1e7809d8d22db53963', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(170055426428642, 'Lotye', 'Alexandre', '1970-05-29', '485133b03eec52af0afc2ccab8737f3c', 'Vendeur', NULL, NULL, 0, 4, 0),
(177092774664744, 'Lio', 'Fabrice', '1977-09-24', 'd4af298a2f50246c5a0b9ebbc547ab28', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(177094416301428, 'Beaulieu', 'Felicien', '1977-09-23', '52de53c5365801cf520cf5ca67a46ed2', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(183125910395284, 'Lagrange', 'Arnaud', '1983-12-05', 'ec33c27178ed42a257747bc069d4afdf', 'Technicien', NULL, 4, 1, NULL, 0),
(184010670392524, 'Guay', 'Christien', '1984-01-16', 'cfc2e01c7c8e9ef8b5ccafe4981cc3e9', 'Chargé de manège', 177094416301428, NULL, 0, NULL, 0),
(186119185783610, 'Roch', 'Bernard', '1986-11-21', '607d6df616e2c29467c1709040d3a03c', 'Vendeur', NULL, NULL, 0, 5, 0),
(188109516634135, 'Landers', 'Roger', '1988-10-14', '0c63ae03d2c108e15892525626abf73e', 'Technicien', NULL, 2, 1, NULL, 0),
(189027865394675, 'Jolicoeur', 'joel', '1989-02-27', '4fd587a01ac969916d52423b95198b88', 'Technicien', NULL, 1, 1, NULL, 0),
(192080610253029, 'Tanguay', 'Felix', '1992-08-22', '9bdb1e1becb5e003c9a8812b1edc871f', 'Chargé de manège', 269019550295812, NULL, 0, NULL, 0),
(192082736647756, 'Lord', 'Seb', '1992-08-24', '2d0e1d62e9c22b11892948fa6440186b', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(192121367804307, 'Mousseau', 'Geoffrey', '1992-12-01', '81394ed6bdee804ed8d2c96e7378e062', 'Serveur', NULL, NULL, 0, 2, 1),
(193089249285020, 'Heru', 'Léo', '1993-08-07', 'd4af298a2f50246c5a0b9ebbc547ab28', 'Technicien', NULL, 4, 0, NULL, 0),
(193129620491184, 'bouvrier', 'Christien', '1993-12-09', '1530f0becee488112c3c639e5c27d7a5', 'Vendeur', NULL, NULL, 0, NULL, 0),
(199027268902305, 'Lejeune', 'Daniel', '1999-02-06', '06df08d537012bb8b815b297c0ee359f', 'Serveur', NULL, NULL, 0, 1, 1),
(259057174363269, 'Galarneau', 'Diane', '1959-05-08', 'ec0854c2d8b9d91b8d35465c150ab85d', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(262017839201528, 'Plouffe', 'Élodie', '1962-06-03', '9666b0fef12b0b357fa5b3d8a67b7867', 'Vendeur', NULL, NULL, 0, 4, 1),
(269019550295812, 'Ansel', 'Narcisse', '1969-01-03', 'dc7afdc58a5bf795ce2474f648f2123c', 'Chargé de manège', NULL, NULL, 0, NULL, 0),
(269054528453129, 'Allard', 'Dominique', '1969-05-17', '81bfe29fe35d6b7a66617c2cb8f234c2', 'Vendeur', NULL, NULL, 0, 6, 1),
(273129489402427, 'Fontaine', 'Charlotte', '1973-12-05', 'e461072819aa69de63b6a6b948d84caa', 'Chargé de manège', 184010670392524, NULL, 0, NULL, 0),
(280061676520542, 'Meilleur', 'Valérie', '1980-06-13', '0028824d513a19c3a9f8caaad437f119', 'Serveur', NULL, NULL, 0, 1, 0),
(285041689753759, 'Breton', 'Fayme', '1985-05-15', '8854163285c1d50b0df9426b7d2291b0', 'Vendeur', NULL, NULL, 0, 5, 1),
(285062730491825, 'Méthoir', 'Carole', '1985-06-27', '7b941a95e8a8720b1980c5556f5f7c4c', 'Technicien', NULL, 3, 1, NULL, 0),
(296089249285020, 'jorit', 'Lola', '1996-08-07', '2d0e1d62e9c22b11892948fa6440186b', 'Technicien', NULL, NULL, 0, NULL, 0),
(296097812309417, 'Laris', 'Lola', '1996-08-08', 'Monpass22', 'Technicien', NULL, 1, 1, NULL, NULL),
(393874739983721, 'Jack', 'Robert', '1959-12-04', 'b519fe74ac792bbf477dd5370fccec5c', 'Directeur', NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `PiecesDetachees`
--

CREATE TABLE `PiecesDetachees` (
  `NumSerie` decimal(8,0) NOT NULL,
  `nomPC` varchar(32) DEFAULT NULL,
  `IdA` int DEFAULT NULL,
  `IdM` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `PiecesDetachees`
--

INSERT INTO `PiecesDetachees` (`NumSerie`, `nomPC`, `IdA`, `IdM`) VALUES
(14189639, 'Roue', 4, 1),
(16718152, 'Moteur', 3, NULL),
(19626463, 'Auto', 3, NULL),
(23477564, 'Engrenage', 4, 4),
(34578422, 'Siège', 4, 3),
(36664674, 'Wagon', 4, NULL),
(52910329, 'Moteur', 4, NULL),
(54236789, 'Engrenage', 4, NULL),
(61231584, 'Moteur', 1, 2),
(72435685, 'Wagon', 2, NULL),
(72938848, 'Wagon', 2, 4),
(79193025, 'Roue', 1, 5),
(87654327, 'Wagon', 4, NULL),
(91025273, 'Chaise', 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `TypeObjet`
--

CREATE TABLE `TypeObjet` (
  `IdT` int NOT NULL,
  `libelleT` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `TypeObjet`
--

INSERT INTO `TypeObjet` (`IdT`, `libelleT`) VALUES
(1, 'Friandise'),
(2, 'Gadget'),
(3, 'Peluche'),
(4, 'Bijoux'),
(5, 'Souvenir'),
(6, 'Vetement'),
(7, 'Jouet'),
(8, 'Nourriture'),
(9, 'Boisson');

-- --------------------------------------------------------

--
-- Structure de la table `Zone`
--

CREATE TABLE `Zone` (
  `IdZ` int NOT NULL,
  `nomZ` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Zone`
--

INSERT INTO `Zone` (`IdZ`, `nomZ`) VALUES
(1, 'Aqualand'),
(2, 'Haute-Voltige'),
(3, 'Lumber-zone');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Atelier`
--
ALTER TABLE `Atelier`
  ADD PRIMARY KEY (`IdA`),
  ADD KEY `fk_Atelier_Zone` (`IdZ`);

--
-- Index pour la table `Bilan`
--
ALTER TABLE `Bilan`
  ADD PRIMARY KEY (`NomM`,`NumSS`,`DateB`,`demi_journee`),
  ADD KEY `fk_Bilan_Personnel` (`NumSS`);

--
-- Index pour la table `Boutique`
--
ALTER TABLE `Boutique`
  ADD PRIMARY KEY (`IdB`),
  ADD KEY `fk_Boutique_Zone` (`IdZ`);

--
-- Index pour la table `Competences`
--
ALTER TABLE `Competences`
  ADD PRIMARY KEY (`NumSS`,`IdF`),
  ADD KEY `fk_Competences_Famille` (`IdF`);

--
-- Index pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD PRIMARY KEY (`NumSS`,`IdM`),
  ADD KEY `fk_Equipe_Manege` (`IdM`);

--
-- Index pour la table `Famille`
--
ALTER TABLE `Famille`
  ADD PRIMARY KEY (`IdF`);

--
-- Index pour la table `Maintenance`
--
ALTER TABLE `Maintenance`
  ADD PRIMARY KEY (`IdM`),
  ADD KEY `fk_Maintenance_Manege` (`NomM`);

--
-- Index pour la table `Manege`
--
ALTER TABLE `Manege`
  ADD PRIMARY KEY (`NomM`),
  ADD KEY `fk_Manege_Famille` (`IdF`),
  ADD KEY `fk_Manege_Zone` (`IdZ`);

--
-- Index pour la table `Metier`
--
ALTER TABLE `Metier`
  ADD PRIMARY KEY (`Metier`);

--
-- Index pour la table `Objet`
--
ALTER TABLE `Objet`
  ADD PRIMARY KEY (`IdO`),
  ADD KEY `fk_Objet_Boutique` (`IdB`),
  ADD KEY `fk_Objet_TypeObjet` (`IdT`);

--
-- Index pour la table `Personnel`
--
ALTER TABLE `Personnel`
  ADD PRIMARY KEY (`NumSS`),
  ADD KEY `fk_Personnel_Atelier` (`IdA`),
  ADD KEY `fk_Personnel_Boutique` (`IdB`),
  ADD KEY `fk_Personnel_Metier` (`Metier`),
  ADD KEY `fk_Personnel_Personnel` (`remplace`);

--
-- Index pour la table `PiecesDetachees`
--
ALTER TABLE `PiecesDetachees`
  ADD PRIMARY KEY (`NumSerie`),
  ADD KEY `fk_PieceDetachees_Atelier` (`IdA`),
  ADD KEY `fk_PieceDetachees_Manege` (`IdM`);

--
-- Index pour la table `TypeObjet`
--
ALTER TABLE `TypeObjet`
  ADD PRIMARY KEY (`IdT`);

--
-- Index pour la table `Zone`
--
ALTER TABLE `Zone`
  ADD PRIMARY KEY (`IdZ`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Atelier`
--
ALTER TABLE `Atelier`
  ADD CONSTRAINT `fk_Atelier_Zone` FOREIGN KEY (`IdZ`) REFERENCES `Zone` (`IdZ`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Bilan`
--
ALTER TABLE `Bilan`
  ADD CONSTRAINT `fk_Bilan_Personnel` FOREIGN KEY (`NumSS`) REFERENCES `Personnel` (`NumSS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Boutique`
--
ALTER TABLE `Boutique`
  ADD CONSTRAINT `fk_Boutique_Zone` FOREIGN KEY (`IdZ`) REFERENCES `Zone` (`IdZ`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Competences`
--
ALTER TABLE `Competences`
  ADD CONSTRAINT `fk_Competences_Famille` FOREIGN KEY (`IdF`) REFERENCES `Famille` (`IdF`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Competences_Personnel` FOREIGN KEY (`NumSS`) REFERENCES `Personnel` (`NumSS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD CONSTRAINT `fk_Equipe_Manege` FOREIGN KEY (`IdM`) REFERENCES `Maintenance` (`IdM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Equipe_Personnel` FOREIGN KEY (`NumSS`) REFERENCES `Personnel` (`NumSS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Maintenance`
--
ALTER TABLE `Maintenance`
  ADD CONSTRAINT `fk_Maintenance_Manege` FOREIGN KEY (`NomM`) REFERENCES `Manege` (`NomM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Manege`
--
ALTER TABLE `Manege`
  ADD CONSTRAINT `fk_Manege_Famille` FOREIGN KEY (`IdF`) REFERENCES `Famille` (`IdF`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Manege_Zone` FOREIGN KEY (`IdZ`) REFERENCES `Zone` (`IdZ`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Objet`
--
ALTER TABLE `Objet`
  ADD CONSTRAINT `fk_Objet_Boutique` FOREIGN KEY (`IdB`) REFERENCES `Boutique` (`IdB`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Objet_TypeObjet` FOREIGN KEY (`IdT`) REFERENCES `TypeObjet` (`IdT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Personnel`
--
ALTER TABLE `Personnel`
  ADD CONSTRAINT `fk_Personnel_Atelier` FOREIGN KEY (`IdA`) REFERENCES `Atelier` (`IdA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Personnel_Boutique` FOREIGN KEY (`IdB`) REFERENCES `Boutique` (`IdB`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Personnel_Metier` FOREIGN KEY (`Metier`) REFERENCES `Metier` (`Metier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Personnel_Personnel` FOREIGN KEY (`remplace`) REFERENCES `Personnel` (`NumSS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `PiecesDetachees`
--
ALTER TABLE `PiecesDetachees`
  ADD CONSTRAINT `fk_PieceDetachees_Atelier` FOREIGN KEY (`IdA`) REFERENCES `Atelier` (`IdA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PieceDetachees_Manege` FOREIGN KEY (`IdM`) REFERENCES `Maintenance` (`IdM`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
