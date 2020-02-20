<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('request_model', 'request');
		$this->load->model('change_model', 'change_type');
		$this->load->model('translation_model', 'translation');
    }
	
	function view_request($projectID, $taskID, $requestID){
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}		

		$data['title'] = 'PUMASOK NA HAYOP KA';
		$CI = &get_instance();
		$data['request'] = $this->request->request($requestID);
		$data['curr_request'] = $this->request->get_current_request($requestID);

		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		
		echo json_encode($data);
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