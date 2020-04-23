<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {
	//load models
	function __construct(){
        parent::__construct();
        $this->load->model('request_model', 'request');
		$this->load->model('change_model', 'change_type');
		$this->load->model('translation_model', 'translation');
		$this->load->model('recommendation_model', 'recommendation');
    }
	//GET
	//----------------------------------------------------
	function view_request($projectID, $taskID, $requestID){
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}		

		$data['title'] = '';
		$CI = &get_instance();
		$data['uat_requests'] = $this->request->get_uat_request_details($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['prod_requests'] = $this->request->get_prod_request_details($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['impacted'] = $this->translation->get_impacted($projectID, $taskID);
		
		echo json_encode($data);
	}

	function view_request_comments() {
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}	
		$requestID = $this->input->post('requestID');
		$CI = &get_instance();
		$data['recommendations'] = $this->recommendation->get_recommendations($requestID);


		echo json_encode($data);
	}
	
	//INSERT
		//TRANSLATION-----------------------------------------------------------
	function save(){
		//$data = json_decode('{"project":{"projectId":"45678","taskId":"456789","projectOwner":"Dememor Mendoza","documentType":"PurchaseOrder","projectOwnerId":"1","senderID":"mdpl-au","receiverID":"mdp-nz","server":"MapEU","highlightNote":"","devLog":"","requestDate":"03/10/2020","deployDate":"03/10/2020"},"translationDetails":{"translation":{"0":{"testId":"987654654","translationName":"mdpl-automdp-nzcustom","releaseAsDocType":"PurchaseOrder","translationChange":"asdgasdgadgadsgadsfasdfdsf","impacted":{"0":{"sender":"","recever":"","documentType":"","testvslive":""}}}}}}',true);

		$response = array();
		$project = $data['project'];
		
		$translation = $data['translationDetails']['translation'];
		// $table = $data['tableDetails']['table'];
		// $pm = $data['pmDetails']['pm'];

		$pID = $this->request->insert_project($project['projectId'], (int)$project['projectOwnerId']);
		$tID = $this->request->insert_task((int)$project['taskId'], (int)$pID[0]->insertedProjectID, (int)$project['projectOwnerId'], $project['senderID'], $project['receiverID'], $project['documentType'], $project['server']);
		$rID = $this->request->insert_request((int)$tID[0]->insertedTaskID, $project['environment'], $project['urgency'], "In Queue", $project['revisionNumber'], $project['deployDate'], NULL);
		
		if(count($translation) > 0){
			$this->create_new_translation_request((int)$rID[0]->insertedRequestID, $translation);
		}
		// else if(count($table > 0)){
			//$this->create_new_table_request((int)$rID[0]->insertedRequestID, $table);
		// }
		// else{
			// $this->create_new_pm_request((int)$rID[0]->insertedRequestID, $pm);
		// }
	}
	
	function create_new_translation_request($rID, $translation){
		
		$ctID = $this->add_change_type($rID, "Translation");
		
		for($i =0; $i < count($translation); $i++)
		 {
			$testId = $translation[$i]['testId'];
			$translationName = $translation[$i]['translationName'];
			$translationChange = $translation[$i]['translationChange'];
			
			$trID = $this->add_translation((int)$ctID[0]->insertedChangeTypeID, $translationName, (int)$testId);
			$this->add_translation_change((int)$trID[0]->insertedTranslationID, $translationChange);
			
			$impacted = $translation[$i]['impacted'];
			for($j =0; $j < count($impacted); $j++)
			{
				$docType = $impacted[$j]['documentType'];
				$sender = $impacted[$j]['sender'];
				$receiver = $impacted[$j]['recever'];
				$internalIDs = $impacted[$j]['testvslive'];
				
				if(strlen($docType) ==0 && strlen($sender) ==0 &&strlen($receiver) ==0 &&strlen($internalIDs) ==0){
					
					$this->add_impacted((int)$trID[0]->insertedTranslationID, $sender, $receiver, $docType, $internalIDs);

				}
			}
		 }			
	}
	
	function request_to_prod(){
		//$jsondata = $tID, $ctID, $name, $date, $urgency, $revisionNumber, $deployDate, $uatInternalID
		
		$this->update_client_approval($tID, $name, $date);
		
		$rID = $this->request->insert_request($tID, "PROD", $urgency, "In Queue", $revisionNumber, $deployDate, $uatInternalID);
		$this->change_type->link_prod_request($ctID, $rID);
		
	}
	
	function add_translation_request(){
		// $jsondata = $primaryKeyTaskID, $urgency, $revisionNumber, $deployDate, $translationDetails
		$translation = $data['translationDetails']['translation'];
		
		$rID = $this->request->insert_request($primaryKeyTaskID, "UAT", $urgency, "In Queue", $revisionNumber, $deployDate, NULL);
		
		if(count($translation) > 0){
			$this->create_new_translation_request((int)$rID[0]->insertedRequestID, $translation);
		}
	}
	
		//----------------------------
	function add_change_type($rID, $type){
		//type, "Translation", "Table",  "PM"
		$ctID = $this->change_type->insert_change_type($rID, $type);
		
		return $ctID;
	}
	
	function add_translation($ctID, $name, $testInternalID){
		$trID = $this->translation->insert_translation($ctID, $name, $testInternalID);
		
		return $trID;
	}
	
	function add_translation_change($trID, $changes){
		$this->translation->insert_translation_change($trID, $changes);
	}
	
	function add_impacted($trID, $sender, $receiver, $docType, $internalIDs){
		$this->translation->insert_impacted($trID, $sender, $receiver, $docType, $internalIDs);
	}
	
		//RECOMMENDATION-------------------------------------------------
	function add_recommendation($requestID, $recommendation, $userID) {
		$recommendationID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);
	}
	
	
	//UPDATE
	//--------------------------------------------------------------
	function update_project(){
		$this->request->update_project($pID, $newProjectID, $newProjectOwnerID);
	}
	
	function update_task(){
		$this->request->update_task($tID, $newTaskID, $newOwnerID, $newSender, $newReceiver, $newDocType, $newServer);
	}
	
	function update_request(){
		$this->request->update_request($rID, $newEnvironment, $newRevisionNumber, $newUrgency, $newDeployDate);
	}
	
	function update_translation(){
		$this->translation->update_translation($trID, $newName, $newInternalID);
	}
	
	function update_translation_changes(){
		$this->translation->update_translation_changes($tcID, $newChanges);
	}
	
	function update_impacted(){
		$this->translation->update_impacted($ID, $newSender,$newReceiver, $newDocType, $newInternalIDs);
	}
	
	function update_request_status_to_exported($rID){
		$this->request->update_status($rID, "Exported");
	}
	
	function assign_to_me($rID){
		$this->request->assign_request_to_me($rID, $this->session->userdata('user_id'));
	}
	
	function update_client_approval($tID, $name, $date){
		$this->request->update_client_approval($tID, $name, $date);
	}
}