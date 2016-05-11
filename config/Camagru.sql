-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mer 11 Mai 2016 à 00:07
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `Camagru`
--

CREATE DATABASE IF NOT EXISTS `Camagru` DEFAULT CHARSET=latin1;
USE `Camagru`;


-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
  `comment` text NOT NULL,
  `pic_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_publication` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Structure de la table `Images`
--

DROP TABLE IF EXISTS `Images`;
CREATE TABLE `Images` (
  `id` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
  `img_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Structure de la table `Likes`
--

DROP TABLE IF EXISTS `Likes`;
CREATE TABLE `Likes` (
  `id` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
  `pic_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Structure de la table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `id` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_inscription` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
