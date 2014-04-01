-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 01. dub 2014, 11:38
-- Verze serveru: 5.6.16
-- Verze PHP: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `nakupujem`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'photo id',
  `product_id` int(11) NOT NULL COMMENT 'pruduct id',
  `url` text COLLATE utf8_slovak_ci NOT NULL COMMENT 'url to foto',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci COMMENT='table of photos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of product',
  `title` varchar(200) COLLATE utf8_slovak_ci NOT NULL COMMENT 'title of product',
  `description` text COLLATE utf8_slovak_ci NOT NULL COMMENT 'description of product',
  `phone` varchar(20) COLLATE utf8_slovak_ci NOT NULL COMMENT 'phone number on seller',
  `email` varchar(50) COLLATE utf8_slovak_ci NOT NULL COMMENT 'email on seller',
  `location` varchar(60) COLLATE utf8_slovak_ci NOT NULL COMMENT 'location of product',
  `shipping` int(100) NOT NULL COMMENT 'where can be item shipped',
  `user_id` int(11) NOT NULL COMMENT 'id of user ',
  `price` varchar(80) COLLATE utf8_slovak_ci NOT NULL DEFAULT 'Dohodou' COMMENT 'price of product',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date when inserted',
  `view_counter` int(11) NOT NULL COMMENT 'counter of views',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `price` (`price`),
  FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) COLLATE utf8_slovak_ci NOT NULL,
  `password` varchar(24) COLLATE utf8_slovak_ci NOT NULL,
  `first_name` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_slovak_ci NOT NULL,
  `location` text COLLATE utf8_slovak_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_slovak_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `score` float DEFAULT '50',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci COMMENT='table of users' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
