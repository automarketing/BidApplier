<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Channelvod extends Base_controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
		$this->load->database();
		$this->load->model('basic');
		$this->load->model('user_model');

		if(!$this->isLoggedIn()){
			redirect(site_url('admin/login'),'refresh');
		}
	}

/* ----- Country starts here -----*/

	public function country(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/country");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$countryDataArr = array();
		$paginationLink = "";
		$countrySearchFormCountryInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "countrySearchFormSubmit")){
			$countrySearchFormCountryInput = $this->input->post("countrySearchFormCountryInput");

			$this->session->set_userdata("countrySearchFormCountryInput", $countrySearchFormCountryInput);
		}

		$where = array();
		if($this->session->userdata("countrySearchFormCountryInput") != ""){
			$countrySearchFormCountryInput = $this->session->userdata("countrySearchFormCountryInput");

			$where['where']["b_countries.country LIKE "] = "%".$countrySearchFormCountryInput."%";
		}

		if(!empty($where) && count($where)>0){
			$countryCountDataResult = $this->basic->get_data("b_countries",$where,"","","",NULL,'b_countries.country ASC','',1);
			$totalRows = $countryCountDataResult['extra_index']['num_rows'];

			$countryDataResult = $this->basic->get_data("b_countries",$where,"","",$limit,$start,'b_countries.country ASC');
		}
		else{
			$countryCountDataResult = $this->basic->get_data("b_countries",'','','','',NULL,'b_countries.country ASC','',1);
			$totalRows = $countryCountDataResult['extra_index']['num_rows'];

			$countryDataResult = $this->basic->get_data("b_countries","","","",$limit,$start,'b_countries.country ASC');
		}

		$this->init_pagination(site_url('admin/channelvod/country'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($countryDataResult as $countryData) {
			$countryDataArr[$i] = array(
				"id" => $countryData["id"],
				"country" => $countryData['country']
			);
			$i++;
		}

		// echo "<pre>";
		// print_r($countryResult);
		// echo "<pre>";

		$data['countrySearchFormCountryInput'] = $countrySearchFormCountryInput;

		$data["countryDataArr"] = $countryDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/country_list', $data);
	}

	public function addCountryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$countryInput = $this->input->post("countryInput");

		if(!empty($countryInput)){
			$select = array("id");
			$where = array("country"=>$countryInput);
			if($this->basic->is_unique("b_countries",$where,$select)){
				$data = array("country"=>$countryInput);
				if($this->basic->insert_data("b_countries",$data)){
					$msgType = "success";
					$msg = "This Country is saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Country.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Country is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Country cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function getCountryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$countryID = $this->input->post("countryID");

		if(!empty($countryID)){
			$where = array("where"=>array("id"=>$countryID));
			$countryDataResult = $this->basic->get_data("b_countries",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Country id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$countryDataResult));
	}

	public function updateCountryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$countryEditInput = $this->input->post("countryEditInput", TRUE);
		$countryID = $this->input->post("countryID", TRUE);

		if(!empty($countryEditInput) && !empty($countryID)){
			$select = array("id");
			$where = array("id != "=>$countryID, "country"=>$countryEditInput);
			if($this->basic->is_unique("b_countries",$where,$select)){
				$where = array("id"=>$countryID);
				$data = array("country"=>$countryEditInput);
				if($this->basic->update_data("b_countries",$where,$data)){
					$msgType = "success";
					$msg = "Country updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Country.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Country is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Country and Country id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function deleteCountryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$countryID = $this->input->post("countryID", TRUE);

		if(!empty($countryID)){
			$where = array("id"=>$countryID);
			if($this->basic->delete_data("b_countries",$where)){
				$msgType = "success";
				$msg = "This Country deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Country.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Country id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Country ends here -----*/

/* ----- Category starts here -----*/

	public function category(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/category");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$categoryDataArr = array();
		$paginationLink = "";
		$categorySearchFormCategoryInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "categorySearchFormSubmit")){
			$categorySearchFormCategoryInput = $this->input->post("categorySearchFormCategoryInput");

			$this->session->set_userdata("categorySearchFormCategoryInput", $categorySearchFormCategoryInput);
		}

		$where = array();
		if($this->session->userdata("categorySearchFormCategoryInput") != ""){
			$categorySearchFormCategoryInput = $this->session->userdata("categorySearchFormCategoryInput");

			$where['where']["l_category.category LIKE "] = "%".$categorySearchFormCategoryInput."%";
		}

		if(!empty($where) && count($where)>0){
			$categoryCountDataResult = $this->basic->get_data("l_category",$where,"","","",NULL,'l_category.category ASC','',1);
			$totalRows = $categoryCountDataResult['extra_index']['num_rows'];

			$categoryDataResult = $this->basic->get_data("l_category",$where,"","",$limit,$start,'l_category.category ASC');
		}
		else{
			$categoryCountDataResult = $this->basic->get_data("l_category",'','','','',NULL,'l_category.category ASC','',1);
			$totalRows = $categoryCountDataResult['extra_index']['num_rows'];

			$categoryDataResult = $this->basic->get_data("l_category","","","",$limit,$start,'l_category.category ASC');
		}

		$this->init_pagination(site_url('admin/channelvod/category'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($categoryDataResult as $categoryData) {
			$categoryDataArr[$i] = array(
				"uid" => $categoryData["uid"],
				"category" => $categoryData['category']
			);
			$i++;
		}

		// echo "<pre>";
		// print_r($categoryResult);
		// echo "<pre>";

		$data['categorySearchFormCategoryInput'] = $categorySearchFormCategoryInput;

		$data["categoryDataArr"] = $categoryDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/category_list', $data);
	}


	public function addCategoryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$categoryInput = $this->input->post("categoryInput");

		if(!empty($categoryInput)){
			$select = array("uid");
			$where = array("category"=>$categoryInput);
			if($this->basic->is_unique("l_category",$where,$select)){
				$data = array("category"=>$categoryInput);
				if($this->basic->insert_data("l_category",$data)){
					$msgType = "success";
					$msg = "This Category is saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Category.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Category is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Category cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function getCategoryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$categoryID = $this->input->post("categoryID");

		if(!empty($categoryID)){
			$where = array("where"=>array("uid"=>$categoryID));
			$categoryDataResult = $this->basic->get_data("l_category",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Category id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$categoryDataResult));
	}

	public function updateCategoryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$categoryEditInput = $this->input->post("categoryEditInput", TRUE);
		$categoryID = $this->input->post("categoryID", TRUE);

		if(!empty($categoryEditInput) && !empty($categoryID)){
			$select = array("uid");
			$where = array("uid != "=>$categoryID, "category"=>$categoryEditInput);
			if($this->basic->is_unique("l_category",$where,$select)){
				$where = array("uid"=>$categoryID);
				$data = array("category"=>$categoryEditInput);
				if($this->basic->update_data("l_category",$where,$data)){
					$msgType = "success";
					$msg = "Category updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Category.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Category is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Category and Category id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function deleteCategoryData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$categoryID = $this->input->post("categoryID", TRUE);

		if(!empty($categoryID)){
			$where = array("uid"=>$categoryID);
			if($this->basic->delete_data("l_category",$where)){
				$msgType = "success";
				$msg = "This Category deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Category.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Category id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Category ends here -----*/


/* ----- Company starts here -----*/

	public function company(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/company");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$companyDataArr = array();
		$paginationLink = "";
		$companySearchFormCompanyInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "companySearchFormSubmit")){
			$companySearchFormCompanyInput = $this->input->post("companySearchFormCompanyInput");

			$this->session->set_userdata("companySearchFormCompanyInput", $companySearchFormCompanyInput);
		}

		$where = array();
		if($this->session->userdata("companySearchFormCompanyInput") != ""){
			$companySearchFormCompanyInput = $this->session->userdata("companySearchFormCompanyInput");

			$where['where']["l_company.company LIKE "] = "%".$companySearchFormCompanyInput."%";
		}

		if(!empty($where) && count($where)>0){
			$companyCountDataResult = $this->basic->get_data("l_company",$where,"","","",NULL,'l_company.company ASC','',1);
			$totalRows = $companyCountDataResult['extra_index']['num_rows'];

			$companyDataResult = $this->basic->get_data("l_company",$where,"","",$limit,$start,'l_company.company ASC');
		}
		else{
			$companyCountDataResult = $this->basic->get_data("l_company",'','','','',NULL,'l_company.company ASC','',1);
			$totalRows = $companyCountDataResult['extra_index']['num_rows'];

			$companyDataResult = $this->basic->get_data("l_company","","","",$limit,$start,'l_company.company ASC');
		}

		$this->init_pagination(site_url('admin/channelvod/company'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($companyDataResult as $companyData) {
			$companyDataArr[$i] = array(
				"uid" => $companyData["uid"],
				"company" => $companyData['company']
			);
			$i++;
		}

		// echo "<pre>";
		// print_r($companyResult);
		// echo "<pre>";

		$data['companySearchFormCompanyInput'] = $companySearchFormCompanyInput;

		$data["companyDataArr"] = $companyDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/company_list', $data);
	}


	public function addCompanyData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$companyInput = $this->input->post("companyInput");

		if(!empty($companyInput)){
			$select = array("uid");
			$where = array("company"=>$companyInput);
			if($this->basic->is_unique("l_company",$where,$select)){
				$data = array("company"=>$companyInput);
				if($this->basic->insert_data("l_company",$data)){
					$msgType = "success";
					$msg = "This Company is saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Company.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Company is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Company cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function getCompanyData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$companyID = $this->input->post("companyID");

		if(!empty($companyID)){
			$where = array("where"=>array("uid"=>$companyID));
			$companyDataResult = $this->basic->get_data("l_company",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Company id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$companyDataResult));
	}

	public function updateCompanyData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$companyEditInput = $this->input->post("companyEditInput", TRUE);
		$companyID = $this->input->post("companyID", TRUE);

		if(!empty($companyEditInput) && !empty($companyID)){
			$select = array("uid");
			$where = array("uid != "=>$companyID, "company"=>$companyEditInput);
			if($this->basic->is_unique("l_company",$where,$select)){
				$where = array("uid"=>$companyID);
				$data = array("company"=>$companyEditInput);
				if($this->basic->update_data("l_company",$where,$data)){
					$msgType = "success";
					$msg = "Company updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Company.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Company is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Company and Company id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function deleteCompanyData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$companyID = $this->input->post("companyID", TRUE);

		if(!empty($companyID)){
			$where = array("uid"=>$companyID);
			if($this->basic->delete_data("l_company",$where)){
				$msgType = "success";
				$msg = "This Company deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Company.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Company id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Company ends here -----*/


/* ----- Language starts here -----*/

	public function language(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/language");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$languageDataArr = array();
		$paginationLink = "";
		$languageSearchFormLanguageInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "languageSearchFormSubmit")){
			$languageSearchFormLanguageInput = $this->input->post("languageSearchFormLanguageInput");

			$this->session->set_userdata("languageSearchFormLanguageInput", $languageSearchFormLanguageInput);
		}

		$where = array();
		if($this->session->userdata("languageSearchFormLanguageInput") != ""){
			$languageSearchFormLanguageInput = $this->session->userdata("languageSearchFormLanguageInput");

			$where['where']["b_language.language LIKE "] = "%".$languageSearchFormLanguageInput."%";
		}

		if(!empty($where) && count($where)>0){
			$languageCountDataResult = $this->basic->get_data("b_language",$where,"","","",NULL,'b_language.language ASC','',1);
			$totalRows = $languageCountDataResult['extra_index']['num_rows'];

			$languageDataResult = $this->basic->get_data("b_language",$where,"","",$limit,$start,'b_language.language ASC');
		}
		else{
			$languageCountDataResult = $this->basic->get_data("b_language",'','','','',NULL,'b_language.language ASC','',1);
			$totalRows = $languageCountDataResult['extra_index']['num_rows'];

			$languageDataResult = $this->basic->get_data("b_language","","","",$limit,$start,'b_language.language ASC');
		}

		$this->init_pagination(site_url('admin/channelvod/language'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($languageDataResult as $languageData) {
			$languageDataArr[$i] = array(
				"uid" => $languageData["uid"],
				"language" => $languageData['language']
			);
			$i++;
		}

		// echo "<pre>";
		// print_r($languageResult);
		// echo "<pre>";

		$data['languageSearchFormLanguageInput'] = $languageSearchFormLanguageInput;

		$data["languageDataArr"] = $languageDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/language_list', $data);
	}


	public function addLanguageData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$languageInput = $this->input->post("languageInput");

		if(!empty($languageInput)){
			$select = array("uid");
			$where = array("language"=>$languageInput);
			if($this->basic->is_unique("b_language",$where,$select)){
				$data = array("language"=>$languageInput);
				if($this->basic->insert_data("b_language",$data)){
					$msgType = "success";
					$msg = "This Language is saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Language.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Language is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Language cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function getLanguageData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$languageID = $this->input->post("languageID");

		if(!empty($languageID)){
			$where = array("where"=>array("uid"=>$languageID));
			$languageDataResult = $this->basic->get_data("b_language",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Language id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$languageDataResult));
	}

	public function updateLanguageData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$languageEditInput = $this->input->post("languageEditInput", TRUE);
		$languageID = $this->input->post("languageID", TRUE);

		if(!empty($languageEditInput) && !empty($languageID)){
			$select = array("uid");
			$where = array("uid != "=>$languageID, "language"=>$languageEditInput);
			if($this->basic->is_unique("b_language",$where,$select)){
				$where = array("uid"=>$languageID);
				$data = array("language"=>$languageEditInput);
				if($this->basic->update_data("b_language",$where,$data)){
					$msgType = "success";
					$msg = "Language updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Language.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Language is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Language and Language id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function deleteLanguageData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$languageID = $this->input->post("languageID", TRUE);

		if(!empty($languageID)){
			$where = array("uid"=>$languageID);
			if($this->basic->delete_data("b_language",$where)){
				$msgType = "success";
				$msg = "This Language deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Language.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Language id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Language ends here -----*/


/* ----- Vod starts here -----*/

	public function vod(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/vod");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$vodDataArr = array();
		$paginationLink = "";

		$vodSearchFormCategoryInput = "";
		$vodSearchFormCountryInput = "";
		$vodSearchFormCompanyInput = "";
		$vodSearchFormLanguageInput = "";
		$vodSearchFormUrlInput = "";
		$vodSearchFormLiveInput = "";
		$vodSearchFormDateInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "vodSearchFormSubmit")){
			$vodSearchFormCategoryInput = $this->input->post("vodSearchFormCategoryInput");
			$vodSearchFormCountryInput = $this->input->post("vodSearchFormCountryInput");
			$vodSearchFormCompanyInput = $this->input->post("vodSearchFormCompanyInput");
			$vodSearchFormLanguageInput = $this->input->post("vodSearchFormLanguageInput");
			$vodSearchFormUrlInput = $this->input->post("vodSearchFormUrlInput");
			$vodSearchFormLiveInput = $this->input->post("vodSearchFormLiveInput");
			$vodSearchFormDateInput = $this->input->post("vodSearchFormDateInput");

			$this->session->set_userdata("vodSearchFormCategoryInput", $vodSearchFormCategoryInput);
			$this->session->set_userdata("vodSearchFormCountryInput", $vodSearchFormCountryInput);
			$this->session->set_userdata("vodSearchFormCompanyInput", $vodSearchFormCompanyInput);
			$this->session->set_userdata("vodSearchFormLanguageInput", $vodSearchFormLanguageInput);
			$this->session->set_userdata("vodSearchFormUrlInput", $vodSearchFormUrlInput);
			$this->session->set_userdata("vodSearchFormLiveInput", $vodSearchFormLiveInput);
			$this->session->set_userdata("vodSearchFormDateInput", $vodSearchFormDateInput);
		}

		$where = array();
		if($this->session->userdata("vodSearchFormCategoryInput") != ""){
			$vodSearchFormCategoryInput = $this->session->userdata("vodSearchFormCategoryInput");
			$where['where']["v_vod.category"] = $vodSearchFormCategoryInput;
		}
		if($this->session->userdata("vodSearchFormCountryInput") != ""){
			$vodSearchFormCountryInput = $this->session->userdata("vodSearchFormCountryInput");
			$where['where']["v_vod.country"] = $vodSearchFormCountryInput;
		}
		if($this->session->userdata("vodSearchFormCompanyInput") != ""){
			$vodSearchFormCompanyInput = $this->session->userdata("vodSearchFormCompanyInput");
			$where['where']["v_vod.company"] = $vodSearchFormCompanyInput;
		}
		if($this->session->userdata("vodSearchFormLanguageInput") != ""){
			$vodSearchFormLanguageInput = $this->session->userdata("vodSearchFormLanguageInput");
			$where['where']["v_vod.language"] = $vodSearchFormLanguageInput;
		}
		if($this->session->userdata("vodSearchFormUrlInput") != ""){
			$vodSearchFormUrlInput = $this->session->userdata("vodSearchFormUrlInput");
			$where['where']["v_vod.url LIKE "] = "%".$vodSearchFormUrlInput."%";
		}
		if($this->session->userdata("vodSearchFormLiveInput") != ""){
			$vodSearchFormLiveInput = $this->session->userdata("vodSearchFormLiveInput");
			$where['where']["v_vod.alive"] = $vodSearchFormLiveInput;
		}
		if($this->session->userdata("vodSearchFormDateInput") != ""){
			$vodSearchFormDateInput = $this->session->userdata("vodSearchFormDateInput");
			$where['where']["v_vod.date"] = $vodSearchFormDateInput;
		}


		if(!empty($where) && count($where)>0){
			$vodCountDataResult = $this->basic->get_data("v_vod",$where,"","","",NULL,'v_vod.uid DESC','',1);
			$totalRows = $vodCountDataResult['extra_index']['num_rows'];

			$select = array("v_vod.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "v_vod.url as url", "v_vod.alive as alive", "v_vod.date as date");
			$join = array("l_category"=>"l_category.uid=v_vod.category, left", "b_countries"=>"b_countries.id=v_vod.country, left", "l_company"=>"l_company.uid=v_vod.company, left", "b_language"=>"b_language.uid=v_vod.language, left");
			$vodDataResult = $this->basic->get_data("v_vod",$where,$select,$join,$limit,$start,'v_vod.uid DESC');
		}
		else{
			$vodCountDataResult = $this->basic->get_data("v_vod",'','','','',NULL,'v_vod.uid DESC','',1);
			$totalRows = $vodCountDataResult['extra_index']['num_rows'];

			$select = array("v_vod.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "v_vod.url as url", "v_vod.alive as alive", "v_vod.date as date");
			$join = array("l_category"=>"l_category.uid=v_vod.category, left", "b_countries"=>"b_countries.id=v_vod.country, left", "l_company"=>"l_company.uid=v_vod.company, left", "b_language"=>"b_language.uid=v_vod.language, left");
			$vodDataResult = $this->basic->get_data("v_vod","",$select,$join,$limit,$start,'v_vod.uid DESC');
		}

		$this->init_pagination(site_url('admin/channelvod/vod'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($vodDataResult as $vodData) {
			$vodDataArr[$i] = array(
				"uid" => $vodData["uid"],
				"category_name" => $vodData['category_name'],
				"country_name" => $vodData['country_name'],
				"company_name" => $vodData['company_name'],
				"language_name" => $vodData['language_name'],
				"url" => $vodData['url'],
				"alive" => $vodData['alive'],
				"date" => $vodData['date']
			);
			$i++;
		}

		// getting category data
		$categoryDataResult = $this->basic->get_data("l_category","","","","","",'l_category.category ASC');
		// getting country data
		$countryDataResult = $this->basic->get_data("b_countries","","","","","",'b_countries.country ASC');
		// getting company data
		$companyDataResult = $this->basic->get_data("l_company","","","","","",'l_company.company ASC');
		// getting language data
		$languageDataResult = $this->basic->get_data("b_language","","","","","",'b_language.language ASC');


		$data['vodSearchFormCategoryInput'] = $vodSearchFormCategoryInput;
		$data['vodSearchFormCountryInput'] = $vodSearchFormCountryInput;
		$data['vodSearchFormCompanyInput'] = $vodSearchFormCompanyInput;
		$data['vodSearchFormLanguageInput'] = $vodSearchFormLanguageInput;
		$data['vodSearchFormUrlInput'] = $vodSearchFormUrlInput;
		$data['vodSearchFormLiveInput'] = $vodSearchFormLiveInput;
		$data['vodSearchFormDateInput'] = $vodSearchFormDateInput;

		$data["categoryDataResult"] = $categoryDataResult;
		$data["countryDataResult"] = $countryDataResult;
		$data["companyDataResult"] = $companyDataResult;
		$data["languageDataResult"] = $languageDataResult;

		$data["vodDataArr"] = $vodDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/vod_list', $data);
	}


	public function addVodData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$vodCategoryInput = $this->input->post("vodCategoryInput");
		$vodCountryInput = $this->input->post("vodCountryInput");
		$vodCompanyInput = $this->input->post("vodCompanyInput");
		$vodLanguageInput = $this->input->post("vodLanguageInput");
		$vodUrlInput = $this->input->post("vodUrlInput");
		$vodAliveInput = $this->input->post("vodAliveInput");
		$vodDateInput = $this->input->post("vodDateInput");

		if(!empty($vodCategoryInput) && !empty($vodCountryInput) && !empty($vodCompanyInput) && !empty($vodLanguageInput)
			&& !empty($vodUrlInput) && $vodAliveInput != "" && !empty($vodDateInput)){
			$select = array("uid");
			$where = array("category"=>$vodCategoryInput, "country"=>$vodCountryInput, "company"=>$vodCompanyInput, "language"=>$vodLanguageInput);
			if($this->basic->is_unique("v_vod",$where,$select)){
				$data = array("category"=>$vodCategoryInput,"country"=>$vodCountryInput,"company"=>$vodCompanyInput,"language"=>$vodLanguageInput,"url"=>$vodUrlInput,"alive"=>$vodAliveInput,"date"=>$vodDateInput);
				if($this->basic->insert_data("v_vod",$data)){
					$msgType = "success";
					$msg = "This VOD data saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This VOD data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This VOD data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "VOD required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function getVodData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$vodID = $this->input->post("vodID");

		if(!empty($vodID)){
			$where = array("where"=>array("uid"=>$vodID));
			$vodDataResult = $this->basic->get_data("v_vod",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "VOD id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$vodDataResult));
	}

	public function updateVodData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$vodEditCategoryInput = $this->input->post("vodEditCategoryInput", TRUE);
		$vodEditCountryInput = $this->input->post("vodEditCountryInput", TRUE);
		$vodEditCompanyInput = $this->input->post("vodEditCompanyInput", TRUE);
		$vodEditLanguageInput = $this->input->post("vodEditLanguageInput", TRUE);
		$vodEditUrlInput = $this->input->post("vodEditUrlInput", TRUE);
		$vodEditAliveInput = $this->input->post("vodEditAliveInput", TRUE);
		$vodEditDateInput = $this->input->post("vodEditDateInput", TRUE);
		$vodID = $this->input->post("vodID", TRUE);

		if(!empty($vodEditCategoryInput) && !empty($vodEditCountryInput) && !empty($vodEditCompanyInput) && !empty($vodEditLanguageInput) &&
			!empty($vodEditUrlInput) && $vodEditAliveInput != "" && !empty($vodEditDateInput) && !empty($vodID)){
			$select = array("uid");
			$where = array("uid != "=>$vodID, "category"=>$vodEditCategoryInput, "country"=>$vodEditCountryInput, "company"=>$vodEditCompanyInput, "language"=>$vodEditLanguageInput);
			if($this->basic->is_unique("v_vod",$where,$select)){
				$where = array("uid"=>$vodID);
				$data = array("category"=>$vodEditCategoryInput, "country"=>$vodEditCountryInput, "company"=>$vodEditCompanyInput, "language"=>$vodEditLanguageInput, "url"=>$vodEditUrlInput, "alive"=>$vodEditAliveInput, "date"=>$vodEditDateInput);
				if($this->basic->update_data("v_vod",$where,$data)){
					$msgType = "success";
					$msg = "VOD data updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update VOD data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This VOD data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "VOD required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function deleteVodData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$vodID = $this->input->post("vodID", TRUE);

		if(!empty($vodID)){
			$where = array("uid"=>$vodID);
			if($this->basic->delete_data("v_vod",$where)){
				$msgType = "success";
				$msg = "This VOD data deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This VOD data.";
			}
		}
		else{
			$msgType = "error";
			$msg = "VOD id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Vod ends here -----*/


/* ----- Channel starts here -----*/

	public function channel(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "channelvod/channel");
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");


		$data = array();
		$msgType = "";
		$msg = "";

		$channelDataArr = array();
		$paginationLink = "";

		$channelSearchFormCategoryInput = "";
		$channelSearchFormCountryInput = "";
		$channelSearchFormCompanyInput = "";
		$channelSearchFormLanguageInput = "";
		$channelSearchFormUrlInput = "";
		$channelSearchFormLiveInput = "";
		$channelSearchFormDateInput = "";


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "channelSearchFormSubmit")){
			$channelSearchFormCategoryInput = $this->input->post("channelSearchFormCategoryInput");
			$channelSearchFormCountryInput = $this->input->post("channelSearchFormCountryInput");
			$channelSearchFormCompanyInput = $this->input->post("channelSearchFormCompanyInput");
			$channelSearchFormLanguageInput = $this->input->post("channelSearchFormLanguageInput");
			$channelSearchFormUrlInput = $this->input->post("channelSearchFormUrlInput");
			$channelSearchFormLiveInput = $this->input->post("channelSearchFormLiveInput");
			$channelSearchFormDateInput = $this->input->post("channelSearchFormDateInput");

			$this->session->set_userdata("channelSearchFormCategoryInput", $channelSearchFormCategoryInput);
			$this->session->set_userdata("channelSearchFormCountryInput", $channelSearchFormCountryInput);
			$this->session->set_userdata("channelSearchFormCompanyInput", $channelSearchFormCompanyInput);
			$this->session->set_userdata("channelSearchFormLanguageInput", $channelSearchFormLanguageInput);
			$this->session->set_userdata("channelSearchFormUrlInput", $channelSearchFormUrlInput);
			$this->session->set_userdata("channelSearchFormLiveInput", $channelSearchFormLiveInput);
			$this->session->set_userdata("channelSearchFormDateInput", $channelSearchFormDateInput);
		}

		$where = array();
		if($this->session->userdata("channelSearchFormCategoryInput") != ""){
			$channelSearchFormCategoryInput = $this->session->userdata("channelSearchFormCategoryInput");
			$where['where']["l_channel.category"] = $channelSearchFormCategoryInput;
		}
		if($this->session->userdata("channelSearchFormCountryInput") != ""){
			$channelSearchFormCountryInput = $this->session->userdata("channelSearchFormCountryInput");
			$where['where']["l_channel.country"] = $channelSearchFormCountryInput;
		}
		if($this->session->userdata("channelSearchFormCompanyInput") != ""){
			$channelSearchFormCompanyInput = $this->session->userdata("channelSearchFormCompanyInput");
			$where['where']["l_channel.company"] = $channelSearchFormCompanyInput;
		}
		if($this->session->userdata("channelSearchFormLanguageInput") != ""){
			$channelSearchFormLanguageInput = $this->session->userdata("channelSearchFormLanguageInput");
			$where['where']["l_channel.language"] = $channelSearchFormLanguageInput;
		}
		if($this->session->userdata("channelSearchFormUrlInput") != ""){
			$channelSearchFormUrlInput = $this->session->userdata("channelSearchFormUrlInput");
			$where['where']["l_channel.url LIKE "] = "%".$channelSearchFormUrlInput."%";
		}
		if($this->session->userdata("channelSearchFormLiveInput") != ""){
			$channelSearchFormLiveInput = $this->session->userdata("channelSearchFormLiveInput");
			$where['where']["l_channel.alive"] = $channelSearchFormLiveInput;
		}
		if($this->session->userdata("channelSearchFormDateInput") != ""){
			$channelSearchFormDateInput = $this->session->userdata("channelSearchFormDateInput");
			$where['where']["l_channel.date"] = $channelSearchFormDateInput;
		}

		if(!empty($where) && count($where)>0){
			$channelCountDataResult = $this->basic->get_data("l_channel",$where,"","","",NULL,'l_channel.uid DESC','',1);
			$totalRows = $channelCountDataResult['extra_index']['num_rows'];

			$select = array("l_channel.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "l_channel.url as url", "l_channel.alive as alive", "l_channel.date as date");
			$join = array("l_category"=>"l_category.uid=l_channel.category, left", "b_countries"=>"b_countries.id=l_channel.country, left", "l_company"=>"l_company.uid=l_channel.company, left", "b_language"=>"b_language.uid=l_channel.language, left");
			$channelDataResult = $this->basic->get_data("l_channel",$where,$select,$join,$limit,$start,'l_channel.uid DESC');
		}
		else{
			$channelCountDataResult = $this->basic->get_data("l_channel",'','','','',NULL,'l_channel.uid DESC','',1);
			$totalRows = $channelCountDataResult['extra_index']['num_rows'];

			$select = array("l_channel.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "l_channel.url as url", "l_channel.alive as alive", "l_channel.date as date");
			$join = array("l_category"=>"l_category.uid=l_channel.category, left", "b_countries"=>"b_countries.id=l_channel.country, left", "l_company"=>"l_company.uid=l_channel.company, left", "b_language"=>"b_language.uid=l_channel.language, left");
			$channelDataResult = $this->basic->get_data("l_channel","",$select,$join,$limit,$start,'l_channel.uid DESC');
		}

		$this->init_pagination(site_url('admin/channelvod/channel'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($channelDataResult as $channelData) {
			$channelDataArr[$i] = array(
				"uid" => $channelData["uid"],
				"category_name" => $channelData['category_name'],
				"country_name" => $channelData['country_name'],
				"company_name" => $channelData['company_name'],
				"language_name" => $channelData['language_name'],
				"url" => $channelData['url'],
				"alive" => $channelData['alive'],
				"date" => $channelData['date']
			);
			$i++;
		}

		// getting category data
		$categoryDataResult = $this->basic->get_data("l_category","","","","","",'l_category.category ASC');
		// getting country data
		$countryDataResult = $this->basic->get_data("b_countries","","","","","",'b_countries.country ASC');
		// getting company data
		$companyDataResult = $this->basic->get_data("l_company","","","","","",'l_company.company ASC');
		// getting language data
		$languageDataResult = $this->basic->get_data("b_language","","","","","",'b_language.language ASC');


		$data['channelSearchFormCategoryInput'] = $channelSearchFormCategoryInput;
		$data['channelSearchFormCountryInput'] = $channelSearchFormCountryInput;
		$data['channelSearchFormCompanyInput'] = $channelSearchFormCompanyInput;
		$data['channelSearchFormLanguageInput'] = $channelSearchFormLanguageInput;
		$data['channelSearchFormUrlInput'] = $channelSearchFormUrlInput;
		$data['channelSearchFormLiveInput'] = $channelSearchFormLiveInput;
		$data['channelSearchFormDateInput'] = $channelSearchFormDateInput;

		$data["categoryDataResult"] = $categoryDataResult;
		$data["countryDataResult"] = $countryDataResult;
		$data["companyDataResult"] = $companyDataResult;
		$data["languageDataResult"] = $languageDataResult;

		$data["channelDataArr"] = $channelDataArr;
		$data['paginationLink'] = $paginationLink;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/channel_list', $data);
	}


	public function addChannelData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$channelCategoryInput = $this->input->post("channelCategoryInput");
		$channelCountryInput = $this->input->post("channelCountryInput");
		$channelCompanyInput = $this->input->post("channelCompanyInput");
		$channelLanguageInput = $this->input->post("channelLanguageInput");
		$channelUrlInput = $this->input->post("channelUrlInput");
		$channelAliveInput = $this->input->post("channelAliveInput");
		$channelDateInput = $this->input->post("channelDateInput");

		if(!empty($channelCategoryInput) && !empty($channelCountryInput) && !empty($channelCompanyInput) && !empty($channelLanguageInput)
			&& !empty($channelUrlInput) && $channelAliveInput != "" && !empty($channelDateInput)){
			$select = array("uid");
			$where = array("category"=>$channelCategoryInput, "country"=>$channelCountryInput, "company"=>$channelCompanyInput, "language"=>$channelLanguageInput);
			if($this->basic->is_unique("l_channel",$where,$select)){
				$data = array("category"=>$channelCategoryInput,"country"=>$channelCountryInput,"company"=>$channelCompanyInput,"language"=>$channelLanguageInput,"url"=>$channelUrlInput,"alive"=>$channelAliveInput,"date"=>$channelDateInput);
				if($this->basic->insert_data("l_channel",$data)){
					$msgType = "success";
					$msg = "This Channel data saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Channel data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Channel data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Channel required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function getChannelData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$channelID = $this->input->post("channelID");

		if(!empty($channelID)){
			$where = array("where"=>array("uid"=>$channelID));
			$channelDataResult = $this->basic->get_data("l_channel",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Channel id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$channelDataResult));
	}

	public function updateChannelData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$channelEditCategoryInput = $this->input->post("channelEditCategoryInput", TRUE);
		$channelEditCountryInput = $this->input->post("channelEditCountryInput", TRUE);
		$channelEditCompanyInput = $this->input->post("channelEditCompanyInput", TRUE);
		$channelEditLanguageInput = $this->input->post("channelEditLanguageInput", TRUE);
		$channelEditUrlInput = $this->input->post("channelEditUrlInput", TRUE);
		$channelEditAliveInput = $this->input->post("channelEditAliveInput", TRUE);
		$channelEditDateInput = $this->input->post("channelEditDateInput", TRUE);
		$channelID = $this->input->post("channelID", TRUE);

		if(!empty($channelEditCategoryInput) && !empty($channelEditCountryInput) && !empty($channelEditCompanyInput) && !empty($channelEditLanguageInput) &&
			!empty($channelEditUrlInput) && $channelEditAliveInput != "" && !empty($channelEditDateInput) && !empty($channelID)){
			$select = array("uid");
			$where = array("uid != "=>$channelID, "category"=>$channelEditCategoryInput, "country"=>$channelEditCountryInput, "company"=>$channelEditCompanyInput, "language"=>$channelEditLanguageInput);
			if($this->basic->is_unique("l_channel",$where,$select)){
				$where = array("uid"=>$channelID);
				$data = array("category"=>$channelEditCategoryInput, "country"=>$channelEditCountryInput, "company"=>$channelEditCompanyInput, "language"=>$channelEditLanguageInput, "url"=>$channelEditUrlInput, "alive"=>$channelEditAliveInput, "date"=>$channelEditDateInput);
				if($this->basic->update_data("l_channel",$where,$data)){
					$msgType = "success";
					$msg = "Channel data updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Channel data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Channel data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Channel required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}


	public function deleteChannelData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$channelID = $this->input->post("channelID", TRUE);

		if(!empty($channelID)){
			$where = array("uid"=>$channelID);
			if($this->basic->delete_data("l_channel",$where)){
				$msgType = "success";
				$msg = "This Channel data deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete This Channel data.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Channel id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

/* ----- Channel ends here -----*/

public function platformcategory(){
	// setting session data to menu selection
	$this->session->set_userdata("menuSelect", "channelvod/platformcategory");
	$data = array();
	$msgType = "";
	$msg = "";
	$category_data = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_category.php')), true);
	$j=0;
	foreach ($category_data as $categoryData) {
		$categoryDataArr[$j] = array(
			"id" => $categoryData["id"],
			"parentId" => $categoryData['parentId'],
			"depth" => $categoryData['depth'],
			"name" => $categoryData['name'],
			"date" => $categoryData['date']
		);
		$j++;
	}

	$data['categoryDataArr'] = $categoryDataArr;

	$data['msgType'] = $msgType;
	$data['msg'] = $msg;

			$this->_O('admin/platform_category', $data);
}
public function platformvod(){
	$this->session->set_userdata("menuSelect", "channelvod/platformvod");
	$data = array();
	$msgType = "";
	$msg = "";
	$limit = 20;
	$paginationLink = "";
	$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

	$event = $this->input->post("event");

	 $count_data = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_list.php')), true);

	 $this->init_pagination(site_url('admin/channelvod/platformvod'), count($count_data), $limit);
 	 $paginationLink = $this->pagination->create_links();
	 $part1 = $this->user_model->get_vodlist($limit,$start);
	$i=0;
	foreach ($part1 as $part1Data) {
		$vodDataArr[$i] = array(
			"id" => $part1Data["id"],
			"name" => $part1Data['name'],
			"category" => $part1Data['category'],
			"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part1Data['id']."/flavorId/".$part1Data['flavorid']."/forceproxy/true/name/".$part1Data['name'].$part1Data['file_ext'],
			"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part1Data['id']."/version/100002/width=".$part1Data['width']."/height=".$part1Data['height'],
			"date" => $part1Data['date']
		);
		$i++;
	}

	$data['vodDataArr'] = $vodDataArr;
  $data['paginationLink'] = $paginationLink;
	$data['msgType'] = $msgType;
	$data['msg'] = $msg;

			$this->_O('admin/platform_vod', $data);
}

}
