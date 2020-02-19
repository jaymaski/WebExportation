<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {
	//load models
	function __construct(){
        parent::__construct();
        $this->load->model('request_model', 'request');
		$this->load->model('change_model', 'change_type');
		$this->load->model('translation_model', 'translation');
		$this->load->model('recommendation_model', 'recommendation');
    }
	//Request data that use in view_request page
	function view_request($projectID, $taskID, $requestID){
		
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
		mysqli_next_result($CI->db->conn_id);
		$data['recommendations'] = $this->request->get_recommendations($requestID);
		
		$this->load->view('template/header_main');
		$this->load->view('users/requests/view_request', $data);
		$this->load->view('template/footer_main');
	}
	
	function add_recommendation($requestID, $recommendation, $userID){
		
		$data['errMsg'] = "";
		$recommendationID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);
		
		if($recommendationID <= 0){
			$data['errMsg'] = "Ooops, something went wrong. Recommendation didn't insert.";
			$this->load->view('errors/index', $data);
			exit;
		}
		return true;
	}
	
	
	
	
	// ADD REQUEST
	// function add_request(){
		
		// $insertedProjectID = $this->request->insert_project($projectID, $projectOwnerID);
		// $insertedTaskID = $this->request->insert_task($taskID, $projectID, $ownerID, $sender, $receiver, $docType);
		// $insertedRequestID = $this->request->insert_request($taskID, $environment, $urgency, $status, $revisionNumber, $requestDate);
		
		// foreach($formTranslations as $translation)
			
			// $insertedChangeTypeID = $this->change_type->insert_change_type($insertedRequestID, "Translation");
			// $insertedTranslationID = $this->translation->insert_translation($insertedChangeTypeID, $name, $internalID);
			
				// foreach($formTranslationChanges as changes)
					// $this->translation->insert_translation_change($insertedTranslationID, $changes);
					
				// foreach($formImpacted as $impacted)
					// $this->translation->insert_impacted($insertedTranslationID, $sender, $receiver, $docType, $internalIDs);
		
		// return true;
	// }
	
	
}