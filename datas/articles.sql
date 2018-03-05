-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 05 mars 2018 à 16:33
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `filrougeteam`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_articles` int(11) UNSIGNED NOT NULL,
  `titre` varchar(125) CHARACTER SET utf8 NOT NULL,
  `contenu` text CHARACTER SET utf8 NOT NULL,
  `date` date DEFAULT NULL,
  `categorie1` tinyint(1) NOT NULL,
  `categorie2` tinyint(1) NOT NULL,
  `categorie3` tinyint(1) NOT NULL,
  `categorie4` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_articles`, `titre`, `contenu`, `date`, `categorie1`, `categorie2`, `categorie3`, `categorie4`) VALUES
(1, 'Titre 1 (cat 1)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-01', 1, 0, 0, 0),
(2, 'Titre 2 (cat 1,2)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-02', 1, 1, 0, 0),
(3, 'Titre 3 (cat 1,3)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-04', 1, 0, 1, 0),
(4, 'Titre 4 (cat 3)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-05', 0, 0, 1, 0),
(5, 'Titre 5 (cat 4)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-05', 0, 0, 0, 1),
(6, 'Titre 6 (cat 1,2,3)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-05', 1, 1, 1, 0),
(7, 'Titre 7 (cat 2)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-05', 0, 1, 0, 0),
(8, 'Titre 8 (cat 3)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, iure nihil tempore. Aut possimus autem eius beatae, commodi reiciendis ea eos, voluptatem, rem aliquam porro, quam placeat esse ipsam? Aut!', '2018-03-05', 0, 0, 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_articles`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_articles` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
