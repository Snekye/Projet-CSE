-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 mai 2023 à 09:10
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_cse`
--

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE `droit` (
  `Id_Droit` int(11) NOT NULL,
  `Libelle_Droit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `droit`
--

INSERT INTO `droit` (`Id_Droit`, `Libelle_Droit`) VALUES
(1, 'Administrateur'),
(2, 'Lecteur');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `Id_Image` int(11) NOT NULL,
  `Nom_Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`Id_Image`, `Nom_Image`) VALUES
(1, 'https://www.1min30.com/wp-content/uploads/2017/08/Chanel-logo-1.jpg'),
(2, 'https://upload.wikimedia.org/wikipedia/fr/thumb/9/9d/Peugeot_2021_Logo.svg/750px-Peugeot_2021_Logo.svg.png?20210226094449'),
(3, 'https://cdn2.telephone.city/webp/200/pathe.png'),
(4, 'https://media.glassdoor.com/sqll/3044503/novus-tech-solutions-squarelogo-1640152769133.png'),
(5, 'https://thumbs.dreamstime.com/b/concept-vert-sant%C3%A9-logo-%C3%A9co-vie-personnes-soins-mod%C3%A8le-vecteur-de-physioth%C3%A9rapie-en-fond-blanc-221778646.jpg'),
(6, 'https://play-lh.googleusercontent.com/fAkR-TQVwep39nqSAaRJCNCRFaqAckN7zTx6F1z6cOXY-4zfoOKxJN7CJH8Q89A61Q'),
(7, 'https://media.licdn.com/dms/image/C560BAQG0jEgThu4lMQ/company-logo_200_200/0/1519297908797?e=2147483647&v=beta&t=anuO2m_ZAsBIlpseCPsNzc_Gt8IDI-dHSwoDYiRLLi8'),
(8, 'https://pbs.twimg.com/profile_images/1604929444342206464/-YIYswDZ_400x400.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `info_accueil`
--

CREATE TABLE `info_accueil` (
  `Id_Info_Accueil` int(11) NOT NULL,
  `Num_Tel_Info_Accueil` int(11) NOT NULL,
  `Email_Info_Accueil` varchar(255) NOT NULL,
  `Emplacement_Bureau_Info_Accueil` varchar(255) NOT NULL,
  `Titre_Info_Accueil` varchar(255) NOT NULL,
  `Texte_Info_Accueil` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `info_accueil`
--

INSERT INTO `info_accueil` (`Id_Info_Accueil`, `Num_Tel_Info_Accueil`, `Email_Info_Accueil`, `Emplacement_Bureau_Info_Accueil`, `Titre_Info_Accueil`, `Texte_Info_Accueil`) VALUES
(1, 33030303, 'cse@lyceestvincent.fr', 'Bureau du CSE [1er étage bâtiment St-Vincent]', 'CSE Lycée Saint-Vincent', 'Nous vous souhaitons la bienvenue sur le site du comité social et économique du lycée Saint-Vincent à Senlis.<br>Découvrez l\'<a href=\"https://dgranit.lyceestvincent.fr\" target=\"_blank\">équipe</a> et le <a href=\"https://abrunet.lyceestvincent.fr\" target=\"_blank\">rôle</a> et missions de votre CSE.');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `Id_Message` int(11) NOT NULL,
  `Nom_Message` varchar(100) NOT NULL,
  `Prenom_Message` varchar(100) NOT NULL,
  `Email_Message` varchar(255) NOT NULL,
  `Contenu_Message` varchar(3000) NOT NULL,
  `Id_Offre` int(11) DEFAULT NULL,
  `Id_Partenaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`Id_Message`, `Nom_Message`, `Prenom_Message`, `Email_Message`, `Contenu_Message`, `Id_Offre`, `Id_Partenaire`) VALUES
(5, 'Granit', 'Dimitri', 'dimitri.granit@gmail.com', 'Waouh, ces offres promotionnelles ont attiré mon attention ! J\'ai hâte de profiter de super affaires et faire des économies sur mes produits préférés. Je suis partant !', NULL, NULL),
(6, 'Favernay', 'Marcus', 'marcus.favernay@gmail.com', 'Je suis toujours à la recherche de bonnes affaires, et ces offres promotionnelles ont vraiment captivé mon intérêt. Je compte bien en profiter et faire de belles économies !', 2, NULL),
(7, 'Rossi', 'Antoine', 'antoine.rossi@gmail.com', 'Ces offres promotionnelles sont vraiment alléchantes ! Je suis vraiment tenté de les découvrir et de profiter de remises exceptionnelles. Je suis très intéressée !', NULL, NULL),
(8, 'Zarb', 'Tom', 'tom.zarb@gmail.com', 'Les offres promotionnelles que j\'ai vues sont incroyables ! Je ne peux pas résister à l\'idée d\'en profiter et de me faire plaisir sans me ruiner. Je suis totalement séduit !', NULL, NULL),
(9, 'Brunet', 'Alexandre', 'alexandre.brunet@gmail.com', 'Je suis à la recherche de bonnes affaires et ces offres promotionnelles sont exactement ce que je cherchais. Je suis vraiment intéressé par les remises et les avantages proposés. Ça ne se refuse pas !', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

CREATE TABLE `offre` (
  `Id_Offre` int(11) NOT NULL,
  `Nom_Offre` varchar(255) NOT NULL,
  `Description_Offre` varchar(3000) NOT NULL,
  `Date_Debut_Offre` date NOT NULL,
  `Date_Fin_Offre` date DEFAULT NULL,
  `Nombre_Place_Min_Offre` int(11) NOT NULL,
  `Id_Partenaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`Id_Offre`, `Nom_Offre`, `Description_Offre`, `Date_Debut_Offre`, `Date_Fin_Offre`, `Nombre_Place_Min_Offre`, `Id_Partenaire`) VALUES
(1, 'Promo Voyage Ensoleillé', 'Profitez de notre promotion voyage ensoleillé et économisez sur vos prochaines vacances. Des destinations de rêve à des prix imbattables. Ne manquez pas cette occasion de vous évader !', '2023-03-15', '2024-03-03', 20, 3),
(2, 'Offre Tech Futuriste', 'Plongez dans le futur avec notre offre tech futuriste. Des réductions incroyables sur les dernières innovations technologiques. Soyez à la pointe de la technologie sans vous ruiner !', '2022-11-17', '2023-01-18', 150, 8),
(4, 'Promo Gourmande', 'Laissez-vous tenter par notre promo gourmande avec des remises alléchantes sur une sélection de produits gastronomiques. Un festin pour vos papilles à prix réduit.', '2023-02-06', '2023-05-10', 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `offre_image`
--

CREATE TABLE `offre_image` (
  `Id_Offre` int(11) NOT NULL,
  `Id_Image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre_image`
--

INSERT INTO `offre_image` (`Id_Offre`, `Id_Image`) VALUES
(1, 1),
(2, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

CREATE TABLE `partenaire` (
  `Id_Partenaire` int(11) NOT NULL,
  `Nom_Partenaire` varchar(255) NOT NULL,
  `Description_Partenaire` varchar(3000) NOT NULL,
  `Lien_Partenaire` varchar(500) NOT NULL,
  `Id_Image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partenaire`
--

INSERT INTO `partenaire` (`Id_Partenaire`, `Nom_Partenaire`, `Description_Partenaire`, `Lien_Partenaire`, `Id_Image`) VALUES
(1, 'NovusTech Solutions', 'Innovating the Future, Today!', 'https://novustechsolutions.com/', 4),
(2, 'ÉcoVie Santé', 'Votre bien-être, notre priorité écologique.', 'https://www.ecovie.ch/', 5),
(3, 'ProFit Gym', 'Unlock Your Potential, Embrace the Power Within!', 'https://profitgym.nl/', 6),
(5, 'AstraSoft Technologies', 'AstraSoft Technologies!', 'http://astrasoft.me/', 7),
(7, 'DreamWorks Events', 'Turning Dreams into Unforgettable Moments.', 'https://www.dreamworks.com/events', 8),
(8, 'Artisanal Bliss Interiors', 'Bringing Harmony and Beauty into Every Space.', 'https://blisshomeanddesign.com/', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `Nom_Utilisateur` varchar(100) NOT NULL,
  `Prenom_Utilisateur` varchar(100) NOT NULL,
  `Email_Utilisateur` varchar(255) NOT NULL,
  `Password_Utilisateur` varchar(255) NOT NULL,
  `Id_Droit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_Utilisateur`, `Nom_Utilisateur`, `Prenom_Utilisateur`, `Email_Utilisateur`, `Password_Utilisateur`, `Id_Droit`) VALUES
(1, 'Admin', 'Admin', 'admin', '$argon2i$v=19$m=16,t=2,p=1$UTFzQzNEeWpSaHF3eENkUA$Xhq3DRx3Da83rdWtlZs//g', 1),
(2, 'Noël', 'Marie', 'marie.noël@lyceestvincent.fr', '$argon2i$v=19$m=16,t=2,p=1$UTFzQzNEeWpSaHF3eENkUA$Xhq3DRx3Da83rdWtlZs//g', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `droit`
--
ALTER TABLE `droit`
  ADD PRIMARY KEY (`Id_Droit`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`Id_Image`);

--
-- Index pour la table `info_accueil`
--
ALTER TABLE `info_accueil`
  ADD PRIMARY KEY (`Id_Info_Accueil`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Id_Message`),
  ADD KEY `fk_Id_Offre` (`Id_Offre`),
  ADD KEY `fk_Id_Partenaire2` (`Id_Partenaire`);

--
-- Index pour la table `offre`
--
ALTER TABLE `offre`
  ADD PRIMARY KEY (`Id_Offre`),
  ADD KEY `fk_Id_Partenaire` (`Id_Partenaire`);

--
-- Index pour la table `offre_image`
--
ALTER TABLE `offre_image`
  ADD PRIMARY KEY (`Id_Offre`,`Id_Image`),
  ADD KEY `fk_Id_image2` (`Id_Image`),
  ADD KEY `Id_Offre` (`Id_Offre`);

--
-- Index pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD PRIMARY KEY (`Id_Partenaire`),
  ADD KEY `fk_Id_Image` (`Id_Image`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`),
  ADD KEY `fk_Id_Droit` (`Id_Droit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `droit`
  MODIFY `Id_Droit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `Id_Image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `info_accueil`
--
ALTER TABLE `info_accueil`
  MODIFY `Id_Info_Accueil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `Id_Message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `offre`
--
ALTER TABLE `offre`
  MODIFY `Id_Offre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `partenaire`
--
ALTER TABLE `partenaire`
  MODIFY `Id_Partenaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_Id_Offre` FOREIGN KEY (`Id_Offre`) REFERENCES `offre` (`Id_Offre`),
  ADD CONSTRAINT `fk_Id_Partenaire2` FOREIGN KEY (`Id_Partenaire`) REFERENCES `partenaire` (`Id_Partenaire`);

--
-- Contraintes pour la table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `fk_Id_Partenaire` FOREIGN KEY (`Id_Partenaire`) REFERENCES `partenaire` (`Id_Partenaire`);

--
-- Contraintes pour la table `offre_image`
--
ALTER TABLE `offre_image`
  ADD CONSTRAINT `fk_Id_Offre2` FOREIGN KEY (`Id_Offre`) REFERENCES `offre` (`Id_Offre`),
  ADD CONSTRAINT `fk_Id_image2` FOREIGN KEY (`Id_Image`) REFERENCES `image` (`Id_Image`);

--
-- Contraintes pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD CONSTRAINT `fk_Id_Image` FOREIGN KEY (`Id_Image`) REFERENCES `image` (`Id_Image`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_Id_Droit` FOREIGN KEY (`Id_Droit`) REFERENCES `droit` (`Id_Droit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
