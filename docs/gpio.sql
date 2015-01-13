-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2015 at 03:54 PM
-- Server version: 5.5.40
-- PHP Version: 5.4.36-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gpio`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision1`
--

CREATE TABLE IF NOT EXISTS `pinRevision1` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumberBCM` (`pinNumberBCM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pinRevision1`
--

INSERT INTO `pinRevision1` (`pinID`, `pinNumberBCM`, `pinNumberWPi`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '0', '8', 'Pin 0', 'out', '0', '1'),
(2, '1', '9', 'Pin 1', 'out', '0', '1'),
(3, '4', '7', 'Pin 4', 'out', '0', '1'),
(4, '7', '11', 'Pin 7', 'out', '0', '1'),
(5, '8', '10', 'Pin 8', 'out', '0', '1'),
(6, '9', '13', 'Pin 9', 'out', '0', '1'),
(7, '10', '12', 'Pin 10', 'out', '0', '1'),
(8, '11', '14', 'Pin 11', 'out', '0', '1'),
(9, '14', '15', 'Pin 14', 'out', '0', '1'),
(10, '15', '16', 'Pin 15', 'out', '0', '1'),
(11, '17', '0', 'Pin 17', 'out', '0', '1'),
(12, '18', '1', 'Pin 18', 'out', '0', '1'),
(13, '21', '2', 'Pin 21', 'out', '0', '1'),
(14, '22', '3', 'Pin 22', 'out', '0', '1'),
(15, '23', '4', 'Pin 23', 'out', '0', '1'),
(16, '24', '5', 'Pin 24', 'out', '0', '1'),
(17, '25', '6', 'Pin 25', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision2`
--

CREATE TABLE IF NOT EXISTS `pinRevision2` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumberBCM` (`pinNumberBCM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `pinRevision2`
--

INSERT INTO `pinRevision2` (`pinID`, `pinNumberBCM`, `pinNumberWPi`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '2', '8', 'Pin 2', 'out', '1', '1'),
(2, '3', '9', 'Pin 3', 'out', '0', '1'),
(3, '4', '7', 'Pin 4', 'out', '0', '1'),
(4, '7', '11', 'Pin 7', 'out', '0', '1'),
(5, '8', '10', 'Pin 8', 'out', '0', '1'),
(6, '9', '13', 'Pin 9', 'out', '0', '1'),
(7, '10', '12', 'Pin 10', 'out', '0', '1'),
(8, '11', '14', 'Pin 11', 'out', '0', '1'),
(9, '14', '15', 'Pin 14', 'out', '0', '1'),
(10, '15', '16', 'Pin 15', 'out', '0', '1'),
(11, '17', '0', 'Pin 17', 'out', '0', '1'),
(12, '18', '1', 'Pin 18', 'out', '0', '1'),
(13, '27', '2', 'Pin 27', 'out', '0', '1'),
(14, '22', '3', 'Pin 22', 'out', '0', '1'),
(15, '23', '4', 'Pin 23', 'out', '0', '1'),
(16, '24', '5', 'Pin 24', 'out', '0', '1'),
(17, '25', '6', 'Pin 25', 'out', '0', '1'),
(18, '28', '17', 'Pin 28', 'out', '0', '1'),
(19, '29', '18', 'Pin 29', 'out', '0', '1'),
(20, '30', '19', 'Pin 19', 'out', '0', '1'),
(21, '31', '20', 'Pin 31', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision3`
--

CREATE TABLE IF NOT EXISTS `pinRevision3` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  KEY `pinNumberBCM` (`pinNumberBCM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `pinRevision3`
--

INSERT INTO `pinRevision3` (`pinID`, `pinNumberBCM`, `pinNumberWPi`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, 'X', 'X', '3.3V', 'out', '0', '0'),
(2, 'X', 'X', '5V', 'out', '0', '0'),
(3, '2', '8', 'SDA.1', 'out', '0', '0'),
(4, 'X', 'X', '5V', 'out', '0', '0'),
(5, '3', '9', 'SCL.1', 'out', '0', '0'),
(6, 'X', 'X', 'GND', 'out', '0', '0'),
(7, '4', '7', 'GPIO 4/7', 'out', '0', '1'),
(8, '14', '15', 'TxD', 'out', '0', '0'),
(9, 'X', 'X', 'GND', 'out', '0', '0'),
(10, '15', '16', 'RxD', 'out', '0', '0'),
(11, '17', '0', 'GPIO 17/0', 'out', '0', '1'),
(12, '18', '1', 'GPIO 18/1', 'out', '0', '1'),
(13, '27', '2', 'GPIO 27/2', 'out', '0', '1'),
(14, 'X', 'X', 'GND', 'out', '0', '0'),
(15, '22', '3', 'GPIO 22/3', 'out', '0', '1'),
(16, '23', '4', 'GPIO 23/4', 'out', '0', '1'),
(17, 'X', 'X', '3.3V', 'out', '0', '0'),
(18, '24', '5', 'GPIO 24/5', 'out', '0', '1'),
(19, '10', '12', 'MOSI', 'out', '0', '0'),
(20, 'X', 'X', 'GND', 'out', '0', '0'),
(21, '9', '13', 'MISO', 'out', '0', '0'),
(22, '25', '6', 'GPIO 25/6', 'out', '0', '1'),
(23, '11', '14', 'SCLK', 'out', '0', '0'),
(24, '8', '10', 'CE0', 'out', '0', '0'),
(25, 'X', 'X', 'GND', 'out', '0', '0'),
(26, '7', '11', 'CE1', 'out', '0', '0'),
(27, '0', '30', 'SDA.0', 'in', '0', '0'),
(28, '1', '31', 'SCL.0', 'in', '0', '0'),
(29, '5', '21', 'GPIO 5/21', 'out', '0', '1'),
(30, 'X', 'X', 'GND', 'out', '0', '0'),
(31, '6', '22', 'GPIO 6/22', 'out', '0', '1'),
(32, '12', '26', 'GPIO 12/26', 'out', '0', '1'),
(33, '13', '23', 'GPIO 13/23', 'out', '0', '1'),
(34, 'X', 'X', 'GND', 'out', '0', '0'),
(35, '19', '24', 'GPIO 19/24', 'out', '0', '1'),
(36, '16', '27', 'GPIO 16/27', 'out', '0', '1'),
(37, '26', '25', 'GPIO 26/25', 'out', '0', '1'),
(38, '20', '28', 'GPIO 20/28', 'out', '0', '1'),
(39, 'X', 'X', 'GND', 'out', '0', '0'),
(40, '21', '29', 'GPIO 21/29', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE IF NOT EXISTS `timer` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `timerEnabled` int(1) NOT NULL DEFAULT '0',
  `timerOn` text COLLATE utf8_unicode_ci NOT NULL,
  `timerOff` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pinID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(87) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`) VALUES
(1, 'admin', '16384$8$1$mpDAFcxNVvM=$f4341ac30b57cd34e647b210317d71e38a65d9e15203232a7a31a57529ba7dbc');

