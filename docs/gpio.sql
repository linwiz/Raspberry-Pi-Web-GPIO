-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2012 at 03:13 PM
-- Server version: 5.1.49-3
-- PHP Version: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gpio`
--
CREATE DATABASE `gpio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gpio`;

-- --------------------------------------------------------

--
-- Table structure for table `pinDescription`
--
-- Creation: Jun 09, 2012 at 07:50 PM
-- Last update: Jun 10, 2012 at 02:11 PM
--

DROP TABLE IF EXISTS `pinDescription`;
CREATE TABLE IF NOT EXISTS `pinDescription` (
  `pinID` int(11) NOT NULL AUTO_INCREMENT,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinDescription`
--

INSERT INTO `pinDescription` (`pinID`, `pinNumber`, `pinDescription`) VALUES
(1, '4', 'Pin 4'),
(2, '17', 'Pin 17'),
(3, '18', 'Pin 18'),
(4, '21', 'Pin 21'),
(5, '22', 'Pin 22'),
(6, '23', 'Pin 23'),
(7, '24', 'Pin 24'),
(8, '25', 'Pin 25');

-- --------------------------------------------------------

--
-- Table structure for table `pinDirection`
--
-- Creation: Jun 09, 2012 at 06:18 PM
-- Last update: Jun 09, 2012 at 06:19 PM
--

DROP TABLE IF EXISTS `pinDirection`;
CREATE TABLE IF NOT EXISTS `pinDirection` (
  `pinID` int(11) NOT NULL AUTO_INCREMENT,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinDirection`
--

INSERT INTO `pinDirection` (`pinID`, `pinNumber`, `pinDirection`) VALUES
(1, '4', 'out'),
(2, '17', 'out'),
(3, '18', 'out'),
(4, '21', 'out'),
(5, '22', 'out'),
(6, '23', 'out'),
(7, '24', 'out'),
(8, '25', 'out');

-- --------------------------------------------------------

--
-- Table structure for table `pinStatus`
--
-- Creation: Jun 09, 2012 at 05:30 PM
-- Last update: Jun 10, 2012 at 01:54 PM
--

DROP TABLE IF EXISTS `pinStatus`;
CREATE TABLE IF NOT EXISTS `pinStatus` (
  `pinID` int(11) NOT NULL AUTO_INCREMENT,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinStatus`
--

INSERT INTO `pinStatus` (`pinID`, `pinNumber`, `pinStatus`) VALUES
(1, '4', '0'),
(2, '17', '0'),
(3, '18', '0'),
(4, '21', '0'),
(5, '22', '0'),
(6, '23', '0'),
(7, '24', '0'),
(8, '25', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jun 10, 2012 at 02:07 PM
-- Last update: Jun 10, 2012 at 02:09 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`,) VALUES
(1, 'admin', 'sha256:1000:24Aarkujuenoyl9f2XrMPdGN59N/rH8V:qOabv+A/6cjvLBtmKBicXmrYH+Ka3kTT');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
