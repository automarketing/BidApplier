<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Subscriber extends Base_controller {

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
	
	// getting all TVBox subscriber list
	public function index(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "subscriber/index");

		$data = array();
		$subscriberDataArr = array();

		$subscriberInfoSearchFormEmailInput = "";
		$subscriberInfoSearchFormNameInput = "";
		$subscriberInfoSearchFormTelInput = "";
		$subscriberInfoSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "subscriberInfoSearchFormSubmit")){
			$subscriberInfoSearchFormEmailInput = $this->input->post("subscriberInfoSearchFormEmailInput");
			$subscriberInfoSearchFormNameInput = $this->input->post("subscriberInfoSearchFormNameInput");
			$subscriberInfoSearchFormTelInput = $this->input->post("subscriberInfoSearchFormTelInput");
			$subscriberInfoSearchFormAddressInput = $this->input->post("subscriberInfoSearchFormAddressInput");

			$this->session->set_userdata("subscriberInfoSearchFormEmailInput", $subscriberInfoSearchFormEmailInput);
			$this->session->set_userdata("subscriberInfoSearchFormNameInput", $subscriberInfoSearchFormNameInput);
			$this->session->set_userdata("subscriberInfoSearchFormTelInput", $subscriberInfoSearchFormTelInput);
			$this->session->set_userdata("subscriberInfoSearchFormAddressInput", $subscriberInfoSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("subscriberInfoSearchFormNameInput") != ""){
			$subscriberInfoSearchFormNameInput = $this->session->userdata("subscriberInfoSearchFormNameInput");

			$where['or_where']["u_subscriber.first_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
			$where['or_where']["u_subscriber.last_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormAddressInput") != ""){
			$subscriberInfoSearchFormAddressInput = $this->session->userdata("subscriberInfoSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormEmailInput") != ""){
			$subscriberInfoSearchFormEmailInput = $this->session->userdata("subscriberInfoSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$subscriberInfoSearchFormEmailInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormTelInput") != ""){
			$subscriberInfoSearchFormTelInput = $this->session->userdata("subscriberInfoSearchFormTelInput");

			$where['where']["u_subscriber.telephone LIKE "] = "%".$subscriberInfoSearchFormTelInput."%";
		}
		$where['where']["u_device.device_type_id"] = 1;

		if(!empty($where) && count($where)>0){
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}
		else{
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}


		$this->init_pagination(site_url('admin/subscriber/index'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($subscriberDataResult as $subscriberData) {
			$subscriberDataArr[$i] = array(
				'uid'=>$subscriberData['uid'],
				'email'=>$subscriberData['email'],
				'first_name'=>$subscriberData['first_name'],
				'last_name'=>$subscriberData['last_name'],
				'telephone'=>$subscriberData['telephone'],
				'address_street_1'=>$subscriberData['address_street_1'],
				'address_street_2'=>$subscriberData['address_street_2'],
				'city'=>$subscriberData['city'],
				'state'=>$subscriberData['state'],
				'zipcode'=>$subscriberData['zipcode'],
				'country'=>$subscriberData['country'],
				'device_type_id'=>$subscriberData['device_type_id'],
				'active_status'=>$subscriberData['active_status']
			);
			$i++;
		}

		$yearDataArr = $this->getYears(10);

		// getting all subscriber's plan data
		$subscriberPlanDataArr = array();
		$subscriberPlanDataResult = $this->basic->get_data("u_pay_plan",$where='',$select='',$join='',$limit,$start,$order_by='u_pay_plan.uid ASC');
		foreach($subscriberPlanDataResult as $subscriberPlanData){
			$subscriberPlanDataArr[$subscriberPlanData['uid']] = $subscriberPlanData['type'];
		}

		$data['subscriberInfoSearchFormEmailInput'] = $subscriberInfoSearchFormEmailInput;
		$data['subscriberInfoSearchFormNameInput'] = $subscriberInfoSearchFormNameInput;
		$data['subscriberInfoSearchFormTelInput'] = $subscriberInfoSearchFormTelInput;
		$data['subscriberInfoSearchFormAddressInput'] = $subscriberInfoSearchFormAddressInput;

		$data['subscriberDataArr'] = $subscriberDataArr;
		$data['subscriberPlanDataArr'] = $subscriberPlanDataArr;
		$data['yearDataArr'] = $yearDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/subscriber_list', $data);
	}

	// getting all Mobile subscriber list
	public function mobile(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "subscriber/mobile");

		$data = array();
		$subscriberDataArr = array();

		$subscriberInfoSearchFormEmailInput = "";
		$subscriberInfoSearchFormNameInput = "";
		$subscriberInfoSearchFormTelInput = "";
		$subscriberInfoSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "subscriberInfoSearchFormSubmit")){
			$subscriberInfoSearchFormEmailInput = $this->input->post("subscriberInfoSearchFormEmailInput");
			$subscriberInfoSearchFormNameInput = $this->input->post("subscriberInfoSearchFormNameInput");
			$subscriberInfoSearchFormTelInput = $this->input->post("subscriberInfoSearchFormTelInput");
			$subscriberInfoSearchFormAddressInput = $this->input->post("subscriberInfoSearchFormAddressInput");

			$this->session->set_userdata("subscriberInfoSearchFormEmailInput", $subscriberInfoSearchFormEmailInput);
			$this->session->set_userdata("subscriberInfoSearchFormNameInput", $subscriberInfoSearchFormNameInput);
			$this->session->set_userdata("subscriberInfoSearchFormTelInput", $subscriberInfoSearchFormTelInput);
			$this->session->set_userdata("subscriberInfoSearchFormAddressInput", $subscriberInfoSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("subscriberInfoSearchFormNameInput") != ""){
			$subscriberInfoSearchFormNameInput = $this->session->userdata("subscriberInfoSearchFormNameInput");

			$where['or_where']["u_subscriber.first_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
			$where['or_where']["u_subscriber.last_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormAddressInput") != ""){
			$subscriberInfoSearchFormAddressInput = $this->session->userdata("subscriberInfoSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormEmailInput") != ""){
			$subscriberInfoSearchFormEmailInput = $this->session->userdata("subscriberInfoSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$subscriberInfoSearchFormEmailInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormTelInput") != ""){
			$subscriberInfoSearchFormTelInput = $this->session->userdata("subscriberInfoSearchFormTelInput");

			$where['where']["u_subscriber.telephone LIKE "] = "%".$subscriberInfoSearchFormTelInput."%";
		}
		$where['where']["u_device.device_type_id"] = 2;

		if(!empty($where) && count($where)>0){
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}
		else{
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}


		$this->init_pagination(site_url('admin/subscriber/mobile'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($subscriberDataResult as $subscriberData) {
			$subscriberDataArr[$i] = array(
				'uid'=>$subscriberData['uid'],
				'email'=>$subscriberData['email'],
				'first_name'=>$subscriberData['first_name'],
				'last_name'=>$subscriberData['last_name'],
				'telephone'=>$subscriberData['telephone'],
				'address_street_1'=>$subscriberData['address_street_1'],
				'address_street_2'=>$subscriberData['address_street_2'],
				'city'=>$subscriberData['city'],
				'state'=>$subscriberData['state'],
				'zipcode'=>$subscriberData['zipcode'],
				'country'=>$subscriberData['country'],
				'device_type_id'=>$subscriberData['device_type_id'],
				'active_status'=>$subscriberData['active_status']
			);
			$i++;
		}

		$yearDataArr = $this->getYears(10);

		// getting all subscriber's plan data
		$subscriberPlanDataArr = array();
		$subscriberPlanDataResult = $this->basic->get_data("u_pay_plan",$where='',$select='',$join='',$limit,$start,$order_by='u_pay_plan.uid ASC');
		foreach($subscriberPlanDataResult as $subscriberPlanData){
			$subscriberPlanDataArr[$subscriberPlanData['uid']] = $subscriberPlanData['type'];
		}

		$data['subscriberInfoSearchFormEmailInput'] = $subscriberInfoSearchFormEmailInput;
		$data['subscriberInfoSearchFormNameInput'] = $subscriberInfoSearchFormNameInput;
		$data['subscriberInfoSearchFormTelInput'] = $subscriberInfoSearchFormTelInput;
		$data['subscriberInfoSearchFormAddressInput'] = $subscriberInfoSearchFormAddressInput;

		$data['subscriberDataArr'] = $subscriberDataArr;
		$data['subscriberPlanDataArr'] = $subscriberPlanDataArr;
		$data['yearDataArr'] = $yearDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/mobile_subscriber_list', $data);
	}

	// getting all Website subscriber list
	public function website(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "subscriber/website");

		$data = array();
		$subscriberDataArr = array();

		$subscriberInfoSearchFormEmailInput = "";
		$subscriberInfoSearchFormNameInput = "";
		$subscriberInfoSearchFormTelInput = "";
		$subscriberInfoSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "subscriberInfoSearchFormSubmit")){
			$subscriberInfoSearchFormEmailInput = $this->input->post("subscriberInfoSearchFormEmailInput");
			$subscriberInfoSearchFormNameInput = $this->input->post("subscriberInfoSearchFormNameInput");
			$subscriberInfoSearchFormTelInput = $this->input->post("subscriberInfoSearchFormTelInput");
			$subscriberInfoSearchFormAddressInput = $this->input->post("subscriberInfoSearchFormAddressInput");

			$this->session->set_userdata("subscriberInfoSearchFormEmailInput", $subscriberInfoSearchFormEmailInput);
			$this->session->set_userdata("subscriberInfoSearchFormNameInput", $subscriberInfoSearchFormNameInput);
			$this->session->set_userdata("subscriberInfoSearchFormTelInput", $subscriberInfoSearchFormTelInput);
			$this->session->set_userdata("subscriberInfoSearchFormAddressInput", $subscriberInfoSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("subscriberInfoSearchFormNameInput") != ""){
			$subscriberInfoSearchFormNameInput = $this->session->userdata("subscriberInfoSearchFormNameInput");

			$where['or_where']["u_subscriber.first_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
			$where['or_where']["u_subscriber.last_name LIKE "] = "%".$subscriberInfoSearchFormNameInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormAddressInput") != ""){
			$subscriberInfoSearchFormAddressInput = $this->session->userdata("subscriberInfoSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$subscriberInfoSearchFormAddressInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormEmailInput") != ""){
			$subscriberInfoSearchFormEmailInput = $this->session->userdata("subscriberInfoSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$subscriberInfoSearchFormEmailInput."%";
		}
		if($this->session->userdata("subscriberInfoSearchFormTelInput") != ""){
			$subscriberInfoSearchFormTelInput = $this->session->userdata("subscriberInfoSearchFormTelInput");

			$where['where']["u_subscriber.telephone LIKE "] = "%".$subscriberInfoSearchFormTelInput."%";
		}
		$where['where']["u_device.device_type_id"] = 3;

		if(!empty($where) && count($where)>0){
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}
		else{
			$select = array("u_subscriber.uid as uid","u_subscriber.first_name as first_name","u_subscriber.last_name as last_name","u_subscriber.telephone as telephone","u_subscriber.email as email","u_subscriber.address_street_1 as address_street_1","u_subscriber.address_street_2 as address_street_2","u_subscriber.city as city","u_subscriber.state as state","u_subscriber.zipcode as zipcode","u_subscriber.country as country","u_subscriber.active_status as active_status","u_device.device_type_id as device_type_id");
			$join = array("u_device"=>"u_device.s_id=u_subscriber.uid");
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,'','','u_subscriber.uid ASC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,$join,$limit,$start,'u_subscriber.uid ASC');
		}


		$this->init_pagination(site_url('admin/subscriber/mobile'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($subscriberDataResult as $subscriberData) {
			$subscriberDataArr[$i] = array(
				'uid'=>$subscriberData['uid'],
				'email'=>$subscriberData['email'],
				'first_name'=>$subscriberData['first_name'],
				'last_name'=>$subscriberData['last_name'],
				'telephone'=>$subscriberData['telephone'],
				'address_street_1'=>$subscriberData['address_street_1'],
				'address_street_2'=>$subscriberData['address_street_2'],
				'city'=>$subscriberData['city'],
				'state'=>$subscriberData['state'],
				'zipcode'=>$subscriberData['zipcode'],
				'country'=>$subscriberData['country'],
				'device_type_id'=>$subscriberData['device_type_id'],
				'active_status'=>$subscriberData['active_status']
			);
			$i++;
		}

		$yearDataArr = $this->getYears(10);

		// getting all subscriber's plan data
		$subscriberPlanDataArr = array();
		$subscriberPlanDataResult = $this->basic->get_data("u_pay_plan",$where='',$select='',$join='',$limit,$start,$order_by='u_pay_plan.uid ASC');
		foreach($subscriberPlanDataResult as $subscriberPlanData){
			$subscriberPlanDataArr[$subscriberPlanData['uid']] = $subscriberPlanData['type'];
		}

		$data['subscriberInfoSearchFormEmailInput'] = $subscriberInfoSearchFormEmailInput;
		$data['subscriberInfoSearchFormNameInput'] = $subscriberInfoSearchFormNameInput;
		$data['subscriberInfoSearchFormTelInput'] = $subscriberInfoSearchFormTelInput;
		$data['subscriberInfoSearchFormAddressInput'] = $subscriberInfoSearchFormAddressInput;

		$data['subscriberDataArr'] = $subscriberDataArr;
		$data['subscriberPlanDataArr'] = $subscriberPlanDataArr;
		$data['yearDataArr'] = $yearDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/website_subscriber_list', $data);
	}

	// getting subscriber's all data 
	public function getSubscriberAllData(){
		$subscriberId = $this->input->post('subscriberId');

		$where = array("where"=>array("u_subscriber.uid"=>$subscriberId));
		$select = array("u_subscriber.uid as uid", "first_name", "last_name", "company", "telephone", "email", "fax", "address_street_1", "address_street_2", "city", "state", "zipcode", "country", "p_card.type as card_type", "p_card.card_no as card_no", "p_card.cvv as card_cvv", "p_card.exp_year as card_exp_year", "p_card.exp_month as card_exp_month");
		$join = array("p_card"=>"p_card.s_id = u_subscriber.uid, left");
		$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit='',$start="",$order_by='u_subscriber.uid ASC');

		// $cardExpDateArr = explode("-", $subscriberDataResult[0]['card_exp_date']);
		// $cardExpYear = $cardExpDateArr[0]['card_exp_year'];
		// $cardExpMonth = $cardExpDateArr[1]['card_exp_month'];

		$subscriberDataArr = array(
			"uid" => $subscriberDataResult[0]['uid'],
			"first_name" => $subscriberDataResult[0]['first_name'],
			"last_name" => $subscriberDataResult[0]['last_name'],
			"company" => $subscriberDataResult[0]['company'],
			"telephone" => $subscriberDataResult[0]['telephone'],
			"email" => $subscriberDataResult[0]['email'],
			"fax" => $subscriberDataResult[0]['fax'],
			"address_street_1" => $subscriberDataResult[0]['address_street_1'],
			"address_street_2" => $subscriberDataResult[0]['address_street_2'],
			"city" => $subscriberDataResult[0]['city'],
			"state" => $subscriberDataResult[0]['state'],
			"zipcode" => $subscriberDataResult[0]['zipcode'],
			"country" => $subscriberDataResult[0]['country'],
			"card_type" => $subscriberDataResult[0]['card_type'],
			"card_no" => $subscriberDataResult[0]['card_no'],
			"card_cvv" => $subscriberDataResult[0]['card_cvv'],
			"card_exp_year" => $subscriberDataResult[0]['card_exp_year'],
			"card_exp_month" => str_pad($subscriberDataResult[0]['card_exp_month'], 2, '0', STR_PAD_LEFT)
		);

		echo json_encode($subscriberDataArr);
	}

	// saving Subscriber's all data
	public function saveSubscriberAllData(){
		$msgType = "error";
		$msg = "";

		$subsFirstNameInput = $this->input->post('subsFirstNameInput', TRUE);
		$subsLastNameInput = $this->input->post('subsLastNameInput', TRUE);
		$subsCompanyInput = $this->input->post('subsCompanyInput', TRUE);
		$subsTelInput = $this->input->post('subsTelInput', TRUE);
		$subsEmailInput = $this->input->post('subsEmailInput', TRUE);
		$subsFaxInput = $this->input->post('subsFaxInput', TRUE);
		$subsStreet1Input = $this->input->post('subsStreet1Input', TRUE);
		$subsStreet2Input = $this->input->post('subsStreet2Input', TRUE);
		$subsCityInput = $this->input->post('subsCityInput', TRUE);
		$subsStateInput = $this->input->post('subsStateInput', TRUE);
		$subsZipInput = $this->input->post('subsZipInput', TRUE);
		$subsCountryInput = $this->input->post('subsCountryInput', TRUE);
		$subsCardTypeInput = $this->input->post('subsCardTypeInput', TRUE);
		$subsCardNoInput = $this->input->post('subsCardNoInput', TRUE);
		$subsCardCVVNoInput = $this->input->post('subsCardCVVNoInput', TRUE);
		$subsCardExpMonthInput = $this->input->post('subsCardExpMonthInput', TRUE);
		$subsCardExpYearInput = $this->input->post('subsCardExpYearInput', TRUE);
		// $subsCardExpDateInput = $subsCardExpYearInput."-".$subsCardExpMonthInput;

		$subscriberInfoEditFormSubscriberId = $this->input->post('subscriberInfoEditFormSubscriberId', TRUE);


		if(!empty($subsFirstNameInput) && !empty($subsLastNameInput) && !empty($subsTelInput) && !empty($subsEmailInput)
		 && !empty($subsStreet1Input) && !empty($subsCityInput) && !empty($subsCountryInput) && !empty($subsCardTypeInput)
		  && !empty($subsCardNoInput) && !empty($subsCardCVVNoInput) && !empty($subsCardExpMonthInput) && !empty($subsCardExpYearInput) 
		  && !empty($subscriberInfoEditFormSubscriberId)){

			$where = array("uid"=>$subscriberInfoEditFormSubscriberId);
			$data = array(
				"first_name" => $subsFirstNameInput,
				"last_name" => $subsLastNameInput,
				"company" => $subsCompanyInput,
				"telephone" => $subsTelInput,
				"email" => $subsEmailInput,
				"fax" => $subsFaxInput,
				"address_street_1" => $subsStreet1Input,
				"address_street_2" => $subsStreet2Input,
				"city" => $subsCityInput,
				"state" => $subsStateInput,
				"zipcode" => $subsZipInput,
				"country" => $subsCountryInput
			);
			if($this->basic->update_data("u_subscriber",$where,$data)){

				$select = array("uid");
				$where = array("where"=>array('s_id'=>$subscriberInfoEditFormSubscriberId));
				$subscriberCardDataResult = $this->basic->get_data("p_card",$where,$select,$join='',$limit='',$start="",$order_by='p_card.uid ASC',$group_by='',$num_rows=1);
				$subscriberCardDataCount = $subscriberCardDataResult['extra_index']['num_rows'];

				if($subscriberCardDataCount < 1){
					$data = array(
						's_id'=>$subscriberInfoEditFormSubscriberId,
						'type'=>$subsCardTypeInput,
						'card_no'=>$subsCardNoInput,
						'cvv'=>$subsCardCVVNoInput,
						'exp_year'=>$subsCardExpYearInput,
						'exp_month'=>$subsCardExpMonthInput,
						'verification_no'=>'',
						'checkFlag'=>0
					);
					if($this->basic->insert_data("p_card",$data)){
						$msgType = 'success';
						$msg = 'Subscriber\'s information updated successfully.';
					}
					else{
						$msgType = 'error';
						$msg = 'Problem to save subscriber\'s card information data.';
					}
				}
				else{
					$where = array('s_id'=>$subscriberInfoEditFormSubscriberId);
					$data = array('type'=>$subsCardTypeInput,'card_no'=>$subsCardNoInput,'cvv'=>$subsCardCVVNoInput,'exp_year'=>$subsCardExpYearInput,'exp_month'=>$subsCardExpMonthInput);
					if($this->basic->update_data("p_card",$where,$data)){
						$msgType = 'success';
						$msg = 'Subscriber\'s information updated successfully.';
					}
					else{
						$msgType = 'error';
						$msg = 'Problem to save subscriber\'s card information data.';
					}
				}
			}
			else{
				$msgType = 'error';
				$msg = 'Problem to save subscriber\'s information data.';
			}
		}
		else{
			$msgType = 'error';
			$msg = 'You must fill all required field.';
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	// getting subscriber's all payment data 
	public function getSubscriberAllPaymentData(){
		$subscriberPaymentDataArr = array();
		$subscriberPlanID = "";

		$subscriberId = $this->input->post('subscriberId');

		$where = array("where"=>array("p_payment.s_id"=>$subscriberId));
		$select = array("p_payment.uid as uid", "p_payment.plan_id as plan_id", "u_pay_plan.type as plan_type", "p_payment.price as price", "p_payment.date as date", "p_payment.autopay as autopay", "p_payment.startdate as startdate", "p_payment.enddate as enddate", "p_card.card_no as card_no");
		$join = array("p_card"=>"p_card.uid = p_payment.card_id, left", "u_pay_plan"=>"u_pay_plan.uid = p_payment.plan_id, left");
		$subscriberPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,$join,$limit='',$start="",$order_by='p_payment.uid DESC');

		$i=0;
		foreach($subscriberPaymentDataResult as $subscriberPaymentData){
			$subscriberPaymentDataArr[$i] = array(
				"uid" => $subscriberPaymentData["uid"],
				"plan_id" => $subscriberPaymentData["plan_id"],
				"plan_type" => $subscriberPaymentData["plan_type"],
				"price" => $subscriberPaymentData["price"],
				"date" => $subscriberPaymentData["date"],
				"autopay" => $subscriberPaymentData["autopay"],
				"startdate" => $subscriberPaymentData["startdate"],
				"enddate" => $subscriberPaymentData["enddate"],
				"card_no" => $subscriberPaymentData["card_no"]
			);
			$i++;
		}

		$where = array("where"=>array("uid"=>$subscriberId));
		$select = array("plan_id");
		$subscriberPlanDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join="",$limit='',$start="",$order_by='u_subscriber.uid DESC');
		if(!empty($subscriberPlanDataResult) && count($subscriberPlanDataResult) > 0){
			$subscriberPlanID = $subscriberPlanDataResult[0]['plan_id'];			
		}

		echo json_encode(array("subscriberPlanID"=>$subscriberPlanID, "subscriberPaymentDataArr"=>$subscriberPaymentDataArr));
	}

	// saving Subscriber's all data
	public function saveSubscriberPlanData(){
		$msgType = "error";
		$msg = "";

		$subsServicePlanInput = $this->input->post('subsServicePlanInput', TRUE);
		$subscriberPlanEditFormSubscriberId = $this->input->post('subscriberPlanEditFormSubscriberId', TRUE);

		if(!empty($subsServicePlanInput) && !empty($subscriberPlanEditFormSubscriberId)){
			$where = array("uid"=>$subscriberPlanEditFormSubscriberId);
			$data = array(
				"plan_id" => $subsServicePlanInput
			);
			if($this->basic->update_data("u_subscriber",$where,$data)){
				$msgType = 'success';
				$msg = 'Subscriber\'s Service Plan updated successfully.';
			}
			else{
				$msgType = 'error';
				$msg = 'Problem to save subscriber\'s Service Plan.';
			}
		}
		else{
			$msgType = 'error';
			$msg = 'You must have to select Service Plan.';
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	// public function test_payment(){

	// 	$payment_data = array(
	// 		"payment_action" => "Sale",
	// 		"first_name" => "Test1",
	// 		"last_name" => "Test2",
	// 		"card_type" => "Visa",
	// 		"card_number" => "371449635398431",
	// 		"exp_date_month" => "06",
	// 		"exp_date_year" => "2024",
	// 		"card_cvv_number" => "123",
	// 		"amount" => "100",
	// 		"currency_code" => "USD",
	// 		"country_code" => "US"
	// 	);

	// 	$resDataArray = $this->paypal_payment->payment_process("card", $payment_data);

	// 	echo "<br />Response Data : ";
	// 	echo "<pre>"; 
	// 	print_r($resDataArray);
	// 	echo "<pre>"; 
	// }

}