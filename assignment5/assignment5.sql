-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2017 at 12:37 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment5`
--

-- --------------------------------------------------------

--
-- Table structure for table `Club`
--

CREATE TABLE `Club` (
  `clubId` char(20) COLLATE utf8_danish_ci NOT NULL,
  `clubName` char(40) COLLATE utf8_danish_ci NOT NULL,
  `city` char(20) COLLATE utf8_danish_ci NOT NULL,
  `county` char(25) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Representing`
--

CREATE TABLE `Representing` (
  `userName` char(15) COLLATE utf8_danish_ci NOT NULL,
  `clubId` char(20) COLLATE utf8_danish_ci DEFAULT NULL,
  `fallYear` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Season`
--

CREATE TABLE `Season` (
  `fallYear` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Skier`
--

CREATE TABLE `Skier` (
  `userName` char(15) COLLATE utf8_danish_ci NOT NULL,
  `firstName` char(15) COLLATE utf8_danish_ci NOT NULL,
  `lastName` char(15) COLLATE utf8_danish_ci NOT NULL,
  `yearOfBirth` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TotalDistance`
--

CREATE TABLE `TotalDistance` (
  `userName` char(15) COLLATE utf8_danish_ci NOT NULL,
  `totDist` int(11) NOT NULL,
  `fallYear` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Club`
--
ALTER TABLE `Club`
  ADD PRIMARY KEY (`clubId`);

--
-- Indexes for table `Representing`
--
ALTER TABLE `Representing`
  ADD PRIMARY KEY (`userName`,`fallYear`),
  ADD KEY `fallYear` (`fallYear`),
  ADD KEY `Representing_ibfk_2` (`clubId`);

--
-- Indexes for table `Season`
--
ALTER TABLE `Season`
  ADD PRIMARY KEY (`fallYear`);

--
-- Indexes for table `Skier`
--
ALTER TABLE `Skier`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `TotalDistance`
--
ALTER TABLE `TotalDistance`
  ADD PRIMARY KEY (`userName`,`totDist`,`fallYear`),
  ADD KEY `fallYear` (`fallYear`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Representing`
--
ALTER TABLE `Representing`
  ADD CONSTRAINT `Representing_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `Skier` (`userName`),
  ADD CONSTRAINT `Representing_ibfk_2` FOREIGN KEY (`clubId`) REFERENCES `Club` (`clubId`),
  ADD CONSTRAINT `Representing_ibfk_3` FOREIGN KEY (`fallYear`) REFERENCES `Season` (`fallYear`);

--
-- Constraints for table `TotalDistance`
--
ALTER TABLE `TotalDistance`
  ADD CONSTRAINT `TotalDistance_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `Skier` (`userName`),
  ADD CONSTRAINT `TotalDistance_ibfk_2` FOREIGN KEY (`fallYear`) REFERENCES `Season` (`fallYear`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
