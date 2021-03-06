<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct(){
        parent::__construct();
		$this->load->model('users_model', 'user');
        $this->load->model('request_model', 'request');
		$this->load->model('change_model', 'change_type');
		$this->load->model('translation_model', 'translation');
    }
	
	public function index()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}
		
		$CI = &get_instance();

		$data['my_requests'] = $this->request->get_user_requests($this->session->userdata('user_id'));
		mysqli_next_result($CI->db->conn_id);
		$data['shared_requests'] = $this->request->get_shared_requests($this->session->userdata('user_id'));


		$this->load->view('template/header_main');
		$this->load->view('users/users_dashboard', $data);
		$this->load->view('template/footer_main');
	}
	
	public function login() {
		$data['title'] = 'Dashboard';

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === FALSE){
			$data['title'] = 'Login to get started';
			$this->load->view('template/header_no-nav');
			$this->load->view('users/login', $data);
			$this->load->view('template/footer_main');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$result = $this->user->get_user($username, $password);
			
			if($result->num_rows() > 0){
				$row = $result->row(1);
				$user_data = array(
					'user_id'	=> $row->ID,
					'name' 		=> $row->fName." ".$row->lName,
					'username' 	=> $row->username,
					'emailAddress' => $row->emailAddress,
					'department' => $row->depatmentCode,
					'type' => $row->type,
					'logged_in' => true
				);
				$this->session->set_userdata($user_data);
				redirect('users/index');
			}
			else {
				$this->session->set_flashdata('failed', 'Login failed wrong username or password');
				redirect('users/login');
			}			
		}			
	}	

	public function logout(){
		$this->session->unset_userdata('logged_in');

		$this->session->set_flashdata('user_loggedout', 'You are now logged output_add_rewrite_var(name, value)');
		redirect('users/login');
	}	
}
