-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 04:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `documentroutingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `DocumentID` int(11) NOT NULL,
  `TrackingNumber` varchar(50) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `OriginatingOfficeID` int(11) DEFAULT NULL,
  `DestinationOfficeID` int(11) DEFAULT NULL,
  `OwnerEmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`DocumentID`, `TrackingNumber`, `Title`, `CreationDate`, `OriginatingOfficeID`, `DestinationOfficeID`, `OwnerEmployeeID`) VALUES
(13, 'h3453', 'Diploma', '2023-12-16 14:57:38', 1, 1, 2),
(17, 'DOC657db9c435cc4', 'AAAAA', '2023-12-16 14:52:52', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Role` varchar(255) DEFAULT NULL,
  `OfficeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Name`, `Email`, `Role`, `OfficeID`) VALUES
(1, 'John Doe', 'john@example.com', 'Manager', 1),
(2, 'Kath Smith', 'kathsmith@example.com', 'Manager', 3),
(3, 'Alice Williams', 'alice@example.com', 'Analyst', 3);

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `OfficeID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`OfficeID`, `Name`, `Location`) VALUES
(1, 'Headquarters', 'City A'),
(2, 'Branch Office 1', 'City B'),
(3, 'Branch Office 2', 'City C');

-- --------------------------------------------------------

--
-- Table structure for table `termination`
--

CREATE TABLE `termination` (
  `TerminationID` int(11) NOT NULL,
  `DocumentID` int(11) DEFAULT NULL,
  `TerminationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `TerminationReason` enum('Received','Decline','Pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `termination`
--

INSERT INTO `termination` (`TerminationID`, `DocumentID`, `TerminationDate`, `TerminationReason`) VALUES
(16, 13, '2023-12-16 14:57:17', 'Pending'),
(18, 17, '2023-12-16 14:57:22', 'Decline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`DocumentID`),
  ADD UNIQUE KEY `TrackingNumber` (`TrackingNumber`),
  ADD UNIQUE KEY `TrackingNumber_2` (`TrackingNumber`),
  ADD KEY `OriginatingOfficeID` (`OriginatingOfficeID`),
  ADD KEY `DestinationOfficeID` (`DestinationOfficeID`),
  ADD KEY `OwnerEmployeeID` (`OwnerEmployeeID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `OfficeID` (`OfficeID`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`OfficeID`);

--
-- Indexes for table `termination`
--
ALTER TABLE `termination`
  ADD PRIMARY KEY (`TerminationID`),
  ADD KEY `DocumentID` (`DocumentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `DocumentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `office`
--
ALTER TABLE `office`
  MODIFY `OfficeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `termination`
--
ALTER TABLE `termination`
  MODIFY `TerminationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`OriginatingOfficeID`) REFERENCES `office` (`OfficeID`),
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`DestinationOfficeID`) REFERENCES `office` (`OfficeID`),
  ADD CONSTRAINT `document_ibfk_3` FOREIGN KEY (`OwnerEmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`);

--
-- Constraints for table `termination`
--
ALTER TABLE `termination`
  ADD CONSTRAINT `termination_ibfk_1` FOREIGN KEY (`DocumentID`) REFERENCES `document` (`DocumentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
