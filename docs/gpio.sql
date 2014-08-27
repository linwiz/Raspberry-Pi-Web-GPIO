-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2014 at 03:45 PM
-- Server version: 5.5.38-0+wheezy1
-- PHP Version: 5.4.4-14+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gpio`
--
CREATE DATABASE IF NOT EXISTS `gpio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gpio`;

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision1`
--

CREATE TABLE IF NOT EXISTS `pinRevision1` (
`pinID` int(2) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pinRevision1`
--

INSERT INTO `pinRevision1` (`pinID`, `pinNumber`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '0', 'Pin 0', 'out', '0', '1'),
(2, '1', 'Pin 1', 'out', '0', '1'),
(3, '4', 'Pin 4', 'out', '0', '1'),
(4, '7', 'Pin 7', 'out', '0', '1'),
(5, '8', 'Pin 8', 'out', '0', '1'),
(6, '9', 'Pin 9', 'out', '0', '1'),
(7, '10', 'Pin 10', 'out', '0', '1'),
(8, '11', 'Pin 11', 'out', '0', '1'),
(9, '14', 'Pin 14', 'out', '0', '1'),
(10, '15', 'Pin 15', 'out', '0', '1'),
(11, '17', 'Pin 17', 'out', '0', '1'),
(12, '18', 'Pin 18', 'out', '0', '1'),
(13, '21', 'Pin 21', 'out', '0', '1'),
(14, '22', 'Pin 22', 'out', '0', '1'),
(15, '23', 'Pin 23', 'out', '0', '1'),
(16, '24', 'Pin 24', 'out', '0', '1'),
(17, '25', 'Pin 25', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision2`
--

CREATE TABLE IF NOT EXISTS `pinRevision2` (
`pinID` int(2) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pinRevision2`
--

INSERT INTO `pinRevision2` (`pinID`, `pinNumber`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '2', 'Pin 2', 'out', '0', '1'),
(2, '3', 'Pin 3', 'out', '0', '1'),
(3, '4', 'Pin 4', 'out', '0', '0'),
(4, '7', 'Pin 7', 'out', '0', '1'),
(5, '8', 'Pin 8', 'out', '0', '1'),
(6, '9', 'Pin 9', 'out', '0', '1'),
(7, '10', 'Pin 10', 'out', '0', '1'),
(8, '11', 'Pin 11', 'out', '0', '1'),
(9, '14', 'Pin 14', 'out', '0', '1'),
(10, '15', 'Pin 15', 'out', '0', '1'),
(11, '17', 'Pin 17', 'out', '0', '1'),
(12, '18', 'Pin 18', 'out', '0', '1'),
(13, '27', 'Pin 27', 'out', '0', '1'),
(14, '22', 'Pin 22', 'out', '0', '1'),
(15, '23', 'Pin 23', 'out', '0', '1'),
(16, '24', 'Pin 24', 'out', '0', '1'),
(17, '25', 'Pin 25', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pinRevision3`
--

CREATE TABLE IF NOT EXISTS `pinRevision3` (
`pinID` int(2) NOT NULL,
  `pinNumber` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `pinDescription` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pin',
  `pinDirection` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `pinStatus` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pinEnabled` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `pinRevision3`
--

INSERT INTO `pinRevision3` (`pinID`, `pinNumber`, `pinDescription`, `pinDirection`, `pinStatus`, `pinEnabled`) VALUES
(1, '2', 'Pin 2', 'out', '0', '1'),
(2, '3', 'Pin 3', 'out', '0', '1'),
(3, '4', 'Pin 4', 'out', '0', '1'),
(4, '7', 'Pin 7', 'out', '0', '1'),
(5, '8', 'Pin 8', 'out', '0', '1'),
(6, '9', 'Pin 9', 'out', '0', '1'),
(7, '10', 'Pin 10', 'out', '0', '1'),
(8, '11', 'Pin 11', 'out', '0', '1'),
(9, '14', 'Pin 14', 'out', '0', '1'),
(10, '15', 'Pin 15', 'out', '0', '1'),
(11, '17', 'Pin 17', 'out', '0', '1'),
(12, '18', 'Pin 18', 'out', '0', '1'),
(13, '27', 'Pin 27', 'out', '0', '1'),
(14, '22', 'Pin 22', 'out', '0', '1'),
(15, '23', 'Pin 23', 'out', '0', '1'),
(16, '24', 'Pin 24', 'out', '0', '1'),
(17, '25', 'Pin 25', 'out', '0', '1'),
(18, '5', 'Pin 5', 'out', '0', '1'),
(19, '6', 'Pin 6', 'out', '0', '1'),
(20, '12', 'Pin 12', 'out', '0', '1'),
(21, '13', 'Pin 13', 'out', '0', '1'),
(22, '16', 'Pin 16', 'out', '0', '1'),
(23, '19', 'Pin 19', 'out', '0', '1'),
(24, '20', 'Pin 20', 'out', '0', '1'),
(25, '21', 'Pin 21', 'out', '0', '1'),
(26, '26', 'Pin 26', 'out', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
-- Indexes for table `pinRevision1`
--
ALTER TABLE `pinRevision1`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`), ADD KEY `pinID` (`pinID`);

--
-- Indexes for table `pinRevision2`
--
ALTER TABLE `pinRevision2`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`), ADD KEY `pinID` (`pinID`);

--
-- Indexes for table `pinRevision3`
--
ALTER TABLE `pinRevision3`
 ADD PRIMARY KEY (`pinID`), ADD UNIQUE KEY `pinNumber` (`pinNumber`), ADD KEY `pinID` (`pinID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pinRevision1`
--
ALTER TABLE `pinRevision1`
MODIFY `pinID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pinRevision2`
--
ALTER TABLE `pinRevision2`
MODIFY `pinID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pinRevision3`
--
ALTER TABLE `pinRevision3`
MODIFY `pinID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;