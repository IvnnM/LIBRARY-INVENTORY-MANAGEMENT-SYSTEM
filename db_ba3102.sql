-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 01:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS db_ba3102;
USE db_ba3102;

-- Set SQL mode and time zone
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Save old character set values
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

-- Set character set to utf8mb4
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

-- Table structure for table `tbempinfo`

CREATE TABLE IF NOT EXISTS `tbempinfo` (
  `empid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `department` varchar(30) NOT NULL,
  PRIMARY KEY (`empid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tbempinfo`
INSERT INTO `tbempinfo` (`lastname`, `firstname`, `department`) VALUES
('aguila', 'nina', 'cics'),
('REYES', 'CHRISTOPHER', 'cics'),
('RAYOS', 'JONNAH ', 'cics'),
('AUSTRIA', 'CARL ', 'cics'),
('LEYRIT', 'TRISTAN ', 'cics'),
('PABLO', 'JOSEPH', 'cabe'),
('LIBUNAO', 'ANGELENE ', 'cabe'),
('SAMBITAN', 'KRYSTEL ', 'cabe'),
('MACALINGA', 'ANGELICA ', 'cabe'),
('BALAZON', 'FRANCIS ', 'cabe');
-- --------------------------------------------------------

-- Table structure for table `tb_librarian`

CREATE TABLE IF NOT EXISTS `tb_librarian` (
  `librarianID` int(11) NOT NULL AUTO_INCREMENT,
  `empid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Librarian') NOT NULL,
  PRIMARY KEY (`librarianID`),
  FOREIGN KEY (`empid`) REFERENCES `tbempinfo` (`empid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tb_librarian`
INSERT INTO `tb_librarian` (`empid`, `email`, `password`, `role`) VALUES
(1, 'aguila@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Librarian'),
(2, 'reyes@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Librarian');

-- --------------------------------------------------------

-- Table structure for table `tb_studinfo`

CREATE TABLE IF NOT EXISTS `tb_studinfo` (
  `studid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `course` varchar(20) NOT NULL,
  PRIMARY KEY (`studid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tb_studinfo`
INSERT INTO `tb_studinfo` (`lastname`, `firstname`, `course`) VALUES
('Parker', 'Peter', 'BSIT'),
('Kent', 'Clark', 'BSCS'),
('Lozares', 'Maur', 'BSMA'),
('Angelou', 'Queen', 'BSMA'),
('Mayo', 'Man', 'BSMA'),
('Irish', 'Lean', 'BSIT'),
('Maria', 'Andrea', 'BSIT'),
('Valencia', 'Dex', 'BSIT'),
('Bela', 'Ara', 'BSIT'),
('Client', 'Name', 'BSIT');
COMMIT;

-- --------------------------------------------------------

-- Table structure for table `tb_client`

CREATE TABLE IF NOT EXISTS `tb_client` (
  `clientID` int(11) NOT NULL AUTO_INCREMENT,
  `studid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Client') NOT NULL,
  PRIMARY KEY (`clientID`),
  FOREIGN KEY (`studid`) REFERENCES `tb_studinfo` (`studid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tb_client`
INSERT INTO `tb_client` (`studid`, `email`, `password`, `role`) VALUES
(1, 'parker@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(2, 'kent@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(3, 'Maur@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(4, 'Queen@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(5, 'Mayo@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(6, 'Lean@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(7, 'Maria@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(8, 'Dex@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(9, 'Ara@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
(10, 'Client@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client');

-- --------------------------------------------------------

-- Table structure for table `tb_admin`

CREATE TABLE IF NOT EXISTS `tb_admin` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin') NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tb_admin`
INSERT INTO `tb_admin` (`fullname`, `email`, `password`, `role`) VALUES
('Medrano, Ivan D.', 'admin@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Admin name', 'admin2@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Bautista, Chris John L.', 'bautista@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Panaligan, Jomari M.', 'panaligan@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Hernandez, Marc Andrei L.', 'hernandez@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Mendoza, Harvey L.', 'mendoza@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin');
COMMIT;
-- --------------------------------------------------------

-- Table structure for table `books`

CREATE TABLE IF NOT EXISTS `books` (
  `bookID` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ISBN` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `quantity` int NOT NULL,
  `publication_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bookID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `books`
INSERT INTO `books` (`title`, `author`, `genre`, `ISBN`, `description`, `quantity`, `publication_date`) VALUES
('Book 1', 'Author 1', 'Genre 1', 'ISBN10101', 'Description of Book 1', 10, '2023-01-15'),
('Book 2', 'Author 2', 'Genre 2', 'ISBN99999', 'Description of Book 2', 15, '2023-02-20'),
('Book 3', 'Author 3', 'Genre 3', 'ISBN88888', 'Description of Book 3', 8, '2023-03-25'),
('Book 4', 'Author 1', 'Genre 4', 'ISBN77777', 'Description of Book 4', 20, '2023-04-10'),
('Book 5', 'Author 1', 'Genre 1', 'ISBN66666', 'Description of Book 5', 0, '2023-05-05'),
('Book 6', 'Author 1', 'Genre 1', 'ISBN55555', 'Description of Book 6', 15, '2023-06-15'),
('Book 7', 'Author 2', 'Genre 2', 'ISBN44444', 'Description of Book 7', 12, '2023-07-20'),
('Book 8', 'Author 2', 'Genre 2', 'ISBN33333', 'Description of Book 8', 18, '2023-08-25'),
('Book 9', 'Author 2', 'Genre 2', 'ISBN022222', 'Description of Book 9', 25, '2023-09-10'),
('Book 10', 'Author 3', 'Genre 3', 'ISBN11111', 'Description of Book 10', 0, '2022-10-05'),
('Book 11', 'Author 3', 'Genre 4', 'ISBN12345', 'Description of Book 11', 8, '2023-11-15'),
('Book 12', 'Author 4', 'Genre 5', 'ISBN67890', 'Description of Book 12', 15, '2023-12-20'),
('Book 13', 'Author 4', 'Genre 5', 'ISBN13579', 'Description of Book 13', 20, '2023-01-25'),
('Book 14', 'Author 5', 'Genre 6', 'ISBN24680', 'Description of Book 14', 10, '2023-02-10'),
('Book 15', 'Author 6', 'Genre 7', 'ISBN98765', 'Description of Book 15', 0, '2023-03-05'),
('Book 16', 'Author 6', 'Genre 7', 'ISBN11223', 'Description of Book 16', 18, '2023-04-15'),
('Book 17', 'Author 7', 'Genre 8', 'ISBN44556', 'Description of Book 17', 12, '2023-05-20'),
('Book 18', 'Author 7', 'Genre 8', 'ISBN77889', 'Description of Book 18', 22, '2023-06-25'),
('Book 19', 'Author 8', 'Genre 9', 'ISBN99000', 'Description of Book 19', 0, '2023-07-10'),
('Book 20', 'Author 8', 'Genre 9', 'ISBN11222', 'Description of Book 20', 30, '2023-08-05');

-- --------------------------------------------------------

-- Table structure for table `book_transactions`

CREATE TABLE IF NOT EXISTS `book_transactions` (
  `transactionID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `bookID` int NOT NULL,
  `inQuantity` int NOT NULL,
  `outQuantity` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `book_transactions`
INSERT INTO `book_transactions` (`userID`, `bookID`, `inQuantity`, `outQuantity`, `date`) VALUES
(2, 6, 2, 0, '2023-11-19 09:20:17'),
(2, 7, 0, 1, '2023-11-19 09:20:23'),
(2, 8, 1, 0, '2023-11-20 09:20:29'),
(2, 9, 0, 3, '2023-11-20 04:20:00'),
(2, 10, 2, 0, '2023-11-21 06:05:00'),
(1, 11, 4, 0, '2023-11-21 03:14:51'),
(1, 12, 0, 5, '2023-11-23 03:20:58'),
(1, 13, 0, 5, '2023-11-23 04:53:56'),
(1, 14, 1, 0, '2023-11-24 05:08:34'),
(1, 15, 0, 1, '2023-11-25 05:08:45');



-- Group 1
DROP TABLE IF EXISTS `tbaccount`;
CREATE TABLE IF NOT EXISTS `tbaccount` (
  `accid` int NOT NULL AUTO_INCREMENT,
  `empid` int DEFAULT NULL,
  `passwordencrypted` varchar(255) NOT NULL,
  PRIMARY KEY (`accid`),
  KEY `empid` (`empid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbaccount`
--

INSERT INTO `tbaccount` (`accid`, `empid`, `passwordencrypted`) VALUES
(1, NULL, 'hashed_password1'),
(2, NULL, 'hashed_password2');

-- --------------------------------------------------------

--
-- Table structure for table `tbadminfo`
--

DROP TABLE IF EXISTS `tbadminfo`;
CREATE TABLE IF NOT EXISTS `tbadminfo` (
  `admid` int NOT NULL AUTO_INCREMENT,
  `firstname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`admid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbadminfo`
--

INSERT INTO `tbadminfo` (`admid`, `firstname`, `lastname`, `password`) VALUES
(11, 'Queenie', 'Manigbas', 'mina97'),
(12, 'Maria', 'De Leon', 'ganda34');

-- --------------------------------------------------------

--
-- Table structure for table `tbattendance`
--

DROP TABLE IF EXISTS `tbattendance`;
CREATE TABLE IF NOT EXISTS `tbattendance` (
  `attendanceid` int NOT NULL,
  `studid` varchar(10) DEFAULT NULL,
  `empid` int DEFAULT NULL,
  `facilityid` int DEFAULT NULL,
  `subjectid` int DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`attendanceid`),
  KEY `studid` (`studid`),
  KEY `empid` (`empid`),
  KEY `facilityid` (`facilityid`),
  KEY `subjectid` (`subjectid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbempinfo`
--


CREATE TABLE IF NOT EXISTS `tbempinfo` (
  `empid` int NOT NULL AUTO_INCREMENT,
  `firstname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `department` text NOT NULL,
  PRIMARY KEY (`empid`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbempinfo`
--

INSERT INTO `tbempinfo` (`firstname`, `lastname`, `department`) VALUES
('Elenor', 'Labiaga', 'CICS'),
('Daryl', 'Tiquio', 'CICS'),
('Dioneces', 'Alimoren', 'CICS'),
('Christopher', 'Reyes', 'CICS'),
('Arvin', 'Almario', 'CICS'),
('Nina', 'Aguila', 'CICS'),
('Zymon', 'Maquinto', 'CICS');

-- --------------------------------------------------------

--
-- Table structure for table `tbfacility`
--

DROP TABLE IF EXISTS `tbfacility`;
CREATE TABLE IF NOT EXISTS `tbfacility` (
  `facilityid` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `buildingname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `roomnumber` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `seatnumber` int NOT NULL,
  PRIMARY KEY (`facilityid`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbfacility`
--

INSERT INTO `tbfacility` (`facilityid`, `buildingname`, `roomnumber`, `seatnumber`) VALUES
('HC2003', 'HEB', 'Comlab 2', 3),
('CC1008', 'CECS', 'Comlab 1', 8),
('CC1007', 'CECS', 'Comlab 1', 7),
('CC1006', 'CECS', 'Comlab 1', 6),
('CC1005', 'CECS', 'Comlab 1', 5),
('CC1004', 'CECS', 'Comlab 1', 4),
('CC1003', 'CECS', 'Comlab 1', 3),
('CC1002', 'CECS', 'Comlab 1', 2),
('CC1001', 'CECS', 'Comlab 1', 1),
('HC2002', 'HEB', 'Comlab 2', 2),
('HC2001', 'HEB', 'Comlab 2', 1),
('HC1010', 'HEB', 'Comlab 1', 10),
('HC1009', 'HEB', 'Comlab 1', 9),
('HC1008', 'HEB', 'Comlab 1', 8),
('HC1007', 'HEB', 'Comlab 1', 7),
('HC1006', 'HEB', 'Comlab 1', 6),
('HC1005', 'HEB', 'Comlab 1', 5),
('HC1004', 'HEB', 'Comlab 1', 4),
('HC1003', 'HEB', 'Comlab 1', 3),
('HC1002', 'HEB', 'Comlab 1', 2),
('HC1001', 'HEB', 'Comlab 1', 1),
('CC2010', 'CECS', 'Comlab 2', 10),
('CC2009', 'CECS', 'Comlab 2', 9),
('CC2008', 'CECS', 'Comlab 2', 8),
('CC2007', 'CECS', 'Comlab 2', 7),
('CC2006', 'CECS', 'Comlab 2', 6),
('CC2005', 'CECS', 'Comlab 2', 5),
('CC2004', 'CECS', 'Comlab 2', 4),
('CC2003', 'CECS', 'Comlab 2', 3),
('CC2002', 'CECS', 'Comlab 2', 2),
('CC2001', 'CECS', 'Comlab 2', 1),
('CC1010', 'CECS', 'Comlab 1', 10),
('CC1009', 'CECS', 'Comlab 1', 9),
('HC2004', 'HEB', 'Comlab 2', 4),
('HC2005', 'HEB', 'Comlab 2', 5),
('HC2006', 'HEB', 'Comlab 2', 6),
('HC2007', 'HEB', 'Comlab 2', 7),
('HC2008', 'HEB', 'Comlab 2', 8),
('HC2009', 'HEB', 'Comlab 2', 9),
('HC2010', 'HEB', 'Comlab 2', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbstudinfo`
--

CREATE TABLE IF NOT EXISTS `tb_studinfo` (
  `studid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `course` text NOT NULL,
  PRIMARY KEY (`studid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbstudinfo`
--

INSERT INTO `tb_studinfo` (`firstname`, `lastname`, `course`) VALUES
('Maria Andrea', 'De Leon', 'BSIT'),
('Queenie', 'Manigbas', 'BSIT BA'),
('Simone Louis', 'De Villa', 'BSIT'),
('Irish', 'Suarez', 'BSIT'),
('Maureen', 'Lozares', 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `tbsubject`
--

DROP TABLE IF EXISTS `tbsubject`;
CREATE TABLE IF NOT EXISTS `tbsubject` (
  `subjectid` int NOT NULL,
  `subjectcode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subjectname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`subjectid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbsubject`
--

INSERT INTO `tbsubject` (`subjectid`, `subjectcode`, `subjectname`) VALUES
(1, 'BAT 401', 'Fundamentals of Business Analytics'),
(2, 'BAT 402', 'Fundamentals of Analytics Modeling'),
(3, 'IT 311', 'Administration and Maintenance'),
(4, 'IT 312', 'Systems Integration and Architecture'),
(5, 'IT 313', 'System Analysis and Design'),
(6, 'GED 107', 'Ethics'),
(7, 'IT 314', 'Web Systems and Technologies');
COMMIT;

-- Restore old character set values
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
