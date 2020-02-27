<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recommendation extends CI_Controller {
	//load models
	function __construct(){
        parent::__construct();
		$this->load->model('recommendation_model', 'recommendation');
    }
	//INSERT
	//-------------------------------------------------------------
	function add_recommendation($requestID, $recommendation, $userID){
		
		$rID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);
		
		if($rID > 0){
			return true;
		}
		else{
			return false;
		}
	}
	//GET
	//-------------------------------------------------------------
	function get_recommendations($requestID){
		
		$data = $this->recommendation->get_recommendations($requestID);
		echo json_encode($data);
	}
	
	//UPDATE
	//------------------------------------------------------------
	function update_recommendation($rID, $newRecommendation){
		
		$data = $this->recommendation->update_recommendation($rID, $newRecommendation);
		echo json_encode($data);
		
	}

}