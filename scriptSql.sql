-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 19 Mai 2015 à 12:15
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gsb_frais`
--
CREATE DATABASE IF NOT EXISTS `gsb_frais` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gsb_frais`;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
('a131', '201412', 0, NULL, '2015-02-24', 'CL'),
('a131', '201502', 0, NULL, '2015-02-24', 'CR'),
('a17', '201410', 0, NULL, '2014-10-09', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('a131', '201412', 'ETP', 0),
('a131', '201412', 'KM', 0),
('a131', '201412', 'NUI', 0),
('a131', '201412', 'REP', 0),
('a131', '201502', 'ETP', 0),
('a131', '201502', 'KM', 0),
('a131', '201502', 'NUI', 0),
('a131', '201502', 'REP', 0),
('a17', '201410', 'ETP', 0),
('a17', '201410', 'KM', 0),
('a17', '201410', 'NUI', 0),
('a17', '201410', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(20) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `Niveau` int(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `Niveau`) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', 'jux7g', 'bibi', '46000', 'Cahors', '2005-12-21', 1),
('a17', 'Andre', 'David', 'dandre', 'abc', 'oppg5', '69600', 'oullins', '1998-11-23', 1),
('a55', 'Bedos', 'Christian', 'cbedos', 'gmhxd', 'baboula', '69600', 'Oullins', '1995-01-12', 1),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'bic', 'bora bora', '46123', 'Gramat', '2000-05-01', 1),
('b13', 'Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', 1),
('b16', 'Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', 0),
('b19', 'Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', 0),
('b25', 'Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05', 0),
('b28', 'Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12', 0),
('b34', 'Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23', 0),
('b4', 'Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12', 0),
('b50', 'Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 0),
('b59', 'Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', 0),
('c14', 'Daburons', 'François', 'fdaburon', '7oqpv', '45 Boulevard', '69600', 'Oullins', '2002-02-11', 0),
('c3', 'De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', 0),
('c54', 'Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', 0),
('d13', 'Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', 0),
('d51', 'Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', 0),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', 0),
('e24', 'Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', 0),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', 0),
('e49', 'Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', 0),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01', 0),
('e52', 'Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01', 0),
('f21', 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', 0),
('f39', 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01', 0),
('f4', 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', 0),
('z25', 'dede', 'mama', 'dede69', '123', 'fdbvfd', '69600', 'Oullins', '2015-03-05', 0);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `FicheFrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FicheFrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `fk_FraisForfait` FOREIGN KEY (`idVisiteur`) REFERENCES `fichefrais` (`idVisiteur`),
  ADD CONSTRAINT `LigneFraisForfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `LigneFraisForfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `fk_FraisHorsForfait` FOREIGN KEY (`idVisiteur`) REFERENCES `fichefrais` (`idVisiteur`),
  ADD CONSTRAINT `LigneFraisHorsForfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
