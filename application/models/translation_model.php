<?php

/**
 *
 *Translation CRUD
 *
 */

class Translation_model extends CI_Model{
	//connect to databse "exportation"
	public function __construct(){
		parent::__construct();
        $this->load->database('default', TRUE);
    }
	//GET
	//-----------------------------------------------------
	function get_translation($projectID, $taskID){
		$get_translation = "CALL get_translation(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID );
		$query = $this->db->query($get_translation, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function get_translation_change($projectID, $taskID){
		$get_translation_change = "CALL get_translation_change(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_translation_change, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function get_impacted($projectID, $taskID){
		$get_impacted = "CALL get_impacted(?, ?)";
		$param = array('projectID' => $projectID, 'taskID' => $taskID);
		$query = $this->db->query($get_impacted, $param);
		
		return $query->result();
	}
	//INSERT
	//--------------------------------------------------------
	function insert_translation($changeTypeID, $name, $testInternalID ){
		
		$insert_translation = "CALL insert_translation(?, ?, ?)";
		$param = array('changeTypeID' => $changeTypeID,'name' => $name,'testInternalID' => $testInternalID);
		$query = $this->db->query($insert_translation, $param);
		$result = $query->result();
		
		return $result;
		
	}
	
	function insert_translation_change($translationID, $changes){
		
		$insert_translation_change = "CALL insert_translation_change(?, ?)";
		$param = array('translationID' => $translationID,'changes' => $changes);
		$query = $this->db->query($insert_translation_change, $param);
		$result = $query->result();
			
		return $result;
	}
	
	function insert_impacted($translationID, $sender, $receiver, $docType, $internalIDs){
		$insert_impacted = "CALL insert_impacted(?, ?, ?)";
		$param = array('translationID' => $translationID,'sender' => $sender,'receiver' => $receiver,'docType' => $docType,'internalIDs' => $internalIDs);
		$query = $this->db->query($insert_impacted, $param);
		$result = $query->result();
		
		return $result;
	}
	//UPDATE
	//------------------------------------------------------------------
	function update_translation($ID, $newName, $newTestInternalID){
		$update_translation = "CALL update_translation(?, ?, ?)";
		$param = array('inputID' => $ID,'newName' => $newName,'newTestInternalID' => $newTestInternalID);
		$query = $this->db->query($update_translation, $param);
		$result = $query->result();
		
		return $result;
	}
	
	function update_translation_changes($ID, $newChanges){
		$update_translation_changes = "CALL update_translation_changes(?, ?)";
		$param = array('inputID' => $ID,'newChanges' => $newChanges);
		$query = $this->db->query($update_translation_changes, $param);
		$result = $query->result();
		
		return $result;
	}

	function update_impacted($ID, $newSender,$newReceiver, $newDocType, $newInternalIDs){
		$update_impacted = "CALL update_impacted(?, ?)";
		$param = array('inputID' => $ID,'newSender' => $newSender,'newReceiver' => $newReceiver,'newDocType' => $newDocType,'newInternalIDs' => $newInternalIDs);
		$query = $this->db->query($update_impacted, $param);
		$result = $query->result();
		
		return $result;
	}

}