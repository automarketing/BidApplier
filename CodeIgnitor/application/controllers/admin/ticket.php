<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Ticket extends Base_controller {

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

	public function open(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "ticket/open");

		$data = array();
		$msgType = "";
		$msg = "";

		$openTicketSubscriberEmailInput = array();
		$openTicketQuestionInput = "";
		$openTicketDetailInput = "";

		// getting loggedin user data from session
		$loginUserID = $this->session->userdata('loginUserID');
		$loginUserType = $this->session->userdata('loginUserType');

		
		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "openTicketFormSubmit")){
			$openTicketSubscriberEmailInput = $this->input->post("openTicketSubscriberEmailInput");
			$openTicketQuestionInput = $this->input->post("openTicketQuestionInput");
			$openTicketDetailInput = $this->input->post("openTicketDetailInput");

			if(count($openTicketSubscriberEmailInput)>0){
				if(!empty($openTicketQuestionInput)){
					if(!empty($openTicketDetailInput)){
						foreach($openTicketSubscriberEmailInput as $subscriberID){
							// inserting data to ticket table
							$postDatetime = date("Y-m-d H:i:s");

							$data = array("tq_id"=>$openTicketQuestionInput, "from_user_id"=>$loginUserID, "from_user_type"=>"admin", "to_user_id"=>$subscriberID, "to_user_type"=>"subscriber", "open_datetime"=>$postDatetime, "close_datetime"=>"", "active_status"=>1);
							$this->basic->insert_data("ticket",$data);
							$ticketID = $this->db->insert_id();

							// inserting data to ticket detail table
							$data = array("t_id"=>$ticketID, "datetime"=>$postDatetime, "desc"=>$openTicketDetailInput, "from_user_id"=>$loginUserID, "from_user_type"=>"admin", "to_user_id"=>$subscriberID, "to_user_type"=>"subscriber");
							$this->basic->insert_data("ticket_detail",$data);
						}

						$openTicketSubscriberEmailInput = array();
						$openTicketQuestionInput = "";
						$openTicketDetailInput = "";

						$msgType = "success";
						$msg = "Ticket saved successfully.";
					}
					else{
						$msgType = "error";
						$msg = "Ticket Details cannot be empty.";
					}
				}
				else{
					$msgType = "error";
					$msg = "You must select at least 1 Question.";
				}
			}
			else{
				$msgType = "error";
				$msg = "You must select at least 1 Subscriber.";
			}
		}

		// getting all subscriber in list
		$select = array("uid", "first_name", "last_name", "email");
		$subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,'','',NULL,$order_by='first_name');

		// getting all ticket questions in list
		$where = array("where"=>array("active_status"=>1));
		$select = array("uid", "question");
		$ticketQuestionDataResult = $this->basic->get_data("ticket_questions",$where,$select,'','',NULL,$order_by='question');


		$data['openTicketSubscriberEmailInput'] = $openTicketSubscriberEmailInput;
		$data['openTicketQuestionInput'] = $openTicketQuestionInput;
		$data['openTicketDetailInput'] = $openTicketDetailInput;
		
		$data['subscriberDataResult'] = $subscriberDataResult;
		$data['ticketQuestionDataResult'] = $ticketQuestionDataResult;

		$data['msgType'] = $msgType;
		$data['msg'] = $msg;

        $this->_O('admin/open_ticket', $data);
	}


	public function active(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "ticket/active");

		$data = array();
		$activeTicketDataArr = array();

		$activeTicketSearchFormEmailInput = "";
		$activeTicketSearchFormFromDateInput = "";
		$activeTicketSearchFormToDateInput = "";

		// getting loggedin user data from session
		$loginUserID = $this->session->userdata('loginUserID');
		$loginUserType = $this->session->userdata('loginUserType');


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "activeTicketFormSubmit")){
			$activeTicketSearchFormEmailInput = $this->input->post("activeTicketSearchFormEmailInput");
			$activeTicketSearchFormFromDateInput = $this->input->post("activeTicketSearchFormFromDateInput");
			$activeTicketSearchFormToDateInput = $this->input->post("activeTicketSearchFormToDateInput");

			$this->session->set_userdata("activeTicketSearchFormEmailInput", $activeTicketSearchFormEmailInput);
			$this->session->set_userdata("activeTicketSearchFormFromDateInput", $activeTicketSearchFormFromDateInput);
			$this->session->set_userdata("activeTicketSearchFormToDateInput", $activeTicketSearchFormToDateInput);
		}

		$where = array();
		if($this->session->userdata("activeTicketSearchFormEmailInput") != ""){
			$activeTicketSearchFormEmailInput = $this->session->userdata("activeTicketSearchFormEmailInput");

			$where['or_where']["s.email LIKE "] = "%".$activeTicketSearchFormEmailInput."%";
			$where['or_where']["a.email LIKE "] = "%".$activeTicketSearchFormEmailInput."%";
		}
		if($this->session->userdata("activeTicketSearchFormFromDateInput") != ""){
			$activeTicketSearchFormFromDateInput = $this->session->userdata("activeTicketSearchFormFromDateInput");

			$where['where']["t.open_datetime >= "] = $activeTicketSearchFormFromDateInput;
		}
		if($this->session->userdata("activeTicketSearchFormToDateInput") != ""){
			$activeTicketSearchFormToDateInput = $this->session->userdata("activeTicketSearchFormToDateInput");

			$where['where']["t.open_datetime <= "] = $activeTicketSearchFormToDateInput;
		}
		$where['where']['t.active_status'] = 1;


		if(!empty($where) && count($where)>0){
			$select = array("t.uid AS uid", "tq.question AS question", "IF(t.from_user_type='subscriber', s.email, a.email) AS sender_email", "t.from_user_type AS sender_type", "IF(t.to_user_type='subscriber', s.email, a.email) AS receiver_email", "t.to_user_type AS receiver_type", "t.open_datetime AS open_datetime", "t.close_datetime AS close_datetime");
			$join = array("ticket_questions tq"=>"tq.uid = t.tq_id, left", "u_subscriber s"=>"s.uid = IF(t.from_user_type = 'subscriber',t.from_user_id,t.to_user_id)", "u_admin a"=>"a.uid = IF(t.from_user_type = 'admin', t.from_user_id, t.to_user_id)");

			$activeTicketCountDataResult = $this->basic->get_data("ticket t",$where,$select,$join,'',NULL,'uid DESC','',1);
			$totalRows = $activeTicketCountDataResult['extra_index']['num_rows'];

			$activeTicketDataResult = $this->basic->get_data("ticket t",$where,$select,$join,$limit,$start,'t.uid DESC');

		}
		else{
			$select = array("t.uid AS uid", "tq.question AS question", "IF(t.from_user_type='subscriber', s.email, a.email) AS sender_email", "t.from_user_type AS sender_type", "IF(t.to_user_type='subscriber', s.email, a.email) AS receiver_email", "t.to_user_type AS receiver_type", "t.open_datetime AS open_datetime", "t.close_datetime AS close_datetime");
			$join = array("ticket_questions tq"=>"tq.uid = t.tq_id, left", "u_subscriber s"=>"s.uid = IF(t.from_user_type = 'subscriber',t.from_user_id,t.to_user_id)", "u_admin a"=>"a.uid = IF(t.from_user_type = 'admin', t.from_user_id, t.to_user_id)");

			$activeTicketCountDataResult = $this->basic->get_data("ticket t",'',$select,$join,'',NULL,'uid DESC','',1);
			$totalRows = $activeTicketCountDataResult['extra_index']['num_rows'];

			$activeTicketDataResult = $this->basic->get_data("ticket t",'',$select,$join,$limit,$start,'t.uid DESC');
		}

		$this->init_pagination(site_url('admin/ticket/active'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($activeTicketDataResult as $activeTicketData) {
			$activeTicketDataArr[$i] = array(
				"uid" => $activeTicketData['uid'],
				"question" => $activeTicketData['question'],
				"sender_email" => $activeTicketData['sender_email'],
				"sender_type" => $activeTicketData['sender_type'],
				"receiver_email" => $activeTicketData['receiver_email'],
				"receiver_type" => $activeTicketData['receiver_type'],
				"open_datetime" => $activeTicketData['open_datetime'],
				"close_datetime" => $activeTicketData['close_datetime']
			);
			$i++;	
		}


		$data['activeTicketSearchFormEmailInput'] = $activeTicketSearchFormEmailInput;
		$data['activeTicketSearchFormFromDateInput'] = $activeTicketSearchFormFromDateInput;
		$data['activeTicketSearchFormToDateInput'] = $activeTicketSearchFormToDateInput;

		$data['activeTicketDataArr'] = $activeTicketDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/active_ticket', $data);
	}

	public function closed(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "ticket/closed");

		$data = array();
		$closedTicketDataArr = array();

		$closedTicketSearchFormEmailInput = "";
		$closedTicketSearchFormFromDateInput = "";
		$closedTicketSearchFormToDateInput = "";

		// getting loggedin user data from session
		$loginUserID = $this->session->userdata('loginUserID');
		$loginUserType = $this->session->userdata('loginUserType');


		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "closedTicketFormSubmit")){
			$closedTicketSearchFormEmailInput = $this->input->post("closedTicketSearchFormEmailInput");
			$closedTicketSearchFormFromDateInput = $this->input->post("closedTicketSearchFormFromDateInput");
			$closedTicketSearchFormToDateInput = $this->input->post("closedTicketSearchFormToDateInput");

			$this->session->set_userdata("closedTicketSearchFormEmailInput", $closedTicketSearchFormEmailInput);
			$this->session->set_userdata("closedTicketSearchFormFromDateInput", $closedTicketSearchFormFromDateInput);
			$this->session->set_userdata("closedTicketSearchFormToDateInput", $closedTicketSearchFormToDateInput);
		}

		$where = array();
		if($this->session->userdata("closedTicketSearchFormEmailInput") != ""){
			$closedTicketSearchFormEmailInput = $this->session->userdata("closedTicketSearchFormEmailInput");

			$where['or_where']["s.email LIKE "] = "%".$closedTicketSearchFormEmailInput."%";
			$where['or_where']["a.email LIKE "] = "%".$closedTicketSearchFormEmailInput."%";
		}
		if($this->session->userdata("closedTicketSearchFormFromDateInput") != ""){
			$closedTicketSearchFormFromDateInput = $this->session->userdata("closedTicketSearchFormFromDateInput");

			$where['where']["t.open_datetime >= "] = $closedTicketSearchFormFromDateInput;
		}
		if($this->session->userdata("closedTicketSearchFormToDateInput") != ""){
			$closedTicketSearchFormToDateInput = $this->session->userdata("closedTicketSearchFormToDateInput");

			$where['where']["t.open_datetime <= "] = $closedTicketSearchFormToDateInput;
		}
		$where['where']['t.active_status'] = 0;


		if(!empty($where) && count($where)>0){
			$select = array("t.uid AS uid", "tq.question AS question", "IF(t.from_user_type='subscriber', s.email, a.email) AS sender_email", "t.from_user_type AS sender_type", "IF(t.to_user_type='subscriber', s.email, a.email) AS receiver_email", "t.to_user_type AS receiver_type", "t.open_datetime AS open_datetime", "t.close_datetime AS close_datetime");
			$join = array("ticket_questions tq"=>"tq.uid = t.tq_id, left", "u_subscriber s"=>"s.uid = IF(t.from_user_type = 'subscriber',t.from_user_id,t.to_user_id)", "u_admin a"=>"a.uid = IF(t.from_user_type = 'admin', t.from_user_id, t.to_user_id)");

			$closedTicketCountDataResult = $this->basic->get_data("ticket t",$where,$select,$join,'',NULL,'uid DESC','',1);
			$totalRows = $closedTicketCountDataResult['extra_index']['num_rows'];

			$closedTicketDataResult = $this->basic->get_data("ticket t",$where,$select,$join,$limit,$start,'t.uid DESC');

		}
		else{
			$select = array("t.uid AS uid", "tq.question AS question", "IF(t.from_user_type='subscriber', s.email, a.email) AS sender_email", "t.from_user_type AS sender_type", "IF(t.to_user_type='subscriber', s.email, a.email) AS receiver_email", "t.to_user_type AS receiver_type", "t.open_datetime AS open_datetime", "t.close_datetime AS close_datetime");
			$join = array("ticket_questions tq"=>"tq.uid = t.tq_id, left", "u_subscriber s"=>"s.uid = IF(t.from_user_type = 'subscriber',t.from_user_id,t.to_user_id)", "u_admin a"=>"a.uid = IF(t.from_user_type = 'admin', t.from_user_id, t.to_user_id)");

			$closedTicketCountDataResult = $this->basic->get_data("ticket t",'',$select,$join,'',NULL,'uid DESC','',1);
			$totalRows = $closedTicketCountDataResult['extra_index']['num_rows'];

			$closedTicketDataResult = $this->basic->get_data("ticket t",'',$select,$join,$limit,$start,'t.uid DESC');
		}

		$this->init_pagination(site_url('admin/ticket/active'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($closedTicketDataResult as $closedTicketData) {
			$closedTicketDataArr[$i] = array(
				"uid" => $closedTicketData['uid'],
				"question" => $closedTicketData['question'],
				"sender_email" => $closedTicketData['sender_email'],
				"sender_type" => $closedTicketData['sender_type'],
				"receiver_email" => $closedTicketData['receiver_email'],
				"receiver_type" => $closedTicketData['receiver_type'],
				"open_datetime" => $closedTicketData['open_datetime'],
				"close_datetime" => $closedTicketData['close_datetime']
			);
			$i++;	
		}


		$data['closedTicketSearchFormEmailInput'] = $closedTicketSearchFormEmailInput;
		$data['closedTicketSearchFormFromDateInput'] = $closedTicketSearchFormFromDateInput;
		$data['closedTicketSearchFormToDateInput'] = $closedTicketSearchFormToDateInput;

		$data['closedTicketDataArr'] = $closedTicketDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/closed_ticket', $data);
	}


	public function getTicketDetailHistoryList(){
		$ticketDetailDataResult = array();
		
		$ticketID = $this->input->post("ticketID");

		$select = array("td.uid as uid", "td.datetime as datetime", "td.desc as description", "IF(td.from_user_type='subscriber', CONCAT(s.first_name,' ',s.last_name), CONCAT(a.first_name,' ',a.last_name)) AS sender_name", "IF(td.from_user_type='subscriber', s.email, a.email) AS sender_email", "td.from_user_type AS sender_type");
		$where = array("where"=>array("td.t_id"=>$ticketID));
		$join = array("u_subscriber s"=>"s.uid = IF(td.from_user_type = 'subscriber',td.from_user_id,td.to_user_id)", "u_admin a"=>"a.uid = IF(td.from_user_type = 'admin', td.from_user_id, td.to_user_id)");
		$ticketDetailDataResult = $this->basic->get_data("ticket_detail td",$where,$select,$join,'',NULL,'td.uid ASC');

		echo json_encode(array("ticketDetailDataResult"=>$ticketDetailDataResult));
	}


	public function ticket_questions(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "ticket/ticket_questions");

		$data = array();
		$ticketQuestionDataArr = array();

		$ticketQuestionSearchFormQuestionInput = "";

		$limit = 20;
		$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$event = $this->input->post("event");
		if(!empty($event) && !strcmp($event, "ticketQuestionSearchFormSubmit")){
			$ticketQuestionSearchFormQuestionInput = $this->input->post("ticketQuestionSearchFormQuestionInput");

			$this->session->set_userdata("ticketQuestionSearchFormQuestionInput", $ticketQuestionSearchFormQuestionInput);
		}

		$where = array();
		if($this->session->userdata("ticketQuestionSearchFormQuestionInput") != ""){
			$ticketQuestionSearchFormQuestionInput = $this->session->userdata("ticketQuestionSearchFormQuestionInput");

			$where['where']["question LIKE "] = "%".$ticketQuestionSearchFormQuestionInput."%";
		}

		if(!empty($where) && count($where)>0){
			$ticketQuestionCountDataResult = $this->basic->get_data("ticket_questions",$where,"","","",NULL,'question ASC','',1);
			$totalRows = $ticketQuestionCountDataResult['extra_index']['num_rows'];

			$ticketQuestionDataResult = $this->basic->get_data("ticket_questions",$where,"","",$limit,$start,'question ASC');
		}
		else{
			$ticketQuestionCountDataResult = $this->basic->get_data("ticket_questions",'','','','',NULL,'question ASC','',1);
			$totalRows = $ticketQuestionCountDataResult['extra_index']['num_rows'];

			$ticketQuestionDataResult = $this->basic->get_data("ticket_questions","","","",$limit,$start,'question ASC');
		}

		$this->init_pagination(site_url('admin/ticket/ticket_questions'), $totalRows, $limit);
		$paginationLink = $this->pagination->create_links();

		$i=0;
		foreach ($ticketQuestionDataResult as $ticketQuestionData) {
			$ticketQuestionDataArr[$i] = array(
				"uid" => $ticketQuestionData["uid"],
				"question" => $ticketQuestionData['question'],
				"active_status" => $ticketQuestionData['active_status']
			);
			$i++;	
		}

		$data['ticketQuestionSearchFormQuestionInput'] = $ticketQuestionSearchFormQuestionInput;

		$data["ticketQuestionDataArr"] = $ticketQuestionDataArr;
		$data['paginationLink'] = $paginationLink;

        $this->_O('admin/ticket_question_list', $data);
	}


	public function addTicketQuestionData(){
		$msgType = "";
		$msg = "";

		$questionInput = $this->input->post("questionInput");

		if(!empty($questionInput)){
			$select = array("uid");
			$where = array("question"=>$questionInput);
			if($this->basic->is_unique("ticket_questions",$where,$select)){
				$data = array("question"=>$questionInput, "active_status"=>1);
				if($this->basic->insert_data("ticket_questions",$data)){
					$msgType = "success";
					$msg = "This Question is saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Question.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Question is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Question cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function updateTicketQuestionActiveData(){
		$msgType = "";
		$msg = "";

		$ticketQuestionID = $this->input->post("ticketQuestionID");
		$titcketQuestionActiveStatus = $this->input->post("titcketQuestionActiveStatus");

		if(!empty($ticketQuestionID)){
			$where = array("uid"=>$ticketQuestionID);
			$data = array("active_status"=>$titcketQuestionActiveStatus);
			if($this->basic->update_data("ticket_questions",$where,$data)){
				$msgType = "success";
				$msg = "This Question activated successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to update active status This Question.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Question id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function getTicketQuestionData(){
		$msgType = "";
		$msg = "";
		$msgDetail = array();

		$ticketQuestionID = $this->input->post("ticketQuestionID");

		if(!empty($ticketQuestionID)){
			$where = array("where"=>array("uid"=>$ticketQuestionID));
			$ticketQuestionDataResult = $this->basic->get_data("ticket_questions",$where);

			$msgType = "success";
		}
		else{
			$msgType = "error";
			$msg = "Question id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg, "msgDetail"=>$ticketQuestionDataResult));
	}

	public function updateTicketQuestionData(){
		$msgType = "";
		$msg = "";

		$questionEditInput = $this->input->post("questionEditInput", TRUE);
		$ticketQuestionID = $this->input->post("ticketQuestionID", TRUE);

		if(!empty($questionEditInput) && !empty($ticketQuestionID)){
			$where = array("uid"=>$ticketQuestionID);
			$data = array("question"=>$questionEditInput);
			if($this->basic->update_data("ticket_questions",$where,$data)){
				$msgType = "success";
				$msg = "Question updated successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to update Question.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Question and Question id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}
}