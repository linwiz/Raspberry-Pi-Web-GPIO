-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2015 at 05:18 PM
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

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision1`
--

DROP TABLE IF EXISTS `pinRevision1`;
CREATE TABLE IF NOT EXISTS `pinRevision1` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumberBCM`)
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

DROP TABLE IF EXISTS `pinRevision2`;
CREATE TABLE IF NOT EXISTS `pinRevision2` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumberBCM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `pinRevision2`
--

INSERT INTO `pinRevision2` (`pinID`, `pinNumberBCM`, `pinNumberWPi`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '2', '8', 'Pin 2', 'out', '0', '1'),
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

DROP TABLE IF EXISTS `pinRevision3`;
CREATE TABLE IF NOT EXISTS `pinRevision3` (
  `pinID` int(2) NOT NULL AUTO_INCREMENT,
  `pinNumberBCM` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinNumberWPi` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`pinID`),
  UNIQUE KEY `pinNumber` (`pinNumberBCM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `pinRevision3`
--

INSERT INTO `pinRevision3` (`pinID`, `pinNumberBCM`, `pinNumberWPi`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '2', '8', 'Pin 2', 'out', '0', '1'),
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
(18, '5', '21', 'Pin 5', 'out', '0', '1'),
(19, '6', '22', 'Pin 6', 'out', '0', '1'),
(20, '12', '26', 'Pin 12', 'out', '0', '1'),
(21, '13', '23', 'Pin 13', 'out', '0', '1'),
(22, '16', '27', 'Pin 16', 'out', '0', '1'),
(23, '19', '24', 'Pin 19', 'out', '0', '1'),
(24, '20', '28', 'Pin 20', 'out', '0', '1'),
(25, '21', '29', 'Pin 21', 'out', '0', '1'),
(26, '26', '25', 'Pin 26', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

DROP TABLE IF EXISTS `timer`;
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

DROP TABLE IF EXISTS `users`;
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

