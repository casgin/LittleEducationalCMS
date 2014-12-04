-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Host: 127.2.100.2:3306
-- Generato il: Dic 04, 2014 alle 20:36
-- Versione del server: 5.5.40
-- Versione PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `supercms`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `pagine`
--

CREATE TABLE IF NOT EXISTS `pagine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(250) NOT NULL,
  `titolo` varchar(250) NOT NULL,
  `abstract` text NOT NULL,
  `testo` longtext NOT NULL,
  `immagine` varchar(250) NOT NULL,
  `data_pubblicazione` datetime NOT NULL,
  `stato` enum('pubblicata','bozza','cestino') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `topmenu`
--

CREATE TABLE IF NOT EXISTS `topmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `css_class` varchar(80) NOT NULL,
  `ordine` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nominativo` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(13) NOT NULL,
  `ruolo` enum('admin','editor','readonly') NOT NULL,
  `attivo` enum('attivo','disattivo') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nominativo`, `email`, `passwd`, `ruolo`, `attivo`) VALUES
(1, 'Gianfranco Castro', 'gianfranco.castro@gmail.com', 'ciao', 'admin', 'attivo'),
(2, 'Armando Maradona', 'armando.maradona@gmail.com', 'armando', 'editor', 'attivo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
