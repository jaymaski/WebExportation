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
	//GET
	//----------------------------------------------------
	function view_request($projectID, $taskID){
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}		

		$data['title'] = '';
		$CI = &get_instance();
		$data['requests'] = $this->request->get_request($projectID, $taskID);
		// mysqli_next_result($CI->db->conn_id);
		// $data['curr_request'] =  $this->request->get_current_request($requestID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['impacted'] = $this->translation->get_impacted($projectID, $taskID);
		
		echo json_encode($data);
	}

	function view_request_comments() {
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}	
		$requestID = $this->input->post('requestID');
		$CI = &get_instance();
		$data['recommendations'] = $this->recommendation->get_recommendations($requestID);


		echo json_encode($data);
	}

	function update(){
		$data['projectID'] = $this->input->post('projectID');
		$data['taskID'] = $this->input->post('taskID');
		$data['projectOwner'] = $this->input->post('projectOwner');
		$data['sender'] = $this->input->post('sender');
		$data['receiver'] = $this->input->post('receiver');
		$data['docType'] = $this->input->post('docType');

		//insert logic here

		//check if insert was successful

		echo json_encode($data);
	}
	
	//Add Recommendation
	function add_recommendation($requestID, $recommendation, $userID) {
		$recommendationID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);
		
		if($recommendationID > 0){
			return true;
		}
		else{
			return false;
		}
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
	
	function loadRecord($rowno = 0){

		// Row per page
		$rowperpage = 2;
	
		// Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = 5;
	
		// Get records
		$CI = &get_instance();
		$my_requests = $this->request->get_user_requests($this->session->userdata('user_id'));
		
		// Pagination Configuration
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		// $config["total_rows"] = $totalRecords;
		// $config["per_page"] = $limit;
		// $config['use_page_numbers'] = TRUE;
		// $config['page_query_string'] = TRUE;
		// $config['enable_query_strings'] = TRUE;
		// $config['num_links'] = 1;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';		
	
		// Initialize
		$this->pagination->initialize($config);
	
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['my_requests'] = $my_requests;
		$data['row'] = $rowno;
	
		echo json_encode($data);
	}
}