-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2015 at 11:26 AM
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
-- Table structure for table `mcp23017`
--

DROP TABLE IF EXISTS `mcp23017`;
CREATE TABLE IF NOT EXISTS `mcp23017` (
  `pinID` int(11) NOT NULL AUTO_INCREMENT,
  `pinNumber` int(11) NOT NULL,
  `pinStatus` int(11) NOT NULL DEFAULT '0',
  `pinEnabled` int(11) NOT NULL DEFAULT '0',
  `basePin` int(11) NOT NULL DEFAULT '100',
  `address` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0x20',
  `pinDirection` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  PRIMARY KEY (`pinID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=129 ;

--
-- Dumping data for table `mcp23017`
--

INSERT INTO `mcp23017` (`pinID`, `pinNumber`, `pinStatus`, `pinEnabled`, `basePin`, `address`, `pinDirection`) VALUES
(1, 100, 0, 0, 100, '0x20', 'out'),
(2, 101, 0, 0, 100, '0x20', 'out'),
(3, 102, 0, 0, 100, '0x20', 'out'),
(4, 103, 0, 0, 100, '0x20', 'out'),
(5, 104, 0, 0, 100, '0x20', 'out'),
(6, 105, 0, 0, 100, '0x20', 'out'),
(7, 106, 0, 0, 100, '0x20', 'out'),
(8, 107, 0, 0, 100, '0x20', 'out'),
(9, 108, 0, 0, 100, '0x20', 'out'),
(10, 109, 0, 0, 100, '0x20', 'out'),
(11, 110, 0, 0, 100, '0x20', 'out'),
(12, 111, 0, 0, 100, '0x20', 'out'),
(13, 112, 0, 0, 100, '0x20', 'out'),
(14, 113, 0, 0, 100, '0x20', 'out'),
(15, 114, 0, 0, 100, '0x20', 'out'),
(16, 115, 0, 0, 100, '0x20', 'out'),
(17, 116, 0, 0, 116, '0x21', 'out'),
(18, 117, 0, 0, 116, '0x21', 'out'),
(19, 118, 0, 0, 116, '0x21', 'out'),
(20, 119, 0, 0, 116, '0x21', 'out'),
(21, 120, 0, 0, 116, '0x21', 'out'),
(22, 121, 0, 0, 116, '0x21', 'out'),
(23, 122, 0, 0, 116, '0x21', 'out'),
(24, 123, 0, 0, 116, '0x21', 'out'),
(25, 124, 0, 0, 116, '0x21', 'out'),
(26, 125, 0, 0, 116, '0x21', 'out'),
(27, 126, 0, 0, 116, '0x21', 'out'),
(28, 127, 0, 0, 116, '0x21', 'out'),
(29, 128, 0, 0, 116, '0x21', 'out'),
(30, 129, 0, 0, 116, '0x21', 'out'),
(31, 130, 0, 0, 116, '0x21', 'out'),
(32, 131, 0, 0, 116, '0x21', 'out'),
(33, 132, 0, 0, 132, '0x22', 'out'),
(34, 133, 0, 0, 132, '0x22', 'out'),
(35, 134, 0, 0, 132, '0x22', 'out'),
(36, 135, 0, 0, 132, '0x22', 'out'),
(37, 136, 0, 0, 132, '0x22', 'out'),
(38, 137, 0, 0, 132, '0x22', 'out'),
(39, 138, 0, 0, 132, '0x22', 'out'),
(40, 139, 0, 0, 132, '0x22', 'out'),
(41, 140, 0, 0, 132, '0x22', 'out'),
(42, 141, 0, 0, 132, '0x22', 'out'),
(43, 142, 0, 0, 132, '0x22', 'out'),
(44, 143, 0, 0, 132, '0x22', 'out'),
(45, 144, 0, 0, 132, '0x22', 'out'),
(46, 145, 0, 0, 132, '0x22', 'out'),
(47, 146, 0, 0, 132, '0x22', 'out'),
(48, 147, 0, 0, 132, '0x22', 'out'),
(49, 148, 0, 0, 148, '0x23', 'out'),
(50, 149, 0, 0, 148, '0x23', 'out'),
(51, 150, 0, 0, 148, '0x23', 'out'),
(52, 151, 0, 0, 148, '0x23', 'out'),
(53, 152, 0, 0, 148, '0x23', 'out'),
(54, 153, 0, 0, 148, '0x23', 'out'),
(55, 154, 0, 0, 148, '0x23', 'out'),
(56, 155, 0, 0, 148, '0x23', 'out'),
(57, 156, 0, 0, 148, '0x23', 'out'),
(58, 157, 0, 0, 148, '0x23', 'out'),
(59, 158, 0, 0, 148, '0x23', 'out'),
(60, 159, 0, 0, 148, '0x23', 'out'),
(61, 160, 0, 0, 148, '0x23', 'out'),
(62, 161, 0, 0, 148, '0x23', 'out'),
(63, 162, 0, 0, 148, '0x23', 'out'),
(64, 163, 0, 0, 148, '0x23', 'out'),
(65, 164, 0, 0, 164, '0x24', 'out'),
(66, 165, 0, 0, 164, '0x24', 'out'),
(67, 166, 0, 0, 164, '0x24', 'out'),
(68, 167, 0, 0, 164, '0x24', 'out'),
(69, 168, 0, 0, 164, '0x24', 'out'),
(70, 169, 0, 0, 164, '0x24', 'out'),
(71, 170, 0, 0, 164, '0x24', 'out'),
(72, 171, 0, 0, 164, '0x24', 'out'),
(73, 172, 0, 0, 164, '0x24', 'out'),
(74, 173, 0, 0, 164, '0x24', 'out'),
(75, 174, 0, 0, 164, '0x24', 'out'),
(76, 175, 0, 0, 164, '0x24', 'out'),
(77, 176, 0, 0, 164, '0x24', 'out'),
(78, 177, 0, 0, 164, '0x24', 'out'),
(79, 178, 0, 0, 164, '0x24', 'out'),
(80, 179, 0, 0, 164, '0x24', 'out'),
(81, 180, 0, 0, 180, '0x25', 'out'),
(82, 181, 0, 0, 180, '0x25', 'out'),
(83, 182, 0, 0, 180, '0x25', 'out'),
(84, 183, 0, 0, 180, '0x25', 'out'),
(85, 184, 0, 0, 180, '0x25', 'out'),
(86, 185, 0, 0, 180, '0x25', 'out'),
(87, 186, 0, 0, 180, '0x25', 'out'),
(88, 187, 0, 0, 180, '0x25', 'out'),
(89, 188, 0, 0, 180, '0x25', 'out'),
(90, 189, 0, 0, 180, '0x25', 'out'),
(91, 190, 0, 0, 180, '0x25', 'out'),
(92, 191, 0, 0, 180, '0x25', 'out'),
(93, 192, 0, 0, 180, '0x25', 'out'),
(94, 193, 0, 0, 180, '0x25', 'out'),
(95, 194, 0, 0, 180, '0x25', 'out'),
(96, 195, 0, 0, 180, '0x25', 'out'),
(97, 196, 0, 0, 196, '0x26', 'out'),
(98, 197, 0, 0, 196, '0x26', 'out'),
(99, 198, 0, 0, 196, '0x26', 'out'),
(100, 199, 0, 0, 196, '0x26', 'out'),
(101, 200, 0, 0, 196, '0x26', 'out'),
(102, 201, 0, 0, 196, '0x26', 'out'),
(103, 202, 0, 0, 196, '0x26', 'out'),
(104, 203, 0, 0, 196, '0x26', 'out'),
(105, 204, 0, 0, 196, '0x26', 'out'),
(106, 205, 0, 0, 196, '0x26', 'out'),
(107, 206, 0, 0, 196, '0x26', 'out'),
(108, 207, 0, 0, 196, '0x26', 'out'),
(109, 208, 0, 0, 196, '0x26', 'out'),
(110, 209, 0, 0, 196, '0x26', 'out'),
(111, 210, 0, 0, 196, '0x26', 'out'),
(112, 211, 0, 0, 196, '0x26', 'out'),
(113, 212, 0, 0, 212, '0x27', 'out'),
(114, 213, 0, 0, 212, '0x27', 'out'),
(115, 214, 0, 0, 212, '0x27', 'out'),
(116, 215, 0, 0, 212, '0x27', 'out'),
(117, 216, 0, 0, 212, '0x27', 'out'),
(118, 217, 0, 0, 212, '0x27', 'out'),
(119, 218, 0, 0, 212, '0x27', 'out'),
(120, 219, 0, 0, 212, '0x27', 'out'),
(121, 220, 0, 0, 212, '0x27', 'out'),
(122, 221, 0, 0, 212, '0x27', 'out'),
(123, 222, 0, 0, 212, '0x27', 'out'),
(124, 223, 0, 0, 212, '0x27', 'out'),
(125, 224, 0, 0, 212, '0x27', 'out'),
(126, 225, 0, 0, 212, '0x27', 'out'),
(127, 226, 0, 0, 212, '0x27', 'out'),
(128, 227, 0, 0, 212, '0x27', 'out');

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

