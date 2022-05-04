-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 04, 2022 at 07:58 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helperland`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `Id` int(11) NOT NULL,
  `CityName` varchar(50) NOT NULL,
  `StateId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`Id`, `CityName`, `StateId`) VALUES
(1, 'Wedding', 1),
(2, 'Berlin', 1),
(3, 'Cottbus', 2),
(4, 'Strausberg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ContactUsId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Subject` varchar(500) DEFAULT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Message` longtext NOT NULL,
  `UploadFileName` varchar(100) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `FileName` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ContactUsId`, `Name`, `Email`, `Subject`, `PhoneNumber`, `Message`, `UploadFileName`, `CreatedOn`, `CreatedBy`, `FileName`) VALUES
(1, 'abc def', 'vatsaldendpara001@gmail.com', 'general', '9998085586', 'bh', '', '2022-04-23 15:04:08', NULL, ''),
(2, 'abc def', 'vatsaldendpara007@gmail.com', 'general', '9998085586', '25', '', '2022-04-23 15:49:32', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `favoriteandblocked`
--

CREATE TABLE `favoriteandblocked` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `TargetUserId` int(11) NOT NULL,
  `IsFavorite` tinyint(4) NOT NULL,
  `IsBlocked` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favoriteandblocked`
--

INSERT INTO `favoriteandblocked` (`Id`, `UserId`, `TargetUserId`, `IsFavorite`, `IsBlocked`) VALUES
(3, 6, 7, 1, 0),
(4, 7, 6, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RatingId` int(11) NOT NULL,
  `ServiceRequestId` int(11) NOT NULL,
  `RatingFrom` int(11) NOT NULL,
  `RatingTo` int(11) NOT NULL,
  `Ratings` decimal(2,1) NOT NULL,
  `Comments` varchar(2000) DEFAULT NULL,
  `RatingDate` datetime(3) NOT NULL,
  `OnTimeArrival` decimal(2,1) NOT NULL DEFAULT 0.0,
  `Friendly` decimal(2,1) NOT NULL DEFAULT 0.0,
  `QualityOfService` decimal(2,1) NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`RatingId`, `ServiceRequestId`, `RatingFrom`, `RatingTo`, `Ratings`, `Comments`, `RatingDate`, `OnTimeArrival`, `Friendly`, `QualityOfService`) VALUES
(2, 10, 6, 7, '4.3', '', '2022-04-27 22:26:52.000', '4.0', '4.0', '5.0');

-- --------------------------------------------------------

--
-- Table structure for table `servicerequest`
--

CREATE TABLE `servicerequest` (
  `ServiceRequestId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ServiceId` int(11) NOT NULL,
  `ServiceStartDate` datetime(3) NOT NULL,
  `ZipCode` varchar(10) NOT NULL,
  `ServiceHourlyRate` decimal(8,2) DEFAULT NULL,
  `ServiceHours` double NOT NULL,
  `ExtraHours` double DEFAULT NULL,
  `SubTotal` decimal(8,2) NOT NULL,
  `Discount` decimal(8,2) DEFAULT NULL,
  `TotalCost` decimal(8,2) NOT NULL,
  `Comments` varchar(500) DEFAULT NULL,
  `PaymentTransactionRefNo` varchar(50) DEFAULT NULL,
  `PaymentDue` tinyint(4) NOT NULL DEFAULT 0,
  `ServiceProviderId` int(11) DEFAULT NULL,
  `SPAcceptedDate` datetime(3) DEFAULT NULL,
  `HasPets` tinyint(4) NOT NULL DEFAULT 0,
  `Status` int(11) DEFAULT NULL,
  `CreatedDate` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `ModifiedDate` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `ModifiedBy` int(11) DEFAULT NULL,
  `RefundedAmount` decimal(8,2) DEFAULT NULL,
  `Distance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `HasIssue` tinyint(4) DEFAULT NULL,
  `PaymentDone` tinyint(4) DEFAULT NULL,
  `RecordVersion` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servicerequest`
--

INSERT INTO `servicerequest` (`ServiceRequestId`, `UserId`, `ServiceId`, `ServiceStartDate`, `ZipCode`, `ServiceHourlyRate`, `ServiceHours`, `ExtraHours`, `SubTotal`, `Discount`, `TotalCost`, `Comments`, `PaymentTransactionRefNo`, `PaymentDue`, `ServiceProviderId`, `SPAcceptedDate`, `HasPets`, `Status`, `CreatedDate`, `ModifiedDate`, `ModifiedBy`, `RefundedAmount`, `Distance`, `HasIssue`, `PaymentDone`, `RecordVersion`) VALUES
(9, 6, 0, '2022-04-28 10:00:00.000', '10551', '18.00', 4, 1, '72.00', '0.00', '72.00', '', NULL, 0, 7, '2022-04-27 22:28:10.000', 0, 1, '2022-04-27 21:02:08.000', '2022-04-27 22:28:43.000', 6, '0.00', '0.00', NULL, 1, '1'),
(10, 6, 0, '2022-04-27 08:00:00.000', '10551', '18.00', 3.5, 0.5, '63.00', '0.00', '63.00', '', NULL, 0, 7, '2022-04-27 22:25:46.000', 0, 4, '2022-04-27 21:02:43.000', '2022-04-27 21:02:43.600', NULL, '0.00', '0.00', NULL, 1, '0'),
(11, 6, 0, '2022-05-04 08:00:00.000', '10551', '18.00', 3.5, 0.5, '63.00', '0.00', '63.00', '', NULL, 0, 7, '2022-05-04 21:06:41.000', 1, 2, '2022-05-04 21:03:01.000', '2022-05-04 21:03:01.142', NULL, '0.00', '0.00', NULL, 1, '0'),
(12, 6, 0, '2022-05-04 08:00:00.000', '10551', '18.00', 4, 1, '72.00', '0.00', '72.00', '', NULL, 0, 7, NULL, 0, 1, '2022-05-04 21:05:09.000', '2022-05-04 21:05:09.361', NULL, '0.00', '0.00', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `servicerequestaddress`
--

CREATE TABLE `servicerequestaddress` (
  `Id` int(11) NOT NULL,
  `ServiceRequestId` int(11) DEFAULT NULL,
  `AddressLine1` varchar(200) DEFAULT NULL,
  `AddressLine2` varchar(200) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL,
  `Mobile` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servicerequestaddress`
--

INSERT INTO `servicerequestaddress` (`Id`, `ServiceRequestId`, `AddressLine1`, `AddressLine2`, `City`, `State`, `PostalCode`, `Mobile`, `Email`) VALUES
(9, 9, '112', 'jamuna park', 'Berlin', 'Berlin', '10551', '9998085586', 'vatsaldendpara001@gmail.com'),
(10, 10, '112', 'desai vadi', 'Berlin', 'Berlin', '10551', '9988774455', 'vatsaldendpara001@gmail.com'),
(11, 11, '112', 'jamuna park', 'Berlin', 'Berlin', '10551', '9998085586', 'vatsaldendpara001@gmail.com'),
(12, 12, '112', 'desai vadi', 'Berlin', 'Berlin', '10551', '9988774455', 'vatsaldendpara001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `servicerequestextra`
--

CREATE TABLE `servicerequestextra` (
  `ServiceRequestExtraId` int(11) NOT NULL,
  `ServiceRequestId` int(11) NOT NULL,
  `ServiceExtraId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servicerequestextra`
--

INSERT INTO `servicerequestextra` (`ServiceRequestExtraId`, `ServiceRequestId`, `ServiceExtraId`) VALUES
(9, 9, 12),
(10, 10, 3),
(11, 11, 1),
(12, 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `Id` int(11) NOT NULL,
  `StateName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`Id`, `StateName`) VALUES
(1, 'Berlin'),
(2, 'Brandenburg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Mobile` varchar(20) NOT NULL,
  `UserTypeId` int(11) NOT NULL,
  `Gender` int(11) DEFAULT NULL,
  `DateOfBirth` datetime(3) DEFAULT NULL,
  `UserProfilePicture` varchar(200) DEFAULT NULL,
  `IsRegisteredUser` tinyint(4) NOT NULL DEFAULT 0,
  `PaymentGatewayUserRef` varchar(200) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL,
  `WorksWithPets` tinyint(4) NOT NULL DEFAULT 0,
  `LanguageId` int(11) DEFAULT NULL,
  `NationalityId` int(11) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `ModifiedDate` datetime(3) NOT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `IsApproved` tinyint(4) NOT NULL DEFAULT 0,
  `IsActive` tinyint(4) NOT NULL DEFAULT 0,
  `IsDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `Status` int(11) DEFAULT NULL,
  `BankTokenId` varchar(100) DEFAULT NULL,
  `TaxNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `FirstName`, `LastName`, `Email`, `Password`, `Mobile`, `UserTypeId`, `Gender`, `DateOfBirth`, `UserProfilePicture`, `IsRegisteredUser`, `PaymentGatewayUserRef`, `ZipCode`, `WorksWithPets`, `LanguageId`, `NationalityId`, `CreatedDate`, `ModifiedDate`, `ModifiedBy`, `IsApproved`, `IsActive`, `IsDeleted`, `Status`, `BankTokenId`, `TaxNo`) VALUES
(5, 'Admin', 'Admin', 'vatsalthakor22@gmail.com', '$2y$10$FdWQjptU5uA2uEV4L6QBLuTgEH9aLmUHGpfZUx/Uk/YB0jODoR3Me', '8469116765', 3, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '2022-03-17 15:58:21', '0000-00-00 00:00:00.000', 0, 1, 0, 0, NULL, NULL, NULL),
(6, 'vatsal', 'dendpara', 'vatsaldendpara001@gmail.com', '$2y$10$tVwalhH12rz.IOw7cm1iKu1X6jrwmeGddVm2l8Dk44beyIjeE6wVm', '9998085586', 1, 0, '2001-12-01 00:00:00.000', 'NULL', 0, NULL, NULL, 0, NULL, NULL, '2022-04-23 14:59:57', '0000-00-00 00:00:00.000', 0, 1, 0, 0, NULL, NULL, NULL),
(7, 'Vats', 'dendpara', 'vatsaldendpara007@gmail.com', '$2y$10$sURxw8K5isSzA1oRy4nsf.36KK31Dl8CmdRgfyavZLyznJGbG2FkO', '9998085586', 2, 1, '1997-06-19 00:00:00.000', 'avatar-male', 0, NULL, NULL, 0, NULL, NULL, '2022-04-23 15:00:57', '2022-04-23 15:01:26.000', 5, 1, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

CREATE TABLE `useraddress` (
  `AddressId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AddressLine1` varchar(200) NOT NULL,
  `AddressLine2` varchar(200) DEFAULT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) NOT NULL,
  `IsDefault` tinyint(4) NOT NULL DEFAULT 0,
  `IsDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `Mobile` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraddress`
--

INSERT INTO `useraddress` (`AddressId`, `UserId`, `AddressLine1`, `AddressLine2`, `City`, `State`, `PostalCode`, `IsDefault`, `IsDeleted`, `Mobile`, `Email`) VALUES
(4, 7, '002', 'desai vadi', 'Berlin', 'Berlin', '10551', 0, 0, '9998085586', 'vatsaldendpara007@gmail.com'),
(5, 6, '112', 'jamuna park', 'Berlin', 'Berlin', '10551', 0, 0, '9998085586', 'vatsaldendpara001@gmail.com'),
(6, 6, '112', 'desai vadi', 'Berlin', 'Berlin', '10551', 0, 0, '9988774455', 'vatsaldendpara001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `zipcode`
--

CREATE TABLE `zipcode` (
  `Id` int(11) NOT NULL,
  `ZipcodeValue` varchar(50) NOT NULL,
  `CityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zipcode`
--

INSERT INTO `zipcode` (`Id`, `ZipcodeValue`, `CityId`) VALUES
(1, '13347', 1),
(2, '13349', 1),
(3, '10551', 2),
(4, '10553', 2),
(5, '03048', 3),
(6, '03050', 3),
(7, '15344', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `StateId` (`StateId`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ContactUsId`);

--
-- Indexes for table `favoriteandblocked`
--
ALTER TABLE `favoriteandblocked`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `TargetUserId` (`TargetUserId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RatingId`),
  ADD KEY `ServiceRequestId` (`ServiceRequestId`),
  ADD KEY `RatingFrom` (`RatingFrom`),
  ADD KEY `RatingTo` (`RatingTo`);

--
-- Indexes for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD PRIMARY KEY (`ServiceRequestId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `ServiceProviderId` (`ServiceProviderId`);

--
-- Indexes for table `servicerequestaddress`
--
ALTER TABLE `servicerequestaddress`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ServiceRequestId` (`ServiceRequestId`);

--
-- Indexes for table `servicerequestextra`
--
ALTER TABLE `servicerequestextra`
  ADD PRIMARY KEY (`ServiceRequestExtraId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD PRIMARY KEY (`AddressId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `zipcode`
--
ALTER TABLE `zipcode`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CityId` (`CityId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ContactUsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favoriteandblocked`
--
ALTER TABLE `favoriteandblocked`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RatingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `servicerequest`
--
ALTER TABLE `servicerequest`
  MODIFY `ServiceRequestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `servicerequestaddress`
--
ALTER TABLE `servicerequestaddress`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `servicerequestextra`
--
ALTER TABLE `servicerequestextra`
  MODIFY `ServiceRequestExtraId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `AddressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zipcode`
--
ALTER TABLE `zipcode`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`StateId`) REFERENCES `state` (`Id`);

--
-- Constraints for table `favoriteandblocked`
--
ALTER TABLE `favoriteandblocked`
  ADD CONSTRAINT `favoriteandblocked_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`),
  ADD CONSTRAINT `favoriteandblocked_ibfk_2` FOREIGN KEY (`TargetUserId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`ServiceRequestId`) REFERENCES `servicerequest` (`ServiceRequestId`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`RatingFrom`) REFERENCES `user` (`UserId`),
  ADD CONSTRAINT `rating_ibfk_3` FOREIGN KEY (`RatingTo`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD CONSTRAINT `servicerequest_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`),
  ADD CONSTRAINT `servicerequest_ibfk_2` FOREIGN KEY (`ServiceProviderId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `servicerequestaddress`
--
ALTER TABLE `servicerequestaddress`
  ADD CONSTRAINT `servicerequestaddress_ibfk_1` FOREIGN KEY (`ServiceRequestId`) REFERENCES `servicerequest` (`ServiceRequestId`);

--
-- Constraints for table `servicerequestextra`
--
ALTER TABLE `servicerequestextra`
  ADD CONSTRAINT `servicerequestextra_ibfk_1` FOREIGN KEY (`ServiceRequestExtraId`) REFERENCES `servicerequest` (`ServiceRequestId`);

--
-- Constraints for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `useraddress_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `zipcode`
--
ALTER TABLE `zipcode`
  ADD CONSTRAINT `zipcode_ibfk_1` FOREIGN KEY (`CityId`) REFERENCES `city` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
