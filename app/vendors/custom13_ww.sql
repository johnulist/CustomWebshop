-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 28 Oct 2010 om 13:16
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
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gebruiker_id` int(10) unsigned NOT NULL,
  `huidige_status` varchar(64) NOT NULL,
  `factuurnummer` varchar(32) DEFAULT NULL,
  `besteldatum` datetime DEFAULT NULL,
  `betaalmethode` varchar(64) DEFAULT NULL,
  `betaalcode` varchar(64) DEFAULT NULL,
  `isBetaald` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `betaaldatum` datetime DEFAULT NULL,
  `bed` int(11) NOT NULL,
  `factuuradres` text,
  `afleveradres` text,
  `aflevermethode` varchar(64) DEFAULT NULL,
  `aflevercode` varchar(64) DEFAULT NULL,
  `opmerkingen` text NOT NULL,
  `btw_percentage` tinyint(3) unsigned NOT NULL,
  `subtotaal_excl` decimal(8,2) unsigned NOT NULL,
  `korting_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `verzendkosten_excl` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `totaal_excl` decimal(8,2) unsigned NOT NULL,
  `btw_bedrag` decimal(8,2) unsigned NOT NULL,
  `totaal_incl` decimal(8,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `factuurnummer` (`factuurnummer`),
  KEY `gebruiker_id` (`gebruiker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellingen`
--


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
  `totaal_excl` decimal(8,2) unsigned NOT NULL,
  `btw_bedrag` decimal(8,2) unsigned NOT NULL,
  `totaal_incl` decimal(8,2) unsigned NOT NULL,
  `opmerkingen` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bestelling_id` (`bestelling_id`,`product_id`,`productvariant_id`),
  KEY `product_id` (`product_id`),
  KEY `productvariant_id` (`productvariant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelregels`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelstatussen`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `betaalmethoden`
--

CREATE TABLE IF NOT EXISTS `betaalmethoden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `betaalmethode` varchar(64) NOT NULL,
  `isActief` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `betaalmethoden`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorien`
--

CREATE TABLE IF NOT EXISTS `categorien` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `omschrijving` text NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`,`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `categorien`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `categorien_producten`
--


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
  `f_land` varchar(64) NOT NULL,
  `afleveradres` varchar(128) NOT NULL,
  `a_postcode` varchar(6) NOT NULL,
  `a_plaats` varchar(64) NOT NULL,
  `a_land` varchar(64) NOT NULL,
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
  `korting` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'percentage',
  `emailadres` varchar(128) NOT NULL,
  `wachtwoord` varchar(40) NOT NULL,
  `isBeheerder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 = klant, 1 = beheerder',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emailadres` (`emailadres`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `bedrijfsnaam`, `contactpersoon`, `factuuradres`, `f_postcode`, `f_plaats`, `f_land`, `afleveradres`, `a_postcode`, `a_plaats`, `a_land`, `voorkeurstaal`, `voorkeursvaluta`, `kvknummer`, `btwnummer`, `bank_rekeningnummer`, `bank_tenaamstelling`, `bank_plaats`, `www`, `telefoon`, `mobiel`, `fax`, `korting`, `emailadres`, `wachtwoord`, `isBeheerder`, `created`, `modified`) VALUES
(1, 'Custom Webwinkel', 'Mattijs Meiboom', 'Stockholmstraat 2e', '9723BC', 'Groningen', 'Nederland', 'Stockholmstraat 2e', '9723BC', 'Groningen', 'Nederland', 'dut', 'EUR', 1088252, 'NL110339381B01', '1347.70.854 ', 'Customwebsite', 'Groningen', 'http://www.customwebsite.nl', '0507520161', '0653895448', NULL, 0, 'mattijs@customwebsite.nl', '', 1, '2010-10-28 14:12:31', '2010-10-28 14:12:31');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `instellingen`
--

CREATE TABLE IF NOT EXISTS `instellingen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `value` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `instellingen`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `levermethoden`
--

CREATE TABLE IF NOT EXISTS `levermethoden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `levermethode` varchar(64) NOT NULL,
  `isActief` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `levermethoden`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `merken`
--

CREATE TABLE IF NOT EXISTS `merken` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `naam` (`naam`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `merken`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `productafbeeldingen`
--


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
  `zie_ook` varchar(64) NOT NULL COMMENT 'product-id''s gescheiden door kommas',
  `productcode` varchar(64) NOT NULL,
  `verkoopprijs` decimal(8,2) unsigned NOT NULL,
  `inkoopprijs` decimal(8,2) unsigned DEFAULT NULL,
  `aanbiedingsprijs` decimal(8,2) unsigned DEFAULT NULL,
  `btw` tinyint(3) unsigned NOT NULL COMMENT 'percentage',
  `afbeelding` varchar(128) DEFAULT NULL,
  `voorraad` int(10) unsigned DEFAULT NULL,
  `levertijd` int(11) DEFAULT NULL COMMENT 'in dagen',
  `merk_id` int(10) unsigned DEFAULT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_title` varchar(128) NOT NULL,
  `aantal_keer_verkocht` int(11) NOT NULL DEFAULT '0' COMMENT 'cacheveld',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `merk_id` (`merk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `producten`
--


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
  ADD CONSTRAINT `categorien_producten_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorien_producten_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productafbeeldingen`
--
ALTER TABLE `productafbeeldingen`
  ADD CONSTRAINT `productafbeeldingen_ibfk_2` FOREIGN KEY (`productvariant_id`) REFERENCES `productvarianten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productafbeeldingen_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD CONSTRAINT `producten_ibfk_1` FOREIGN KEY (`merk_id`) REFERENCES `merken` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productvarianten`
--
ALTER TABLE `productvarianten`
  ADD CONSTRAINT `productvarianten_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `producten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
