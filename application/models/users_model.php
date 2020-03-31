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

	function getUsers($postData){
 
		$response = array();
	  
		$this->accounts->select('*');
	
		if($postData['keyword'] ){
	 
		  // Select record
		  $this->accounts->where("fName like '%". $postData['keyword'] ."%' ");
		  
		  $records = $this->accounts->get('users')->result();
	
		  foreach($records as $row ){
			$response[] = array("id"=>$row->ID,"name"=>$row->fName. " " .$row->lName);
		  }
	 
		}
		
		return $response;
	  }

}
	
	