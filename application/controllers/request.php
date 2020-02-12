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
		$CI = &get_instance();
		//selected translation
		$data['curr_request'] = $this->request->get_current_request($requestID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		
		mysqli_next_result($CI->db->conn_id);
		//history of selected translation
		 $data['request_history'] = $this->request->get_request_history($requestID, $projectID, $taskID);
		
		
		$this->load->view('template/header_main');
		$this->load->view('users/requests/view_request', $data);
		$this->load->view('template/footer_main');
	}
	
	
	public function create_task(){
        if ($this->input->post('submit')) { 
            $this->form_validation->set_rules('taskID', 'Task ID', 'trim|required');
            $this->form_validation->set_rules('projectID', 'Project ID', 'trim|required');
            $this->form_validation->set_rules('ownerID', 'Owner ID', 'trim|required');
            $this->form_validation->set_rules('sender', 'Sender', 'trim|required');
			$this->form_validation->set_rules('receiver', 'Receiver', 'trim|required');
			$this->form_validation->set_rules('docType', 'Document', 'trim|required');
			
            if ($this->form_validation->run() !== FALSE) {
                $indexID = $this->request->insert_task($this->input->post('taskID'), $this->input->post('projectID'), $this->input->post('ownerID'), $this->input->post('sender'),$this->input->post('receiver'),$this->input->post('docType'));
				
				if($indexID){
					$data['indexID'] = $indexID;
					$this->load->view('requests/view_task', $data);
				}
				else{
					$this->load->view('requests/all_request');
				}
            } else {
				$data['error'] = 'error occurred during saving data: all fields are required';
                $this->load->view('users/requests/create_task', $data);
            }
        } else {
            $this->load->view('users/requests/create_task');
        }
    }
	
	public function view_task(){
		$this->load->view('users/requests/view_task');
	}
}