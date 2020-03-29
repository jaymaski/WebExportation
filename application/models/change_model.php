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
	
	function insert_change_type($uatRequestID, $type){
		$insert_change_type = "CALL insert_change_type(?, ?)";
		$param = array('uatRequestID' => $uatRequestID, 'type' => $type);
		$query = $this->db->query($insert_change_type, $param);
		$result = $query->result();
		
		return $result;
		
	}
	
	function link_prod_request($ID, $prodRequestID){
		$link_prod_request = "CALL link_prod_request(?, ?)";
		$param = array('inputID' => $ID, 'prodRequestID' => $prodRequestID);
		$query = $this->db->query($link_prod_request, $param);
		$result = $query->result();
		
		return $result;
	}
	
	
	
}