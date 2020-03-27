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
}