<?php

/**
 *
 *Recommendations CRUD
 *
 */

class Recommendation_model extends CI_Model{
	//connect to databse "exportation"
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function insert_recommendation($requestID, $recommendation, $userID){
		$insert_recommendation = "CALL insert_recommendation(?, ?, ?)";
		$param = array('requestID' => $requestID,'recommendation' => $recommendation,'userID' => $userID);
		$query = $this->db->query($insert_recommendation, $param);
		$result = $query->result();
		return $result;
	}
	
}