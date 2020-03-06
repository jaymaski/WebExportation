-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 07:06 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `assign_request_to_me` (IN `inputID` INT, IN `assigneeID` INT)  NO SQL
BEGIN
	UPDATE 
		requests
    SET
        status = "Assigned",
        assigneeID = assigneeID,
        assignedAt = NOW()
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_request` ()  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	r.requestID,
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
        r.deployDate,
       	r.assignee,
        r.assignedAt
    FROM
		(
			SELECT
				a.projectID,
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
		(
        	SELECT 
            	a.ID as requestID,
            	a.taskID,
            	a.environment,
                a.revisionNumber,
                a.status,
                a.requestDate,
                a.deployDate,
            	CONCAT(b.fName," ",b.lName)  AS assignee,
            	a.assignedAt
            FROM
            	requests a
            LEFT JOIN
            	Accounts.users b
			ON
				a.assigneeID = b.ID
        )r
		ON
			r.taskID = t.taskID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_current_request` (IN `requestID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	p.ID,
        p.projectID,
        p.projectOwner,
        t.indexID,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
    	r.requestID,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate,
       	r.assignee,
        r.assignedAt
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
			t.projectID = p.ID
		LEFT JOIN
		(
        	SELECT 
            	a.ID as requestID,
            	a.taskID,
            	a.environment,
                a.revisionNumber,
                a.status,
                a.requestDate,
                a.deployDate,
            	CONCAT(b.fName," ",b.lName)  AS assignee,
            	a.assignedAt
            FROM
            	requests a
            LEFT JOIN
            	Accounts.users b
			ON
				a.assigneeID = b.ID
        )r
		ON
			r.taskID = t.indexID
        WHERE	
        	r.requestID = requestID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_impacted` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	i.ID AS impactedID,
        i.translationID,
		i.sender,
        i.receiver,
        i.docType,
        i.internalIDs
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
			t.projectID = p.ID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.indexID
        LEFT JOIN
        	change_type ct
        ON
        	r.ID = ct.requestID
        LEFT JOIN
        	translation trans
        ON
        	trans.changeTypeID = ct.ID
        JOIN
        	impacted i 
        ON
        	i.translationID = trans.ID
        WHERE
        	p.projectID = projectID
        AND
			t.taskID = taskID            
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recommendations` (IN `requestID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
		r.ID as recommendationID,
        r.requestID,
        r.recommendation
    FROM
    	recommendations r 
    WHERE
    	r.requestID = requestID
    ORDER BY	
    	r.ID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_request` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	p.ID,
        p.projectID,
        p.projectOwner,
        t.indexID,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
    	r.requestID,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate,
       	r.assignee,
        r.assignedAt
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
			t.projectID = p.ID
		LEFT JOIN
		(
        	SELECT 
            	a.ID as requestID,
            	a.taskID,
            	a.environment,
                a.revisionNumber,
            	a.urgency,
                a.status,
                a.requestDate,
                a.deployDate,
            	CONCAT(b.fName," ",b.lName)  AS assignee,
            	a.assignedAt
            FROM
            	requests a
            LEFT JOIN
            	Accounts.users b
			ON
				a.assigneeID = b.ID
        )r
		ON
			r.taskID = t.indexID
        WHERE	
        	t.taskID = taskID
       	AND
        	p.projectID = projectID
        ORDER BY 
        	r.requestID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_shared_requests` (IN `userID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	p.ID,
        p.projectID,
        p.projectOwner,
        t.indexID,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
    	r.requestID,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate,
       	r.assignee,
        r.assignedAt
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
				a.docType,
            	a.ownerID
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.ID
		LEFT JOIN
        (
        	SELECT 
            	a.ID as requestID,
            	a.taskID,
            	a.environment,
                a.revisionNumber,
                a.status,
                a.requestDate,
                a.deployDate,
            	CONCAT(b.fName," ",b.lName)  AS assignee,
            	a.assignedAt
            FROM
            	requests a
            LEFT JOIN
            	Accounts.users b
			ON
				a.assigneeID = b.ID
        )r
		ON
			r.taskID = t.indexID
        LEFT JOIN
        	shared_requests sr
        ON
        	sr.projectID = p.projectID
        AND
        	sr.taskID = t.taskID
        WHERE
        	sr.userID = userID
       ;
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
        trans.internalID
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
			t.projectID = p.ID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.indexID
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
    	tc.ID,
		tc.translationID,
        tc.changes
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
			t.projectID = p.ID
		LEFT JOIN
			requests r
		ON
			r.taskID = t.indexID
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
    	p.projectID,
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
    	t.projectID = p.projectID
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
		p.projectID = projectID
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
    	p.projectID,
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
    	t.projectID = p.projectID
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
		p.projectID = projectID
    AND
    	t.taskID = taskID
    AND 
    	r.environment = "UAT"
    AND
        r.status = "Exported"
    ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_requests` (IN `userID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	p.ID,
        p.projectID,
        p.projectOwner,
        t.indexID,
        t.taskID,
        t.owner,
        t.sender,
        t.receiver,
        t.docType,
    	r.requestID,
        r.environment,
		r.revisionNumber,
        r.status,
        r.requestDate,
        r.deployDate,
       	r.assignee,
        r.assignedAt
    FROM
		(
			SELECT
            	a.ID,
				a.projectID,
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
				a.docType,
            	a.ownerID
			FROM
				tasks a
			JOIN
				Accounts.users b
			ON
				a.ownerID = b.ID
		)t
		ON
			t.projectID = p.ID
		LEFT JOIN
		(
        	SELECT 
            	a.ID as requestID,
            	a.taskID,
            	a.environment,
                a.revisionNumber,
                a.status,
                a.requestDate,
                a.deployDate,
            	CONCAT(b.fName," ",b.lName)  AS assignee,
            	a.assignedAt
            FROM
            	requests a
            LEFT JOIN
            	Accounts.users b
			ON
				a.assigneeID = b.ID
        )r
		ON
			r.taskID = t.indexID
        WHERE
        	t.ownerID = userID
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
	DECLARE insertedProjectID INT;
    
    INSERT INTO projects 
    	(projectID, projectOwnerID)
    SELECT	
    	projectID,
        ProjectOwnerID
	WHERE	
    	NOT EXISTS 
    (
    	SELECT
        	*
        FROM 
        	projects p
        WHERE
        	p.projectID = projectID
    );
    
    SET insertedProjectID = LAST_INSERT_ID();
    SELECT insertedProjectID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_recommendation` (IN `requestID` INT, IN `recommendation` LONGTEXT, IN `userID` INT)  NO SQL
BEGIN
	DECLARE recommendationID int;
    
	INSERT INTO recommendations
    (requestID, recommendation, recommendedBy)
    VALUES
    (requestID, recommendation, userID);
    
    SET recommendationID = LAST_INSERT_ID();
    SELECT recommendationID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_request` (IN `taskID` INT, IN `environment` VARCHAR(10), IN `urgency` VARCHAR(50), IN `status` VARCHAR(20), IN `revNum` INT)  NO SQL
BEGIN
	DECLARE insertedRequest INT;
    
    INSERT INTO requests
    	(
        	taskID,
            environment,
            urgency,
            status,
            revisionNumber
        )
    SELECT	
    	taskID,
        environment,
        urgency,
        status,
        revNum
	WHERE	
    	NOT EXISTS 
    (
    	SELECT
        	*
        FROM 
        	requests r
        WHERE
        	r.taskID = taskID
        AND 
        	r.environment = environment
       	AND	
        	r.revisionNumber = revNum
    );
    
    SET insertedRequest = LAST_INSERT_ID();
    SELECT insertedRequest;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_task` (IN `taskID` INT, IN `projectID` INT, IN `ownerID` INT, IN `sender` VARCHAR(50), IN `receiver` VARCHAR(50), IN `docType` VARCHAR(50))  NO SQL
BEGIN
	DECLARE insertedIndexID INT;
    
    INSERT INTO tasks
    	(
        	taskID,
            projectID,
            ownerID,
            sender,
            receiver,
            docType
        )
    SELECT	
    	taskID,
        projectID,
        ownerID,
        sender,
        receiver,
        docType
	WHERE	
    	NOT EXISTS 
    (
    	SELECT
        	*
        FROM 
        	tasks t
        WHERE
        	t.taskID = taskID
    );
    
    SET insertedIndexID = LAST_INSERT_ID();
    SELECT insertedIndexID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_translation` (IN `changeTypeID` INT, IN `name` VARCHAR(150), IN `internalID` VARCHAR(200))  NO SQL
BEGIN
	DECLARE translationID INT;
    
	INSERT INTO translation
    (changeTypeID, name, internalID)
    VALUES
    (changeTypeID, name, internalID);
    
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_project_id` (IN `projectID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	ID
    FROM
    	projects p
    WHERE
    	p.projectID = projectID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_request` (IN `taskID` INT, IN `environment` VARCHAR(50), IN `revisionNumber` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	r.ID
    FROM
    	tasks t 
    LEFT JOIN
    	requests r 
    ON 
    	t.ID = r.taskID
    WHERE
    	t.taskID = taskID
    AND
    	r.environment = environment
    AND
    	r.revisionNumber = revisionNumber
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_task_id` (IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
    	ID
    FROM
    	tasks t 
    WHERE
    	t.taskID = taskID
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_impacted` (IN `inputID` INT, IN `newSender` VARCHAR(50), IN `newReceiver` VARCHAR(50), IN `newDocType` VARCHAR(50), IN `newInternalIDs` VARCHAR(300))  NO SQL
BEGIN
    UPDATE
        impacted
    SET
        sender = newSender,
        receiver = newReceiver,
        docType = newDocType,
        internalIDs = newInternalIDs
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_project` (IN `inputID` INT, IN `newProjectID` INT, IN `newProjectOwnerID` INT)  NO SQL
BEGIN
  UPDATE 
	projects
  SET
     projectID 	= newProjectID,
     projectOwnerID = newProjectOwnerID
  WHERE
     ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_recommendation` (IN `inputID` INT, IN `newRecommendation` LONGTEXT)  NO SQL
BEGIN
	UPDATE
        recommendations
    SET
        recommendation = newRecommendation
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_request` (IN `inputID` INT, IN `newEnvironment` VARCHAR(10), IN `newRevisionNumber` INT, IN `newUrgency` VARCHAR(10), IN `newDeployDate` DATETIME)  NO SQL
BEGIN
    UPDATE 
        requests
    SET
        environment 	= newEnvironment,
        revisionNumber 	= newRevisionNumber,
        urgency 		= newUrgency,
        deployDate 		= newDeployDate
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_status` (IN `inputID` INT, IN `newStatus` VARCHAR(20))  NO SQL
BEGIN
	UPDATE 
		requests
    SET
        status = newStatus
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_task` (IN `inputID` INT, IN `newTaskID` INT, IN `newOwnerID` INT, IN `newSender` VARCHAR(50), IN `newReceiver` VARCHAR(50), IN `newDocType` VARCHAR(50))  NO SQL
BEGIN
    UPDATE 
        tasks
    SET
        taskID 	= newTaskID,
        ownerID = newOwnerID,
        sender 	= newSender,
        receiver = newReceiver,
        docType = newDocType
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_translation` (IN `inputID` INT, IN `newName` VARCHAR(50), IN `newInternalID` VARCHAR(300))  NO SQL
BEGIN
	UPDATE
        translation
    SET
        name = newName,
        internalID = newInternalID
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_translation_changes` (IN `inputID` INT, IN `newChanges` LONGTEXT)  NO SQL
BEGIN
	UPDATE
        translation_changes
    SET
        changes = newChanges
    WHERE
        ID = inputID;
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
(1, 3, 'Translation'),
(2, 4, 'Translation'),
(3, 5, 'Translation'),
(4, 6, 'Translation'),
(5, 7, 'Translation'),
(6, 8, 'Translation'),
(7, 9, 'Translation'),
(8, 10, 'Translation');

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

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `projectOwnerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `projectID`, `projectOwnerID`) VALUES
(1, 10620, 14),
(2, 12424, 3),
(5, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `ID` int(11) NOT NULL,
  `requestID` int(11) NOT NULL,
  `recommendation` longtext NOT NULL,
  `recommendedBy` int(11) NOT NULL,
  `recommendedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`ID`, `requestID`, `recommendation`, `recommendedBy`, `recommendedAt`) VALUES
(2, 7, '\r\nsisweb-uk	sisemail-uk	CreditNote\r\n\r\nsisweb-ukcreditnotetob2bexml\r\nRemove flatFile \r\n\r\nbool Translation::mapFile(Invoice *docs, YB_FlatFile * flatFile, string &deliveryMethod, string &documentID, string &internalID)\r\n\r\nsisweb-uktosisemail-ukcreditnotecustom\r\ninitialize idx as -1 \r\n\r\nsisweb-ukcreditnotefromb2bexml\r\nWrong translation name for current relationship\r\n\r\n\r\n-------\r\nsis-uk	sisweb-uk	CreditNote\r\n\r\nsis-ukcreditnotetob2bexml\r\nRemove flatFile \r\n\r\nbool Translation::mapFile(Invoice *docs, YB_FlatFile * flatFile)\r\n\r\nRemove raiseInternalError \r\n\r\n    if(!mapFile(docs, flatFile))\r\n    {\r\n        raiseInternalError(\"02\", \"Error in mapping, ERROR MESSAGE: \" + errorMessage);\r\n        delete docs;\r\n        return EXIT_FAILURE;\r\n    }\r\n\r\n\r\nsis-uktosisweb-ukcreditnotecustom\r\nExported\r\nsisweb-ukdocumentroutingcreditnotefromb2bexml\r\nWrong translation name for current relationship\r\n\r\n\r\n\r\nN \r\n06/02/20\r\nsisweb-ukdocumentroutingcreditnotefromb2bexml\r\nThe translation name is kept as it is used for Document Routing to WebPortal\r\n(This was done similar to Norbain projects translations)\r\n\r\n\r\n\r\nsisweb-ukcreditnotefromb2bexml\r\nWe have kept this translation name as it is used for 2 different receiver accounts\r\nFrom sisweb-uk to sisemail-uk\r\nFrom sisweb-uk to sisdisplay-uk\r\n\r\n\r\n\r\n================================\r\nKindly Note:\r\n\r\nAs this is a new translations, we need to follow our standard in naming translation. \r\n\r\nWrong: sisweb-ukdocumentroutingcreditnotefromb2bexml\r\nCorrect: sisweb-ukcreditnotefromb2bexml (exist in your other relationship which should be use in here)\r\n\r\nWrong: sisweb-ukcreditnotefromb2bexml\r\nCorrect: sisemail-ukcreditnotefromb2bexml (not exisiting yet)\r\n\r\nAlso we are only implementing One XR per Receiver or One Receiver per XR, for all new translations\r\n\r\n\r\n\r\n\r\n', 3, '2020-02-19 05:58:46'),
(4, 9, 'sis-uktosisweb-ukcreditnotecustom Add a isFileExist before using deleteFile  Remove the raiseError in the deleteFile. if the  lookupBankDetails and lookupLogoPath fails as this will cause PQ error   Code: if(!lookupLogoPaths(branchCode, vnEmail, headerLogoPath, footerLogoPath, headerCompanyURLByBranch, trailerCompanyURLByBranch, headerLogoWidth, trailerNotes)) {     if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"08\", \"Failed to delete temp html translation file : \" + error);         delete lookupDB;         delete docs;         return EXIT_FAILURE;     }          delete docs;     delete lookupDB;     return EXIT_FAILURE; }  if(headerLogoWidth.length() == 0)     headerLogoWidth = \"250\";  // Lookup Company Bank Details if(!lookupBankDetails(vnEmail,sortCode,accNumber)) {     if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"09\", \"Failed to delete temp html translation file : \" + error);         delete lookupDB;         delete docs;         return EXIT_FAILURE;     }          delete docs;     delete lookupDB;     return EXIT_FAILURE; }  Sample: if(!lookupLogoPaths(branchCode, vnEmail, headerLogoPath, footerLogoPath, headerCompanyURLByBranch, trailerCompanyURLByBranch, headerLogoWidth, trailerNotes)) {     if(YB_V2Util::isFileExist(getOutputFileName() + \".htm\"))         YB_V2Util::deleteFile(getOutputFileName() + \".htm\")          delete docs;     delete lookupDB;     return EXIT_FAILURE; }  if(headerLogoWidth.length() == 0)     headerLogoWidth = \"250\";  // Lookup Company Bank Details if(!lookupBankDetails(vnEmail,sortCode,accNumber)) {     if(YB_V2Util::isFileExist(getOutputFileName() + \".htm\"))         YB_V2Util::deleteFile(getOutputFileName() + \".htm\")          delete docs;     delete lookupDB;     return EXIT_FAILURE; }  Fix the arrangement of the raiseError to avoid overlapping   Code: string *tempDBSettings = YB_V2Util::getDBLookupSettings(); if(tempDBSettings[0].length() <= 0 || tempDBSettings[1].length() <= 0 || tempDBSettings[2].length() <= 0) {     raiseInternalError(\"03\", \"Lookup Error - DBLookupSettings, acquired from YB_V2Util::getDBLookupSettings(), incomplete\");     if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"04\", \"Failed to delete temp html translation file : \" + error);         delete docs;         return EXIT_FAILURE;     }      delete docs;     return EXIT_FAILURE;  }  lookupDB = new YB_MySQL(tempDBSettings[0], tempDBSettings[1], tempDBSettings[2], tempDBSettings[3]); if(lookupDB->isError()) {     raiseInternalError(\"05\", \"Lookup Error For Database B2BE_CUSTOM_LOOKUP - \" + lookupDB->getErrorMessage());     if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"06\", \"Failed to delete temp html translation file : \" + error);         delete docs;         return EXIT_FAILURE;     }      delete docs;     return EXIT_FAILURE; }  Sample: string *tempDBSettings = YB_V2Util::getDBLookupSettings(); if(tempDBSettings[0].length() <= 0 || tempDBSettings[1].length() <= 0 || tempDBSettings[2].length() <= 0) {          if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"04\", \"Failed to delete temp html translation file : \" + error);         delete docs;         return EXIT_FAILURE;     }       raiseInternalError(\"03\", \"Lookup Error - DBLookupSettings, acquired from YB_V2Util::getDBLookupSettings(), incomplete\");     delete docs;     return EXIT_FAILURE;  }  lookupDB = new YB_MySQL(tempDBSettings[0], tempDBSettings[1], tempDBSettings[2], tempDBSettings[3]); if(lookupDB->isError()) {          if(!YB_V2Util::deleteFile(getOutputFileName() + \".htm\"))     {         raiseInternalError(\"06\", \"Failed to delete temp html translation file : \" + error);         delete docs;         return EXIT_FAILURE;     }       raiseInternalError(\"05\", \"Lookup Error For Database B2BE_CUSTOM_LOOKUP - \" + lookupDB->getErrorMessage());     delete docs;     return EXIT_FAILURE; }  As this is still new translation, move the following declared string/int/bool values from h file to cpp file     string font_arial;     string font_times;     string font_courier;     string btCode;     string faxNumber;     string emailAddress;     bool isOriginal;', 3, '2020-02-19 05:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `environment` enum('UAT','PROD') NOT NULL,
  `revisionNumber` int(11) NOT NULL,
  `urgency` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `requestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `deployDate` datetime NOT NULL,
  `assigneeID` int(11) DEFAULT NULL,
  `assignedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`ID`, `taskID`, `environment`, `revisionNumber`, `urgency`, `status`, `requestDate`, `deployDate`, `assigneeID`, `assignedAt`) VALUES
(3, 1, 'UAT', 1, 'Low', 'Exported', '2020-02-19 03:33:39', '2020-02-17 11:32:43', 11, '2020-02-17 03:32:43'),
(4, 1, 'UAT', 2, 'Low', 'Exported', '2020-02-19 03:33:39', '2020-02-19 11:32:43', 11, '2020-02-19 03:32:43'),
(5, 1, 'PROD', 1, 'High', 'Exported', '2020-02-19 03:44:10', '2020-02-19 11:39:45', 11, '2020-02-19 03:39:45'),
(6, 1, 'PROD', 2, 'High', 'Exported', '2020-02-19 03:44:10', '2020-02-19 11:39:45', 11, '2020-02-19 03:39:45'),
(7, 2, 'UAT', 1, 'Medium', 'Exported', '2020-02-19 03:52:38', '2020-02-19 11:50:46', 3, '2020-02-19 03:50:46'),
(8, 2, 'UAT', 2, 'Medium', 'Exported', '2020-02-19 03:52:38', '2020-02-19 11:50:46', 6, '2020-02-19 03:50:46'),
(9, 2, 'UAT', 3, 'Medium', 'Exported', '2020-02-19 04:04:49', '2020-02-19 12:04:21', 12, '2020-02-19 04:04:21'),
(10, 2, 'UAT', 5, 'Low', 'Assigned', '2020-02-19 04:08:25', '2020-02-26 14:14:29', 3, '2020-02-26 07:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `shared_requests`
--

CREATE TABLE `shared_requests` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shared_requests`
--

INSERT INTO `shared_requests` (`ID`, `projectID`, `taskID`, `userID`) VALUES
(2, 10620, 23858, 3);

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
(1, 23858, 1, 11, 'telstradealers-au', 'vita-au', 'Invoice'),
(2, 23733, 2, 3, 'Multiple', 'Multiple', 'PurchaseOrder'),
(4, 1234, 5, 2, 'qwe', 'qwert', 'Invoice');

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE `translation` (
  `ID` int(11) NOT NULL,
  `changeTypeID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `internalID` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translation`
--

INSERT INTO `translation` (`ID`, `changeTypeID`, `name`, `internalID`) VALUES
(1, 1, 'telstradealers-autovita-auinvoicecustom', '457218688131796'),
(2, 2, 'telstradealers-autovita-auinvoicecustom', '457218688131796'),
(3, 3, 'telstradealers-autovita-auinvoicecustom', '1114790108746'),
(4, 4, 'telstradealers-autovita-auinvoicecustom', '1114790108746'),
(5, 5, 'sis-ukcreditnotetob2bexml', '457218688067966,457218688068029,457218688066707\r\n'),
(6, 5, 'sisweb-ukdocumentroutingcreditnotefromb2bexml', ''),
(7, 5, 'sisweb-ukdocumentroutingcreditnotefromb2bexml', ''),
(8, 5, 'sisweb-ukcreditnotetob2bexml ', ''),
(9, 5, 'sisweb-uktosisemail-ukcreditnotecustom', ''),
(10, 5, 'sisweb-ukcreditnotefromb2bexml', ''),
(11, 6, 'sis-uktosisweb-ukcreditnotecustom', '457218688067966'),
(13, 7, 'sisweb-ukcreditnotefromb2bexml ', '457218688068029'),
(14, 8, 'sisweb-ukcreditnotefromb2bexml\r\n', '457218688068029');

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
(1, 1, 'updated the mapping from quantity hardcoded 1 to getting the quantity value of the input'),
(2, 2, 'Serialized items should have an individual line displayed with Qty. as 1\r\n'),
(3, 3, 'updated the mapping from quantity hardcoded 1 to getting the quantity value of the input'),
(4, 4, 'noChanges'),
(5, 5, '1.	- Initial version\r\n- Cloned from niuks-ukcreditnotetob2bexml\r\n2.	- Removed flatfile as function argument'),
(6, 6, '1.	- Initial version\r\n- Cloned from norbainsd-uktonorbainsdweb-ukcreditnotecustom\r\n2.	- Initial version\r\n- Cloned from norbainsd-uktonorbainsdweb-ukcreditnotecustom\r\n'),
(7, 7, '1.	- Initial version\r\n- Cloned from norbainsdweb-ukdocumentroutinginvoicefromb2bexml\r\n'),
(8, 8, '1.	- Initial version\r\n- Cloned from norbainsdweb-ukinvoicetob2bexml\r\n2.	- Removed flatfile as function argument'),
(9, 9, '1.	- Initial version\r\n- Cloned from norbainsdweb-uktonorbainsdemail-ukcreditnotecustom\r\n2.	- Updated initializing idx variable'),
(10, 10, '1.	- Initial version\r\n- Cloned from niukspdf-ukcreditnotefromb2bexml\r\n2.	- Updated header and trailer details\r\n3.	Revert Changes\r\n- Updated header and trailer details\r\n4.	- Updated mapping notes in trailer\r\n5.	- Updated notes size\r\n6.	-Updated Credit Note String Length\r\n7.	- Removed unused code\r\n8.	- Updated logic to split notes to two lines'),
(11, 11, '- Updated inserting Account number to ActivityIdentifier table'),
(12, 13, '- Updated code for receiver email address\r\n- Updated code for delete statements of html file\r\n- Arranged raise internal Errors\r\n- Removed variables in header file\r\n'),
(13, 14, 'noChange');

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
  ADD UNIQUE KEY `projectID` (`projectID`) USING BTREE,
  ADD KEY `projectOwnerID` (`projectOwnerID`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `requestID` (`requestID`),
  ADD KEY `recommendedBy` (`recommendedBy`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `taskID` (`taskID`),
  ADD KEY `assigneeID` (`assigneeID`);

--
-- Indexes for table `shared_requests`
--
ALTER TABLE `shared_requests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `projectID` (`projectID`),
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `impacted`
--
ALTER TABLE `impacted`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shared_requests`
--
ALTER TABLE `shared_requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `translation`
--
ALTER TABLE `translation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `translation_changes`
--
ALTER TABLE `translation_changes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`requestID`) REFERENCES `requests` (`ID`),
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`recommendedBy`) REFERENCES `accounts`.`users` (`ID`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`assigneeID`) REFERENCES `accounts`.`users` (`ID`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`ID`);

--
-- Constraints for table `shared_requests`
--
ALTER TABLE `shared_requests`
  ADD CONSTRAINT `shared_requests_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `accounts`.`users` (`ID`),
  ADD CONSTRAINT `shared_requests_ibfk_5` FOREIGN KEY (`projectID`) REFERENCES `projects` (`projectID`),
  ADD CONSTRAINT `shared_requests_ibfk_6` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`taskID`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`ownerID`) REFERENCES `accounts`.`users` (`ID`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`projectID`) REFERENCES `projects` (`ID`);

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
