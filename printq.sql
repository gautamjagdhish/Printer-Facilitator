-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2018 at 12:47 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `printq`

-- Table structures

CREATE TABLE `main` (
  `rno` varchar(10) NOT NULL PRIMARY KEY,
  `password` varchar(64) NOT NULL,
  `balance` int(6) UNSIGNED ZEROFILL DEFAULT '000000',
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `rno` int(10) NOT NULL,
  `amount` int(5) DEFAULT '0',
  `timestamp` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `printhistory` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `pdfname` varchar(255) NOT NULL,
  `newname` varchar(255) NOT NULL,
  `rno` varchar(10) NOT NULL,
  `color` int(1) NOT NULL DEFAULT '0',
  `pages` varchar(45) NOT NULL,
  `copies` int(4) NOT NULL,
  `cost` int(5) NOT NULL DEFAULT '0',
  `printstatus` int(1) DEFAULT '0',
  `collectstatus` int(1) DEFAULT '0',
  `paystatus` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for tables
--

INSERT INTO `main` (`rno`, `password`, `balance`, `level`) VALUES
('31', 'f6f2ea8f45d8a057c9566a33f99474da2e5c6a6604d736121650e2730c6fb0a3', NULL, 'admin'),
('33', '688787d8ff144c502c7f5cffaafe2cc588d86079f9de88304c26b0cb99ce91c6', 000137, 'student');

INSERT INTO `printhistory` (`id`, `pdfname`, `newname`, `rno`, `color`, `pages`, `copies`, `cost`, `printstatus`, `collectstatus`, `paystatus`) VALUES
(138, 'compressed.tracemonkey-pldi-09.pdf', '1_1,2-5,10_2_1.pdf', '33', 1, '1,2-5,10', 2, 60, 1, 0, 0);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
