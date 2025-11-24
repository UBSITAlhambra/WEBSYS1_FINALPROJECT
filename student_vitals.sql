-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 04:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_vitals`
--

CREATE TABLE `student_vitals` (
  `vitalID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `vitalDate` date NOT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `bloodPressure` varchar(20) DEFAULT NULL,
  `pulse` int(11) DEFAULT NULL,
  `respiratoryRate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_vitals`
--

INSERT INTO `student_vitals` (`vitalID`, `studentID`, `vitalDate`, `temperature`, `bloodPressure`, `pulse`, `respiratoryRate`) VALUES
(2, 1, '2025-11-24', 999.9, '123/78', 123, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_vitals`
--
ALTER TABLE `student_vitals`
  ADD PRIMARY KEY (`vitalID`),
  ADD KEY `studentID` (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_vitals`
--
ALTER TABLE `student_vitals`
  MODIFY `vitalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_vitals`
--
ALTER TABLE `student_vitals`
  ADD CONSTRAINT `student_vitals_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `studentrecord` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
