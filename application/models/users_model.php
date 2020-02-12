<?php
class Users_model extends CI_Model{
        
	public function __construct(){
		parent::__construct();
        $this->accounts = $this->load->database('accounts', TRUE);
    }
	
	function get_user($username, $password){
		$search_user = "CALL search_user(?, ?)";
		$param = array('username' => $username,'password' => $password);
		$query = $this->accounts->query($search_user, $param);
		return $query;
	}
}
	
	