<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Payment extends Base_controller {

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

	// getting all tvbox subscriber's payment list
	public function tvbox_payment(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "payment/tvbox_payment");

		$data = array();
		$tvboxReqDataArr = array();

		$tvboxReqSearchFormEmailInput = "";
		$tvboxReqSearchFormDateInput = "";
		$tvboxReqSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "tvboxReqSearchFormSubmit")){
			$tvboxReqSearchFormEmailInput = $this->input->post("tvboxReqSearchFormEmailInput");
			$tvboxReqSearchFormDateInput = $this->input->post("tvboxReqSearchFormDateInput");
			$tvboxReqSearchFormAddressInput = $this->input->post("tvboxReqSearchFormAddressInput");

			$this->session->set_userdata("tvboxReqSearchFormEmailInput", $tvboxReqSearchFormEmailInput);
			$this->session->set_userdata("tvboxReqSearchFormDateInput", $tvboxReqSearchFormDateInput);
			$this->session->set_userdata("tvboxReqSearchFormAddressInput", $tvboxReqSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("tvboxReqSearchFormEmailInput") != ""){
			$tvboxReqSearchFormEmailInput = $this->session->userdata("tvboxReqSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$tvboxReqSearchFormEmailInput."%";
		}
		if($this->session->userdata("tvboxReqSearchFormDateInput") != ""){
			$tvboxReqSearchFormDateInput = $this->session->userdata("tvboxReqSearchFormDateInput");

			$where['where']["p_payment.date"] = $tvboxReqSearchFormDateInput;
		}
		if($this->session->userdata("tvboxReqSearchFormAddressInput") != ""){
			$tvboxReqSearchFormAddressInput = $this->session->userdata("tvboxReqSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
		}
		$where['where']["u_device.device_type_id"] = 1;

		if(!empty($where) && count($where)>0){
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",$where,$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",$where,$select,$join,$limit,$start,'p_payment.uid DESC');
		}
		else{
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",'',$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",'',$select,$join,$limit,$start,'p_payment.uid DESC');
		}

		$this->init_pagination(site_url('admin/payment/tvbox_request'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($tvboxReqDataResult as $tvboxReqData) {
			$address = "";
			if(!empty($tvboxReqData['address_street_1'])){
				$address .= $tvboxReqData['address_street_1'];
			}
			if(!empty($tvboxReqData['address_street_2'])){
				$address .= $tvboxReqData['address_street_2'];
			}
			if(!empty($tvboxReqData['city'])){
				$address .= $tvboxReqData['city'];
			}
			if(!empty($tvboxReqData['state'])){
				$address .= $tvboxReqData['state'];
			}
			if(!empty($tvboxReqData['zipcode'])){
				$address .= $tvboxReqData['zipcode'];
			}
			if(!empty($tvboxReqData['country'])){
				$address .= $tvboxReqData['country'];
			}

			$tvboxReqDataArr[$i] = array(
				'uid'=>$tvboxReqData['uid'],
				'email'=>$tvboxReqData['email'],
				'address'=>$address,
				'transaction_id'=>$tvboxReqData['transaction_id'],
				'card_type'=>$tvboxReqData['card_type'],
				'price'=>$tvboxReqData['price'],
				'date'=>$tvboxReqData['date']
				// 'req_status'=>$tvboxReqData['req_status']
			);
			$i++;
		}

		$data['tvboxReqSearchFormEmailInput'] = $tvboxReqSearchFormEmailInput;
		$data['tvboxReqSearchFormDateInput'] = $tvboxReqSearchFormDateInput;
		$data['tvboxReqSearchFormAddressInput'] = $tvboxReqSearchFormAddressInput;

		$data['tvboxReqDataArr'] = $tvboxReqDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/tvbox_payment_list', $data);
	}
	
	// getting all mobile subscriber's payment list
	public function mobile_payment(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "payment/mobile_payment");

		$data = array();
		$tvboxReqDataArr = array();

		$tvboxReqSearchFormEmailInput = "";
		$tvboxReqSearchFormDateInput = "";
		$tvboxReqSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "tvboxReqSearchFormSubmit")){
			$tvboxReqSearchFormEmailInput = $this->input->post("tvboxReqSearchFormEmailInput");
			$tvboxReqSearchFormDateInput = $this->input->post("tvboxReqSearchFormDateInput");
			$tvboxReqSearchFormAddressInput = $this->input->post("tvboxReqSearchFormAddressInput");

			$this->session->set_userdata("tvboxReqSearchFormEmailInput", $tvboxReqSearchFormEmailInput);
			$this->session->set_userdata("tvboxReqSearchFormDateInput", $tvboxReqSearchFormDateInput);
			$this->session->set_userdata("tvboxReqSearchFormAddressInput", $tvboxReqSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("tvboxReqSearchFormEmailInput") != ""){
			$tvboxReqSearchFormEmailInput = $this->session->userdata("tvboxReqSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$tvboxReqSearchFormEmailInput."%";
		}
		if($this->session->userdata("tvboxReqSearchFormDateInput") != ""){
			$tvboxReqSearchFormDateInput = $this->session->userdata("tvboxReqSearchFormDateInput");

			$where['where']["p_payment.date"] = $tvboxReqSearchFormDateInput;
		}
		if($this->session->userdata("tvboxReqSearchFormAddressInput") != ""){
			$tvboxReqSearchFormAddressInput = $this->session->userdata("tvboxReqSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
		}
		$where['where']["u_device.device_type_id"] = 2;

		if(!empty($where) && count($where)>0){
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",$where,$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",$where,$select,$join,$limit,$start,'p_payment.uid DESC');
		}
		else{
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",'',$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",'',$select,$join,$limit,$start,'p_payment.uid DESC');
		}

		$this->init_pagination(site_url('admin/payment/tvbox_request'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($tvboxReqDataResult as $tvboxReqData) {
			$address = "";
			if(!empty($tvboxReqData['address_street_1'])){
				$address .= $tvboxReqData['address_street_1'];
			}
			if(!empty($tvboxReqData['address_street_2'])){
				$address .= $tvboxReqData['address_street_2'];
			}
			if(!empty($tvboxReqData['city'])){
				$address .= $tvboxReqData['city'];
			}
			if(!empty($tvboxReqData['state'])){
				$address .= $tvboxReqData['state'];
			}
			if(!empty($tvboxReqData['zipcode'])){
				$address .= $tvboxReqData['zipcode'];
			}
			if(!empty($tvboxReqData['country'])){
				$address .= $tvboxReqData['country'];
			}

			$tvboxReqDataArr[$i] = array(
				'uid'=>$tvboxReqData['uid'],
				'email'=>$tvboxReqData['email'],
				'address'=>$address,
				'transaction_id'=>$tvboxReqData['transaction_id'],
				'card_type'=>$tvboxReqData['card_type'],
				'price'=>$tvboxReqData['price'],
				'date'=>$tvboxReqData['date']
				// 'req_status'=>$tvboxReqData['req_status']
			);
			$i++;
		}

		$data['tvboxReqSearchFormEmailInput'] = $tvboxReqSearchFormEmailInput;
		$data['tvboxReqSearchFormDateInput'] = $tvboxReqSearchFormDateInput;
		$data['tvboxReqSearchFormAddressInput'] = $tvboxReqSearchFormAddressInput;

		$data['tvboxReqDataArr'] = $tvboxReqDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/mobile_payment_list', $data);
	}
	
	// getting all website subscriber's payment list
	public function website_payment(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "payment/website_payment");

		$data = array();
		$tvboxReqDataArr = array();

		$tvboxReqSearchFormEmailInput = "";
		$tvboxReqSearchFormDateInput = "";
		$tvboxReqSearchFormAddressInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "tvboxReqSearchFormSubmit")){
			$tvboxReqSearchFormEmailInput = $this->input->post("tvboxReqSearchFormEmailInput");
			$tvboxReqSearchFormDateInput = $this->input->post("tvboxReqSearchFormDateInput");
			$tvboxReqSearchFormAddressInput = $this->input->post("tvboxReqSearchFormAddressInput");

			$this->session->set_userdata("tvboxReqSearchFormEmailInput", $tvboxReqSearchFormEmailInput);
			$this->session->set_userdata("tvboxReqSearchFormDateInput", $tvboxReqSearchFormDateInput);
			$this->session->set_userdata("tvboxReqSearchFormAddressInput", $tvboxReqSearchFormAddressInput);
		}

		$where = array();
		if($this->session->userdata("tvboxReqSearchFormEmailInput") != ""){
			$tvboxReqSearchFormEmailInput = $this->session->userdata("tvboxReqSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$tvboxReqSearchFormEmailInput."%";
		}
		if($this->session->userdata("tvboxReqSearchFormDateInput") != ""){
			$tvboxReqSearchFormDateInput = $this->session->userdata("tvboxReqSearchFormDateInput");

			$where['where']["p_payment.date"] = $tvboxReqSearchFormDateInput;
		}
		if($this->session->userdata("tvboxReqSearchFormAddressInput") != ""){
			$tvboxReqSearchFormAddressInput = $this->session->userdata("tvboxReqSearchFormAddressInput");

			$where['or_where']["u_subscriber.address_street_1 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.address_street_2 LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.city LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.state LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.zipcode LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
			$where['or_where']["u_subscriber.country LIKE "] = "%".$tvboxReqSearchFormAddressInput."%";
		}
		$where['where']["u_device.device_type_id"] = 3;

		if(!empty($where) && count($where)>0){
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",$where,$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",$where,$select,$join,$limit,$start,'p_payment.uid DESC');
		}
		else{
			$select = array("p_payment.uid as uid", "u_subscriber.email as email", "u_subscriber.address_street_1 as address_street_1", "u_subscriber.address_street_2 as address_street_2", "u_subscriber.city as city", "u_subscriber.state as state", "u_subscriber.zipcode as zipcode", "u_subscriber.country as country", "p_payment.transaction_id as transaction_id", "p_card.type as card_type", "p_payment.price as price", "p_payment.date as date");
			$join = array("u_subscriber"=>"u_subscriber.uid=p_payment.s_id, left", "p_card"=>"p_card.uid=p_payment.card_id, left", "u_device"=>"u_device.s_id=u_subscriber.uid, left");
			$tvboxReqCountDataResult = $this->basic->get_data("p_payment",'',$select,$join,'','','p_payment.uid DESC','',1);
			$totalRows = $tvboxReqCountDataResult['extra_index']['num_rows'];

			$tvboxReqDataResult = $this->basic->get_data("p_payment",'',$select,$join,$limit,$start,'p_payment.uid DESC');
		}

		$this->init_pagination(site_url('admin/payment/tvbox_request'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($tvboxReqDataResult as $tvboxReqData) {
			$address = "";
			if(!empty($tvboxReqData['address_street_1'])){
				$address .= $tvboxReqData['address_street_1'];
			}
			if(!empty($tvboxReqData['address_street_2'])){
				$address .= $tvboxReqData['address_street_2'];
			}
			if(!empty($tvboxReqData['city'])){
				$address .= $tvboxReqData['city'];
			}
			if(!empty($tvboxReqData['state'])){
				$address .= $tvboxReqData['state'];
			}
			if(!empty($tvboxReqData['zipcode'])){
				$address .= $tvboxReqData['zipcode'];
			}
			if(!empty($tvboxReqData['country'])){
				$address .= $tvboxReqData['country'];
			}

			$tvboxReqDataArr[$i] = array(
				'uid'=>$tvboxReqData['uid'],
				'email'=>$tvboxReqData['email'],
				'address'=>$address,
				'transaction_id'=>$tvboxReqData['transaction_id'],
				'card_type'=>$tvboxReqData['card_type'],
				'price'=>$tvboxReqData['price'],
				'date'=>$tvboxReqData['date']
				// 'req_status'=>$tvboxReqData['req_status']
			);
			$i++;
		}

		$data['tvboxReqSearchFormEmailInput'] = $tvboxReqSearchFormEmailInput;
		$data['tvboxReqSearchFormDateInput'] = $tvboxReqSearchFormDateInput;
		$data['tvboxReqSearchFormAddressInput'] = $tvboxReqSearchFormAddressInput;

		$data['tvboxReqDataArr'] = $tvboxReqDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/website_payment_list', $data);
	}
	
	// update tvbox request status
	public function saveTvboxRequestStatus(){
		$msg = "";
		$msgType = "";

		$tvboxReqID = $this->input->post("tvboxReqID");
		$tvboxReqStatusVal = $this->input->post("tvboxReqStatusVal");

		if(!empty($tvboxReqStatusVal)){
			$where = array("uid"=>$tvboxReqID);
			$data = array("req_status"=>$tvboxReqStatusVal);
			if($this->basic->update_data("p_tvbox_payment",$where,$data)){
				$msgType = "success";
				$msg = "Request Status updated successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to update Request Status.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Request Status cannot be empty.";
		}

		echo json_encode(array("msg"=>$msg, "msgType"=>$msgType));
	}

	// getting all payment history list
	public function payment_history(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "payment/payment_history");

		$data = array();
		$paymentHistoryDataArr = array();

		$paymentHistorySearchFormEmailInput = "";
		$paymentHistorySearchFormNameInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "paymentHistorySearchFormSubmit")){
			$paymentHistorySearchFormEmailInput = $this->input->post("paymentHistorySearchFormEmailInput");
			$paymentHistorySearchFormNameInput = $this->input->post("paymentHistorySearchFormNameInput");

			$this->session->set_userdata("paymentHistorySearchFormEmailInput", $paymentHistorySearchFormEmailInput);
			$this->session->set_userdata("paymentHistorySearchFormNameInput", $paymentHistorySearchFormNameInput);
		}

		$where = array();
		if($this->session->userdata("paymentHistorySearchFormNameInput") != ""){
			$paymentHistorySearchFormNameInput = $this->session->userdata("paymentHistorySearchFormNameInput");

			$where['or_where']["u_subscriber.first_name LIKE "] = "%".$paymentHistorySearchFormNameInput."%";
			$where['or_where']["u_subscriber.last_name LIKE "] = "%".$paymentHistorySearchFormNameInput."%";
		}
		if($this->session->userdata("paymentHistorySearchFormEmailInput") != ""){
			$paymentHistorySearchFormEmailInput = $this->session->userdata("paymentHistorySearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$paymentHistorySearchFormEmailInput."%";
		}


		if(!empty($where) && count($where)>0){
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",$where,'','','',NULL,'u_subscriber.uid DESC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$select = array("u_subscriber.uid AS uid", "u_subscriber.email AS email", "u_subscriber.first_name AS first_name", "u_subscriber.last_name AS last_name", "p_card.type AS card_type", "p_card.card_no AS card_no", "u_subscriber_plan.type AS subscriber_plan_type");
			$join = array("p_card"=>"p_card.s_id=u_subscriber.uid, left", "u_subscriber_plan"=>"u_subscriber_plan.uid=u_subscriber.plan_id, left");
			$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit,$start,'uid ASC');
		}
		else{
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",'','','','',NULL,'u_subscriber.uid DESC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$select = array("u_subscriber.uid AS uid", "u_subscriber.email AS email", "u_subscriber.first_name AS first_name", "u_subscriber.last_name AS last_name", "p_card.type AS card_type", "p_card.card_no AS card_no", "u_subscriber_plan.type AS subscriber_plan_type");
			$join = array("p_card"=>"p_card.s_id=u_subscriber.uid, left", "u_subscriber_plan"=>"u_subscriber_plan.uid=u_subscriber.plan_id, left");
			$subscriberDataResult = $this->basic->get_data("u_subscriber","",$select,$join,$limit,$start,'uid ASC');
		}

		$this->init_pagination(site_url('admin/payment/payment_history'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($subscriberDataResult as $subscriberData) {
			$totalPayment = 0;
			$subscriberLastPayment = 0;
			$subscriberLastPaymentDate = "";
			$subscriberAutopay = "";
			$subscriberNextPaymentDate = "";
			$subscriberID = $subscriberData["uid"];

			$where = array("where"=>array("s_id"=>$subscriberID));
			$select = array("SUM(price) AS total_payment");
			$subscriberTotalPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,"","",NULL,'p_payment.uid DESC');
			if(!empty($subscriberTotalPaymentDataResult[0]['total_payment'])) 
				$totalPayment = $subscriberTotalPaymentDataResult[0]['total_payment'];


			$select = array("price AS last_payment", "date AS last_payment_date", "autopay", "enddate AS next_payment_date");
			$subscriberLastPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,'',1,NULL,'p_payment.uid DESC');
			if(!empty($subscriberLastPaymentDataResult[0]['last_payment'])) 
				$subscriberLastPayment = $subscriberLastPaymentDataResult[0]['last_payment'];
			if(!empty($subscriberLastPaymentDataResult[0]['last_payment_date'])) 
				$subscriberLastPaymentDate = $subscriberLastPaymentDataResult[0]['last_payment_date'];
			if(!empty($subscriberLastPaymentDataResult[0]['autopay'])) 
				$subscriberAutopay = $subscriberLastPaymentDataResult[0]['autopay'];
			if(!empty($subscriberLastPaymentDataResult[0]['next_payment_date'])) 
				$subscriberNextPaymentDate = $subscriberLastPaymentDataResult[0]['next_payment_date'];


			$paymentHistoryDataArr[$i] = array(
				"uid" => $subscriberID,
				"email" => $subscriberData['email'],
				"first_name" => $subscriberData['first_name'],
				"last_name" => $subscriberData['last_name'],
				"card_type" => $subscriberData['card_type'],
				"card_no" => $subscriberData['card_no'],
				"subscriber_plan_type" => $subscriberData['subscriber_plan_type'],
				"payment_total" => $totalPayment,
				"last_payment" => $subscriberLastPayment,
				"last_payment_date" => $subscriberLastPaymentDate,
				"autopay" => $subscriberAutopay,
				"next_payment_date" => $subscriberNextPaymentDate
			);
			$i++;	
		}


		$data['paymentHistorySearchFormEmailInput'] = $paymentHistorySearchFormEmailInput;
		$data['paymentHistorySearchFormNameInput'] = $paymentHistorySearchFormNameInput;

		$data['paymentHistoryDataArr'] = $paymentHistoryDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/payment_history_list', $data);
	}

	// getting a specific subscriber's payment history list
	public function getSubscriberPayHistoryList(){
		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$subscriberID = $this->input->post("subscriberID", TRUE);

		if(!empty($subscriberID)){
			$where = array("where"=>array("p_payment.s_id"=>$subscriberID));
			$select = array("p_payment.uid AS uid", "p_payment.s_id AS subscriber_id", "p_payment.date AS date", "u_subscriber_plan.type AS plan_type", "p_card.card_no AS card_no", "p_card.type AS card_type", "p_payment.price AS price", "p_payment.autopay AS autopay", "p_payment.startdate AS startdate", "p_payment.enddate AS enddate");
			$join = array("p_card"=>"p_card.s_id=p_payment.card_id, left", "u_subscriber_plan"=>"u_subscriber_plan.uid=p_payment.plan_id, left");
			$subscriberPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,$join,'','','p_payment.uid DESC');			

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "No subscriber id found";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail" => $subscriberPaymentDataResult));
	}

	// getting all suspend list
	public function suspend(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "payment/suspend");

		$data = array();
		$suspendDataArr = array();

		$suspendSearchFormEmailInput = "";
		$suspendSearchFormNameInput = "";

		$subscriberLastPayment = "";
		$subscriberLastPaymentDate = "";
		$subscriberNextPaymentDate = "";
		$subscriberPaymentPendingDuration = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "suspendSearchFormSubmit")){
			$suspendSearchFormEmailInput = $this->input->post("suspendSearchFormEmailInput");
			$suspendSearchFormNameInput = $this->input->post("suspendSearchFormNameInput");

			$this->session->set_userdata("suspendSearchFormEmailInput", $suspendSearchFormEmailInput);
			$this->session->set_userdata("suspendSearchFormNameInput", $suspendSearchFormNameInput);
		}

		$where = array();
		if($this->session->userdata("suspendSearchFormNameInput") != ""){
			$suspendSearchFormNameInput = $this->session->userdata("suspendSearchFormNameInput");

			$where['or_where']["u_subscriber.first_name LIKE "] = "%".$suspendSearchFormNameInput."%";
			$where['or_where']["u_subscriber.last_name LIKE "] = "%".$suspendSearchFormNameInput."%";
		}
		if($this->session->userdata("suspendSearchFormEmailInput") != ""){
			$suspendSearchFormEmailInput = $this->session->userdata("suspendSearchFormEmailInput");

			$where['where']["u_subscriber.email LIKE "] = "%".$suspendSearchFormEmailInput."%";
		}
		$where['where']['active_status'] = 1;


		if(!empty($where) && count($where)>0){
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",$where,'','','',NULL,'u_subscriber.uid DESC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$select = array("u_subscriber.uid AS uid", "u_subscriber.email AS email", "u_subscriber.first_name AS first_name", "u_subscriber.last_name AS last_name", "u_subscriber_plan.type AS subscriber_plan_type");
			$join = array("u_subscriber_plan"=>"u_subscriber_plan.uid=u_subscriber.plan_id, left");
			$subscriberDataResult = $this->basic->get_data("u_subscriber",$where,$select,$join,$limit,$start,'u_subscriber.uid DESC');
		}
		else{
			$subscriberCountDataResult = $this->basic->get_data("u_subscriber",'','','','',NULL,'u_subscriber.uid DESC','',1);
			$totalRows = $subscriberCountDataResult['extra_index']['num_rows'];

			$select = array("u_subscriber.uid AS uid", "u_subscriber.email AS email", "u_subscriber.first_name AS first_name", "u_subscriber.last_name AS last_name", "u_subscriber_plan.type AS subscriber_plan_type");
			$join = array("u_subscriber_plan"=>"u_subscriber_plan.uid=u_subscriber.plan_id, left");
			$subscriberDataResult = $this->basic->get_data("u_subscriber","",$select,$join,$limit,$start,'u_subscriber.uid DESC');
		}

		$this->init_pagination(site_url('admin/payment/suspend'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($subscriberDataResult as $subscriberData) {
			$totalPayment = 0;
			$subscriberLastPayment = 0;
			$subscriberLastPaymentDate = "";
			$subscriberAutopay = "";
			$subscriberNextPaymentDate = "";
			$subscriberID = $subscriberData["uid"];

			$where = array("where"=>array("s_id"=>$subscriberID));
			$select = array("SUM(price) AS total_payment");
			$subscriberTotalPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,"","",NULL,'p_payment.uid DESC');
			if(!empty($subscriberTotalPaymentDataResult[0]['total_payment'])) 
				$totalPayment = $subscriberTotalPaymentDataResult[0]['total_payment'];


			$select = array("p_payment.price AS last_payment", "p_payment.date AS last_payment_date", "p_payment.enddate AS next_payment_date", "DATEDIFF(CURDATE(), p_payment.enddate) AS pending_duration");
			$subscriberLastPaymentDataResult = $this->basic->get_data("p_payment",$where,$select,'',1,NULL,'p_payment.uid DESC');
			if(!empty($subscriberLastPaymentDataResult[0]['last_payment'])) 
				$subscriberLastPayment = $subscriberLastPaymentDataResult[0]['last_payment'];
			if(!empty($subscriberLastPaymentDataResult[0]['last_payment_date'])) 
				$subscriberLastPaymentDate = $subscriberLastPaymentDataResult[0]['last_payment_date'];
			if(!empty($subscriberLastPaymentDataResult[0]['next_payment_date'])) 
				$subscriberNextPaymentDate = $subscriberLastPaymentDataResult[0]['next_payment_date'];
			if(!empty($subscriberLastPaymentDataResult[0]['pending_duration'])) 
				$subscriberPaymentPendingDuration = $subscriberLastPaymentDataResult[0]['pending_duration'];

			$suspendDataArr[$i] = array(
				"uid" => $subscriberID,
				"email" => $subscriberData['email'],
				"first_name" => $subscriberData['first_name'],
				"last_name" => $subscriberData['last_name'],
				"subscriber_plan_type" => $subscriberData['subscriber_plan_type'],
				"payment_total" => $totalPayment,
				"last_payment" => $subscriberLastPayment,
				"last_payment_date" => $subscriberLastPaymentDate,
				"next_payment_date" => $subscriberNextPaymentDate,
				"pending_duration" => $subscriberPaymentPendingDuration
			);
			$i++;	
		}


		$data['suspendSearchFormEmailInput'] = $suspendSearchFormEmailInput;
		$data['suspendSearchFormNameInput'] = $suspendSearchFormNameInput;

		$data['suspendDataArr'] = $suspendDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/suspend_list', $data);
	}
}