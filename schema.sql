-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-09-2015 a las 17:35:12
-- Versión del servidor: 10.0.21-MariaDB-log
-- Versión de PHP: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fichiers`
--
CREATE DATABASE IF NOT EXISTS `fichiers` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `fichiers`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dossiers`
--

CREATE TABLE IF NOT EXISTS `dossiers` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nom du dossier',
  `chemin` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Chemin vers le dossier',
  `niveau` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Niveau du dossier',
  `parent` smallint(5) unsigned NOT NULL COMMENT 'ID du dossier parent',
  `type` enum('Photo','Video','Ebook','Divers') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Type de document contenu dans le dossier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichiers`
--

CREATE TABLE IF NOT EXISTS `fichiers` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `nom` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nom du fichier',
  `mime` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'MIME',
  `parent` smallint(5) unsigned NOT NULL COMMENT 'ID du dossier parent',
  `image` tinyint(1) NOT NULL COMMENT 'Est image',
  `thumbnail` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'URL de la miniature',
  `size` int(10) unsigned NOT NULL COMMENT 'Poids du fichier',
  `width` smallint(5) unsigned NOT NULL COMMENT 'Largeur',
  `height` smallint(5) unsigned NOT NULL COMMENT 'Hauteur',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
  `md5sum` char(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Somme MD5',
  `type` enum('Photo','Video','Ebook','Divers') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Type de document du fichier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dossiers`
--
ALTER TABLE `dossiers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `md5sum` (`md5sum`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dossiers`
--
ALTER TABLE `dossiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT de la tabla `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
