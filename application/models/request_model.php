<?php

/**
 *
 *Project Task Request CRUD
 *
 */

class Request_model extends CI_Model{
	//connect to databse "exportation"
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	//GET
	//---------------------------------------------------------------------------
	
	//return value to main page / tabs
	function get_latest_user_requests($userID,$type){
		$get_latest_user_requests = "CALL get_latest_user_requests(?, ?)";
		$param = array('userID' => $userID, 'type' => $type);
		$query = $this->db->query($get_latest_user_requests, $param);
		return $query->result();
	}
	//return uat request details
	function get_uat_request_details($projectID, $taskID){
		$get_uat_request_details = "CALL get_uat_request_details(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_uat_request_details, $param);
		return $query->result();
	}
	//return prod request details
	function get_prod_request_details($projectID, $taskID){
		$get_prod_request_details = "CALL get_prod_request_details(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_prod_request_details, $param);
		return $query->result();
	}
	//return shared request
	function get_shared_requests($userID){
		$get_shared_requests = "CALL get_shared_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_shared_requests, $param);
		return $query->result();
	}	
	
	
	function get_id_of_project($projectID){
		$get_id_of_project = "CALL get_id_of_project(?)";
		$param = array('projectID' => $projectID);
		$query = $this->db->query($get_id_of_project, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function get_id_of_task($taskID){
		$get_id_of_task = "CALL get_id_of_task(?)";
		$param = array('taskID' => $taskID);
		$query = $this->db->query($get_id_of_task, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function get_id_of_request($taskID, $environment, $revisionNumber){
		$get_id_of_request = "CALL get_id_of_request(?, ?, ?)";
		$param = array('taskID' => $taskID);
		$query = $this->db->query($get_id_of_request, $param);
		$result = $query->result();
		
		return $result;
	}

	//INSERT
	//-----------------------------------------------------------------------------
	function insert_request($taskID, $environment, $urgency, $status, $revisionNumber, $deployDate, $uatInternalID){
		$insert_request = "CALL insert_request(?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'environment' => $environment,'urgency' => $urgency, 'status' => $status, 'revisionNumber' => $revisionNumber, 'deployDate' => $deployDate, 'uatInternalID' => $uatInternalID);
		$query = $this->db->query($insert_request, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function insert_project($projectID, $projectOwnerID){
		$insert_project = "CALL insert_project(?, ?)";
		$param = array('projectID' => $projectID, 'projectOwnerID' => $projectOwnerID);
		$query = $this->db->query($insert_project, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType, $server){
		$insert_task = "CALL insert_task(?, ?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'projectID' => $projectID, 'ownerID' => $ownerID, 'sender' => $sender, 'receiver' => $receiver, 'docType' => $docType, 'server' => $server);
		$query = $this->db->query($insert_task, $param);
		$result = $query->result();
		
		return $result;
	}
	
	//UPDATE
	//-----------------------------------------------------------------------------
	function update_project($ID, $newProjectID, $newProjectOwnerID){
		$update_project = "CALL update_project(?, ?, ?)";
		$param = array('inputID' => $ID,'newProjectID' => $newProjectID,'newProjectOwnerID' => $newProjectOwnerID);
		$query = $this->db->query($update_project, $param);
		$result = $query->result();
		
		return $result;
	}

	function update_task($ID, $newTaskID, $newOwnerID, $newSender, $newReceiver, $newDocType, $newServer){
		$update_task = "CALL update_task(?, ?, ?, ?, ?, ?, ?)";
		$param = array('inputID' => $ID,'newTaskID' => $newTaskID,'newOwnerID' => $newOwnerID,'newSender' => $newSender,'newReceiver' => $newReceiver,'newDocType' => $newDocType, 'newServer' => $newServer);
		$query = $this->db->query($update_task, $param);
		$result = $query->result();
		
		return $result;
	}

	function update_request($ID, $newEnvironment, $newRevisionNumber, $newUrgency, $newDeployDate){
		$update_request = "CALL update_request(?, ?, ?, ?, ?)";
		$param = array('inputID' => $ID,'newEnvironment' => $newEnvironment,'newRevisionNumber' => $newRevisionNumber,'newUrgency' => $newUrgency,'newDeployDate' => $newDeployDate);
		$query = $this->db->query($update_request, $param);
		$result = $query->result();
		
		return $result;
	}

	function update_status($ID, $newStatus){
		$update_status = "CALL update_status(?, ?)";
		$param = array('inputID' => $ID, 'newStatus' => $newStatus);
		$query = $this->db->query($update_status, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function assign_request_to_me($ID, $assigneeID){
		$assign_request_to_me = "CALL assign_request_to_me(?, ?)";
		$param = array('inputID' => $ID, 'assigneeID' => $assigneeID);
		$query = $this->db->query($assign_request_to_me, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function update_client_approval($tID, $name, $date){
		$update_client_approval = "CALL update_client_approval(?, ?, ?)";
		$param = array('inputID' => $tID, 'approverName' => $name, 'approvalDate' => $date);
		$query = $this->db->query($update_client_approval, $param);
		$result = $query->result();
		
		return $result;
	}
	
}