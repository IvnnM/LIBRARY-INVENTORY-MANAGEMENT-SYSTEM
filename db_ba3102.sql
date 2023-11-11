-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 01:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28
CREATE DATABASE IF NOT EXISTS db_ba3102;
USE db_ba3102;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ba3102`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `ISBN` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `publication_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`title`, `author`, `genre`, `ISBN`, `description`, `quantity`, `publication_date`) VALUES
('Book 1', 'Author 1', 'Genre 1', 'ISBN123456', 'Description of Book 1', 10, '2022-01-15'),
('Book 2', 'Author 2', 'Genre 2', 'ISBN234567', 'Description of Book 2', 15, '2022-02-20'),
('Book 3', 'Author 3', 'Genre 3', 'ISBN345678', 'Description of Book 3', 8, '2022-03-25'),
('Book 4', 'Author 1', 'Genre 4', 'ISBN456789', 'Description of Book 4', 20, '2022-04-10'),
('Book 5', 'Author 1', 'Genre 1', 'ISBN101112', 'Description of Book 5', 20, '2022-05-05'),
('Book 6', 'Author 1', 'Genre 1', 'ISBN789012', 'Description of Book 6', 15, '2022-06-15'),
('Book 7', 'Author 2', 'Genre 2', 'ISBN890123', 'Description of Book 7', 12, '2022-07-20'),
('Book 8', 'Author 2', 'Genre 2', 'ISBN901234', 'Description of Book 8', 18, '2022-08-25'),
('Book 9', 'Author 2', 'Genre 2', 'ISBN012345', 'Description of Book 9', 25, '2022-09-10'),
('Book 10', 'Author 3', 'Genre 3', 'ISBN123456', 'Description of Book 10', 10, '2022-10-05');

-- --------------------------------------------------------

--
-- Table structure for table `book_transactions`
--

CREATE TABLE `book_transactions` (
  `transactionID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `inQuantity` int(11) NOT NULL,
  `outQuantity` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_transactions`
--

-- Inserting data into `book_transactions`
INSERT INTO `book_transactions` (`userID`, `bookID`, `inQuantity`, `outQuantity`, `date`) VALUES
(2, 6, 2, 0, '2023-11-02 09:20:17'),
(3, 7, 0, 1, '2023-11-02 09:20:23'),
(2, 8, 1, 0, '2023-11-02 09:20:29'),
(3, 9, 0, 3, '2023-11-03 04:20:00'),
(3, 10, 2, 0, '2023-11-03 06:05:00'),
(3, 11, 4, 0, '2023-11-03 03:14:51'),
(2, 12, 0, 5, '2023-11-03 03:20:58'),
(3, 13, 0, 5, '2023-11-03 04:53:56'),
(3, 14, 1, 0, '2023-11-03 05:08:34'),
(3, 15, 0, 1, '2023-11-03 05:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Client','Librarian') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fullname`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Admin'),
('Client User', 'client@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Client'),
('Librarian User', 'librarian@g', '$2y$10$7WBXttrmFnqyZgP/w3hQCuj1UFGktv.zrkE7vVALTOhiOQa.LSSFq', 'Librarian');
