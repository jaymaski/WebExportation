-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2020 at 12:44 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `assign_request_to_me` (IN `requestID` INT, IN `assigneeID` INT)  NO SQL
BEGIN
	UPDATE 
		requests
    SET
        status = "Reviewing",
        assigneeID = assigneeID,
        assignedAt = NOW()
    WHERE
        ID = requestID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_id_of_project` (IN `projectID` INT)  NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_id_of_request` (IN `taskID` INT, IN `environment` VARCHAR(50), IN `revisionNumber` INT)  NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_id_of_task` (IN `taskID` INT)  NO SQL
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
        	(r.ID = ct.uatRequestID
        OR
        	r.ID = ct.prodRequestID)
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
        GROUP BY
        	i.ID,
            i.translationID,
            i.sender,
            i.receiver,
            i.docType,
            i.internalIDs
       ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_latest_user_requests` (IN `userID` INT, IN `type` VARCHAR(15))  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;

SELECT
	X.ID,
	projectID,
	projectOwner,
	indexID,
	taskID,
	owner,
	sender,
	receiver,
	docType,
	requestID,
    server,
	environment,
	revisionNumber,
	status,
	requestDate,
	deployDate,
    clientProdApproval,
    clientApprovalDate,
	assignee,
	assignedAt,
    ct.ID as changeTypeID,
    ct.uatRequestID,
    ct.prodRequestID,
    ct.type
FROM
(
	SELECT
		DENSE_RANK() OVER(PARTITION BY taskID ORDER BY requestID DESC) AS Latest,
    	p.ID,
        p.projectID,
        p.projectOwner,
        t.indexID,
        t.taskID,
        t.owner,
    	t.ownerID,
        t.sender,
        t.receiver,
        t.docType,
    	t.server,
    	t.clientProdApproval,
    	t.clientApprovalDate,
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
            	a.server,
           		a.clientProdApproval,
           		a.clientApprovalDate,
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
)X
LEFT JOIN
	change_type ct
ON
	ct.uatRequestID = X.requestID
OR
	ct.prodRequestID = X.requestID
WHERE
	X.ownerID = userID
AND
	X.Latest = 1
AND
	ct.type = type
ORDER BY 
	ct.ID DESC
LIMIT 1;


SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_prod_request_details` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
SELECT
	ID,
	projectID,
	projectOwner,
	indexID,
	taskID,
	owner,
	sender,
	receiver,
	docType,
	requestID,
    server,
	environment,
	revisionNumber,
	status,
	requestDate,
	deployDate,
    clientProdApproval,
	clientApprovalDate,
	assignee,
	assignedAt
FROM
(
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
   		t.server,
        t.clientProdApproval,
    	t.clientApprovalDate,
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
            	a.server,
            	a.clientProdApproval,
    			a.clientApprovalDate
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
)X
        WHERE	
        	X.taskID = taskID
       	AND
        	X.projectID = projectID
        AND
			X.environment = "PROD"
              ;
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recommendations` (IN `requestID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	SELECT
		r.ID as recommendationID,
        r.requestID,
        r.recommendation,
        CONCAT(u.fName, " ", u.lName) as recommendedBy,
        r.recommendedAt,
        d.departmentCode
    FROM
    	recommendations r 
    LEFT JOIN
    	accounts.users u
    ON
    	r.recommendedBy = u.ID
    LEFT JOIN
    	accounts.departments d
    ON
    	d.ID = u.deptID
    WHERE
    	r.requestID = requestID
    ORDER BY	
    	r.ID
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
    	ct.ID as changeTypeID,
        trans.ID as translationID,
        trans.name,
        trans.testInternalID
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
		(r.ID = ct.uatRequestID OR r.ID = ct.prodRequestID)
	LEFT JOIN
		translation trans
	ON
		trans.changeTypeID = ct.ID
	WHERE
		p.projectID = projectID
	AND
		t.taskID = taskID    
	GROUP BY
        trans.ID,
        trans.name,
        trans.testInternalID
    ORDER BY
    	ct.ID
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
		(r.ID = ct.uatRequestID OR r.ID = ct.prodRequestID)
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
	GROUP BY
		tc.ID,
		tc.translationID,
        tc.changes
    ORDER BY 
    	tc.ID
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
    	t.projectID = p.ID
    LEFT JOIN
    	requests r
    ON
    	t.ID = r.taskID
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_uat_request_details` (IN `projectID` INT, IN `taskID` INT)  NO SQL
BEGIN
SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
SELECT
	X.ID,
	projectID,
	projectOwner,
	indexID,
	taskID,
	owner,
	sender,
	receiver,
	docType,
	requestID,
    server,
	environment,
	revisionNumber,
	status,
	requestDate,
	deployDate,
    clientProdApproval,
	clientApprovalDate,
	assignee,
	assignedAt,
    ct.ID as changeTypeID,
    ct.uatRequestID,
    ct.prodRequestID,
    ct.type
FROM
(
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
   		t.server,
        t.clientProdApproval,
    	t.clientApprovalDate,
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
            	a.server,
            	a.clientProdApproval,
    			a.clientApprovalDate
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
)X
JOIN
	change_type ct
ON
	ct.uatRequestID = X.requestID
        WHERE	
        	X.taskID = taskID
       	AND
        	X.projectID = projectID
        AND
			X.environment = "UAT"
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
    	t.projectID = p.ID
    LEFT JOIN
    	requests r
    ON
    	t.ID = r.taskID
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_change_type` (IN `uatRequestID` INT, IN `type` VARCHAR(20))  NO SQL
BEGIN
	DECLARE changeTypeID INT;
    
	INSERT INTO change_type
    (uatRequestID, type)
    VALUES
    (uatRequestID, type);
    
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_request` (IN `taskID` INT, IN `environment` VARCHAR(10), IN `urgency` VARCHAR(50), IN `status` VARCHAR(20), IN `revNum` INT, IN `deployDate` DATE, IN `uatInternalID` TEXT)  NO SQL
BEGIN
	DECLARE insertedRequest INT;
    
    INSERT INTO requests
    	(
        	taskID,
            environment,
            urgency,
            status,
            revisionNumber,
            deployDate,
            uatInternalID
        )
    SELECT	
    	taskID,
        environment,
        urgency,
        status,
        revNum,
        deployDate,
        uatInternalID
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_task` (IN `taskID` INT, IN `projectID` INT, IN `ownerID` INT, IN `sender` VARCHAR(50), IN `receiver` VARCHAR(50), IN `docType` VARCHAR(50), IN `server` VARCHAR(10))  NO SQL
BEGIN
	DECLARE insertedIndexID INT;
    
    INSERT INTO tasks
    	(
        	taskID,
            projectID,
            ownerID,
            sender,
            receiver,
            docType,
            server
        )
    SELECT	
    	taskID,
        projectID,
        ownerID,
        sender,
        receiver,
        docType,
        server
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_translation` (IN `changeTypeID` INT, IN `name` VARCHAR(150), IN `testInternalID` VARCHAR(200))  NO SQL
BEGIN
	DECLARE translationID INT;
    
	INSERT INTO translation
    (changeTypeID, name, testInternalID)
    VALUES
    (changeTypeID, name, testInternalID);
    
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `link_prod_request` (IN `inputID` INT, IN `prodRequestID` INT)  NO SQL
BEGIN
	UPDATE 
        change_type
    SET
        prodRequestID 	= prodRequestID
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_client_approval` (IN `inputID` INT, IN `approverName` VARCHAR(100), IN `approvalDate` DATE)  NO SQL
BEGIN
	UPDATE 
        tasks
    SET
        clientProdApproval 	= approverName,
		clientApprovalDate = approvalDate
    WHERE
        ID = inputID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_status` (IN `requestID` INT, IN `newStatus` VARCHAR(20))  NO SQL
BEGIN
	UPDATE 
		requests
    SET
        status = newStatus
    WHERE
        ID = requestID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_task` (IN `inputID` INT, IN `newTaskID` INT, IN `newOwnerID` INT, IN `newSender` VARCHAR(50), IN `newReceiver` VARCHAR(50), IN `newDocType` VARCHAR(50), IN `newServer` VARCHAR(10))  NO SQL
BEGIN
    UPDATE 
        tasks
    SET
        taskID 	= newTaskID,
        ownerID = newOwnerID,
        sender 	= newSender,
        receiver = newReceiver,
        docType = newDocType,
        server = newServer
    WHERE
        ID = inputID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_translation` (IN `inputID` INT, IN `newName` VARCHAR(50), IN `newTestInternalID` VARCHAR(300))  NO SQL
BEGIN
	UPDATE
        translation
    SET
        name = newName,
        testInternalID = newTestInternalID
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
  `uatRequestID` int(11) NOT NULL,
  `prodRequestID` int(11) DEFAULT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `change_type`
--

INSERT INTO `change_type` (`ID`, `uatRequestID`, `prodRequestID`, `type`) VALUES
(3, 20, 21, 'Translation'),
(4, 22, 24, 'Translation'),
(5, 23, 24, 'Translation');

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
) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `projectOwnerID` int(11) NOT NULL
) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `projectID`, `projectOwnerID`) VALUES
(6, 1, 1),
(7, 2, 2);

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
) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `environment` enum('UAT','PROD') NOT NULL,
  `revisionNumber` varchar(20) NOT NULL,
  `urgency` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `requestDate` timestamp NULL DEFAULT current_timestamp(),
  `deployDate` datetime NOT NULL,
  `assigneeID` int(11) DEFAULT NULL,
  `assignedAt` timestamp NULL DEFAULT NULL,
  `uatInternalID` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`ID`, `taskID`, `environment`, `revisionNumber`, `urgency`, `status`, `requestDate`, `deployDate`, `assigneeID`, `assignedAt`, `uatInternalID`) VALUES
(20, 7, 'UAT', '1', 'Low', 'Exported', '2020-03-23 01:24:05', '2020-03-24 00:00:00', 3, '2020-03-23 06:16:20', NULL),
(21, 7, 'PROD', '1', 'High', 'Exported', '2020-03-23 06:30:01', '2020-03-24 00:00:00', 3, '2020-03-23 08:02:13', '123'),
(22, 7, 'UAT', '2', 'Low', 'Exported', '2020-03-29 22:29:57', '2020-03-30 06:29:28', 3, '2020-03-29 22:30:17', NULL),
(23, 7, 'UAT', '3', 'Low', 'Exported', '2020-03-29 22:31:33', '2020-03-31 06:31:02', 3, '2020-03-29 22:31:02', NULL),
(24, 7, 'PROD', '2 - 3', 'High', 'Reviewing', '2020-03-29 22:32:42', '2020-03-31 06:32:04', 3, '2020-03-29 22:32:56', '12345, 45678');

-- --------------------------------------------------------

--
-- Table structure for table `shared_requests`
--

CREATE TABLE `shared_requests` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `ID` int(11) NOT NULL,
  `serverName` varchar(20) NOT NULL,
  `tableName` varchar(100) NOT NULL,
  `change` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `docType` enum('PurchaseOrder','PurchaseOrderChange','PurchaseOrderAcknowledge','Invoice','Report') NOT NULL,
  `server` varchar(10) NOT NULL,
  `clientProdApproval` varchar(100) DEFAULT NULL,
  `clientApprovalDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`ID`, `taskID`, `projectID`, `ownerID`, `sender`, `receiver`, `docType`, `server`, `clientProdApproval`, `clientApprovalDate`) VALUES
(7, 1, 6, 3, 'S1', 'R1', 'Invoice', 'Mel02', 'Jom', '2020-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE `translation` (
  `ID` int(11) NOT NULL,
  `changeTypeID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `testInternalID` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translation`
--

INSERT INTO `translation` (`ID`, `changeTypeID`, `name`, `testInternalID`) VALUES
(17, 3, 'T1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `translation_changes`
--

CREATE TABLE `translation_changes` (
  `ID` int(11) NOT NULL,
  `translationID` int(11) NOT NULL,
  `changes` longtext NOT NULL
) ENGINE=MYISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `translation_changes`
--

INSERT INTO `translation_changes` (`ID`, `translationID`, `changes`) VALUES
(16, 17, '-Updated 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `change_type`
--
ALTER TABLE `change_type`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `uatRequestID` (`uatRequestID`),
  ADD KEY `prodRequestID` (`prodRequestID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `impacted`
--
ALTER TABLE `impacted`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `shared_requests`
--
ALTER TABLE `shared_requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `translation`
--
ALTER TABLE `translation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `translation_changes`
--
ALTER TABLE `translation_changes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `change_type`
--
ALTER TABLE `change_type`
  ADD CONSTRAINT `change_type_ibfk_1` FOREIGN KEY (`uatRequestID`) REFERENCES `requests` (`ID`),
  ADD CONSTRAINT `change_type_ibfk_2` FOREIGN KEY (`prodRequestID`) REFERENCES `requests` (`ID`);

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
