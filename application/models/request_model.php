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
	//return recommendations for the selected request
	function get_recommendations($requestID){
		$get_recommendations = "CALL get_recommendations(?)";
		$param = array('requestID' => $requestID);
		$query = $this->db->query($get_recommendations, $param);
		return $query->result();
	}
	//return all requests for specific project task
	function get_request($projectID, $taskID){
		$get_request = "CALL get_request(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_request, $param);
		return $query->result();
	}
	//return all requests for current user
	function get_user_requests($userID){
		$get_user_requests = "CALL get_user_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_user_requests, $param);
		return $query->result();
	}
	//return selected request
	function get_current_request($requestID){
		$get_current_request = "CALL get_current_request(?)";
		$param = array('requestID' => $requestID);
		$query = $this->db->query($get_current_request, $param);
		return $query->result();
	}
	//return shared requests for current user
	function get_shared_requests($userID){
		$get_shared_requests = "CALL get_shared_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_shared_requests, $param);
		return $query->result();
	}	
	//return all requests	
	function get_all_request(){
		$get_all_request = "CALL get_all_request()";
		$query = $this->db->query($get_all_request);
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
		
		return $result;
	}
	
	function insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType){
		$insert_task = "CALL insert_task(?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'projectID' => $projectID, 'ownerID' => $ownerID, 'sender' => $sender, 'receiver' => $receiver, 'docType' => $docType);
		$query = $this->db->query($insert_task, $param);
		$result = $query->result();
		
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

	function assign_request_to_me($ID, $assigneeID){
		$assign_request_to_me = "CALL assign_request_to_me(?, ?)";
		$param = array('inputID' => $ID, 'assigneeID' => $assigneeID);
		$query = $this->db->query($assign_request_to_me, $param);
		$result = $query->result();
		
		return $result;
	}
}