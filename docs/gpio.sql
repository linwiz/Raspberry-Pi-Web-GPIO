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
(1, '4', '0', '1'),
(2, '17', '0', '1'),
(3, '18', '0', '1'),
(4, '21', '0', '1'),
(5, '22', '0', '1'),
(6, '23', '0', '1'),
(7, '24', '0', '1'),
(8, '25', '0', '1');

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
