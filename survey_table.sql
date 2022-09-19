-- MedizinballMyAdmin SQL Dump
-- version 4.7.4
-- https://www.Medizinballmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2021 at 03:30 PM
-- Server version: 10.1.30-MariaDB
-- Medizinball Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `praxis login`
--

-- --------------------------------------------------------

--
-- Table structure for table `geraete_liste`
--

CREATE TABLE `geraete_liste` (
  `geraete_id` int(11) NOT NULL,
  `geraete_name` varchar(100) NOT NULL,
  `user_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geraete_liste`
--

INSERT INTO `geraete_liste` (`geraete_id`, `geraete_name`) VALUES
(1, 'Medizinball'),
(3, 'Sprossenwand'),
(4, 'Therapie-Liege'),
(5, 'Medizinball'),
(6, 'Medizinball'),
(7, 'Therapie-Liege'),
(8, 'Medizinball'),
(9, 'Sprossenwand'),
(10, 'Medizinball'),
(11, 'Therapie-Liege'),
(12, 'Therapie-Liege');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `geraete_liste`
--
ALTER TABLE `geraete_liste`
  ADD PRIMARY KEY (`geraete_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `geraete_liste`
--
ALTER TABLE `geraete_liste`
  MODIFY `geraete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
