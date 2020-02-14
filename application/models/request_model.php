<?php

/**
 *
 *Project Task Request CRUD
 *
 */

class Request_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function get_recommendations($requestID){
		$get_recommendations = "CALL get_recommendations(?)";
		$param = array('requestID' => $requestID);
		$query = $this->db->query($get_recommendations, $param);
		return $query->result();
	}
	
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
	
	function get_request_history($requestID, $projectID, $taskID){
		$get_request_history = "CALL get_request_history(?, ?, ?)";
		$param = array('requestID' => $requestID, 'projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_request_history, $param);
		return $query->result();
	}
		
	function get_shared_requests($userID){
		$get_shared_requests = "CALL get_shared_requests(?)";
		$param = array('userID' => $userID);
		$query = $this->db->query($get_shared_requests, $param);
		return $query->result();
	}	
		
	function get_all_request(){
		$get_all_project_task_request = "CALL get_project_task_request_list()";
		$query = $this->db->query($get_all_project_task_request);
		return $query->result();
	}
	
	
	function insert_request($projectID, $projectOwnerID, $taskID, $ownerID, $sender, $receiver, $docType, $environment, $status, $revisionNumber, $requestDate){
		
		$projectID = insert_project($projectID, $projectOwnerID);
		
		if($projectID != -1){
			
			$taskID = insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType);
			
			if($taskID != -1){
				
				$insert_request = "CALL insert_request(?, ?, ?, ?, ?)";
				$param = array('taskID' => $taskID, 'environment' => $environment, 'status' => $status, 'revisionNumber' => $revisionNumber, 'requestDate' => $requestDate);
				$query = $this->db->query($insert_request, $param);
				$result = $query->result();
		
				if($result > -1){
					return $result;
				}
				else{
					return -1;
				}
				
			}
			else{
				return -1;
			}
		}
		else{
			return -1;
		}
	}
	
	function insert_project($projectID, $projectOwnerID){
		$insert_project = "CALL insert_project(?, ?)";
		$param = array('ID' => $projectID, 'projectOwnerID' => $projectOwnerID);
		$query = $this->db->query($insert_project, $param);
		$result = $query->result();
		
		if($result > -1){
			return $result;
		}
		else{
			return -1;
		}
	}
	
	function insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType){
		$insert_task = "CALL insert_task(?, ?, ?, ?, ?, ?)";
		$param = array('taskID' => $taskID, 'projectID' => $projectID, 'ownerID' => $ownerID, 'sender' => $sender, 'receiver' => $receiver, 'docType' => $docType);
		$query = $this->db->query($insert_task, $param);
		$result = $query->result();
		
		if($result > -1){
			return $result;
		}
		else{
			return -1;
		}
	}
	
	
	
	
}