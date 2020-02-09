<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function index()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}

		$data['title'] = 'Dashboard';

		$this->load->view('template/header_main');
		$this->load->view('users/users_dashboard', $data);
		$this->load->view('template/footer_main');
	}
	public function login() {
		$data['title'] = 'Dashboard';
		$this->load->model('users_model');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === FALSE){
			$data['title'] = 'Login to get started';
			$this->load->view('template/header_no-nav');
			$this->load->view('users/login', $data);
			$this->load->view('template/footer_main');
		} else {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			//$user_id = $this->users_model->login($username, $password); //Retrieves from db
			$user_id = true; //ganto muna
			if($user_id) {
				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
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
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');

		$this->session->set_flashdata('user_loggedout', 'You are now logged output_add_rewrite_var(name, value)');
		redirect('users/login');
	}	

	public function email(){
		$this->load->model('users_model');
		$status = $this->input->post('emailBtn');
		$note = $this->input->post('note');
		$sent = $this->users_model->send_mail($status, $note);
	}
}
