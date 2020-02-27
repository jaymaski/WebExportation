<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {
	//load models
	function __construct(){
        parent::__construct();
        $this->load->model('request_model', 'request');
		$this->load->model('change_model', 'change_type');
		$this->load->model('translation_model', 'translation');
    }
	//GET
	//----------------------------------------------------
	function view_request($projectID, $taskID, $requestID){
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}		

		$data['title'] = '';
		$CI = &get_instance();
		$data['requests'] = $this->request->get_request($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['curr_request'] =  $this->request->get_current_request($requestID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['impacted'] = $this->translation->get_impacted($projectID, $taskID);
		
		echo json_encode($data);
	}
	
	//SEARCH 
	//-----------------------------------------------------
	function search_project_id($projectID){
		$result = $this->request->search_project_id($projectID);
		
		if($result > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function search_task_id($taskID){
		$result = $this->request->search_task_id($taskID);
		
		if($result > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function search_request($taskID, $environment, $revisionNumber){
		$result = $this->request-> search_request($taskID, $environment, $revisionNumber);
		
		if($result > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//INSERT
	//-----------------------------------------------------------
	
	function add_request(){
		
		$pID = $this->request->insert_project($projectID, $projectOwnerID);
		$tID = $this->request->insert_task($taskID, $pID, $ownerID, $sender, $receiver, $docType);	
		$rID = $this->request->insert_request($tID, $environment, $urgency, $status, $revisionNumber, $requestDate);
		
		// foreach($  as $translation)
			$ctID = $this->change_type->insert_change_type($rID, "Translation");
			$trID = $this->translation->insert_translation($ctID, $name, $internalID);
			$this->translation->insert_translation_change($trID, $changes);
					
				// foreach($formImpacted as $impacted)
					$this->translation->insert_impacted($trID, $sender, $receiver, $docType, $internalIDs);
		
		return true;		
	}
	
	//UPDATE
	//--------------------------------------------------------------
	function update_request(){
		
		$this->request->update_project($pID, $newProjectID, $newProjectOwnerID);
		$this->request->update_task($tID, $newTaskID, $newOwnerID, $newSender, $newReceiver, $newDocType);
		$this->request->update_request($rID, $newEnvironment, $newRevisionNumber, $newUrgency, $newDeployDate);
		
		// foreach($  as $translation)
			$this->translation->update_translation($trID, $newName, $newInternalID);
			$this->translation->update_translation_changes($tcID, $newChanges);
		
		// foreach($formImpacted as $impacted)
			$this->translation->update_impacted($ID, $newSender,$newReceiver, $newDocType, $newInternalIDs);
		
		return true;
	}
	
	function update_status(){
		 
		$this->request->update_status($rID, $newStatus);
	}
	
	function assign_to_me(){
		
		$this->request->assign_request_to_me($rID, $this->session->userdata('user_id'));
	}
	
	
	
}