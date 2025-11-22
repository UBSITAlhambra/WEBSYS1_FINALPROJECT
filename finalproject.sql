-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 01:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30
-- Generation Time: Nov 20, 2025 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
  `brand` varchar(32) NOT NULL,
  `category` varchar(32) NOT NULL,
  `addDate` date NOT NULL,
  `expDate` date NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`itemID`, `genericName`, `dosage`, `brand`, `category`, `addDate`, `expDate`, `quantity`) VALUES
(2, 'paracetamol', '12', 'tempra', 'qweq', '2025-11-02', '2025-11-17', 86);

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
(0, 'Regina', '', 'George', 'regina@gmail.com', '$2y$10$awryAXW69OiCHl4ElKXHYexbCIcEk8HgQ8NxbYS7xt5Lz8qB7wcem', 'Staff', '2025-11-20 18:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `studentrecord`
--

CREATE TABLE `studentrecord` (
  `ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `idNum` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `complaint` varchar(255) NOT NULL,
  `visitDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentrecord`
--

INSERT INTO `studentrecord` (`ID`, `name`, `idNum`, `department`, `complaint`, `visitDate`) VALUES
(1, '123', 123, 123, '123', '2025-11-20');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transactionDate` date NOT NULL,
  `itemID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionID`, `quantity`, `transactionDate`, `itemID`, `studentID`) VALUES
(4, 12, '2025-11-20', 2, 1),
(5, 12, '2025-11-20', 2, 1);

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
-- AUTO_INCREMENT for table `studentrecord`
--
ALTER TABLE `studentrecord`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
