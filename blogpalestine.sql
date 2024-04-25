-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 22 avr. 2024 à 18:09
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
-- Base de données : `blogpalestine`
--

-- --------------------------------------------------------

--
-- Structure de la table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `titre`, `image`, `date`, `contenu`) VALUES
(11, 1, 'L\'appel à la paix', 'palestine-flag-780x470.jpg', '2024-04-20 22:20:41', 'Face à la réalité brutale de la guerre, nombreux sont ceux qui appellent à la paix et à la réconciliation. Il est temps de mettre fin à la violence et de chercher des solutions pacifiques pour garantir un avenir meilleur pour tous les peuples de la région. #PaixEnPalestine'),
(13, 1, 'Les conséquences sur la jeunesse', 'images.jpg', '2024-04-20 22:25:53', 'La vie en Palestine est marquée par la complexité des conflits qui nous entourent. Chaque jour, nous faisons face à des défis pour accéder aux ressources de base et maintenir un semblant de normalité pour nos familles. La solidarité et le soutien mutuel sont essentiels pour traverser ces moments difficiles. #VieEnConflit'),
(15, 3, 'Vers une compréhension mutuelle', 'palestinian_flag003.png', '2024-04-21 15:38:17', 'Les relations complexes entre la Palestine et Israël ont été marquées par des décennies de conflits et de tensions. Malgré les différences profondes qui nous séparent, de nombreux Palestiniens et Israéliens aspirent à une coexistence pacifique et à une compréhension mutuelle. Il est essentiel de reconnaître les souffrances et les aspirations des deux côtés pour avancer vers une solution durable et juste. #CompréhensionMutuelle');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `blog_id` int(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `user_id`, `blog_id`, `commentaire`) VALUES
(8, 1, 10, 'Reste en Paix #Paix');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Visiteur1', 'visiteur1@gmail.com', '$2y$10$nLECge7gi01WuDN4IucCOe7zSY0CSyQ7nlkL4tYRB5ewsuh//O4qm'),
(2, 'visiteur2', 'visiteur2@gmail.com', '$2y$10$KEYHi1iCEVVam2UxEtWvCOn8Hg6wbwnFFf91.MJZkSTTIcJ1j.bY2'),
(3, 'Visiteur 3', 'visiteur3@gmail.com', '$2y$10$q7hUfRpkokBgN0roN66NZeXXqy9C1Swy2MIeYGku5C5cGDIi.Eipu'),
(8, 'visiteur 4', 'visiteur4@gmail.com', '$2y$10$Vyo79RgSpa/def1hRe5vouxPuGj0V0AmFEdVExfrfA9.PXwo00tS.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
