-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 20 déc. 2022 à 21:00
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Qcm2Maths`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `phrase_secrete` varchar(256) DEFAULT NULL,
  `mail` varchar(100) NOT NULL,
  `derniere_connexion` datetime NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `statut` varchar(50) NOT NULL DEFAULT 'prof'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `mdp`, `phrase_secrete`, `mail`, `derniere_connexion`, `verified`, `statut`) VALUES
(1, 'LALLEMAND', 'Fabrice', '4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2', 'modetriche', 'fabrice@flallemand.fr', '2022-12-20 20:15:11', 1, 'admin'),
(36, 'GALOIS', 'Evariste', 'b753f606c5b8152becfd06205c661136786f5e2dbeb9ac7276dd9b7cb42e4db2', NULL, 'fabrice.lallemand@ac-clermont.fr', '2022-12-20 18:35:35', 1, 'prof');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
