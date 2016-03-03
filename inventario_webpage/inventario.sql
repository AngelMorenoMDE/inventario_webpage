-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2016 a las 17:36:41
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `id_building` int(11) NOT NULL AUTO_INCREMENT,
  `name_building` varchar(50) NOT NULL,
  `id_campus` int(11) NOT NULL,
  PRIMARY KEY (`id_building`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `building`
--

INSERT INTO `building` (`id_building`, `name_building`, `id_campus`) VALUES
(18, 'Rectorado', 1),
(19, 'Ampliación Rectorado', 1),
(20, 'Departamental I', 1),
(21, 'Departamental II', 1),
(22, 'Aulario I', 1),
(23, 'Aulario II', 1),
(24, 'Aulario III', 1),
(25, 'Laboratorios I', 1),
(26, 'Laboratorios II', 1),
(27, 'Laboratorios III', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campus`
--

CREATE TABLE IF NOT EXISTS `campus` (
  `id_campus` int(11) NOT NULL AUTO_INCREMENT,
  `name_campus` varchar(50) NOT NULL,
  PRIMARY KEY (`id_campus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `campus`
--

INSERT INTO `campus` (`id_campus`, `name_campus`) VALUES
(1, 'Móstoles'),
(2, 'Alcorcón'),
(3, 'Vicálvaro'),
(4, 'Fuenlabrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_driver_type`
--

CREATE TABLE IF NOT EXISTS `category_driver_type` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `category_driver_type`
--

INSERT INTO `category_driver_type` (`id_category`, `name_category`) VALUES
(1, 'video'),
(2, 'audio'),
(3, 'lan'),
(4, 'chipset'),
(5, 'bios'),
(6, 'usb'),
(7, 'device'),
(8, 'impresora'),
(9, 'escaner'),
(10, 'teclado'),
(11, 'raton');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cd_type`
--

CREATE TABLE IF NOT EXISTS `cd_type` (
  `id_cd_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_cd_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cd_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `cd_type`
--

INSERT INTO `cd_type` (`id_cd_type`, `name_cd_type`) VALUES
(1, 'No tiene'),
(2, 'CD'),
(3, 'CDRW'),
(4, 'DVD'),
(5, 'DVDRW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computer`
--

CREATE TABLE IF NOT EXISTS `computer` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `type_computer` varchar(50) DEFAULT NULL,
  `cpu_name` varchar(50) DEFAULT NULL,
  `no_mhz` int(11) DEFAULT NULL,
  `ram_type` varchar(50) DEFAULT NULL,
  `ram_mb` int(11) DEFAULT NULL,
  `hdd1_type` varchar(50) DEFAULT NULL,
  `hdd1_gb` int(11) DEFAULT NULL,
  `hdd2_type` varchar(50) DEFAULT NULL,
  `hdd2_gb` int(11) DEFAULT NULL,
  `graphic_card` varchar(50) DEFAULT NULL,
  `sound_card` varchar(50) DEFAULT NULL,
  `ethernet_card` varchar(50) DEFAULT NULL,
  `id_cd_unit1` int(11) DEFAULT NULL,
  `id_cd_unit2` int(11) DEFAULT NULL,
  `vga` tinyint(4) DEFAULT NULL,
  `dvi` tinyint(4) DEFAULT NULL,
  `hdmi` tinyint(4) DEFAULT NULL,
  `no_usb` int(11) DEFAULT NULL,
  `ssoo` varchar(50) DEFAULT NULL,
  `ssoo_type` varchar(20) DEFAULT NULL,
  `name_equip` varchar(50) DEFAULT NULL,
  `domain` varchar(50) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `mask` varchar(20) DEFAULT NULL,
  `dns_1` varchar(20) DEFAULT NULL,
  `dns_2` varchar(20) DEFAULT NULL,
  `gateway` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `computer`
--

INSERT INTO `computer` (`id_electronic_eq`, `trademark`, `model`, `type_computer`, `cpu_name`, `no_mhz`, `ram_type`, `ram_mb`, `hdd1_type`, `hdd1_gb`, `hdd2_type`, `hdd2_gb`, `graphic_card`, `sound_card`, `ethernet_card`, `id_cd_unit1`, `id_cd_unit2`, `vga`, `dvi`, `hdmi`, `no_usb`, `ssoo`, `ssoo_type`, `name_equip`, `domain`, `ip`, `mask`, `dns_1`, `dns_2`, `gateway`) VALUES
(167, 'clonico', '0', '1', 'Pentium  IV 2666MHz', 2666, '1', 1280, '1', 40, '1', -1, 'NVIDIA RIVA TNT2 Model 64/Model 64  16MB', 'Intel 828001DB ICH4 AC,97 Audio Controller  [A-1]', 'Fast Ethernet Ovislink LFE 8139ATX', 1, 1, 0, 0, 0, 4, 'Windows XP', 'Profesional SP3', 'hermes', 'kybele', '212.128.1.250', '0.0.0.0', '193.147.184.2', '193.147.184.11', '212.128.1.1'),
(168, 'clonico', '0', '1', 'Intel Pentium D930 3000MHz', 3000, '2', 1200, '3', 160, '2', 74, 'ATI Radeon X1050', 'Intel 82801GB ICH7', 'Realtek PCI 6BE Family Controller', 5, 1, 1, 0, 0, 6, 'Windows XP', 'Profesional SP3', 'argos', 'kybele', '193.147.52.77', '0.0.0.0', '193.147.184.2', '193.147.184.11', '212.128.1.1'),
(169, 'clonico', '0', '1', 'Dual Cuore Intel Core Duo E 6320 1866MHz', 1866, '1', 1024, '1', 80, '1', -1, 'RANDEON X1050 (RV370) (256MB)', 'Realtec ALC 883@VIA VT8237A', 'Realtek RTL 8169/8110 Family Gigabyte', 1, 1, 0, 0, 0, 6, 'Windows XP', 'Profesional SP3', 'antigona', 'kybele', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(170, 'clonico', '0', '1', 'Intel Pentium III 731MHz', 731, '2', 348, '2', 40, '1', -1, 'ATI RAGE', '', '', 2, 4, 1, 0, 0, 2, 'Windows XP', 'Profesional SP3', 'harmonia', 'kybele', '193.147.52.39', '0.0.0.0', '193.147.184.2', '193.147.184.7', '212.128.1.1'),
(171, 'clónico', '0', '1', 'Intel Pentium IV 2657 MHz', 2627, '3', 2048, '2', 40, '2', 40, 'VGA Standard (32MB)', 'Creative SB PCI 128 (Ensoniq ES 5880) Sound Card', 'Realtek RTL 8139/810x Family Fast Ethernet NIC', 5, 1, 1, 0, 0, 4, 'Windows 7', 'Profesional', 'anquises', '', '193.147.52.73', '0.0.0.0', '193.147.184.2', '192.147.184.11', '193.147.52.1'),
(172, 'clónico', '0', '1', 'Dual Core Intel Core 2 Duo 2666MHz', 2666, '3', 2038, '3', 320, '3', -1, 'Intel G33 G31 Express Chipset Family 256MB', 'Intel 82801GB ICH7 High Definition Controller A-1', 'Realtek RTL 8102E Family PCI-E Fast Ethernet NIC', 4, 1, 0, 0, 0, 7, 'Windows XP', 'Profesional SP3', 'selene', 'kybele', '212.128.1.130', '0.0.0.0', '192.147.184.2', '193.147.184.11', '212.128.1.1'),
(174, 'clónico', '0', '1', 'Intel Pentium IV 3000 MHz', 3000, '2', 2048, '3', 160, '1', -1, 'Intel 82801EB ICH5-AC97 Audio Controller A-2 A-3', 'RANDEON 9250 Secondary (128 MB)', 'MT PRO/100 de Intel', 4, 1, 0, 0, 0, -1, 'Windows XP', 'Profesional SP3', 'artemisa', 'kybele', '193.147.71.195', '0.0.0.0', '193.147.184.2', '193.147.184.11', '193.147.71.129'),
(175, 'clónico', '0', '1', 'Dual Core Intel Pentium D930 3000MHz', 3000, '3', 1024, '3', 160, '3', 120, 'Randeon (Microsoft WDDM)(256 MB)', 'Analog Devices AD1986A Intel 82801GBICH7 ', 'NIC Gigabit Ethernet PCI-E Realtek RTL8168B/8111B', 5, 1, 1, 1, 0, 8, 'Windows 7', 'Profesional', 'rsantaescolasti', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(176, 'clónico', '0', '1', 'Intel Pentium IV 2666MHz', 2666, '2', 768, '2', 18, '1', -1, 'NVIDIA GEFORCE MX 440  AGP8X (64MB)', 'VIA AC 97 Enhanced Audio Controller', 'NIC Fast Ethernet PCI Familia RTL8139 Realtek', 4, 1, 1, 0, 0, 4, 'Windows XP', 'Profesional SP3', 'atlante', 'kybele', '212.128.1.150', '193.147.184.11', '193.147.184.2', '212.128.1.1', '0.0.0.0'),
(177, 'clónico', '0', '1', 'Dual Core Intel Core2 Duo 1866MHz', 1866, '3', 2048, '2', 400, '2', 80, 'ATI Randeon X1050 Secundary (512MB)', 'VIA VT8237A High Definition Audio Controller', 'Realtek RTL8169/8110 Family Gigabit Ethernet NIC', 5, 1, 1, 1, 0, 6, 'Windows XP', 'Profesional SP2', 'eros', 'kybele', '212.128.1.101', '0.0.0.0', '193.147.184.2', '193.147.184.7', '212.128.1.1'),
(178, 'clónico', '0', '1', 'Intel Pentium III 600MHz', 600, '2', 384, '2', 0, '1', -1, 'ATI 3D RAGE II C AGP (8MB)', 'Creative SB PCI128 (Ensoniq ES1371)', 'Intel 21143 (Genérico)', 2, 1, 1, 0, 0, 2, 'Windows XP', 'Profesional SP3', 'cronos', 'kybele', '212.128.1.204', '0.0.0.0', '193.147.184.2', '193.147.184.11', '212.128.1.1'),
(179, 'clónico', '0', '1', 'Dual Core Pentium D930 3000MHz', 3000, '3', 1024, '3', 80, '1', -1, 'Randeon X 550', 'Intel 82801', 'Realtek RTL 8168/8111', 2, 5, 1, 1, 0, 4, 'Windows XP', 'Profesional SP3', 'febe', 'kybele', '193.147.52.75', '0.0.0.0', '193.147.184.2', '193.147.184.11', '193.147.52.1'),
(180, 'Hibrido', '0', '1', 'Dual core Intel Core 2 Duo E6320 1866MHz', 1866, '3', 1024, '3', 80, '1', -1, 'ATI Randeon X1050 (512MB)', 'Realtek ALC 662 Intel 82801GBICH7', 'Atheros L2 Fast Ethernet 10/100 Base T', 1, 1, 1, 1, 0, 4, 'Windows XP', 'Profesional SP3', 'fedra', 'kybele', '193.147.52.202', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(181, 'VAIO ', 'PCG-4H1M', '2', 'Mobile Interl Core Solo ULVU1300 1066MHz', 1066, '2', 502, '2', 80, '1', -1, 'Mobile Intel 945GM Expres Chipset Family 128Mb', 'Realtek ALC 262 Intel 82801GBM ICH7-M', '', 1, 1, 0, 0, 0, -1, 'Windows XP', 'Profesional SP3', '', '', '10.0.7.194', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(182, 'Dell', 'Optiplex 755', '1', 'Dual Core Intel Core 2 Duo E7300 2600MHz', 2600, '2', 2004, '2', 80, '1', -1, 'Intel Q35 Express Chipset Family (256Mb)', 'Analog Devices AD1984@Intel 82801IB ICH9', 'Intel 82566DM - 2Gigabit Eth', 5, 1, 1, 0, 0, 6, 'Windows 7', 'Profesional', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(183, 'clónico', '0', '1', 'no', 0, '2', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 1, 0, 0, 4, 'Windows XP', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(184, 'HP', 'HP PAVILION TX 2000', '1', 'Mobile Dual Core AMD Turion X2 ultra ZM-82', 2200, '3', 840, '2', 298, '1', -1, 'ATI Randeon HD 3200 (320 Mb)', 'Realtek ALC268', 'Realteck ALC268 / wifi: Broadcom 4322 AG', 5, 1, 1, 0, 0, 3, 'Windows XP', 'Profesional SP3', '', '', '212.128.1.162', '0.0.0.0', '193.147.184.2', '193.147.184.11', '212.128.1.1'),
(188, 'no', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(191, 'clónico', 'Nausicaa', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '169.254.8.151', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(198, 'clónico', '0', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', 'hera', '', '212.128.1.143', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(199, 'clónico', '0', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(200, 'clónico', '0', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(205, 'Sony', 'VAIO PCG-4C1M', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', 'heracles', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(208, 'clónico', '0', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(211, 'clónico', '0', '1', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(222, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(223, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(226, 'Samsung', 'NP-N150-JA03ES (blanco)', '2', 'no', 0, '1', 0, '2', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(227, 'Samsung', 'NP-N150-JA03ES (azul)', '2', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(228, 'Samsung', 'NP-N150-JA03ES (rojo)', '2', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(230, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', 'terpsicore', '', '193.147.52.36', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(231, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', 'orfeo', '', '193.147.63.209', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(232, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', 'tifón', '', '212.128.243.101', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(233, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', 'nemosine', '', '193.147.52.38', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(235, 'Samsung', 'NP-R40', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', 'estigia', '', '193.147.52.135', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(236, 'HP', '5208ES', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', '', '', '212.128.3.92', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(237, 'Apple', 'MacBook Pro', '2', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', 'antigona', '', '193.147.52.199', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(238, 'HP', 'Pavillion DV2700', '2', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, '', '', 'vero Vaio', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(239, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(241, 'clónico', '0', '1', 'no', 0, '1', 0, '1', 0, '1', -1, 'no', '', '', 1, 1, 0, 0, 0, -1, 'Windows XP', '', 'scampia', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computer_type`
--

CREATE TABLE IF NOT EXISTS `computer_type` (
  `id_computer_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_computer_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_computer_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `computer_type`
--

INSERT INTO `computer_type` (`id_computer_type`, `name_computer_type`) VALUES
(1, 'Sobremesa'),
(2, 'Portátil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
  `id_driver` int(11) NOT NULL AUTO_INCREMENT,
  `id_electronic_eq` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `category_driver` varchar(50) DEFAULT NULL,
  `name_real_driver` varchar(50) NOT NULL,
  `name_driver` varchar(50) DEFAULT NULL,
  `extension_driver` varchar(20) DEFAULT NULL,
  `mimetype_driver` varchar(20) DEFAULT NULL,
  `size_driver` int(11) DEFAULT NULL,
  `user_upload` varchar(50) DEFAULT NULL,
  `date_upload` int(11) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_driver`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `electronic_equipment`
--

CREATE TABLE IF NOT EXISTS `electronic_equipment` (
  `id_electronic_eq` int(11) NOT NULL AUTO_INCREMENT,
  `electronic_eq_type` int(11) NOT NULL,
  `urjc_code` int(11) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `id_office` int(11) DEFAULT NULL,
  `image_1` varchar(50) DEFAULT NULL,
  `image_2` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_user_asigned` int(11) NOT NULL,
  `id_user_creation` int(11) DEFAULT NULL,
  `id_user_modify` int(11) DEFAULT NULL,
  `id_user_delete` int(11) DEFAULT NULL,
  `date_creation` int(11) DEFAULT NULL,
  `date_modify` int(11) DEFAULT NULL,
  `date_delete` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=248 ;

--
-- Volcado de datos para la tabla `electronic_equipment`
--

INSERT INTO `electronic_equipment` (`id_electronic_eq`, `electronic_eq_type`, `urjc_code`, `serial_number`, `id_office`, `image_1`, `image_2`, `status`, `id_user_asigned`, `id_user_creation`, `id_user_modify`, `id_user_delete`, `date_creation`, `date_modify`, `date_delete`, `description`) VALUES
(167, 1, 69275, '23481918', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402576366, 1402649264, -1, 'MAC: 00-4F-4E-06-9F-AE\r\n'),
(168, 1, 104548, 'BV003', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402576768, 1402649274, -1, 'MAC:00-18-F3-50-02-E1\r\n'),
(169, 1, 104979, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402576987, 1402649284, -1, 'MAC:00-1A-92-36-C8-C8\r\n'),
(170, 1, 0, '000102', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402577420, 1402649294, -1, 'MAC: 00-D0-B7-74-63-CE\r\n'),
(171, 1, 0, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402641044, 1402649308, -1, 'SERVER\r\nMAC:00-50-BF-EE-B6-E0\r\n'),
(172, 1, 160134, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 22, -1, 1402641946, 1402649327, -1, 'SERVIDOR\r\nMAC 00-23-54-CF-43-BE\r\n'),
(173, 1, 103951, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 1, 1, -1, 1402642611, 1402642611, -1, 'SERVIDOR\r\nMAC 00-17-31-0D-8F-BF\r\npendiente de activación'),
(174, 1, 103951, '0', 13, 'No hay foto', 'No hay foto', 1, 37, 22, 22, -1, 1402642819, 1402656252, -1, 'SERVIDOR\r\nMAC 00-17-31-0D-8F-BF\r\n'),
(175, 1, 0, 'BV006', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402643133, 1402649357, -1, 'MAC 00-18-F3-50-08-B8\r\nPTE ACTUALIZACIONES'),
(176, 1, 72723, '32458967', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402643947, 1402649392, -1, 'MAC 00-05-1C-15-13-5C\r\n'),
(177, 1, 104973, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402644262, 1402649405, -1, 'MAC 00-1A-92-36-C8-CF\r\n'),
(178, 1, 0, '659C1', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402644481, 1402649419, -1, 'mac 00-00-24-C8-0A-9F\r\n'),
(179, 1, 104545, 'BV001', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402644833, 1402649431, -1, 'mac 00-17-31-E2-CA-AA\r\n'),
(180, 1, 105290, '0', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402645047, 1402645047, -1, 'mac 00-1B-FC-74-97-0F\r\n'),
(181, 1, 104489, '28244755', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402645268, 1402645268, -1, 'mac 00-13-02-8F-52-DB\r\npte actualiar drivers'),
(182, 1, 0, '9683128963', 13, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402645433, 1402649528, -1, 'mac 00-21-9B-78-75-5F\r\n'),
(183, 1, 69276, '23481927', 20, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402646581, 1402649990, 1402649990, 'antiguo cerbero\r\n'),
(184, 1, 152371, 'CNF8405R0G', 12, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402646948, 1402646948, -1, 'mac 00-1E-68-FE-EC-D3\r\n'),
(185, 3, 69266, '0', 16, 'No hay foto', 'No hay foto', 3, 23, 22, 22, 22, 1402647292, 1402648651, 1402648651, ''),
(186, 11, 69267, 'E60205M2J909396', 17, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402648388, 1402648693, -1, ''),
(187, 3, 69268, 'CNHJM11830', 27, 'No hay foto', 'No hay foto', 1, 24, 22, 22, -1, 1402648878, 1402651433, -1, ''),
(188, 1, 69269, '0', 18, 'No hay foto', 'No hay foto', 3, 24, 22, 22, 22, 1402649253, 1402649749, 1402649749, ''),
(189, 2, 69270, '4514438', 19, 'No hay foto', 'No hay foto', 3, 25, 22, 22, 22, 1402649649, 1402649768, 1402649768, ''),
(190, 11, 69277, '0', 19, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402650053, 1402650053, 1402650053, ''),
(191, 1, 69278, '0', 12, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402650178, 1402650178, -1, 'quimera?'),
(192, 2, 69279, '102KG00418', 19, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402650285, 1402650285, -1, ''),
(193, 11, 103027, 'El300W0B60302', 21, 'No hay foto', 'No hay foto', 1, 35, 22, 22, -1, 1402650432, 1402650432, -1, 'Maxtor \r\nOneTouch II 300GB\r\n'),
(194, 11, 103179, '0', 16, 'No hay foto', 'No hay foto', 1, 23, 22, 22, -1, 1402650482, 1402650482, -1, ''),
(195, 11, 803872, '0', 16, 'No hay foto', 'No hay foto', 1, 23, 22, 22, -1, 1402650568, 1402650568, -1, ''),
(196, 11, 803873, '0', 23, 'No hay foto', 'No hay foto', 1, 27, 22, 22, -1, 1402650625, 1402650625, -1, ''),
(197, 11, 806752, 'NOAF142204', 23, 'No hay foto', 'No hay foto', 1, 27, 22, 22, -1, 1402650680, 1402650680, -1, ''),
(198, 1, 69274, '31735158', 20, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402650929, 1402651029, 1402651029, ''),
(199, 1, 69832, '0', 23, 'No hay foto', 'No hay foto', 3, 27, 22, 22, 22, 1402651009, 1402651009, 1402651009, ''),
(200, 1, 72719, '0', 23, 'No hay foto', 'No hay foto', 3, 27, 22, 22, 22, 1402651113, 1402651113, 1402651113, ''),
(201, 8, 72720, 'FG863Z2140F', 21, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402651176, 1402651176, -1, ''),
(202, 3, 72721, 'CNSD442269', 24, 'No hay foto', 'No hay foto', 1, 28, 22, 22, -1, 1402651343, 1402651343, -1, ''),
(203, 2, 72724, '0', 22, 'No hay foto', 'No hay foto', 3, 29, 22, 22, 22, 1402651539, 1402651699, 1402651699, ''),
(204, 3, 73873, '0', 16, 'No hay foto', 'No hay foto', 3, 23, 22, 22, 22, 1402651616, 1402651688, 1402651688, ''),
(205, 1, 73874, '28182066-5170155', 12, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402651859, 1402651859, 1402651859, ''),
(206, 3, 73875, 'CNCRC05702', 25, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402651962, 1402651962, -1, ''),
(207, 7, 73878, 'CN485S61CN', 26, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402652034, 1402652034, -1, ''),
(208, 1, 73879, '41543975', 19, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402652118, 1402652118, 1402652118, ''),
(209, 3, 73880, 'CNFF111014', 22, 'No hay foto', 'No hay foto', 3, 29, 22, 22, 22, 1402652186, 1402652186, 1402652186, ''),
(210, 11, 73882, '0', 23, 'No hay foto', 'No hay foto', 3, 27, 22, 22, 22, 1402652915, 1402652915, 1402652915, ''),
(211, 1, 73884, '0', 22, 'No hay foto', 'No hay foto', 3, 29, 22, 22, 22, 1402652996, 1402652996, 1402652996, ''),
(212, 11, 803874, '0', 12, 'No hay foto', 'No hay foto', 1, 27, 22, 22, -1, 1402653045, 1402653045, -1, ''),
(213, 11, 803875, '0', 23, 'No hay foto', 'No hay foto', 1, 27, 22, 22, -1, 1402653151, 1402653151, -1, ''),
(214, 11, 804045, '0', 18, 'No hay foto', 'No hay foto', 1, 24, 22, 22, -1, 1402653215, 1402653215, -1, ''),
(215, 11, 804401, '0', 28, 'No hay foto', 'No hay foto', 1, 30, 22, 22, -1, 1402653270, 1402653318, -1, ''),
(216, 11, 804405, '0', 16, 'No hay foto', 'No hay foto', 1, 23, 22, 22, -1, 1402653355, 1402653355, -1, ''),
(217, 11, 804511, '0', 18, 'No hay foto', 'No hay foto', 1, 24, 22, 22, -1, 1402653408, 1402653408, -1, ''),
(218, 3, 104902, 'CNBV621HPV', 12, 'No hay foto', 'No hay foto', 1, 34, 22, 22, -1, 1402653587, 1402653587, -1, ''),
(219, 3, 103953, 'CNCKB01866', 27, 'No hay foto', 'No hay foto', 1, 31, 22, 22, -1, 1402653658, 1402653658, -1, ''),
(220, 2, 105289, '720DY3CY04022', 17, 'No hay foto', 'No hay foto', 3, 32, 22, 22, 22, 1402653767, 1402653767, 1402653767, ''),
(221, 2, 105291, 'HW173AB0RE100', 12, 'No hay foto', 'No hay foto', 1, 34, 22, 22, -1, 1402653893, 1402653893, -1, ''),
(222, 1, 105292, '0', 12, 'No hay foto', 'No hay foto', 3, 34, 22, 22, 22, 1402653972, 1402653972, 1402653972, ''),
(223, 1, 105335, '0', 21, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402654040, 1402654040, 1402654040, ''),
(224, 11, 105401, '07004372', 29, 'No hay foto', 'No hay foto', 1, 36, 22, 22, -1, 1402654104, 1402654288, -1, 'Fujitsu\r\nHandyDrive 200GB.MMD 2200UB\r\n'),
(225, 11, 809065, 'CNBA430013A4236CF23', 21, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402654203, 1402654203, -1, ''),
(226, 1, 160652, 'Z0DV93KZ100309', 24, 'No hay foto', 'No hay foto', 1, 23, 22, 22, -1, 1402654533, 1402654533, -1, ''),
(227, 1, 160653, 'Z0E293HZ100129D', 25, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402654610, 1402654715, -1, ''),
(228, 1, 160654, 'Z0EA93FZ200821H', 25, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402654682, 1402654682, -1, ''),
(229, 8, 160655, 'Q8BU003AAAAAC0293', 25, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402654794, 1402654794, -1, ''),
(230, 1, 103947, '0', 19, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402654899, 1402655051, -1, ''),
(231, 1, 103949, '0', 12, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402655029, 1402655029, -1, ''),
(232, 1, 103950, '0', 19, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402655174, 1402655207, -1, ''),
(233, 1, 103952, '0', 19, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402656395, 1402656395, -1, ''),
(234, 3, 104748, '8T21BAIP114407P', 12, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402656464, 1402656464, -1, ''),
(235, 1, 104750, '798J93FLB00797R', 20, 'No hay foto', 'No hay foto', 2, 34, 22, 22, -1, 1402656580, 1402656697, -1, ''),
(236, 1, 152084, '0', 12, 'No hay foto', 'No hay foto', 1, 28, 22, 22, -1, 1402656684, 1402656684, -1, ''),
(237, 1, 152085, 'MB134Y/A', 17, 'No hay foto', 'No hay foto', 1, 37, 22, 22, -1, 1402656914, 1402656914, -1, ''),
(238, 1, 152141, '2CE8160SRT', 26, 'No hay foto', 'No hay foto', 1, 38, 22, 22, -1, 1402657011, 1402657011, -1, ''),
(239, 1, 152143, '0', 12, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402657071, 1402657171, 1402657171, ''),
(240, 11, 152175, '0', 12, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402657112, 1402657112, 1402657112, ''),
(241, 1, 152177, '0', 12, 'No hay foto', 'No hay foto', 3, 34, 22, 22, 22, 1402657288, 1402657314, 1402657314, ''),
(242, 3, 152221, 'E63209A8J480647', 30, 'No hay foto', 'No hay foto', 1, 27, 22, 22, -1, 1402657375, 1402657453, -1, 'casa'),
(243, 11, 152222, '65C210143', 29, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402657743, 1402657743, -1, 'OvisLink\r\nWP-101U\r\n'),
(244, 11, 152228, '0', 12, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402657801, 1402657801, 1402657801, ''),
(245, 3, 152259, '0', 24, 'No hay foto', 'No hay foto', 3, 1, 22, 22, 22, 1402657871, 1402657871, 1402657871, ''),
(246, 3, 152272, 'CMB883GG7F', 21, 'No hay foto', 'No hay foto', 1, 35, 22, 22, -1, 1402657972, 1402658143, -1, ''),
(247, 3, 152287, 'MY87GHH12H', 17, 'No hay foto', 'No hay foto', 1, 1, 22, 22, -1, 1402658199, 1402658199, -1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `electronic_eq_type`
--

CREATE TABLE IF NOT EXISTS `electronic_eq_type` (
  `id_elect_eq_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_elect_eq_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_elect_eq_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `electronic_eq_type`
--

INSERT INTO `electronic_eq_type` (`id_elect_eq_type`, `name_elect_eq_type`) VALUES
(1, 'ordenador'),
(2, 'monitor'),
(3, 'impresora'),
(4, 'raton'),
(5, 'teclado'),
(6, 'cable'),
(7, 'scaner'),
(8, 'proyector'),
(11, 'otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hdd_type`
--

CREATE TABLE IF NOT EXISTS `hdd_type` (
  `id_hdd_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_hdd_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_hdd_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `hdd_type`
--

INSERT INTO `hdd_type` (`id_hdd_type`, `name_hdd_type`) VALUES
(1, 'No tiene'),
(2, 'IDE'),
(3, 'SATA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keyboard`
--

CREATE TABLE IF NOT EXISTS `keyboard` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `conector_type` varchar(50) DEFAULT NULL,
  `wireless` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitor`
--

CREATE TABLE IF NOT EXISTS `monitor` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `no_inch` int(11) DEFAULT NULL,
  `monitor_type` varchar(50) DEFAULT NULL,
  `vga` tinyint(4) DEFAULT NULL,
  `dvi` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `monitor`
--

INSERT INTO `monitor` (`id_electronic_eq`, `trademark`, `model`, `no_inch`, `monitor_type`, `vga`, `dvi`) VALUES
(189, 'Sony', 'SDMX72', 2, '1', 1, 0),
(192, 'LG', ' Flatron 774FT', 1, '2', 0, 0),
(203, 'no', '0', 1, '1', 0, 0),
(220, 'Hanns G ', 'HW173A', 1, '1', 0, 0),
(221, 'Hanns G ', 'HW173A', 1, '1', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitor_type`
--

CREATE TABLE IF NOT EXISTS `monitor_type` (
  `id_monitor_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_monitor_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_monitor_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `monitor_type`
--

INSERT INTO `monitor_type` (`id_monitor_type`, `name_monitor_type`) VALUES
(1, 'CRT'),
(2, 'TFT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mouse`
--

CREATE TABLE IF NOT EXISTS `mouse` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `conector_type` varchar(50) DEFAULT NULL,
  `optik` tinyint(4) DEFAULT NULL,
  `wireless` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `id_office` int(11) NOT NULL AUTO_INCREMENT,
  `name_office` varchar(50) NOT NULL,
  `id_building` int(11) NOT NULL,
  `no_floor` int(11) NOT NULL,
  PRIMARY KEY (`id_office`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `office`
--

INSERT INTO `office` (`id_office`, `name_office`, `id_building`, `no_floor`) VALUES
(12, 'Despacho 2014A', 18, 2),
(13, 'Despacho 117', 21, 1),
(14, 'Despacho 118', 21, 1),
(15, 'Despacho 122', 21, 1),
(16, 'Despacho 210', 21, 2),
(17, 'Despacho 228', 21, 2),
(18, 'Despacho 211', 21, 2),
(19, 'Despacho 217', 21, 2),
(20, 'Despacho 222', 21, 2),
(21, 'Despacho 218', 21, 2),
(22, 'Despacho 232', 21, 2),
(23, 'Despacho 209', 21, 2),
(24, 'Despacho 1028', 19, 2),
(25, 'Despacho 1025', 19, 2),
(26, 'Despacho 1026', 19, 2),
(27, 'Despacho 1029', 19, 2),
(28, 'Despacho 236', 21, 2),
(29, 'Despacho 2014B', 19, 2),
(30, 'Despacho 1030', 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `others`
--

CREATE TABLE IF NOT EXISTS `others` (
  `id_electronic_eq` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `others`
--

INSERT INTO `others` (`id_electronic_eq`, `name`) VALUES
(186, 'Fax'),
(190, 'Equipamiento red'),
(193, 'HD externo'),
(194, 'telefono'),
(195, 'Compl.Info'),
(196, 'Compl.Info'),
(197, 'Compl.Info'),
(210, 'EquipamRed'),
(212, 'Compl.Info'),
(213, 'Periferico'),
(214, 'Compl.info  '),
(215, 'Telefono'),
(216, 'Teléfonos   '),
(217, 'Compl.Info'),
(224, 'disco externo'),
(225, 'Compl.Info'),
(240, 'Periferico'),
(243, 'Servidor de impresión'),
(244, 'Periferico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `printer`
--

CREATE TABLE IF NOT EXISTS `printer` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `color` tinyint(4) DEFAULT NULL,
  `laser` tinyint(4) DEFAULT NULL,
  `paralel` tinyint(4) DEFAULT NULL,
  `usb` tinyint(4) DEFAULT NULL,
  `ethernet` tinyint(4) DEFAULT NULL,
  `name_equip` varchar(50) DEFAULT NULL,
  `domain` varchar(50) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `mask` varchar(20) DEFAULT NULL,
  `dns_1` varchar(20) DEFAULT NULL,
  `dns_2` varchar(20) DEFAULT NULL,
  `gateway` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `printer`
--

INSERT INTO `printer` (`id_electronic_eq`, `trademark`, `model`, `color`, `laser`, `paralel`, `usb`, `ethernet`, `name_equip`, `domain`, `ip`, `mask`, `dns_1`, `dns_2`, `gateway`) VALUES
(185, 'no', '0', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(187, 'HP', 'LaserJet 1005', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(202, 'HP', 'LaserJet 1010', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(204, 'no', '0', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(206, 'HP', 'LaserJet 3500', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(209, 'HP', 'LaserJet 1010', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(218, 'HP', 'LaserJet 1022', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(219, 'HP', 'LaserJet 1022', 0, 1, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(234, 'Samsung', 'SCX-400', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(242, 'Brother', 'MFC-7820N', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(245, 'no', '0', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(246, 'HP', 'CM1312 MFP', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0'),
(247, 'HP', 'Photosmart C7200', 0, 0, 0, 0, 0, '', '', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0', '0.0.0.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `name_project` varchar(50) DEFAULT NULL,
  `id_project_status` int(11) NOT NULL,
  `id_user_creation` varchar(50) DEFAULT NULL,
  `id_user_modify` varchar(50) DEFAULT NULL,
  `id_user_delete` varchar(50) DEFAULT NULL,
  `date_creation` int(11) DEFAULT NULL,
  `date_modify` int(11) DEFAULT NULL,
  `date_delete` int(11) DEFAULT NULL,
  `summary` text,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`id_project`, `name_project`, `id_project_status`, `id_user_creation`, `id_user_modify`, `id_user_delete`, `date_creation`, `date_modify`, `date_delete`, `summary`) VALUES
(7, 'Kybele', 2, '2', '2', '22', 1402575588, 1402575588, 1402655249, ' '),
(8, 'M82', 1, '22', '22', '-1', 1402648266, 1402650757, -1, 'Métodos de Investigación en Ingeniería del Software'),
(9, 'M109', 1, '22', '22', '-1', 1402650795, 1402650795, -1, ' Entorno para el desarrollo e integración automática de archivos digitales en la web'),
(10, 'M157', 1, '22', '22', '-1', 1402653432, 1402653432, -1, ' MIFISIS'),
(11, 'M217', 1, '22', '22', '-1', 1402653448, 1402653448, -1, ' SPARCIM'),
(12, 'M407', 1, '22', '22', '-1', 1402653467, 1402653467, -1, ' FOMDAS'),
(13, 'M661', 1, '22', '22', '-1', 1402653494, 1402653494, -1, ' Red de Gestión de Datos'),
(14, 'M266', 1, '22', '22', '-1', 1402658995, 1402658995, -1, ' GOLD'),
(15, 'M604', 1, '22', '22', '-1', 1402659023, 1402659023, -1, ' MODEL-CAOS'),
(16, 'M914', 1, '22', '22', '-1', 1402659042, 1402659042, -1, ' MASAI'),
(17, 'Otros', 1, '22', '22', '-1', 1402659089, 1402659089, -1, ' ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projector`
--

CREATE TABLE IF NOT EXISTS `projector` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `bright` varchar(50) DEFAULT NULL,
  `contrast` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `projector`
--

INSERT INTO `projector` (`id_electronic_eq`, `trademark`, `model`, `type`, `bright`, `contrast`) VALUES
(201, 'EPSON', 'EMP-54', 1, '', ''),
(229, 'Optoma', 'PK102 Pro', 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projector_type`
--

CREATE TABLE IF NOT EXISTS `projector_type` (
  `id_type_projector` int(11) NOT NULL AUTO_INCREMENT,
  `name_projector` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type_projector`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `projector_type`
--

INSERT INTO `projector_type` (`id_type_projector`, `name_projector`) VALUES
(1, 'LCD'),
(2, 'DLP'),
(3, 'LED');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_doc`
--

CREATE TABLE IF NOT EXISTS `project_doc` (
  `id_project_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `name_description` varchar(50) DEFAULT NULL,
  `mimetype` varchar(20) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `extension` varchar(20) DEFAULT NULL,
  `date_upload` int(11) DEFAULT NULL,
  `user_upload` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_project_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_eq`
--

CREATE TABLE IF NOT EXISTS `project_eq` (
  `id_project` int(11) DEFAULT NULL,
  `id_electronic_eq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `project_eq`
--

INSERT INTO `project_eq` (`id_project`, `id_electronic_eq`) VALUES
(1, 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_status`
--

CREATE TABLE IF NOT EXISTS `project_status` (
  `id_project_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_project_status` varchar(50) NOT NULL,
  PRIMARY KEY (`id_project_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `project_status`
--

INSERT INTO `project_status` (`id_project_status`, `name_project_status`) VALUES
(1, 'Activo'),
(2, 'Terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id_purchase` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `name_purchase` varchar(50) DEFAULT NULL,
  `date_purchase` int(11) DEFAULT NULL,
  `purchaser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_purchase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_doc`
--

CREATE TABLE IF NOT EXISTS `purchase_doc` (
  `id_purchase_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `name_description` varchar(50) DEFAULT NULL,
  `mimetype` varchar(20) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `extension` varchar(20) DEFAULT NULL,
  `date_upload` int(11) DEFAULT NULL,
  `user_upload` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_purchase_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_eq`
--

CREATE TABLE IF NOT EXISTS `purchase_eq` (
  `id_purchase` int(11) DEFAULT NULL,
  `id_electronic_eq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ram_type`
--

CREATE TABLE IF NOT EXISTS `ram_type` (
  `id_ram_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_ram_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_ram_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ram_type`
--

INSERT INTO `ram_type` (`id_ram_type`, `name_ram_type`) VALUES
(1, 'SDRAM'),
(2, 'DDR1'),
(3, 'DDR2'),
(4, 'DDR3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id_rol`, `name`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scanner`
--

CREATE TABLE IF NOT EXISTS `scanner` (
  `id_electronic_eq` int(11) NOT NULL,
  `trademark` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `resolution` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `scanner`
--

INSERT INTO `scanner` (`id_electronic_eq`, `trademark`, `model`, `resolution`) VALUES
(207, 'HP', 'ScanJet 5590', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(50) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id_status`, `name_status`) VALUES
(1, 'activo'),
(2, 'en reparacion'),
(3, 'baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name`, `surname`, `email`, `password`, `id_rol`) VALUES
(1, 'Comun', 'Usuario Comun ', 'comun@kybele.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(2, 'Usuario', ' user ', 'user@kybele.es', '98eabfc1d034e32c841758648d9fa083', 2),
(22, 'Administrador', 'admin', 'admin@kybele.es', '04f74ea2554b7bc93b70d1f06c34e12a', 1),
(23, 'bvela', '', 'bvela@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(24, 'jmcavero', '', 'jmcavero@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(25, 'sandra.luci', 'luci ', 'sandra.luci@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(26, 'mlopez', '', 'mlopez@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(27, 'emarcos', '', 'emarcos@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(28, 'vcastro', '', 'vcastro@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(29, 'cjacunia', '', 'cjacunia@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(30, 'pcaceres', '', 'pcaceres@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(31, 'cecuesta', '', 'cecuesta@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(32, 'ftrias', '', 'ftrias@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(33, 'laboratorio', '', 'laboratorio@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(34, 'jgarzas', ' ', 'jgarzas@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(35, 'ehermann', '', 'ehermann@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(36, 'dsanchez', '', 'dsanchez@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(37, 'isantiago', '', 'isantiago@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(38, 'vbollati', '', 'vbollati@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(39, 'dgranada', '', 'dgranada@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(40, 'abparrilla', ' ', 'abparrilla@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(41, 'virginia', ' ', 'virginia@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2),
(42, 'jmvara', '', 'jmvara@urjc.es', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wire`
--

CREATE TABLE IF NOT EXISTS `wire` (
  `id_electronic_eq` int(11) NOT NULL,
  `meters` int(11) DEFAULT NULL,
  `conector_type_a` varchar(50) DEFAULT NULL,
  `conector_type_b` varchar(50) DEFAULT NULL,
  `wire_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_electronic_eq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wire_type`
--

CREATE TABLE IF NOT EXISTS `wire_type` (
  `id_wire_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_wire_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_wire_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `wire_type`
--

INSERT INTO `wire_type` (`id_wire_type`, `name_wire_type`) VALUES
(1, 'usb'),
(4, 'ps/2'),
(5, 'mini usb'),
(6, 'RJ45'),
(7, 'RJ45 cruzado'),
(8, 'VGA'),
(9, 'DVI');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
