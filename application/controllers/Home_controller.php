<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_controller extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Home Page';

		$this->load->view('template/header_main');
		$this->load->view('home', $data);
		$this->load->view('template/footer_main');
	}
}
