-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2020 at 12:49 AM
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
-- Database: `exportation`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_change_type_id` (IN `changeTypeID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT	
   		ID
    FROM
    	change_type ct
   	WHERE
		ct.ID = changeTypeID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_change_type_list` (IN `requestID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	*
    FROM
    	change_type ct
    WHERE
		ct.requestID = requestID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_current_request` (IN `requestID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	r.ID AS requestID,
    	t.indexID,
    	p.projectID,
        p.projectOwner,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate
    FROM
		(
			SELECT
				a.ID AS projectID,
				CONCAT(b.fName," ",b.lName) AS projectOwner
			FROM
				projects a
			JOIN
				Accounts.users b
			ON
				a.projectOwnerID = b.ID
		)p
		LEFT JOIN
		(
			SELECT	
				a.ID AS indexID, 
            	a.taskID,
				a.projectID,
				CONCAT(b.fName," ",b.lName)  AS owner,
				a.sender,
				a.receiver,
				a.docType
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.projectID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.taskID
        WHERE	
        	r.ID = requestID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_project` (IN `projectID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT	
    	p.ID as projectID,
        p.projectOwnerID,
        CONCAT(u.fName," ",u.lName) as projectOwner
    FROM
    	projects p 
    LEFT JOIN
    	accounts.users u
    ON
    	p.projectOwnerID = u.ID
    WHERE
    	p.ID = projectID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_project_task_list` (IN `projectID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT	
    	t.ID AS indexID,
    	t.taskID,
        t.ownerID,
        CONCAT(u.fName," ",lName) AS owner,
        t.sender,
        t.receiver,
        t.docType
    FROM
    	tasks t
    LEFT JOIN
    	accounts.users u 
    ON
    	t.ownerID = u.ID
    WHERE
		t.projectID = projectID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_project_task_request_list` ()  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	r.ID AS requestID,
    	t.indexID,
    	p.projectID,
        p.projectOwner,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate
    FROM
		(
			SELECT
				a.ID AS projectID,
				CONCAT(b.fName," ",b.lName) AS projectOwner
			FROM
				projects a
			JOIN
				Accounts.users b
			ON
				a.projectOwnerID = b.ID
		)p
		LEFT JOIN
		(
			SELECT	
				a.ID AS indexID, 
            	a.taskID,
				a.projectID,
				CONCAT(b.fName," ",b.lName)  AS owner,
				a.sender,
				a.receiver,
				a.docType
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.projectID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.taskID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_request_history` (IN `requestID` INT, IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	r.ID AS requestID,
    	t.indexID,
    	p.projectID,
        p.projectOwner,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate
    FROM
		(
			SELECT
				a.ID AS projectID,
				CONCAT(b.fName," ",b.lName) AS projectOwner
			FROM
				projects a
			JOIN
				Accounts.users b
			ON
				a.projectOwnerID = b.ID
		)p
		LEFT JOIN
		(
			SELECT	
				a.ID AS indexID, 
            	a.taskID,
				a.projectID,
				CONCAT(b.fName," ",b.lName)  AS owner,
				a.sender,
				a.receiver,
				a.docType
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.projectID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.taskID
        WHERE	
        	t.taskID = taskID
       	AND
        	p.projectID = projectID
        AND 
        	r.ID != requestID
        ORDER BY 
        	r.ID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_task` (IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	t.ID AS indexID,
    	t.taskID,
        t.ownerID,
        CONCAT(u.fName," ",lName) AS owner,
        t.sender,
        t.receiver,
        t.docType
    FROM
    	tasks t
    LEFT JOIN
    	accounts.users u 
    ON
    	t.ownerID = u.ID
    WHERE
		t.taskID = taskID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translation` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
		r.ID AS requestID,
        ct.ID AS changeTypeID,
        ct.type,
        trans.ID as translationID,
        trans.name,
        trans.internalID,
        trans.isImpacted
    FROM
		(
			SELECT
				a.ID AS projectID,
				CONCAT(b.fName," ",b.lName) AS projectOwner
			FROM
				projects a
			JOIN
				Accounts.users b
			ON
				a.projectOwnerID = b.ID
		)p
		LEFT JOIN
		(
			SELECT	
				a.ID AS indexID, 
            	a.taskID,
				a.projectID,
				CONCAT(b.fName," ",b.lName)  AS owner,
				a.sender,
				a.receiver,
				a.docType
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.projectID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.taskID
        LEFT JOIN
        	change_type ct
        ON
        	r.ID = ct.requestID
        LEFT JOIN
        	translation trans
        ON
        	trans.changeTypeID = ct.ID
        WHERE
        	p.projectID = projectID
        AND
			t.taskID = taskID            
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translation_change` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
		tc.translationID,
        tc.changes
    FROM
		(
			SELECT
				a.ID AS projectID,
				CONCAT(b.fName," ",b.lName) AS projectOwner
			FROM
				projects a
			JOIN
				Accounts.users b
			ON
				a.projectOwnerID = b.ID
		)p
		LEFT JOIN
		(
			SELECT	
				a.ID AS indexID, 
            	a.taskID,
				a.projectID,
				CONCAT(b.fName," ",b.lName)  AS owner,
				a.sender,
				a.receiver,
				a.docType
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.projectID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.taskID
        LEFT JOIN
        	change_type ct
        ON
        	r.ID = ct.requestID
        LEFT JOIN
        	translation trans
        ON
        	trans.changeTypeID = ct.ID
        LEFT JOIN
        	translation_changes tc
        ON
        	tc.translationID = trans.ID
        WHERE
        	p.projectID = projectID
        AND
			t.taskID = taskID            
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translation_id` (IN `changeTypeID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	ID
    FROM
    	translation t 
    WHERE
		t.changeTypeID = changeTypeID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translation_list` (IN `changeTypeID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	*
    FROM
    	translation t
    WHERE
    	t.changeTypeID = changeTypeID;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_UAT_latest_translation` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT	
    	translationID,
    	projectID,
        taskID,
        environment,
        revisionNumber,
        status,
        name
    FROM
    (
    SELECT
    	DENSE_RANK() OVER(PARTITION BY trans.name ORDER BY r.revisionNumber DESC) AS Latest,
    	trans.ID AS translationID,
    	p.ID AS projectID,
        t.taskID,
        r.environment,
        r.revisionNumber,
        r.status,
        trans.name
    FROM
    	projects p 
   	LEFT JOIN
    	tasks t
    ON
    	t.projectID = p.ID
    LEFT JOIN
    	requests r
    ON
    	t.taskID = r.taskID
    LEFT JOIN
    	change_type ct
    ON
    	r.ID = ct.requestID
    LEFT JOIN
    	translation trans
    ON
    	trans.changeTypeID = ct.ID
    WHERE
		p.ID = projectID
    AND
    	t.taskID = taskID
    AND 
    	r.environment = "UAT"
    AND
        r.status = "Exported"
    )exported
    WHERE
		exported.Latest = 1
    ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_UAT_translation_list` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
    SELECT
    	trans.ID AS translationID,
    	p.ID AS projectID,
        t.taskID,
        r.environment,
        r.revisionNumber,
        r.status,
        trans.name
    FROM
    	projects p 
   	LEFT JOIN
    	tasks t
    ON
    	t.projectID = p.ID
    LEFT JOIN
    	requests r
    ON
    	t.taskID = r.taskID
    LEFT JOIN
    	change_type ct
    ON
    	r.ID = ct.requestID
    LEFT JOIN
    	translation trans
    ON
    	trans.changeTypeID = ct.ID
    WHERE
		p.ID = projectID
    AND
    	t.taskID = taskID
    AND 
    	r.environment = "UAT"
    AND
        r.status = "Exported"
    ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_change_type` (IN `requestID` INT, IN `type` VARCHAR(20))  NO SQL
BEGIN
	DECLARE changeTypeID INT;
    
	INSERT INTO change_type
    (requestID, type)
    VALUES
    (requestID, type);
    
    SET changeTypeID = LAST_INSERT_ID();
    SELECT changeTypeID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_impacted` (IN `translationID` INT, IN `sender` VARCHAR(50), IN `receiver` VARCHAR(50), IN `docType` VARCHAR(50), IN `internalIDs` VARCHAR(200))  NO SQL
BEGIN
	INSERT INTO impacted
    (translationID, sender, receiver, docType, internalIDs)
    VALUES
    (translationID, sender, receiver, docType, internalIDs);	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_project` (IN `projectID` INT, IN `projectOwnerID` INT)  NO SQL
BEGIN
	DECLARE projectID INT;
    
	INSERT INTO projects
    VALUES
    (projectID, projectOwnerID);
    
    SET projectID = LAST_INSERT_ID();
    SELECT projectID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_request` (IN `taskID` INT, IN `environment` VARCHAR(10), IN `status` VARCHAR(20), IN `revNum` INT, IN `reqDate` DATE)  NO SQL
BEGIN
	DECLARE requestID INT;
    
	INSERT INTO requests
    (taskID, environment, status, revisionNumber, requestDate)
    VALUES
    (taskID, environment, status, revNum, reqDate);
    
    SET requestID = LAST_INSERT_ID();
    SELECT requestID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_task` (IN `taskID` INT, IN `projectID` INT, IN `ownerID` INT, IN `sender` VARCHAR(50), IN `receiver` VARCHAR(50), IN `docType` VARCHAR(50))  NO SQL
BEGIN
	DECLARE indexID INT;
    
	INSERT INTO tasks 
    (taskID, projectID, ownerID, sender, receiver, docType)
    VALUES
    (taskID, projectID, ownerID, sender, receiver, docType);
    
    SET indexID = LAST_INSERT_ID();
    SELECT indexID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_translation` (IN `changeTypeID` INT, IN `name` VARCHAR(150), IN `internalID` VARCHAR(200), IN `isImpacted` BOOLEAN)  NO SQL
BEGIN
	DECLARE translationID INT;
    
	INSERT INTO translation
    (changeTypeID, name, internalID, isImpacted)
    VALUES
    (changeTypeID, name, internalID, isImpacted);
    
    SET translationID = LAST_INSERT_ID();
    SELECT translationID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_translation_change` (IN `translationID` INT, IN `changes` TEXT)  NO SQL
BEGIN
	INSERT INTO translation_changes
    (translationID, changes)
    VALUES
    (translationID, changes);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `change_type`
--

CREATE TABLE `change_type` (
  `ID` int(11) NOT NULL,
  `requestID` int(11) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `change_type`
--

INSERT INTO `change_type` (`ID`, `requestID`, `type`) VALUES
(1, 1, 'Translation'),
(2, 2, 'Translation'),
(3, 3, 'Translation'),
(4, 4, 'Translation'),
(5, 5, 'Translation');

-- --------------------------------------------------------

--
-- Table structure for table `impacted`
--

CREATE TABLE `impacted` (
  `ID` int(11) NOT NULL,
  `translationID` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `docType` enum('PurchaseOrder','PurchaseOrderChange','PurchaseOrderAcknowledge','Invoice','Report') NOT NULL,
  `internalIDs` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `impacted`
--

INSERT INTO `impacted` (`ID`, `translationID`, `sender`, `receiver`, `docType`, `internalIDs`) VALUES
(1, 7, 'rha-au ', 'philipsli ', 'PurchaseOrder', '4820356475, 4819964924, 4819392100; 457218688053562, 457218688053563, 457218688053564\r\n'),
(2, 7, 'rhaies-au ', 'philipsli ', 'PurchaseOrder', '4819797670, 4819359488, 4819162062; 457218688053651, 457218688053652, 457218688053653'),
(3, 7, 'rhajrt-au ', 'philipsli ', 'PurchaseOrder', '4819960962, 4819941468, 4819072614; 457218688053674, 457218688053675, 457218688053678');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL,
  `projectOwnerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `projectOwnerID`) VALUES
(12437, 1),
(12441, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `environment` enum('UAT','PROD') NOT NULL,
  `status` varchar(10) NOT NULL,
  `revisionNumber` int(11) NOT NULL,
  `requestDate` date NOT NULL DEFAULT current_timestamp(),
  `deployDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`ID`, `taskID`, `environment`, `status`, `revisionNumber`, `requestDate`, `deployDate`) VALUES
(1, 23661, 'UAT', 'Exported', 1, '2020-01-15', '2020-02-15'),
(2, 23661, 'PROD', 'Exported', 1, '2020-01-20', '2020-02-21'),
(3, 23665, 'UAT', 'Exported', 1, '2020-01-20', '2020-01-21'),
(4, 23665, 'PROD', 'Exported', 1, '2020-01-26', '2020-01-27'),
(5, 23665, 'UAT', 'Exported', 2, '2020-02-12', '2020-02-12');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `docType` enum('PurchaseOrder','PurchaseOrderChange','PurchaseOrderAcknowledge','Invoice','Report') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`ID`, `taskID`, `projectID`, `ownerID`, `sender`, `receiver`, `docType`) VALUES
(1, 23661, 12437, 3, 'csremail', 'wiscustomer-au', 'PurchaseOrder'),
(2, 23665, 12441, 3, 'Multiple', 'Multiple', 'PurchaseOrder');

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE `translation` (
  `ID` int(11) NOT NULL,
  `changeTypeID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `internalID` varchar(150) NOT NULL,
  `isImpacted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translation`
--

INSERT INTO `translation` (`ID`, `changeTypeID`, `name`, `internalID`, `isImpacted`) VALUES
(1, 1, 'csremailtowiscustomer-aupurchaseordercustom', '457218688036601,457218688036602', 0),
(2, 2, 'csremailtowiscustomer-aupurchaseordercustom', '457218688036601,457218688036602', 0),
(3, 3, 'middys-autophilipslipurchaseordercustom', '457218688038745', 0),
(4, 3, 'cnw-autophilipslipurchaseordercustom', '457218688038805', 0),
(5, 3, 'hegtophilipsli-aupurchaseordercustom', '457218688038804', 0),
(6, 3, 'mmemtophilipslipurchaseordercustom', '457218688038808', 0),
(7, 3, 'rhatophilipsli-aupurchaseordercustom', '457218688038806, 457218688038809, 457218688038815', 1),
(12, 5, 'middys-autophilipslipurchaseordercustom', '', 0),
(13, 5, 'mmemtophilipslipurchaseordercustom', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `translation_changes`
--

CREATE TABLE `translation_changes` (
  `ID` int(11) NOT NULL,
  `translationID` int(11) NOT NULL,
  `changes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translation_changes`
--

INSERT INTO `translation_changes` (`ID`, `translationID`, `changes`) VALUES
(1, 1, 'Add logic that replace the character comma, hyphen and hash or Number sign with space in the function findPartNumber before the countField variable.'),
(2, 2, 'Add logic that replace the character comma, hyphen and hash or Number sign with space in the function findPartNumber before the countField variable.'),
(3, 3, 'Update lightingsalesdesk philips.com to orders.au signify.com'),
(4, 3, 'Update sequence of internalErrors'),
(5, 3, 'Update YBV2UtilbgetHostname to YBV2UtilgetEnvironmentName'),
(6, 3, 'Update raiseIgnoreDocument code to IG sequenceNumber'),
(7, 3, 'Update the SQL to new standard format'),
(8, 3, 'Update email address to noreply in TEST '),
(9, 3, 'Use .append in string concatenation'),
(10, 3, 'Updated sqlquery variable name to sqlResult'),
(11, 3, 'Updated no.reply b2be.com to noreply b2be.com'),
(12, 3, 'Updated the error message to show the actual email address per environment'),
(13, 3, 'Updated the actual email recipients per environment'),
(14, 3, 'Updated test email recipients'),
(15, 4, 'Update lightingsalesdesk signify.com to orders.au signify.com'),
(16, 4, 'Use .append in string concatenation'),
(17, 4, 'Updated email address from no.reply b2be.com to noreply b2be.com'),
(18, 4, 'Updated error message to show the actual email address per environment'),
(19, 5, 'Update lightingsalesdesk signify.com to orders.au signify.com'),
(20, 5, 'Changed File Delete to YB V2Util deleteFile'),
(21, 6, 'updated lightingsalesdesk signify.com to orders.au signify.com'),
(22, 6, 'updated YB V2Util getHostname to YB V2Util getEnvironmentName'),
(23, 6, 'Updated SQL to new standard format'),
(24, 6, 'Updated the error message to show the actual email address per environment'),
(25, 7, 'updated lightingsalesdesk signify.com to orders.au signify.com'),
(26, 7, 'Added checking in item package to avoid out of bound error'),
(27, 7, 'Updated no.reply b2be.com to noreply b2be.com'),
(28, 12, 'Reverted to old version'),
(29, 13, 'Reverted to old version');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `change_type`
--
ALTER TABLE `change_type`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `requestID` (`requestID`);

--
-- Indexes for table `impacted`
--
ALTER TABLE `impacted`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `translationID` (`translationID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `projectOwnerID` (`projectOwnerID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `taskID` (`taskID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `taskID` (`taskID`) USING BTREE,
  ADD KEY `projectID` (`projectID`),
  ADD KEY `ownerID` (`ownerID`);

--
-- Indexes for table `translation`
--
ALTER TABLE `translation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `changeTypeID` (`changeTypeID`);

--
-- Indexes for table `translation_changes`
--
ALTER TABLE `translation_changes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `translationID` (`translationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `change_type`
--
ALTER TABLE `change_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `impacted`
--
ALTER TABLE `impacted`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `translation`
--
ALTER TABLE `translation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `translation_changes`
--
ALTER TABLE `translation_changes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `change_type`
--
ALTER TABLE `change_type`
  ADD CONSTRAINT `change_type_ibfk_1` FOREIGN KEY (`requestID`) REFERENCES `requests` (`ID`);

--
-- Constraints for table `impacted`
--
ALTER TABLE `impacted`
  ADD CONSTRAINT `impacted_ibfk_1` FOREIGN KEY (`translationID`) REFERENCES `translation` (`ID`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`projectOwnerID`) REFERENCES `accounts`.`users` (`ID`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`taskID`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `projects` (`ID`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`ownerID`) REFERENCES `accounts`.`users` (`ID`);

--
-- Constraints for table `translation`
--
ALTER TABLE `translation`
  ADD CONSTRAINT `translation_ibfk_1` FOREIGN KEY (`changeTypeID`) REFERENCES `change_type` (`ID`);

--
-- Constraints for table `translation_changes`
--
ALTER TABLE `translation_changes`
  ADD CONSTRAINT `translation_changes_ibfk_1` FOREIGN KEY (`translationID`) REFERENCES `translation` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
