<?php

/**
 *
 *Translation CRUD
 *
 */

class Translation_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	
	function get_translation($projectID, $taskID){
		$get_translation = "CALL get_translation(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID );
		$query = $this->db->query($get_translation, $param);
		$result = $query->result();
		
		if($result > -1){
			return $result;
		}
		else{
			return -1;
		}
	}
	
	function get_translation_change($projectID, $taskID){
		$get_translation_change = "CALL get_translation_change(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_translation_change, $param);
		$result = $query->result();
		
		if($result > -1){
			return $result;
		}
		else{
			return -1;
		}
	}
	
	function get_impacted($projectID, $taskID){
		$get_impacted = "CALL get_impacted(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_impacted, $param);
		return $query->result();
	}
	
	function insert_translation($changeTypeID, $name, $internalID, $isImpacted){
		
		$insert_translation = "CALL insert_translation(?, ?, ?, ?)";
		$param = array('changeTypeID' => $changeTypeID,'name' => $name,'internalID' => $internalID, 'isImpacted' => $isImpacted);
		$query = $this->db->query($insert_translation, $param);
		$result = $query->result();
		
		if($result > -1){
			return $result;
		}
		else{
			return -1;
		}
		
	}
	
	function insert_translation_change($translationID, $changes){
		
		$insert_translation_change = "CALL insert_translation_change(?, ?)";
		$param = array('translationID' => $translationID,'changes' => $changes);
		$query = $this->db->query($insert_translation_change, $param);
		$result = $query->result();
			
		if($result > -1){
			return $result;	
		}
		else{
			return -1;
		}
	}
	
	
	
}