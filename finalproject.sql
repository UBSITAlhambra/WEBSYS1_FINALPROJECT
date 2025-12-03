-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 05:59 AM
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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `itemID` int(11) NOT NULL,
  `genericName` varchar(32) NOT NULL,
  `dosage` varchar(32) NOT NULL,
  `category` varchar(32) NOT NULL,
  `addDate` date NOT NULL,
  `expDate` date NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`itemID`, `genericName`, `dosage`, `category`, `addDate`, `expDate`, `quantity`) VALUES
(2, 'paracetamol', '12', 'qweq', '2025-11-02', '2025-11-17', 86);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(20) NOT NULL DEFAULT 'Staff',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`ID`, `FirstName`, `MiddleName`, `LastName`, `Email`, `Password`, `Role`, `Created_At`) VALUES
(1, 'Regina', '', 'George', 'regina@gmail.com', '$2y$10$awryAXW69OiCHl4ElKXHYexbCIcEk8HgQ8NxbYS7xt5Lz8qB7wcem', 'Staff', '2025-11-20 18:25:29'),
(2, 'Juan', 'De', 'La Cruz', 'juan@gmail.com', '$2y$10$6s74LJqDZ8EYoYc0jkzDwugKaGkCsJkdlgEsNnZ2asCZJUurYAOG2', 'Staff', '2025-11-24 17:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `studentrecord`
--

CREATE TABLE `studentrecord` (
  `ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `idNum` int(11) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Student',
  `department` varchar(30) NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `complaint` varchar(255) NOT NULL,
  `visitDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentrecord`
--

INSERT INTO `studentrecord` (`ID`, `name`, `idNum`, `gender`, `role`, `department`, `section`, `complaint`, `visitDate`) VALUES
(1, '123', 123, NULL, 'Student', '123', NULL, '123', '2025-11-20'),
(2, 'Juan', 0, 'Male', 'Student', '', '', '', '0000-00-00'),
(3, 'Juan de', 0, '', 'Non-Teaching Staff', '', '', 'Fever', '2025-12-03'),
(4, 'redloie', 0, '', 'Non-Teaching Staff', '', '', 'Fainting', '2025-12-03');

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
(2, 1, '2025-11-24', 999.9, '123/78', 123, 12),
(3, 2, '0000-00-00', 999.9, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transactionDate` date NOT NULL,
  `itemID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionID`, `quantity`, `transactionDate`, `itemID`, `studentID`, `remarks`) VALUES
(4, 12, '2025-11-20', 2, 1, NULL),
(5, 12, '2025-11-20', 2, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `studentrecord`
--
ALTER TABLE `studentrecord`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student_vitals`
--
ALTER TABLE `student_vitals`
  ADD PRIMARY KEY (`vitalID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `fk_transaction_item` (`itemID`),
  ADD KEY `fk_transaction_student` (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studentrecord`
--
ALTER TABLE `studentrecord`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_vitals`
--
ALTER TABLE `student_vitals`
  MODIFY `vitalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
