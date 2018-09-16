<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Masjid extends Base_controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
		$this->load->database();
		$this->load->model('basic');

		if(!$this->isLoggedIn()){
			redirect(site_url('admin/login'),'refresh');
		}
	}

	public function video_list(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "masjid/video_list");

		$data = array();
		$msgType = "";
		$msg = "";

		$masjidVideoListDataArr = array();
		$paginationLink = "";

		$masjidVideoListSearchFormNameInput = "";
		$masjidVideoListSearchFormCountryInput = "";
		$masjidVideoListSearchFormStateInput = "";
		$masjidVideoListSearchFormCityInput = "";

		$countryDataResult = "";
		$stateDataResult = "";
		$cityDataResult = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "masjidVideoListSearchFormSubmit")){
			$masjidVideoListSearchFormNameInput = $this->input->post("masjidVideoListSearchFormNameInput");
			$masjidVideoListSearchFormCountryInput = $this->input->post("masjidVideoListSearchFormCountryInput");
			$masjidVideoListSearchFormStateInput = $this->input->post("masjidVideoListSearchFormStateInput");
			$masjidVideoListSearchFormCityInput = $this->input->post("masjidVideoListSearchFormCityInput");

			$this->session->set_userdata("masjidVideoListSearchFormNameInput", $masjidVideoListSearchFormNameInput);
			$this->session->set_userdata("masjidVideoListSearchFormCountryInput", $masjidVideoListSearchFormCountryInput);
			$this->session->set_userdata("masjidVideoListSearchFormStateInput", $masjidVideoListSearchFormStateInput);
			$this->session->set_userdata("masjidVideoListSearchFormCityInput", $masjidVideoListSearchFormCityInput);
		}
		if(!empty($event) && !strcmp($event, "masjidVideoListSearchFormSubmitOnly")){
			$masjidVideoListSearchFormNameInput = $this->input->post("masjidVideoListSearchFormNameInput");
			$masjidVideoListSearchFormCountryInput = $this->input->post("masjidVideoListSearchFormCountryInput");
			$masjidVideoListSearchFormStateInput = $this->input->post("masjidVideoListSearchFormStateInput");
			$masjidVideoListSearchFormCityInput = $this->input->post("masjidVideoListSearchFormCityInput");
		}

		$where = array();
		if($this->session->userdata("masjidVideoListSearchFormNameInput") != ""){
			$masjidVideoListSearchFormNameInput = $this->session->userdata("masjidVideoListSearchFormNameInput");
			$where['where']["m_masjid.name LIKE "] = "%".$masjidVideoListSearchFormNameInput."%";
		}
		if($this->session->userdata("masjidVideoListSearchFormCountryInput") != ""){
			$masjidVideoListSearchFormCountryInput = $this->session->userdata("masjidVideoListSearchFormCountryInput");
			$where['where']["m_masjid.country_id"] = $masjidVideoListSearchFormCountryInput;
		}
		if($this->session->userdata("masjidVideoListSearchFormStateInput") != ""){
			$masjidVideoListSearchFormStateInput = $this->session->userdata("masjidVideoListSearchFormStateInput");
			$where['where']["m_masjid.state_id"] = $masjidVideoListSearchFormStateInput;
		}
		if($this->session->userdata("masjidVideoListSearchFormCityInput") != ""){
			$masjidVideoListSearchFormCityInput = $this->session->userdata("masjidVideoListSearchFormCityInput");
			$where['where']["m_masjid.city_id"] = $masjidVideoListSearchFormCityInput;
		}


		if(!empty($where) && count($where)>0){
			$masjidVideoListCountDataResult = $this->basic->get_data("m_masjid",$where,"","","",NULL,'m_masjid.uid DESC','',1);
			$totalRows = $masjidVideoListCountDataResult['extra_index']['num_rows'];

			$select = array("m_masjid.uid as uid", "m_masjid.name as name", "b_countries.country as country_name", "b_states.state as state_name", "b_cities.city as city_name", "m_masjid.homeurl as homeurl", "m_masjid.alive as alive");
			$join = array("b_countries"=>"b_countries.id=m_masjid.country_id, left", "b_states"=>"b_states.id=m_masjid.state_id, left", "b_cities"=>"b_cities.id=m_masjid.city_id, left");
			$masjidVideoListDataResult = $this->basic->get_data("m_masjid",$where,$select,$join,$limit,$start,'m_masjid.uid DESC');
		}
		else{
			$masjidVideoListCountDataResult = $this->basic->get_data("m_masjid",'','','','',NULL,'m_masjid.uid DESC','',1);
			$totalRows = $masjidVideoListCountDataResult['extra_index']['num_rows'];

			$select = array("m_masjid.uid as uid", "m_masjid.name as name", "b_countries.country as country_name", "b_states.state as state_name", "b_cities.city as city_name", "m_masjid.homeurl as homeurl", "m_masjid.alive as alive");
			$join = array("b_countries"=>"b_countries.id=m_masjid.country_id, left", "b_states"=>"b_states.id=m_masjid.state_id, left", "b_cities"=>"b_cities.id=m_masjid.city_id, left");
			$masjidVideoListDataResult = $this->basic->get_data("m_masjid","",$select,$join,$limit,$start,'m_masjid.uid DESC');
		}

		$this->init_pagination(site_url('admin/masjid/video_list'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();


		$i=0;
		foreach ($masjidVideoListDataResult as $masjidVideoListData) {
			$masjidVideoListDataArr[$i] = array(
				"uid" => $masjidVideoListData["uid"],
				"name" => $masjidVideoListData['name'],
				"country_name" => $masjidVideoListData['country_name'],
				"state_name" => $masjidVideoListData['state_name'],
				"city_name" => $masjidVideoListData['city_name'],
				"homeurl" => $masjidVideoListData['homeurl'],
				"alive" => $masjidVideoListData['alive']
			);
			$i++;	
		}


		// getting country data
		$countryDataResult = $this->basic->get_data("b_countries","","","","","",'b_countries.country ASC');
		// getting state data
		if(!empty($masjidVideoListSearchFormCountryInput)){
			$where = array("where"=>array("country_id"=>$masjidVideoListSearchFormCountryInput));
			$stateDataResult = $this->basic->get_data("b_states",$where,"","","","",'b_states.state ASC');
		}
		// getting language data
		if(!empty($masjidVideoListSearchFormStateInput)){
			$where = array("where"=>array("state_id"=>$masjidVideoListSearchFormStateInput));
			$cityDataResult = $this->basic->get_data("b_cities",$where,"","","","",'b_cities.city ASC');
		}


		$data['masjidVideoListSearchFormNameInput'] = $masjidVideoListSearchFormNameInput;
		$data['masjidVideoListSearchFormCountryInput'] = $masjidVideoListSearchFormCountryInput;
		$data['masjidVideoListSearchFormStateInput'] = $masjidVideoListSearchFormStateInput;
		$data['masjidVideoListSearchFormCityInput'] = $masjidVideoListSearchFormCityInput;

		$data["countryDataResult"] = $countryDataResult;
		$data["stateDataResult"] = $stateDataResult;
		$data["cityDataResult"] = $cityDataResult;

		$data["masjidVideoListDataArr"] = $masjidVideoListDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;


        $this->_O('admin/masjid_video_list', $data);		
	}

	public function getSateByCountry(){
		$stateDataArr = array();

		$countryID = $this->input->post("countryID", TRUE);

		$where = array("where"=>array("country_id"=>$countryID));
		$stateDataResult = $this->basic->get_data("b_states",$where,"","","","",'b_states.state ASC');

		if(count($stateDataResult) > 0){
			$i=0;
			foreach ($stateDataResult as $stateData) {
				$stateDataArr[$i] = array(
					"id" => $stateData['id'],
					"state" => $stateData['state']
				);
				$i++;
			}
		}

		echo json_encode(array("stateDataArr"=>$stateDataArr));
	}

	public function getCityByState(){
		$cityDataArr = array();

		$stateID = $this->input->post("stateID", TRUE);

		$where = array("where"=>array("state_id"=>$stateID));
		$cityDataResult = $this->basic->get_data("b_cities",$where,"","","","",'b_cities.city ASC');

		if(count($cityDataResult) > 0){
			$i=0;
			foreach ($cityDataResult as $cityData) {
				$cityDataArr[$i] = array(
					"id" => $cityData['id'],
					"city" => $cityData['city']
				);
				$i++;
			}
		}

		echo json_encode(array("cityDataArr"=>$cityDataArr));
	}

	public function addMasjidVideo(){
		$msgType = "";
		$msg = "";

		$masjidVideoListAddNameInput = $this->input->post("masjidVideoListAddNameInput");
		$masjidVideoListAddCountryInput = $this->input->post("masjidVideoListAddCountryInput");
		$masjidVideoListAddStateInput = $this->input->post("masjidVideoListAddStateInput");
		$masjidVideoListAddCityInput = $this->input->post("masjidVideoListAddCityInput");
		$masjidVideoListAddUrlInput = $this->input->post("masjidVideoListAddUrlInput");
		$masjidVideoListAddAliveInput = $this->input->post("masjidVideoListAddAliveInput");

		if(!empty($masjidVideoListAddNameInput) && !empty($masjidVideoListAddCountryInput) && !empty($masjidVideoListAddStateInput) && !empty($masjidVideoListAddCityInput) && !empty($masjidVideoListAddUrlInput) && $masjidVideoListAddAliveInput != ""){
			$select = array("uid");
			$where = array("country_id"=>$masjidVideoListAddCountryInput, "state_id"=>$masjidVideoListAddStateInput, "city_id"=>$masjidVideoListAddCityInput, "homeurl"=>$masjidVideoListAddUrlInput);
			if($this->basic->is_unique("m_masjid",$where,$select)){
				$data = array(
					"name"=>$masjidVideoListAddNameInput,
					"country_id"=>$masjidVideoListAddCountryInput,
					"state_id"=>$masjidVideoListAddStateInput,
					"city_id"=>$masjidVideoListAddCityInput,
					"homeurl"=>$masjidVideoListAddUrlInput,
					"alive"=>$masjidVideoListAddAliveInput
				);
				if($this->basic->insert_data("m_masjid",$data)){
					$msgType = "success";
					$msg = "This Masjid Video data saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Masjid Video data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Masjid Video data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Masjid Video required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function getMasjidVideoData(){
		$msgType = "";
		$msg = "";
		$masjidVideoDataResult = array();
		$stateDataArr = array();
		$cityDataArr = array();

		$masjidVideoID = $this->input->post("masjidVideoID");

		if(!empty($masjidVideoID)){
			$where = array("where"=>array("uid"=>$masjidVideoID));
			$masjidVideoDataResult = $this->basic->get_data("m_masjid",$where);

			$countryID = $masjidVideoDataResult[0]['country_id'];
			$where = array("where"=>array("country_id"=>$countryID));
			$stateDataResult = $this->basic->get_data("b_states",$where,"","","","",'b_states.state ASC');
			if(count($stateDataResult) > 0){
				$i=0;
				foreach ($stateDataResult as $stateData) {
					$stateDataArr[$i] = array(
						"id" => $stateData['id'],
						"state" => $stateData['state']
					);
					$i++;
				}
			}

			$stateID = $masjidVideoDataResult[0]['state_id'];
			$where = array("where"=>array("state_id"=>$stateID));
			$cityDataResult = $this->basic->get_data("b_cities",$where,"","","","",'b_cities.city ASC');
			if(count($cityDataResult) > 0){
				$i=0;
				foreach ($cityDataResult as $cityData) {
					$cityDataArr[$i] = array(
						"id" => $cityData['id'],
						"city" => $cityData['city']
					);
					$i++;
				}
			}


			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Masjid Video id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "masjidVideoDataResult"=>$masjidVideoDataResult, "stateDataArr"=>$stateDataArr, "cityDataArr"=>$cityDataArr));
	}

	public function updateMasjidVideoData(){
		$msgType = "";
		$msg = "";

		$masjidVideoListEditNameInput = $this->input->post("masjidVideoListEditNameInput", TRUE);
		$masjidVideoListEditCountryInput = $this->input->post("masjidVideoListEditCountryInput", TRUE);
		$masjidVideoListEditStateInput = $this->input->post("masjidVideoListEditStateInput", TRUE);
		$masjidVideoListEditCityInput = $this->input->post("masjidVideoListEditCityInput", TRUE);
		$masjidVideoListEditUrlInput = $this->input->post("masjidVideoListEditUrlInput", TRUE);
		$masjidVideoListEditAliveInput = $this->input->post("masjidVideoListEditAliveInput", TRUE);
		$masjidVideoID = $this->input->post("masjidVideoID", TRUE);

		if(!empty($masjidVideoListEditNameInput) && !empty($masjidVideoListEditCountryInput) && !empty($masjidVideoListEditStateInput) && !empty($masjidVideoListEditCityInput) && !empty($masjidVideoListEditUrlInput) && $masjidVideoListEditAliveInput != "" && !empty($masjidVideoID)){
			$select = array("uid");
			$where = array("uid != "=>$masjidVideoID, "country_id"=>$masjidVideoListEditCountryInput, "state_id"=>$masjidVideoListEditStateInput, "city_id"=>$masjidVideoListEditCityInput, "homeurl"=>$masjidVideoListEditUrlInput);
			if($this->basic->is_unique("m_masjid",$where,$select)){
				$where = array("uid"=>$masjidVideoID);
				$data = array("name"=>$masjidVideoListEditNameInput, "country_id"=>$masjidVideoListEditCountryInput, "state_id"=>$masjidVideoListEditStateInput, "city_id"=>$masjidVideoListEditCityInput, "homeurl"=>$masjidVideoListEditUrlInput, "alive"=>$masjidVideoListEditAliveInput);
				if($this->basic->update_data("m_masjid",$where,$data)){
					$msgType = "success";
					$msg = "Masjid Video data updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Masjid Video data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Masjid Video data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Masjid Video required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function deleteMasjidVideoData(){
		$msgType = "";
		$msg = "";

		$masjidVideoID = $this->input->post("masjidVideoID", TRUE);

		if(!empty($masjidVideoID)){
			$where = array("uid"=>$masjidVideoID);
			if($this->basic->delete_data("m_masjid",$where)){
				$msgType = "success";
				$msg = "This Masjid Video data deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Masjid Video data.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Masjid Video id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

}