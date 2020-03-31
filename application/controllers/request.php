<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{
	//load models
	function __construct()
	{
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
		$data['requests'] = $this->request->get_request($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['curr_request'] =  $this->request->get_current_request($requestID);
		mysqli_next_result($CI->db->conn_id);
		$data['translations'] = $this->translation->get_translation($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['translation_changes'] = $this->translation->get_translation_change($projectID, $taskID);
		mysqli_next_result($CI->db->conn_id);
		$data['impacted'] = $this->translation->get_impacted($projectID, $taskID);
		
		mysqli_next_result($CI->db->conn_id);
		$data['recommendations'] = $this->request->get_recommendations($requestID);

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

	function update(){
		$data['projectID'] = $this->input->post('projectID');
		$data['taskID'] = $this->input->post('taskID');
		$data['projectOwner'] = $this->input->post('projectOwner');
		$data['sender'] = $this->input->post('sender');
		$data['receiver'] = $this->input->post('receiver');
		$data['docType'] = $this->input->post('docType');

		//insert logic here

		//check if insert was successful

		echo json_encode($data);
	}
	
	//Add Recommendation
	function add_recommendation($requestID, $recommendation, $userID) {
		$recommendationID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);

		if ($recommendationID > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//SEARCH 
	//-----------------------------------------------------
	function search_project_id($projectID){
		$result = $this->request->search_project_id($projectID);

		if ($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function search_task_id($taskID){
		$result = $this->request->search_task_id($taskID);

		if ($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function search_request($taskID, $environment, $revisionNumber){
		$result = $this->request-> search_request($taskID, $environment, $revisionNumber);
		
		if($result > 0){
			return true;
		} else {
			return false;
		}
	}
	
	//INSERT
	//-----------------------------------------------------------
	
	function add_request(){
		
		$pID = $this->request->insert_project($projectID, $projectOwnerID);
		$tID = $this->request->insert_task($taskID, $pID, $ownerID, $sender, $receiver, $docType);	
		$rID = $this->request->insert_request($tID, $environment, $urgency, $status, $revisionNumber, $requestDate);
		
		// foreach($  as $translation)
			$ctID = $this->change_type->insert_change_type($rID, "Translation");
			$trID = $this->translation->insert_translation($ctID, $name, $internalID);
			$this->translation->insert_translation_change($trID, $changes);
					
				// foreach($formImpacted as $impacted)
					$this->translation->insert_impacted($trID, $sender, $receiver, $docType, $internalIDs);
		
		return true;		
	}
	
	//UPDATE
	//--------------------------------------------------------------
	function update_request(){
		
		$this->request->update_project($pID, $newProjectID, $newProjectOwnerID);
		$this->request->update_task($tID, $newTaskID, $newOwnerID, $newSender, $newReceiver, $newDocType);
		$this->request->update_request($rID, $newEnvironment, $newRevisionNumber, $newUrgency, $newDeployDate);
		
		// foreach($  as $translation)
			$this->translation->update_translation($trID, $newName, $newInternalID);
			$this->translation->update_translation_changes($tcID, $newChanges);
		
		// foreach($formImpacted as $impacted)
			$this->translation->update_impacted($ID, $newSender,$newReceiver, $newDocType, $newInternalIDs);
		
		return true;
	}
	
	function update_status(){
		 
		$this->request->update_status($rID, $newStatus);
	}
	
	function assign_to_me(){
		
		$this->request->assign_request_to_me($rID, $this->session->userdata('user_id'));
	}
	
	
	

	function save()
	{
		$data = json_decode('{"project":{"projectId":"45678","taskId":"456789","projectOwner":"Dememor Mendoza","documentType":"PurchaseOrder","projectOwnerId":"1","senderID":"mdpl-au","receiverID":"mdp-nz","server":"MapEU","highlightNote":"","devLog":"","requestDate":"03/10/2020","deployDate":"03/10/2020"},"translationDetails":{"translation":{"0":{"testId":"987654654","translationName":"mdpl-automdp-nzcustom","releaseAsDocType":"PurchaseOrder","translationChange":"asdgasdgadgadsgadsfasdfdsf","impacted":{"0":{"sender":"","recever":"","documentType":"","testvslive":""}}}}}}',true);
		//$data = json_decode($this->input->post("data"),true); //$data = json_decode($jsonData, true); //
		$response = array();
		$project = $data['project'];
		$translation = $data['translationDetails']['translation'];
		$insertedProjectID = $this->request->insert_project($project['projectId'], (int)$project['projectOwnerId']);

		$insertedTaskID = $this->request->insert_task((int)$project['taskId'], (int)$insertedProjectID[0]->insertedProjectID, (int)$project['projectOwnerId'], $project['senderID'], $project['receiverID'], $project['documentType']);
		 for($i =0; $i < count($translation); $i++)
		 {
			$testId = $translation[$i]['testId'];
			$translationName = $translation[$i]['translationName'];
			$translationChange = $translation[$i]['translationChange'];

			$insertedTranslationID = $this->request->insert_translation(1, $translationName, (int)$testId);
			$insertTranslationChangeID = $this->request->insert_translation_change((int)$insertedTranslationID[0]->translationID, $translationChange);
			$impacted = $translation[$i]['impacted'];
			for($j =0; $j < count($impacted); $j++)
			{
				$docType = $impacted[$j]['documentType'];
				$sender = $impacted[$j]['sender'];
				$receiver = $impacted[$j]['recever'];
				$internalIDs = $impacted[$j]['testvslive'];
				if(strlen($docType) ==0 && strlen($sender) ==0 &&strlen($receiver) ==0 &&strlen($internalIDs) ==0){
					$impactedID = $this->request->insert_impacted((int)$insertedTranslationID[0]->translationID, $sender, $receiver, $docType, $internalIDs);

				}
			}
		 }
		 $response =array("id" => $insertedProjectID[0]->insertedProjectID,"taskID" => $insertedTaskID[0]->insertedIndexID,"translationID" => $insertedTranslationID[0]->translationID,"translationChangeID" => $insertTranslationChangeID[0]->translationID,"impactedID" => $impactedID[0]->translationID);
		  
		 echo json_encode($response);
	}
}
