-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 13 Dec 2010 om 14:38
-- Serverversie: 5.1.43
-- PHP-Versie: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `custom13_ww`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `attributen`
--

CREATE TABLE IF NOT EXISTS `attributen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attributenset_id` int(10) unsigned NOT NULL,
  `naam` varchar(32) NOT NULL,
  `opties` varchar(255) NOT NULL COMMENT 'comma-separated',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attributenset_id` (`attributenset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Bevat optielijsten voor productattributen' AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `attributen`
--

INSERT INTO `attributen` (`id`, `attributenset_id`, `naam`, `opties`, `created`, `modified`) VALUES
(1, 1, 'Maat', 'S,M,L,XL', '2010-11-19 11:54:18', '2010-12-08 09:08:34'),
(2, 2, 'Geheugen', '1Gb,2Gb,4Gb', '2010-11-19 11:56:05', '2010-11-19 11:56:05'),
(3, 2, 'Harde schijf', '180Gb,360Gb,720Gb,1Tb', '2010-11-19 11:56:05', '2010-11-19 11:56:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `attributensets`
--

CREATE TABLE IF NOT EXISTS `attributensets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `naam` (`naam`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `attributensets`
--

INSERT INTO `attributensets` (`id`, `naam`, `created`, `modified`) VALUES
(1, 'Kledingstuk', '2010-11-19 11:54:18', '2010-12-08 09:08:34'),
(2, 'Custom PC', '2010-11-19 11:56:05', '2010-11-19 11:56:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `afbeelding` varchar(32) DEFAULT NULL,
  `tekst` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `actief` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `banners`
--

INSERT INTO `banners` (`id`, `afbeelding`, `tekst`, `url`, `lft`, `rght`, `parent_id`, `created`, `modified`, `actief`) VALUES
(9, 'banners/free-shipping.png', '', '', 5, 6, NULL, '2010-12-03 09:01:23', '2010-12-03 09:40:51', 1),
(10, 'banners/vintage-slide.png', '', 'http://www.noord-holland.nl', 1, 2, NULL, '2010-12-03 09:26:52', '2010-12-08 14:08:20', 1),
(11, 'banners/1_bed-slide.png', '', '', 3, 4, NULL, '2010-12-03 09:41:05', '2010-12-08 14:08:27', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gebruiker_id` int(10) unsigned NOT NULL,
  `huidige_status` varchar(64) NOT NULL,
  `factuurnummer` varchar(32) DEFAULT NULL,
  `factuurdatum` date DEFAULT NULL,
  `factuurtermijn` int(11) DEFAULT NULL COMMENT 'in dagen',
  `besteldatum` datetime DEFAULT NULL,
  `betaalmethode_id` int(10) unsigned DEFAULT NULL,
  `betaalcode` varchar(64) DEFAULT NULL,
  `isBetaald` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `betaaldatum` datetime DEFAULT NULL,
  `factuuradres_adres` varchar(64) DEFAULT NULL,
  `factuuradres_postcode` varchar(10) DEFAULT NULL,
  `factuuradres_plaats` varchar(64) DEFAULT NULL,
  `afleveradres_adres` varchar(64) DEFAULT NULL,
  `afleveradres_postcode` varchar(10) DEFAULT NULL,
  `afleveradres_plaats` varchar(64) DEFAULT NULL,
  `levermethode_id` int(10) unsigned DEFAULT NULL,
  `trackingcode` varchar(64) DEFAULT NULL COMMENT 'voor bijv. TPG',
  `opmerkingen` text,
  `subtotaal_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `subtotaal_btw` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `korting_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `korting_percentage` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `verzendkosten_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `verzendkosten_btw` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `totaal_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `btw_bedrag` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `totaal_incl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `factuurnummer` (`factuurnummer`),
  KEY `gebruiker_id` (`gebruiker_id`),
  KEY `levermethode_id` (`levermethode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`id`, `gebruiker_id`, `huidige_status`, `factuurnummer`, `factuurdatum`, `factuurtermijn`, `besteldatum`, `betaalmethode_id`, `betaalcode`, `isBetaald`, `betaaldatum`, `factuuradres_adres`, `factuuradres_postcode`, `factuuradres_plaats`, `afleveradres_adres`, `afleveradres_postcode`, `afleveradres_plaats`, `levermethode_id`, `trackingcode`, `opmerkingen`, `subtotaal_excl`, `subtotaal_btw`, `korting_excl`, `korting_percentage`, `verzendkosten_excl`, `verzendkosten_btw`, `totaal_excl`, `btw_bedrag`, `totaal_incl`, `created`, `modified`) VALUES
(6, 1, 'bestelling gefactureerd', '23536', '2010-11-22', 14, '2010-11-22 00:00:00', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '175.50', '0.00', '0.00', '0.00', '0.00', '0.00', '175.50', '33.35', '208.85', '2010-11-22 13:23:35', '2010-11-22 14:40:01'),
(8, 1, 'bestelling gefactureerd', '34555', '2010-11-22', 7, '2010-11-22 00:00:00', 2, NULL, 0, NULL, '', '', '', '', '', '', 2, '', '', '10.75', '2.04', '0.00', '0.00', '6.75', '0.00', '17.50', '2.04', '19.54', '2010-11-22 14:40:55', '2010-12-08 14:28:43'),
(13, 1, 'bestelling geplaatst', NULL, NULL, NULL, '2010-11-26 00:00:00', 1, NULL, 0, NULL, NULL, NULL, NULL, '', '', '', 1, NULL, '', '209.50', '39.80', '0.00', '0.00', '10.00', '0.00', '219.50', '39.80', '259.30', '2010-11-26 11:30:21', '2010-12-08 09:55:41'),
(14, 2, 'bestelling gefactureerd', '234', '2010-12-08', NULL, '2010-11-26 00:00:00', 1, NULL, 0, '2010-12-10 00:00:00', 'Oliemulderstraat 18', '9724JE', 'Groningen', 'Oliemulderstraat 16', '9724JE', 'Groningen', 2, '', '', '49.50', '9.40', '0.00', '0.00', '5.00', '0.95', '54.50', '10.35', '64.85', '2010-11-26 11:30:28', '2010-12-10 12:54:06'),
(15, 1, 'bestelling gefactureerd', '7645656734', '2010-12-03', 14, '2010-11-26 00:00:00', 5, NULL, 0, NULL, '', '', '', '', '', '', 1, '', '', '160.75', '30.54', '0.00', '0.00', '0.00', '0.00', '160.75', '30.54', '191.29', '2010-11-26 11:34:17', '2010-12-10 13:46:21'),
(16, 1, 'bestelling gefactureerd', '2353633', '2010-12-03', NULL, '2010-11-26 00:00:00', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, '10.75', '0.00', '0.00', '0.00', '6.75', '0.00', '17.50', '3.33', '20.83', '2010-11-26 11:39:05', '2010-12-03 11:37:13'),
(17, 1, 'bestelling gefactureerd', '50', '2010-11-26', NULL, '2010-11-26 00:00:00', 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '22.00', '0.00', '0.00', '0.00', '0.00', '0.00', '22.00', '4.18', '26.18', '2010-11-26 11:40:37', '2010-11-26 11:42:21'),
(18, 1, 'bestelling gefactureerd', '2343', '2010-12-03', NULL, '2010-12-03 00:00:00', 3, NULL, 1, NULL, 'test adres', '8745 DA', 'test plaats', 'test adrees', '9789 GD', 'test plaats', 2, '', '', '100.00', '19.00', '0.00', '0.00', '6.75', '0.00', '106.75', '19.00', '125.75', '2010-12-03 13:08:16', '2010-12-08 10:26:07'),
(24, 1, 'bestelling geplaatst', NULL, NULL, NULL, '2010-12-08 00:00:00', 3, NULL, 0, NULL, '', '', '', '', '1234AB', 'Groningen', 2, '', '', '173.50', '32.96', '0.00', '0.00', '6.75', '1.28', '180.25', '34.24', '214.49', '2010-12-08 10:34:34', '2010-12-10 09:32:26'),
(25, 1, 'bestelling geplaatst', NULL, NULL, NULL, '2010-12-08 00:00:00', 3, NULL, 1, NULL, '', '', '', '', '1234AB', 'Groningen', 2, '', '', '10.75', '2.04', '0.00', '0.00', '6.75', '1.28', '17.50', '3.32', '20.82', '2010-12-08 10:34:47', '2010-12-08 10:38:03'),
(26, 1, 'bestelling geplaatst', NULL, NULL, NULL, '2010-12-08 00:00:00', 3, NULL, 0, NULL, NULL, '1234AB', 'Groningen', NULL, '1234BA', 'Haren', 2, NULL, NULL, '25.50', '4.84', '0.00', '0.00', '6.75', '1.28', '32.25', '6.12', '38.37', '2010-12-08 10:45:08', '2010-12-08 10:45:08'),
(27, 1, 'bestelling geplaatst', NULL, NULL, NULL, '2010-12-08 00:00:00', 3, NULL, 0, NULL, NULL, '1234AB', 'Groningen', NULL, '1234BA', 'Haren', 2, NULL, NULL, '197.25', '37.47', '0.00', '0.00', '6.75', '1.28', '204.00', '38.75', '242.75', '2010-12-08 10:51:34', '2010-12-08 10:51:34'),
(29, 1, 'Bestelling toegevoegd', NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Stockholmstraat 2e', '1234BA', 'Haren', 2, '', 'Test met toevoegen vanuit beheer', '0.00', '0.00', '0.00', '0.00', '6.75', '1.28', '6.75', '1.28', '8.03', '2010-12-10 13:12:49', '2010-12-10 13:12:49'),
(30, 1, 'Bestelling toegevoegd', NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Stockholmstraat 2e', '1234BA', 'Haren', 2, '', 'Test met toevoegen vanuit beheer', '0.00', '0.00', '0.00', '0.00', '6.75', '1.28', '6.75', '1.28', '8.03', '2010-12-10 13:14:13', '2010-12-10 13:14:13'),
(31, 1, 'Bestelling toegevoegd', NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Stockholmstraat 2e', '1234BA', 'Haren', 2, '', 'Test met toevoegen vanuit beheer', '0.00', '0.00', '0.00', '0.00', '6.75', '1.28', '6.75', '1.28', '8.03', '2010-12-10 13:14:28', '2010-12-10 13:14:28'),
(32, 1, 'Bestelling toegevoegd', NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Stockholmstraat 2e', '1234BA', 'Haren', 2, '', 'Test met toevoegen vanuit beheer', '0.00', '0.00', '0.00', '0.00', '6.75', '1.28', '6.75', '1.28', '8.03', '2010-12-10 13:15:06', '2010-12-10 13:15:06'),
(33, 1, 'Bestelling toegevoegd', NULL, NULL, NULL, NULL, 1, NULL, 1, '2010-03-01 00:00:00', 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Stockholmstraat 2e', '1234BA', 'Haren', 1, '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2010-12-10 13:18:38', '2010-12-10 13:20:33');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelregels`
--

CREATE TABLE IF NOT EXISTS `bestelregels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bestelling_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `productvariant_id` int(10) unsigned DEFAULT NULL,
  `btw_percentage` int(10) unsigned NOT NULL,
  `aantal` int(10) unsigned NOT NULL,
  `prijs_excl` decimal(8,2) unsigned NOT NULL,
  `btw_bedrag` decimal(8,2) unsigned NOT NULL COMMENT 'per stuk',
  `totaal_excl` decimal(8,2) unsigned NOT NULL,
  `totaal_btw` decimal(8,2) NOT NULL COMMENT '- obv totaal_excl en btwpercentage  -',
  `totaal_incl` decimal(8,2) unsigned NOT NULL,
  `opmerkingen` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bestelling_id_2` (`bestelling_id`,`product_id`),
  KEY `bestelling_id` (`bestelling_id`,`product_id`,`productvariant_id`),
  KEY `product_id` (`product_id`),
  KEY `productvariant_id` (`productvariant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelregels`
--

INSERT INTO `bestelregels` (`id`, `bestelling_id`, `product_id`, `productvariant_id`, `btw_percentage`, `aantal`, `prijs_excl`, `btw_bedrag`, `totaal_excl`, `totaal_btw`, `totaal_incl`, `opmerkingen`, `created`, `modified`) VALUES
(1, 6, 4, NULL, 19, 2, '12.75', '2.42', '25.50', '0.00', '30.35', NULL, '2010-11-22 13:23:35', '2010-11-22 13:23:35'),
(2, 6, 1, NULL, 19, 1, '150.00', '28.50', '150.00', '0.00', '178.50', NULL, '2010-11-22 13:23:35', '2010-11-22 13:23:35'),
(6, 8, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-11-22 14:40:55', '2010-12-08 14:28:43'),
(7, 13, 2, NULL, 19, 2, '12.75', '2.42', '25.00', '4.75', '29.75', NULL, '2010-11-26 11:30:21', '2010-12-08 09:55:41'),
(8, 14, 2, NULL, 19, 1, '12.75', '3.80', '15.00', '2.85', '17.85', NULL, '2010-11-26 11:30:28', '2010-12-10 12:54:06'),
(9, 15, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-11-26 11:34:17', '2010-12-10 13:46:21'),
(10, 16, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '0.00', '12.79', NULL, '2010-11-26 11:39:05', '2010-11-26 11:39:05'),
(11, 17, 5, NULL, 19, 2, '11.00', '2.09', '22.00', '0.00', '26.18', NULL, '2010-11-26 11:40:37', '2010-11-26 11:40:37'),
(12, 18, 2, NULL, 19, 1, '12.75', '2.42', '50.00', '9.50', '59.50', NULL, '2010-12-03 13:08:16', '2010-12-08 10:26:07'),
(13, 18, 1, NULL, 19, 1, '150.00', '28.50', '50.00', '9.50', '59.50', NULL, '2010-12-03 13:08:16', '2010-12-08 10:26:07'),
(14, 24, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-12-08 10:34:34', '2010-12-10 09:32:26'),
(15, 25, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-12-08 10:34:47', '2010-12-08 10:38:03'),
(16, 26, 2, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-08 10:45:08', '2010-12-08 10:45:08'),
(17, 27, 2, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-08 10:51:34', '2010-12-08 10:51:34'),
(19, 14, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-12-10 08:57:25', '2010-12-10 12:54:06'),
(37, 14, 5, NULL, 19, 1, '11.00', '2.09', '11.00', '2.09', '13.09', NULL, '2010-12-10 09:28:56', '2010-12-10 12:54:06'),
(38, 14, 4, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-10 09:31:27', '2010-12-10 12:54:06'),
(39, 24, 1, NULL, 19, 1, '150.00', '28.50', '150.00', '28.50', '178.50', NULL, '2010-12-10 09:31:52', '2010-12-10 09:32:26'),
(40, 24, 2, NULL, 19, 3, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-10 09:32:17', '2010-12-10 09:32:26'),
(41, 27, 1, NULL, 19, 1, '150.00', '28.50', '150.00', '28.50', '178.50', NULL, '2010-12-10 09:48:56', '2010-12-10 09:48:56'),
(42, 27, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-12-10 10:06:10', '2010-12-10 10:06:10'),
(43, 27, 4, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-10 10:12:54', '2010-12-10 10:12:54'),
(44, 27, 5, NULL, 19, 1, '11.00', '2.09', '11.00', '2.09', '13.09', NULL, '2010-12-10 10:18:53', '2010-12-10 10:18:53'),
(45, 13, 3, NULL, 19, 1, '10.75', '2.04', '10.75', '2.04', '12.79', NULL, '2010-12-10 10:23:53', '2010-12-10 10:23:53'),
(46, 13, 1, NULL, 19, 1, '150.00', '28.50', '150.00', '28.50', '178.50', NULL, '2010-12-10 10:24:49', '2010-12-10 10:24:49'),
(47, 13, 4, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-10 10:36:44', '2010-12-10 10:36:44'),
(48, 13, 5, NULL, 19, 1, '11.00', '2.09', '11.00', '2.09', '13.09', NULL, '2010-12-10 10:39:45', '2010-12-10 10:39:45'),
(52, 15, 1, NULL, 19, 1, '150.00', '28.50', '150.00', '28.50', '178.50', NULL, '2010-12-10 13:30:22', '2010-12-10 13:46:21'),
(53, 26, 4, NULL, 19, 1, '12.75', '2.42', '12.75', '2.42', '15.17', NULL, '2010-12-10 13:54:02', '2010-12-10 13:54:02');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelstatussen`
--

CREATE TABLE IF NOT EXISTS `bestelstatussen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bestelling_id` int(10) unsigned NOT NULL,
  `status` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bestelling_id` (`bestelling_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelstatussen`
--

INSERT INTO `bestelstatussen` (`id`, `bestelling_id`, `status`, `created`, `modified`) VALUES
(2, 6, 'bestelling gefactureerd', '2010-11-22 14:40:01', '2010-11-22 14:40:01'),
(3, 8, 'bestelling geplaatst', '2010-11-22 14:40:55', '2010-11-22 14:40:55'),
(4, 8, 'bestelling gefactureerd', '2010-11-22 14:42:42', '2010-11-22 14:42:42'),
(5, 13, 'bestelling geplaatst', '2010-11-26 11:30:21', '2010-11-26 11:30:21'),
(6, 14, 'bestelling geplaatst', '2010-11-26 11:30:28', '2010-11-26 11:30:28'),
(7, 15, 'bestelling geplaatst', '2010-11-26 11:34:17', '2010-11-26 11:34:17'),
(8, 16, 'bestelling geplaatst', '2010-11-26 11:39:05', '2010-11-26 11:39:05'),
(9, 17, 'bestelling geplaatst', '2010-11-26 11:40:37', '2010-11-26 11:40:37'),
(10, 17, 'bestelling gefactureerd', '2010-11-26 11:42:21', '2010-11-26 11:42:21'),
(11, 16, 'bestelling gefactureerd', '2010-12-03 11:37:13', '2010-12-03 11:37:13'),
(12, 15, 'bestelling gefactureerd', '2010-12-03 12:55:28', '2010-12-03 12:55:28'),
(13, 18, 'bestelling geplaatst', '2010-12-03 13:08:16', '2010-12-03 13:08:16'),
(14, 18, 'bestelling gefactureerd', '2010-12-03 13:08:46', '2010-12-03 13:08:46'),
(15, 14, 'bestelling gefactureerd', '2010-12-08 09:26:43', '2010-12-08 09:26:43'),
(16, 14, 'bestelling gewijzigd via beheer', '2010-12-08 09:36:35', '2010-12-08 09:36:35'),
(17, 14, 'bestelling gewijzigd via beheer', '2010-12-08 09:39:40', '2010-12-08 09:39:40'),
(18, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:52:58', '2010-12-08 09:52:58'),
(19, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:53:04', '2010-12-08 09:53:04'),
(20, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:55:10', '2010-12-08 09:55:10'),
(21, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:55:14', '2010-12-08 09:55:14'),
(22, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:55:28', '2010-12-08 09:55:28'),
(23, 13, 'bestelling gewijzigd via beheer', '2010-12-08 09:55:41', '2010-12-08 09:55:41'),
(24, 14, 'bestelling gewijzigd via beheer', '2010-12-08 10:04:05', '2010-12-08 10:04:05'),
(25, 14, 'bestelling gewijzigd via beheer', '2010-12-08 10:04:36', '2010-12-08 10:04:36'),
(26, 14, 'bestelling gewijzigd via beheer', '2010-12-08 10:05:36', '2010-12-08 10:05:36'),
(27, 14, 'bestelling gewijzigd via beheer', '2010-12-08 10:06:40', '2010-12-08 10:06:40'),
(28, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:15:38', '2010-12-08 10:15:38'),
(29, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:16:10', '2010-12-08 10:16:10'),
(30, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:16:16', '2010-12-08 10:16:16'),
(31, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:16:23', '2010-12-08 10:16:23'),
(32, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:16:59', '2010-12-08 10:16:59'),
(33, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:17:05', '2010-12-08 10:17:05'),
(34, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:17:18', '2010-12-08 10:17:18'),
(35, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:17:32', '2010-12-08 10:17:32'),
(36, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:18:27', '2010-12-08 10:18:27'),
(37, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:18:39', '2010-12-08 10:18:39'),
(38, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:25:58', '2010-12-08 10:25:58'),
(39, 18, 'bestelling gewijzigd via beheer', '2010-12-08 10:26:07', '2010-12-08 10:26:07'),
(45, 24, 'bestelling geplaatst', '2010-12-08 10:34:34', '2010-12-08 10:34:34'),
(46, 25, 'bestelling geplaatst', '2010-12-08 10:34:47', '2010-12-08 10:34:47'),
(47, 25, 'bestelling gewijzigd via beheer', '2010-12-08 10:38:03', '2010-12-08 10:38:03'),
(48, 26, 'bestelling geplaatst', '2010-12-08 10:45:08', '2010-12-08 10:45:08'),
(49, 27, 'bestelling geplaatst', '2010-12-08 10:51:34', '2010-12-08 10:51:34'),
(56, 8, 'bestelling gewijzigd via beheer', '2010-12-08 14:28:33', '2010-12-08 14:28:33'),
(57, 8, 'bestelling gewijzigd via beheer', '2010-12-08 14:28:39', '2010-12-08 14:28:39'),
(58, 8, 'bestelling gewijzigd via beheer', '2010-12-08 14:28:44', '2010-12-08 14:28:44'),
(59, 24, 'bestelling gewijzigd via beheer', '2010-12-10 09:32:26', '2010-12-10 09:32:26'),
(60, 14, 'bestelling gewijzigd via beheer', '2010-12-10 10:31:39', '2010-12-10 10:31:39'),
(61, 14, 'bestelling gewijzigd via beheer', '2010-12-10 10:42:54', '2010-12-10 10:42:54'),
(78, 14, 'bestelling gewijzigd via beheer', '2010-12-10 12:53:26', '2010-12-10 12:53:26'),
(79, 14, 'bestelling gewijzigd via beheer', '2010-12-10 12:54:06', '2010-12-10 12:54:06'),
(82, 29, 'bestelling gewijzigd via beheer', '2010-12-10 13:12:49', '2010-12-10 13:12:49'),
(83, 30, 'bestelling gewijzigd via beheer', '2010-12-10 13:14:13', '2010-12-10 13:14:13'),
(84, 31, 'bestelling gewijzigd via beheer', '2010-12-10 13:14:28', '2010-12-10 13:14:28'),
(85, 32, 'bestelling gewijzigd via beheer', '2010-12-10 13:15:06', '2010-12-10 13:15:06'),
(86, 33, 'bestelling gewijzigd via beheer', '2010-12-10 13:18:38', '2010-12-10 13:18:38'),
(87, 33, 'bestelling gewijzigd via beheer', '2010-12-10 13:20:27', '2010-12-10 13:20:27'),
(88, 33, 'bestelling gewijzigd via beheer', '2010-12-10 13:20:33', '2010-12-10 13:20:33'),
(89, 15, 'bestelling gewijzigd via beheer', '2010-12-10 13:28:39', '2010-12-10 13:28:39'),
(90, 15, 'bestelling gewijzigd via beheer', '2010-12-10 13:46:21', '2010-12-10 13:46:21');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `betaalmethoden`
--

CREATE TABLE IF NOT EXISTS `betaalmethoden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `betaalmethode` varchar(64) NOT NULL,
  `key` varchar(32) NOT NULL,
  `isActief` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `betaalmethoden`
--

INSERT INTO `betaalmethoden` (`id`, `betaalmethode`, `key`, `isActief`, `created`, `modified`) VALUES
(1, 'Online betalen met iDeal', 'ideal', 1, '2010-11-15 14:16:08', '2010-11-15 14:16:08'),
(2, 'Online betalen met PayPal', 'paypal', 1, '2010-11-15 14:16:08', '2010-11-15 14:16:08'),
(3, 'Overboeken', 'overboeking', 1, '2010-11-15 14:16:31', '2010-11-15 14:16:31'),
(4, 'Machtiging', 'machtiging', 1, '2010-11-15 14:16:31', '2010-11-15 14:16:31'),
(5, 'Contant', 'contant', 1, '2010-12-10 14:44:48', '2010-12-10 14:44:48');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorien`
--

CREATE TABLE IF NOT EXISTS `categorien` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `omschrijving` text NOT NULL,
  `count_producten` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`,`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `categorien`
--

INSERT INTO `categorien` (`id`, `naam`, `slug`, `meta_keywords`, `meta_description`, `meta_title`, `omschrijving`, `count_producten`, `lft`, `rght`, `parent_id`, `created`, `modified`) VALUES
(1, 'Trainingsbroeken', 'trainingsbroeken', NULL, NULL, NULL, 'Allerhande trainingsbroeken.', 0, 13, 20, NULL, '2010-11-01 10:37:25', '2010-11-01 10:37:25'),
(2, 'Heren', 'heren', NULL, NULL, NULL, '', 0, 14, 15, 1, '2010-11-01 10:41:39', '2010-11-01 10:41:39'),
(3, 'Dames', 'dames', NULL, NULL, NULL, '', 0, 16, 17, 1, '2010-11-01 10:41:55', '2010-11-01 10:41:55'),
(4, 'Sportschoenen', 'sportschoenen', NULL, NULL, NULL, '', 0, 1, 12, NULL, '2010-11-01 10:43:09', '2010-11-01 10:43:09'),
(5, 'Heren', 'heren-1', NULL, NULL, NULL, '', 0, 2, 9, 4, '2010-11-01 11:00:24', '2010-11-01 11:00:24'),
(6, 'Maat 38-41', 'maat-38-41', NULL, NULL, NULL, '', 0, 3, 4, 5, '2010-11-01 11:00:39', '2010-11-01 11:00:39'),
(7, 'Maat 42-44', 'maat-42-44', '', '', '', '', 0, 5, 6, 5, '2010-11-01 11:00:51', '2010-12-08 12:49:29'),
(8, 'Maat 45+', 'maat-45', NULL, NULL, NULL, '', 0, 7, 8, 5, '2010-11-01 11:01:00', '2010-11-01 11:01:00'),
(9, 'Kinderen', 'kinderen', 'trainingsbroeken, kinderen', 'Alle mooie trainingsbroeken voor kinderen', 'Trainingsbroeken voor kinderen', '', 0, 18, 19, 1, '2010-12-03 11:26:53', '2010-12-03 11:26:53'),
(10, 'Ballenbak', 'ballenbak', '', '', '', '<p>ballen in de bak</p>', 0, 10, 11, 4, '2010-12-03 13:08:20', '2010-12-03 13:08:20'),
(11, 'Computerschermen', 'computerschermen', '', '', '', '', 0, 21, 22, NULL, '2010-12-08 12:49:47', '2010-12-08 12:49:47');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorien_producten`
--

CREATE TABLE IF NOT EXISTS `categorien_producten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categorie_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=146 ;

--
-- Gegevens worden uitgevoerd voor tabel `categorien_producten`
--

INSERT INTO `categorien_producten` (`id`, `categorie_id`, `product_id`) VALUES
(1, 1, 4),
(2, 3, 4),
(3, 4, 4),
(34, 5, 5),
(35, 6, 5),
(36, 1, 5),
(103, 5, 2),
(104, 6, 2),
(142, 6, 1),
(143, 7, 1),
(144, 8, 1),
(145, 10, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bedrijfsnaam` varchar(64) DEFAULT NULL,
  `contactpersoon` varchar(64) NOT NULL,
  `factuuradres` varchar(128) NOT NULL,
  `f_postcode` varchar(6) NOT NULL,
  `f_plaats` varchar(64) NOT NULL,
  `f_land` varchar(64) NOT NULL DEFAULT 'Nederland',
  `afleveradres` varchar(128) NOT NULL,
  `a_postcode` varchar(6) NOT NULL,
  `a_plaats` varchar(64) NOT NULL,
  `a_land` varchar(64) NOT NULL DEFAULT 'Nederland',
  `voorkeurstaal` varchar(3) NOT NULL DEFAULT 'dut',
  `voorkeursvaluta` varchar(3) NOT NULL DEFAULT 'EUR',
  `kvknummer` int(8) unsigned DEFAULT NULL,
  `btwnummer` varchar(16) DEFAULT NULL,
  `bank_rekeningnummer` varchar(16) DEFAULT NULL,
  `bank_tenaamstelling` varchar(64) DEFAULT NULL,
  `bank_plaats` varchar(64) DEFAULT NULL,
  `www` varchar(64) DEFAULT NULL,
  `telefoon` varchar(16) DEFAULT NULL,
  `mobiel` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `korting` int(10) unsigned DEFAULT '0' COMMENT 'percentage',
  `emailadres` varchar(128) NOT NULL,
  `wachtwoord` varchar(40) NOT NULL,
  `isBeheerder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 = klant, 1 = beheerder',
  `count_bestellingen` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emailadres` (`emailadres`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `bedrijfsnaam`, `contactpersoon`, `factuuradres`, `f_postcode`, `f_plaats`, `f_land`, `afleveradres`, `a_postcode`, `a_plaats`, `a_land`, `voorkeurstaal`, `voorkeursvaluta`, `kvknummer`, `btwnummer`, `bank_rekeningnummer`, `bank_tenaamstelling`, `bank_plaats`, `www`, `telefoon`, `mobiel`, `fax`, `korting`, `emailadres`, `wachtwoord`, `isBeheerder`, `count_bestellingen`, `created`, `modified`) VALUES
(1, 'Custom Webwinkel', 'Mattijs Meiboom', 'Stockholmstraat 2e', '1234AB', 'Groningen', 'Nederland', 'Stockholmstraat 2e', '1234BA', 'Haren', 'Duitsland', '0', 'EUR', 1088252, 'NL110339381B01', '', '', 'Groningen', 'http://www.customwebsite.nl', '0507520161', '0645548749', '', 0, 'mattijs@customwebsite.nl', '8d0d7030902a7883582bfb66ab43effc3d23b3e1', 1, 0, '2010-11-01 10:24:55', '2010-12-08 11:24:36'),
(2, '', 'Patrick de Vos', '', '', '', '', '', '', '', '', '0', '', NULL, '', '', '', '', NULL, '', '', '', NULL, '', '26ac6a43d5940174a1f4f871d57eeeac4d9b127e', 0, 0, '2010-11-01 14:32:53', '2010-11-15 16:19:26'),
(3, '', 'Jeroen bos', 'Geldstraat 1', '9734KG', 'Haren', 'Nederland', 'Pakjeslaan 34', '9865HD', 'Glimmen', 'Nederland', '0', '', NULL, '', '', '', '', NULL, '0521 - 850931', '06 53368677', '', NULL, 'info@jeroenbos.nl', 'e461f338abca5940f44e376bcc965873bcb39321', 0, 0, '2010-11-17 12:30:48', '2010-12-10 12:55:42'),
(5, '', 'Jan Jansen', '', '', '', 'Nederland', '', '', '', 'Nederland', '0', 'EUR', NULL, '', '', '', '', NULL, '', '', '', 0, 'jan@customwebsite.nl', '8d0d7030902a7883582bfb66ab43effc3d23b3e1', 0, 0, '2010-12-01 14:19:28', '2010-12-08 11:23:46');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `i18n`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `instellingen`
--

CREATE TABLE IF NOT EXISTS `instellingen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `omschrijving` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Gegevens worden uitgevoerd voor tabel `instellingen`
--

INSERT INTO `instellingen` (`id`, `key`, `value`, `created`, `modified`, `omschrijving`) VALUES
(1, 'Site.naam', 'Custom Webshop', '2010-11-01 10:39:14', '2010-11-01 10:39:14', 'De naam van de webshop wordt gebruikt om deze aan zowel de bezoeker als zoekmachines te communiceren. Voorbeeld: ''Custom Webshop''.'),
(2, 'Site.locales', 'dut,eng,ger', '2010-11-01 15:29:56', '2010-11-01 15:29:56', 'De lijst met locales bepaalt de talen die in de webshop worden ondersteund. Vereiste is wel dat er voor de opgegeven talen een woordenboek aanwezig is op de server.'),
(3, 'Site.root_id', '1', '2010-12-03 11:07:39', '2010-12-03 11:07:39', 'ID van de paginaroot'),
(4, 'Site.meta_title', 'Custom Webshop', '2010-12-03 11:30:36', '2010-12-03 11:30:36', 'Default titel voor zoekmachines. Deze wordt overschreven door titels bij producten/categorien etc.'),
(5, 'Site.meta_description', 'Custom Webshop, Webshop, maatwerk, eenvoudig, online', '2010-12-03 11:30:36', '2010-12-03 11:30:36', 'Default description voor zoekmachines. Deze wordt overschreven door titels bij producten/categorien etc.'),
(6, 'Site.meta_keywords', 'Custom Webshop, Webshop, maatwerk, eenvoudig, online', '2010-12-03 11:31:34', '2010-12-03 11:31:34', 'Standaard keywords voor zoekmachines. Deze worden overschreven door paginaspecifieke keywords.'),
(9, 'Site.analytics', '', '2010-12-08 13:12:23', '2010-12-08 12:18:55', 'Een HTML-fragment voor het toevoegen van Google Analytics aan de website. Wordt automatisch geactiveerd indien de code niet leeg is.'),
(10, 'Site.gratisVerzendingVanaf', '100', '2010-12-08 13:20:28', '2010-12-08 12:20:52', 'Indien het totaal van een bestelling hoger is dan het opgegeven bedrag, worden er geen verzendkosten gerekend. Laat leeg om altijd verzendkosten te berekenen.'),
(11, 'Site.afzendAdres', 'info@customwebshop.nl', '2010-12-10 09:19:33', '2010-12-10 09:19:33', 'Dit emailadres wordt gebruikt als afzendadres bij het verzenden van mails uit het systeem naar derden.'),
(12, 'Shop.bedrijfsnaam', 'Custom Webwinkel', '2010-12-10 12:07:53', '2010-12-10 12:07:53', ''),
(13, 'Shop.adres', 'Stockholmstraat 2e', '2010-12-10 12:07:53', '2010-12-10 12:07:53', ''),
(14, 'Shop.postcode', '1234AB', '2010-12-10 12:08:12', '2010-12-10 12:08:12', ''),
(15, 'Shop.plaats', 'Groningen', '2010-12-10 12:08:12', '2010-12-10 12:08:12', ''),
(16, 'Shop.telefoon', '050-5350636', '2010-12-10 12:08:41', '2010-12-10 12:08:41', ''),
(17, 'Shop.fax', '040-5350903', '2010-12-10 12:08:41', '2010-12-10 12:08:41', ''),
(18, 'Shop.emailadres', 'info@customwebsite.nl', '2010-12-10 12:09:14', '2010-12-10 12:09:14', ''),
(19, 'Shop.www', 'www.customwebsite.nl', '2010-12-10 12:09:14', '2010-12-10 12:09:14', ''),
(22, 'Shop.kvk', '1546 4838', '2010-12-10 12:10:07', '2010-12-10 12:10:07', ''),
(23, 'Shop.btw', 'NLB468566', '2010-12-10 12:10:07', '2010-12-10 12:10:07', ''),
(24, 'Shop.bankNaam', 'ABN Amro', '2010-12-10 12:10:44', '2010-12-10 12:10:44', ''),
(25, 'Shop.bankNummer', '486430413', '2010-12-10 12:10:44', '2010-12-10 12:10:44', ''),
(26, 'Shop.bankPlaats', 'Groningen', '2010-12-10 12:11:12', '2010-12-10 12:11:12', ''),
(27, 'Shop.bankIban', 'NL35209834698', '2010-12-10 12:11:12', '2010-12-10 12:11:12', ''),
(28, 'Shop.bankBIC', '83652430', '2010-12-10 12:11:29', '2010-12-10 12:11:29', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `levermethoden`
--

CREATE TABLE IF NOT EXISTS `levermethoden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `levermethode` varchar(64) NOT NULL,
  `isActief` int(11) NOT NULL DEFAULT '1',
  `flagMetAdres` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `verzendkosten_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `btw` int(10) unsigned NOT NULL DEFAULT '19',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `levermethoden`
--

INSERT INTO `levermethoden` (`id`, `levermethode`, `isActief`, `flagMetAdres`, `verzendkosten_excl`, `btw`, `created`, `modified`) VALUES
(1, 'afhalen', 1, 1, '0.00', 19, '2010-11-15 13:51:45', '2010-11-15 13:51:45'),
(2, 'verzenden met TNT', 1, 1, '6.75', 19, '2010-11-15 13:51:45', '2010-11-15 13:51:45');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `merken`
--

CREATE TABLE IF NOT EXISTS `merken` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `flagToonInMenu` int(10) unsigned NOT NULL DEFAULT '1',
  `count_producten` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `naam` (`naam`,`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `merken`
--

INSERT INTO `merken` (`id`, `naam`, `slug`, `flagToonInMenu`, `count_producten`, `created`, `modified`) VALUES
(1, 'Reebok', 'reebok', 1, 0, '2010-11-01 10:15:53', '2010-11-01 14:39:57'),
(2, 'Adidas', 'adidas', 0, 0, '2010-11-01 10:19:40', '2010-12-03 11:21:29'),
(3, 'Nike', 'nike', 1, 0, '2010-11-01 10:19:45', '2010-11-01 10:19:45'),
(4, 'Iadora', 'iadora', 1, 0, '2010-11-01 10:19:51', '2010-11-01 10:19:51'),
(5, 'Iadora', 'iadora-1', 1, 0, '2010-12-10 12:36:20', '2010-12-10 12:36:20'),
(6, 'G-Star', 'g-star', 1, 0, '2010-12-10 12:36:49', '2010-12-10 12:36:49');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `gepubliceerd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`,`lft`,`rght`),
  KEY `gepubliceerd` (`gepubliceerd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `paginas`
--

INSERT INTO `paginas` (`id`, `parent_id`, `lft`, `rght`, `slug`, `url`, `titel`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `created`, `updated`, `gepubliceerd`) VALUES
(1, NULL, 1, 10, '', '', 'Root', 'Verwijder deze pagina niet, dient als placeholder!', NULL, '', '', '2010-12-03 11:04:47', '2010-12-03 11:04:47', 0),
(2, 1, 2, 9, 'home', '/', 'Home', '<p>placeholder - de webshop bevat default slider en aanbiedingen op de homepage.</p>', '', '', '', '2010-12-03 10:08:38', '2010-12-03 10:08:38', 0),
(4, 2, 3, 4, 'contact', '/contact/', 'Contact', '<p>Test</p>', '', '', '', '2010-12-03 10:10:27', '2010-12-03 10:19:56', 1),
(5, 2, 5, 6, 'disclaimer', '/disclaimer/', 'Disclaimer', '<p>Disclaimer</p>', '', '', '', '2010-12-03 10:20:36', '2010-12-03 10:20:36', 1),
(6, 2, 7, 8, 'algemene-voorwaarden', '/algemene-voorwaarden/', 'Algemene Voorwaarden', '<p>Voorwaarden</p>', 'Algemene voorwaarden', '', '', '2010-12-03 10:20:50', '2010-12-03 10:28:54', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productafbeeldingen`
--

CREATE TABLE IF NOT EXISTS `productafbeeldingen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bestandsnaam` varchar(64) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `productvariant_id` int(10) unsigned DEFAULT NULL,
  `isHoofdafbeelding` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bestandsnaam` (`bestandsnaam`),
  KEY `product_id` (`product_id`,`productvariant_id`),
  KEY `productvariant_id` (`productvariant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Gegevens worden uitgevoerd voor tabel `productafbeeldingen`
--

INSERT INTO `productafbeeldingen` (`id`, `bestandsnaam`, `product_id`, `productvariant_id`, `isHoofdafbeelding`, `created`, `modified`) VALUES
(4, 'producten/isdfsdoi.jpg', 2, NULL, 1, '2010-11-08 13:37:59', '2010-11-08 13:37:59'),
(5, 'producten/2_sdfseewewws.jpg', 2, NULL, 0, '2010-11-15 12:19:09', '2010-11-15 12:19:09'),
(6, 'producten/1_dfqqdf.jpg', 2, NULL, 0, '2010-11-15 12:19:19', '2010-11-15 12:19:19'),
(7, 'producten/IMG_3519.jpeg', 1, NULL, 1, '2010-11-17 11:58:37', '2010-11-17 11:58:37');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE IF NOT EXISTS `producten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `omschrijving_kort` varchar(255) NOT NULL,
  `omschrijving_lang` text NOT NULL,
  `zie_ook` varchar(64) DEFAULT NULL COMMENT 'product-id''s gescheiden door kommas',
  `productcode` varchar(64) DEFAULT NULL,
  `verkoopprijs` decimal(8,2) unsigned NOT NULL,
  `inkoopprijs` decimal(8,2) unsigned DEFAULT NULL,
  `aanbiedingsprijs` decimal(8,2) unsigned DEFAULT NULL,
  `btw` tinyint(3) unsigned NOT NULL COMMENT 'percentage',
  `afbeelding` varchar(128) DEFAULT NULL,
  `voorraad` int(10) unsigned DEFAULT NULL,
  `ooktekoopids` varchar(128) DEFAULT NULL,
  `levertijd` int(11) DEFAULT NULL COMMENT 'in dagen',
  `levereenheid` enum('weken','dagen') NOT NULL DEFAULT 'dagen' COMMENT 'dagen',
  `merk_id` int(10) unsigned DEFAULT NULL,
  `attributenset_id` int(10) unsigned DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `aantal_keer_verkocht` int(11) NOT NULL DEFAULT '0' COMMENT 'cacheveld',
  `beschikbaar` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `count_categorien` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productcode` (`productcode`),
  KEY `merk_id` (`merk_id`),
  KEY `attributenset_id` (`attributenset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `slug`, `omschrijving_kort`, `omschrijving_lang`, `zie_ook`, `productcode`, `verkoopprijs`, `inkoopprijs`, `aanbiedingsprijs`, `btw`, `afbeelding`, `voorraad`, `ooktekoopids`, `levertijd`, `levereenheid`, `merk_id`, `attributenset_id`, `meta_keywords`, `meta_description`, `meta_title`, `aantal_keer_verkocht`, `beschikbaar`, `count_categorien`, `created`, `modified`) VALUES
(1, 'Nike Air Max 2010', 'nike-air-max-2010', '', '<p>&nbsp;</p>\r\n<table border="0" cellspacing="0" cellpadding="0" width="449">\r\n<col style="width: 337pt;" width="449"></col> \r\n<tbody>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt; width: 337pt;" width="449" height="20">art code</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">product naam</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">btw</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">merk</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">hoofdafbeeldinge</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">categorie tonen ( meerderen</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">Lange omschrijving</td>\r\n</tr>\r\n<tr style="height: 15pt;" height="20">\r\n<td class="xl65" style="height: 15pt;" height="20">korte omschrijving</td>\r\n</tr>\r\n</tbody>\r\n</table>', NULL, '2547ER', '150.00', NULL, NULL, 19, NULL, NULL, '2,3,4', NULL, 'weken', 3, NULL, 'Keywords', 'Description', 'Producttitel', 0, 0, 0, '2010-11-01 11:09:27', '2010-12-13 14:13:56'),
(2, 'Nike Air Max 2010', 'nike-air-max-2010', 'Nike Trainer Jacket in de "Old School-sterkte" kleur combinatie die perfect past op een gewassen jeans. Side rits met logo in reliÃ«f op metalen aanhangwagens de ritsen. De donkerblauwe pijp aan de achterkant is ook geschikt. 53% polyester, 47% katoen.', 'Nike Trainer Jacket in de "Old School-sterkte" kleur combinatie die perfect past op een gewassen jeans. Side rits met logo in reliÃ«f op metalen aanhangwagens de ritsen. De donkerblauwe pijp aan de achterkant is ook geschikt. 53% polyester, 47% katoen.', NULL, '2547ER1', '12.75', NULL, NULL, 19, NULL, NULL, NULL, 2, 'dagen', 2, NULL, '', '', '', 0, 1, 0, '2010-11-01 13:50:43', '2010-11-15 12:30:06'),
(3, 'Nike Air Max 2010', 'nike-air-max-2010', 'Kort', '', NULL, '2547ER2', '12.75', NULL, '10.75', 19, NULL, 3, NULL, NULL, 'dagen', 2, NULL, '', '', '', 0, 1, 0, '2010-11-01 13:53:17', '2010-11-04 13:54:21'),
(4, 'Nike Air Max 2010', 'nike-air-max-2010-1', 'Kort', '', NULL, '2547ER3', '12.75', NULL, NULL, 19, NULL, NULL, NULL, NULL, 'dagen', 2, NULL, '', '', '', 0, 1, 0, '2010-11-01 13:54:31', '2010-11-01 13:54:31'),
(5, 'Nike Air Max 2010', 'nike-air-max-2010', 'Kort', 'Lang', NULL, '123', '12.75', NULL, '11.00', 19, NULL, 2, NULL, NULL, 'dagen', 2, NULL, '', '', '', 0, 1, 0, '2010-11-01 13:55:27', '2010-11-04 14:22:59');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productvarianten`
--

CREATE TABLE IF NOT EXISTS `productvarianten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant` varchar(128) NOT NULL,
  `verkoopprijs` decimal(8,2) unsigned DEFAULT NULL,
  `inkoopprijs` decimal(8,2) unsigned DEFAULT NULL,
  `aanbiedingsprijs` decimal(8,2) unsigned DEFAULT NULL,
  `voorraad` int(10) unsigned DEFAULT NULL,
  `levertijd` int(10) unsigned DEFAULT NULL COMMENT 'in dagen',
  `product_id` int(10) unsigned NOT NULL,
  `aantal_keer_verkocht` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `productvarianten`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recensies`
--

CREATE TABLE IF NOT EXISTS `recensies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `gebruiker_id` int(10) unsigned DEFAULT NULL,
  `auteur` varchar(64) NOT NULL,
  `recensie` text NOT NULL,
  `waardering` int(10) unsigned NOT NULL COMMENT 'van 1 tot 10',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`gebruiker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `recensies`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titel` varchar(64) NOT NULL,
  `omschrijving` varchar(255) NOT NULL,
  `afbeelding` varchar(64) NOT NULL,
  `prioriteit` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(128) NOT NULL,
  `isActief` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `slider`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `template` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `templates`
--


--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `attributen`
--
ALTER TABLE `attributen`
  ADD CONSTRAINT `attributen_ibfk_1` FOREIGN KEY (`attributenset_id`) REFERENCES `attributensets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`);

--
-- Beperkingen voor tabel `bestelregels`
--
ALTER TABLE `bestelregels`
  ADD CONSTRAINT `bestelregels_ibfk_1` FOREIGN KEY (`bestelling_id`) REFERENCES `bestellingen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bestelregels_ibfk_2` FOREIGN KEY (`productvariant_id`) REFERENCES `productvarianten` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `bestelregels_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bestelstatussen`
--
ALTER TABLE `bestelstatussen`
  ADD CONSTRAINT `bestelstatussen_ibfk_1` FOREIGN KEY (`bestelling_id`) REFERENCES `bestellingen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `categorien_producten`
--
ALTER TABLE `categorien_producten`
  ADD CONSTRAINT `categorien_producten_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorien_producten_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productafbeeldingen`
--
ALTER TABLE `productafbeeldingen`
  ADD CONSTRAINT `productafbeeldingen_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productafbeeldingen_ibfk_2` FOREIGN KEY (`productvariant_id`) REFERENCES `productvarianten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD CONSTRAINT `producten_ibfk_1` FOREIGN KEY (`merk_id`) REFERENCES `merken` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `producten_ibfk_2` FOREIGN KEY (`attributenset_id`) REFERENCES `attributensets` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productvarianten`
--
ALTER TABLE `productvarianten`
  ADD CONSTRAINT `productvarianten_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
