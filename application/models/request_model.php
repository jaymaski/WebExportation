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
	
	function get_request($projectID, $taskID){
		$get_request = "CALL get_request(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_request, $param);
		return $query->result();
	}
	
	function get_user_requests($userID){
		$get_user_requests = "CALL get_user_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_user_requests, $param);
		return $query->result();
	}
	
	function get_current_request($requestID){
		$get_current_request = "CALL get_current_request(?)";
		$param = array('requestID' => $requestID);
		$query = $this->db->query($get_current_request, $param);
		return $query->result();
	}
	
	function get_shared_requests($userID){
		$get_shared_requests = "CALL get_shared_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_shared_requests, $param);
		return $query->result();
	}	
	
	//INSERT
	//-----------------------------------------------------------------------------
	function insert_request($taskID, $environment, $urgency, $status, $revisionNumber, $requestDate){
		$insert_request = "CALL insert_request(?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'environment' => $environment,'urgency' => $urgency, 'status' => $status, 'revisionNumber' => $revisionNumber, 'requestDate' => $requestDate);
		$query = $this->db->query($insert_request, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function insert_project($projectID, $projectOwnerID){
		$insert_project = "CALL insert_project(?, ?)";
		$param = array('projectID' => $projectID, 'projectOwnerID' => $projectOwnerID);
		$query = $this->db->query($insert_project, $param);
		$result = $query->result();
		$query->next_result(); 
		$query->free_result();
		return $result;
	}
	
	function insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType){
		$insert_task = "CALL insert_task(?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'projectID' => $projectID, 'ownerID' => $ownerID, 'sender' => $sender, 'receiver' => $receiver, 'docType' => $docType);
		$query = $this->db->query($insert_task, $param);
		$result = $query->result();
		$query->next_result(); 
		$query->free_result(); 	
		return $result;
	}

	function insert_translation($changeID, $name, $internalID){
		$insert_translation = "CALL insert_translation(?, ?, ?)";
		$param = array('changeTypeID' => $changeID, 'name' => $name, 'internalID' => $internalID);
		$query = $this->db->query($insert_translation, $param);
		$result = $query->result();
		$query->next_result(); 
		$query->free_result(); 
		return $result;
	}

	function insert_translation_change($translationID, $changes){
		$insert_translation_change = "CALL insert_translation_change(?, ?)";
		$param = array('translationID' => $translationID, 'changes' => $changes);
		$query = $this->db->query($insert_translation_change, $param);
		if($query == false)
			return "Error";
		$result = $query->result();
		$query->next_result(); 
		$query->free_result(); 
		return $result;
	}
	
	function insert_impacted($translationID, $sender, $receiver, $docType, $internalIDs){
		$insert_impacted = "CALL insert_impacted(?, ?, ?, ?, ?)";
		$param = array('translationID' => $translationID, 'sender' => $sender,'receiver' => $receiver, 'docType' => $docType,'internalIDs' => $internalIDs);
		$query = $this->db->query($insert_impacted, $param);
		$result = $query->result();
		$query->next_result(); 
		$query->free_result(); 
		return $result;
	}
	
	//SEARCH
	//------------------------------------------------------------------------------
	function search_project_id($projectID){
		$search_project_id = "CALL search_project_id(?)";
		$param = array('projectID' => $projectID);
		$query = $this->db->query($search_project_id, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function search_task_id($taskID){
		$search_task_id = "CALL search_task_id(?)";
		$param = array('taskID' => $taskID);
		$query = $this->db->query($search_task_id, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function search_request($taskID, $environment, $revisionNumber){
		$search_request = "CALL search_request(?, ?, ?)";
		$param = array('taskID' => $taskID);
		$query = $this->db->query($search_request, $param);
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

	function update_task($ID, $newTaskID, $newOwnerID, $newSender, $newReceiver, $newDocType){
		$update_task = "CALL update_task(?, ?, ?, ?, ?, ?)";
		$param = array('inputID' => $ID,'newTaskID' => $newTaskID,'newOwnerID' => $newOwnerID,'newSender' => $newSender,'newReceiver' => $newReceiver,'newDocType' => $newDocType);
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
}