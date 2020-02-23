<?php

/**
 *
 *Change Type CRUD
 *
 */

class Change_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function insert_change_type($requestID, $type){
		$insert_change_type = "CALL insert_change_type(?, ?)";
		$param = array('requestID' => $requestID, 'type' => $type);
		$query = $this->db->query($insert_change_type, $param);
		$result = $query->result();
		
		return $result;
		
	}
	
	
	
}