-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2014 at 06:33 PM
-- Server version: 5.5.38-0+wheezy1
-- PHP Version: 5.4.4-14+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gpio`
--
CREATE DATABASE IF NOT EXISTS `gpio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gpio`;

-- --------------------------------------------------------

--
-- Table structure for table `pinDescription`
--

DROP TABLE IF EXISTS `pinDescription`;
CREATE TABLE IF NOT EXISTS `pinDescription` (
`pinID` int(11) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinDescription`
--

INSERT INTO `pinDescription` (`pinID`, `pinNumber`, `pinDescription`) VALUES
(1, '0', 'Pin 0'),
(2, '1', 'Pin 1'),
(3, '4', 'Pin 4'),
(4, '7', 'Pin 7'),
(5, '8', 'Pin 8'),
(6, '9', 'Pin 9'),
(7, '10', 'Pin 10'),
(8, '11', 'Pin 11'),
(9, '14', 'Pin 14'),
(10, '15', 'Pin 15'),
(11, '17', 'Pin 17'),
(12, '18', 'Pin 18'),
(13, '21', 'Pin 21'),
(14, '22', 'Pin 22'),
(15, '23', 'Pin 23'),
(16, '24', 'Pin 24'),
(17, '25', 'Pin 25');

-- --------------------------------------------------------

--
-- Table structure for table `pinDirection`
--

DROP TABLE IF EXISTS `pinDirection`;
CREATE TABLE IF NOT EXISTS `pinDirection` (
`pinID` int(11) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinDirection`
--

INSERT INTO `pinDirection` (`pinID`, `pinNumber`, `pinDirection`) VALUES
(1, '0', 'out'),
(2, '1', 'out'),
(3, '4', 'out'),
(4, '7', 'out'),
(5, '8', 'out'),
(6, '9', 'out'),
(7, '10', 'out'),
(8, '11', 'out'),
(9, '14', 'out'),
(10, '15', 'out'),
(11, '17', 'out'),
(12, '18', 'out'),
(13, '21', 'out'),
(14, '22', 'out'),
(15, '23', 'out'),
(16, '24', 'out'),
(17, '25', 'out');

-- --------------------------------------------------------

--
-- Table structure for table `pinStatus`
--

DROP TABLE IF EXISTS `pinStatus`;
CREATE TABLE IF NOT EXISTS `pinStatus` (
`pinID` int(11) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pinStatus`
--

INSERT INTO `pinStatus` (`pinID`, `pinNumber`, `pinStatus`, `pinEnabled`) VALUES
(1, '0', '0', '1'),
(2, '1', '0', '1'),
(3, '4', '0', '1'),
(4, '7', '0', '1'),
(5, '8', '0', '1'),
(6, '9', '0', '1'),
(7, '10', '0', '1'),
(8, '11', '0', '1'),
(9, '14', '0', '1'),
(10, '15', '0', '1'),
(11, '17', '0', '1'),
(12, '18', '0', '1'),
(13, '21', '0', '1'),
(14, '22', '0', '1'),
(15, '23', '0', '1'),
(16, '24', '0', '1'),
(17, '25', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`userID` int(11) NOT NULL,
  `username` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`) VALUES
(1, 'admin', 'sha256:1000:/Ec19+8Eal3Pwfc2uyscua+HQ3FGEpcp:Hpk4vO5V5P5a9rEpLgK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pinDescription`
--
ALTER TABLE `pinDescription`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`);

--
-- Indexes for table `pinDirection`
--
ALTER TABLE `pinDirection`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`);

--
-- Indexes for table `pinStatus`
--
ALTER TABLE `pinStatus`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pinDescription`
--
ALTER TABLE `pinDescription`
MODIFY `pinID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pinDirection`
--
ALTER TABLE `pinDirection`
MODIFY `pinID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pinStatus`
--
ALTER TABLE `pinStatus`
MODIFY `pinID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
