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

		// $projectID = $this->input->post('projectID');
		// $taskID = $this->input->post('taskID');
		// $requestID = $this->input->post('requestID');

		$data['title'] = '';
		$CI = &get_instance();
		$data['curr_request'] = $this->request->get_current_request($requestID);
		mysqli_next_result($CI->db->conn_id);
		$data['request_history'] = $this->request->get_request_history($requestID, $projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		
		mysqli_next_result($CI->db->conn_id);
		//history of selected translation
		$data['request_history'] = $this->request->get_request_history($requestID, $projectID, $taskID);
		
		//return $data;
		$this->load->view('template/header_main');
		$this->load->view('users/requests/view_request', $data);
		$this->load->view('template/footer_main');
	}
	
	// function view_request_details($projectID, $taskID, $requestID){
		// $CI = &get_instance();
		// $data['request_details'] = $this->request->get_current_request($requestID);
		// mysqli_next_result($CI->db->conn_id);
		// $data['translations'] = $this->translation->get_translation($projectID, $taskID);
		// mysqli_next_result($CI->db->conn_id);
		// $data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		// mysqli_next_result($CI->db->conn_id);
		// $data['recommendations'] = $this->translation->get_recommendations($requestID);
		
		// $this->load->view('template/header_main');
		// $this->load->view('users/requests/view_request_details', $data);
		// $this->load->view('template/footer_main');
	// }
	
}