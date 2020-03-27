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
	//Request data that use in view_request page
	function view_request($projectID, $taskID, $requestID)
	{
		if (!$this->session->userdata('logged_in')) {
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
	//Add Recommendation
	function add_recommendation($requestID, $recommendation, $userID)
	{

		$recommendationID = $this->recommendation->insert_recommendation($requestID, $recommendation, $userID);

		if ($recommendationID > 0) {
			return true;
		} else {
			return false;
		}
	}

	//SEARCH Request, use in ajax. Check if exist without submitting form
	//Check Project ID
	function search_project_id($projectID)
	{
		$result = $this->request->search_project_id($projectID);

		if ($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	//Check Task ID
	function search_task_id($taskID)
	{
		$result = $this->request->search_task_id($taskID);

		if ($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	//Check Revision number in specific environment
	function search_request($taskID, $environment, $revisionNumber)
	{
		$result = $this->request->search_request($taskID, $environment, $revisionNumber);

		if ($result > 0) {
			return true;
		} else {
			return false;
		}
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
