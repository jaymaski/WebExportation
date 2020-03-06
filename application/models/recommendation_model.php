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
	//GET
	//-----------------------------------------------------
	function get_recommendations($requestID){
		$get_recommendations = "CALL get_recommendations(?)";
		$param = array('requestID' => $requestID);
		$query = $this->db->query($get_recommendations, $param);
		$result = $query->result();
		return $result;
	}
	
	//INSERT
	//------------------------------------------------------
	function insert_recommendation($requestID, $recommendation, $userID){
		$insert_recommendation = "CALL insert_recommendation(?, ?, ?)";
		$param = array('requestID' => $requestID,'recommendation' => $recommendation,'userID' => $userID);
		$query = $this->db->query($insert_recommendation, $param);
		$result = $query->result();
		return $result;
	}
	
	//UPDATE
	//------------------------------------------------------
	function update_recommendation($ID, $newRecommendation){
		$update_recommendation = "CALL update_recommendation(?, ?)";
		$param = array('inputID' => $ID,'newRecommendation' => $newRecommendation);
		$query = $this->db->query($update_recommendation, $param);
		$result = $query->result();
		
		return $result;
	}
	
	
}