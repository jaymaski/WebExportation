-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 07:02 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounts`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_user` (IN `userID` INT)  NO SQL
BEGIN
	DELETE
	FROM
    	users
    WHERE
    	ID = userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user` (IN `userID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;	
    SELECT
    	u.ID,
        u.fName,
        u.lName,
        u.username,
        u.password,
        u.emailAddress,
        d.departmentCode,
        t.type
    FROM
    	users u
    LEFT JOIN
    	departments d
    ON
    	u.deptID = d.ID
    LEFT JOIN
    	types t
    ON
    	u.typeID = t.ID
    WHERE
        ID = userID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_list` ()  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
    SELECT
    	u.ID,
        u.fName,
        u.lName,
        u.username,
        u.password,
        u.emailAddress,
        d.departmentCode,
        t.type
    FROM
    	users u
    LEFT JOIN
    	departments d
    ON
    	u.deptID = d.ID
    LEFT JOIN
    	types t
    ON
    	u.typeID = t.ID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user` (IN `fName` VARCHAR(30), IN `lName` VARCHAR(30), IN `username` VARCHAR(30), IN `password` VARCHAR(30), IN `emailAddress` VARCHAR(50), IN `deptID` INT, IN `typeID` INT)  NO SQL
BEGIN
	DECLARE userID INT;
    
    INSERT INTO users
        (fName, lName,username, password, emailAddress, deptID, typeID)
    VALUES
    	(fName, lName, username, password, emailAddress, deptID, typeID);
        
    SET userID = LAST_INSERT_ID();
    SELECT userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_user` (IN `username` VARCHAR(50), IN `password` VARCHAR(50))  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	u.ID,
        u.fName,
        u.lName,
        u.username,
        u.password,
        u.emailAddress,
        d.departmentCode,
        t.type
    FROM
    	users u
    LEFT JOIN
    	departments d
    ON
    	u.deptID = d.ID
    LEFT JOIN
    	types t
    ON
    	u.typeID = t.ID
    WHERE
    	u.username = username 
    AND
    	u.password = password;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user` (IN `userID` INT, IN `newFName` VARCHAR(50), IN `newLName` VARCHAR(50), IN `newUsername` VARCHAR(50), IN `newPassword` VARCHAR(50), IN `newEmailAddress` VARCHAR(50), IN `newDeptID` INT, IN `newTypeID` INT)  NO SQL
BEGIN
	UPDATE 
    	users u
    SET
    	u.fName = newFName,
        u.lName = newLName,
        u.username = newUsername,
        u.password = newPassword,
        u.emailAddress = newEmailAddress,
        u.deptID = newDeptID,
        u.typeID = newTypeID
    WHERE
		u.ID = userID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `ID` int(11) NOT NULL,
  `departmentCode` varchar(10) NOT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`ID`, `departmentCode`, `description`) VALUES
(1, 'GTASS', 'GTASS'),
(2, 'GCSS', 'GCSS\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `ID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`ID`, `type`) VALUES
(1, 'Admin'),
(2, 'Requester');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `deptID` int(11) NOT NULL,
  `typeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `fName`, `lName`, `username`, `password`, `emailAddress`, `deptID`, `typeID`) VALUES
(1, 'Dememor', 'Mendoza', 'demi', 'mendoza', 'dememor.mendoza@b2be.com', 2, 2),
(2, 'DJ', 'Ramirez', 'dj', 'ramirez', 'dj.ramirez@b2be.com', 2, 2),
(3, 'Joemarie', 'Jacobe', 'joemarie', 'jacobe', 'joemarie.jacobe@b2be.com', 1, 1),
(4, 'Millete', 'Palacio', 'millete', 'palacio', 'millete.palacio@b2be.com', 2, 2),
(5, 'Mariel', 'Bojocan', 'mariel', 'bojocan', 'mariel.bojocan@b2be.com', 2, 2),
(6, 'Miguel', 'Roman', 'miguel', 'roman', 'miguel.roman@b2be.com', 1, 1),
(11, 'Al Wesley', 'Salac', 'alwesley', 'salac', 'alwesley.salac@b2be.com', 1, 1),
(12, 'Jay', 'Macareñas', 'jay', 'macareñas', 'jay.macareñas@b2be.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
