<?php
require_once('base_controller.php');
class Openticket extends Base_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct() {
		 parent::__construct ();
		 $this->load->database();
		 $this->load->model ( 'acount_db' );
		 $this->load->model ( 'user_model' );
     $this->load->model ( 'ticket_db' );
		 $this->load->model('basic');
		 $this->load->helper(array('form','url','html'));
		 $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
    }
    public function index()
    {
				// $username = $_SESSION['user_name'];
				$userid = $_SESSION['user_id'];
				// $userimg = $_SESSION['photo'];
				// $ticket_list = $this->ticket_db->get_ticket(7);
        // $B = $this->load->view('user/open_ticket', array('username' => $username, 'userid'=>$userid ,'userimg'=>$userimg ,
				//                       'ticket_list' => $ticket_list) , TRUE);
        // $this->_O( $B );

				$data = array();
				$msgType = "";
				$msg = "";

				// $openTicketSubscriberEmailInput = array();
				$openTicketQuestionInput = "";
				$openTicketDetailInput = "";

				// getting loggedin user data from session
				$loginUserID = $this->session->userdata('loginUserID');
				$loginUserType = $this->session->userdata('loginUserType');


				$event = $this->input->post("event");
				if(!empty($event) && !strcmp($event, "openTicketFormSubmit")){
					// $openTicketSubscriberEmailInput = $this->input->post("openTicketSubscriberEmailInput");
					$openTicketQuestionInput = $this->input->post("openTicketQuestionInput");
					$openTicketDetailInput = $this->input->post("openTicketDetailInput");

					// if(count($openTicketSubscriberEmailInput)>0){
						if(!empty($openTicketQuestionInput)){
							if(!empty($openTicketDetailInput)){
								// foreach($openTicketSubscriberEmailInput as $subscriberID){
									// inserting data to ticket table
									$postDatetime = date("Y-m-d H:i:s");

									$data = array("tq_id"=>$openTicketQuestionInput, "from_user_id"=>$userid, "from_user_type"=>"subscriber", "to_user_id"=>1, "to_user_type"=>"admin", "open_datetime"=>$postDatetime, "close_datetime"=>"", "active_status"=>1);
									$this->basic->insert_data("ticket",$data);
									$ticketID = $this->db->insert_id();

									// inserting data to ticket detail table
									$data = array("t_id"=>$ticketID, "datetime"=>$postDatetime, "desc"=>$openTicketDetailInput, "from_user_id"=>$userid, "from_user_type"=>"subscriber", "to_user_id"=>1, "to_user_type"=>"admin");
									$this->basic->insert_data("ticket_detail",$data);
								// }

								// $openTicketSubscriberEmailInput = array();
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
					// }
					// else{
					// 	$msgType = "error";
					// 	$msg = "You must select at least 1 Subscriber.";
					// }
				}

				// getting all subscriber in list
				$select = array("uid", "first_name", "last_name", "email");
				$subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,'','',NULL,$order_by='first_name');

				// getting all ticket questions in list
				$where = array("where"=>array("active_status"=>1));
				$select = array("uid", "question");
				$ticketQuestionDataResult = $this->basic->get_data("ticket_questions",$where,$select,'','',NULL,$order_by='question');


				// $data['openTicketSubscriberEmailInput'] = $openTicketSubscriberEmailInput;
				$data['openTicketQuestionInput'] = $openTicketQuestionInput;
				$data['openTicketDetailInput'] = $openTicketDetailInput;

				$data['subscriberDataResult'] = $subscriberDataResult;
				$data['ticketQuestionDataResult'] = $ticketQuestionDataResult;

				$data['msgType'] = $msgType;
				$data['msg'] = $msg;

				$data['username'] = $_SESSION['user_name'];
				$data['useremail'] = $_SESSION['email'];
				$data['userid'] = $userid;
				$uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
				$userimg = $uservalue[0]['photo'];
				$data['userimg'] = $userimg;

				 $B = $this->load->view('user/open_ticket', $data , TRUE);
				 $this->_O( $B );
		        // $this->_O('user/open_ticket', $data);
    }
		public function list_ticket()
		{
			$data = array();
		 $activeTicketDataArr = array();

		//  $activeTicketSearchFormEmailInput = "";
		 $activeTicketSearchFormFromDateInput = "";
		 $activeTicketSearchFormToDateInput = "";

		 // getting loggedin user data from session
		 $loginUserID = $this->session->userdata('loginUserID');
		 $loginUserType = $this->session->userdata('loginUserType');
     $userid = $_SESSION['user_id'];

		 $limit = 20;
		 $start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		 $event = $this->input->post("event");
		 if(!empty($event) && !strcmp($event, "activeTicketFormSubmit")){
			//  $activeTicketSearchFormEmailInput = $this->input->post("activeTicketSearchFormEmailInput");
			 $activeTicketSearchFormFromDateInput = $this->input->post("activeTicketSearchFormFromDateInput");
			 $activeTicketSearchFormToDateInput = $this->input->post("activeTicketSearchFormToDateInput");

			//  $this->session->set_userdata("activeTicketSearchFormEmailInput", $activeTicketSearchFormEmailInput);
			 $this->session->set_userdata("activeTicketSearchFormFromDateInput", $activeTicketSearchFormFromDateInput);
			 $this->session->set_userdata("activeTicketSearchFormToDateInput", $activeTicketSearchFormToDateInput);
		 }

		 $where = array();
		//  if($this->session->userdata("activeTicketSearchFormEmailInput") != ""){
		// 	 $activeTicketSearchFormEmailInput = $this->session->userdata("activeTicketSearchFormEmailInput");
		 //
		// 	 $where['or_where']["s.email LIKE "] = "%".$activeTicketSearchFormEmailInput."%";
		// 	 $where['or_where']["a.email LIKE "] = "%".$activeTicketSearchFormEmailInput."%";
		//  }

		 $where['where']["t.from_user_id || t.to_user_id = "] = $userid;
		 if($this->session->userdata("activeTicketSearchFormFromDateInput") != ""){
			 $activeTicketSearchFormFromDateInput = $this->session->userdata("activeTicketSearchFormFromDateInput");

			 $where['where']["t.open_datetime >= "] = $activeTicketSearchFormFromDateInput;
		 }
		 if($this->session->userdata("activeTicketSearchFormToDateInput") != ""){
			 $activeTicketSearchFormToDateInput = $this->session->userdata("activeTicketSearchFormToDateInput");

			 $where['where']["t.open_datetime <= "] = $activeTicketSearchFormToDateInput;
		 }
		//  $where['where']['t.active_status'] = 1;


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

		 $this->init_pagination(site_url('user/openticket/list_ticket'), $totalRows, $limit);
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


		//  $data['activeTicketSearchFormEmailInput'] = $activeTicketSearchFormEmailInput;
		 $data['activeTicketSearchFormFromDateInput'] = $activeTicketSearchFormFromDateInput;
		 $data['activeTicketSearchFormToDateInput'] = $activeTicketSearchFormToDateInput;

		 $data['activeTicketDataArr'] = $activeTicketDataArr;
		 $data['paginationLink'] = $paginationLink;
		 $data['username'] = $_SESSION['user_name'];
		 $data['userid'] = $userid;
		 $data['useremail'] = $_SESSION['email'];
		 $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
		 $userimg = $uservalue[0]['photo'];
		 $data['userimg'] = $userimg;

			$B = $this->load->view('user/ticket_list', $data , TRUE);
			$this->_O( $B );
		}

		public function getTicketDetailHistoryList(){
			$ticketDetailDataResult = array();

			$ticketID = $this->input->post("ticketID");

			$select = array("td.uid as uid","t.close_datetime as close_datetime","td.datetime as datetime", "tq.question as question", "td.desc as description", "IF(t.from_user_type='admin',t.from_user_id,t.to_user_id) as sendid_value" ,"IF(td.from_user_type='subscriber', CONCAT(s.first_name,' ',s.last_name), CONCAT(a.first_name,' ',a.last_name)) AS sender_name", "IF(td.from_user_type='subscriber', s.email, a.email) AS sender_email", "td.from_user_type AS sender_type");
			$where = array("where"=>array("td.t_id"=>$ticketID));
			$join = array("ticket t"=>"t.uid = td.t_id, left","ticket_questions tq"=>"tq.uid = t.tq_id, left","u_subscriber s"=>"s.uid = IF(td.from_user_type = 'subscriber',td.from_user_id,td.to_user_id)", "u_admin a"=>"a.uid = IF(td.from_user_type = 'admin', td.from_user_id, td.to_user_id)");
			$ticketDetailDataResult = $this->basic->get_data("ticket_detail td",$where,$select,$join,'',NULL,'td.uid ASC');

			echo json_encode(array("ticketDetailDataResult"=>$ticketDetailDataResult));
		}
   public function resendticket(){
		  $message = $this->input->post("message");
			$ticketID = $this->input->post("ticketID");
			$adminID = $this->input->post("adminID");
			$postDatetime = date("Y-m-d H:i:s");
      $userid = $_SESSION['user_id'];
			$data = array("t_id"=>$ticketID, "datetime"=>$postDatetime, "desc"=>$message, "from_user_id"=>$userid, "from_user_type"=>"subscriber", "to_user_id"=>$adminID, "to_user_type"=>"admin");
			$this->basic->insert_data("ticket_detail",$data);
	 }

		public function tvbox_exchang(){
			// $username = $_SESSION['user_name'];
		 $userid = $_SESSION['user_id'];
		 $data = array();
		 $msgType = "";
		 $msg = "";

		 // $openTicketSubscriberEmailInput = array();
		 $openTicketQuestionInput = "";
		 $openTicketDetailInput = "";

		 // getting loggedin user data from session
		 $loginUserID = $this->session->userdata('loginUserID');
		 $loginUserType = $this->session->userdata('loginUserType');


		 $event = $this->input->post("event");
		 if(!empty($event) && !strcmp($event, "openTicketFormSubmit")){
			 // $openTicketSubscriberEmailInput = $this->input->post("openTicketSubscriberEmailInput");
			 $openTicketQuestionInput = $this->input->post("openTicketQuestionInput");
			 $openTicketDetailInput = $this->input->post("openTicketDetailInput");

			 // if(count($openTicketSubscriberEmailInput)>0){
				 if(!empty($openTicketQuestionInput)){
					 if(!empty($openTicketDetailInput)){
						 // foreach($openTicketSubscriberEmailInput as $subscriberID){
							 // inserting data to ticket table
							 $postDatetime = date("Y-m-d H:i:s");

							 $data = array("tq_id"=>$openTicketQuestionInput, "from_user_id"=>$userid, "from_user_type"=>"subscriber", "to_user_id"=>1, "to_user_type"=>"admin", "open_datetime"=>$postDatetime, "close_datetime"=>"", "active_status"=>1);
							 $this->basic->insert_data("ticket",$data);
							 $ticketID = $this->db->insert_id();

							 // inserting data to ticket detail table
							 $data = array("t_id"=>$ticketID, "datetime"=>$postDatetime, "desc"=>$openTicketDetailInput, "from_user_id"=>$userid, "from_user_type"=>"subscriber", "to_user_id"=>1, "to_user_type"=>"admin");
							 $this->basic->insert_data("ticket_detail",$data);
						 // }

						 // $openTicketSubscriberEmailInput = array();
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

		 // getting all subscriber in list
		 $select = array("uid", "first_name", "last_name", "email");
		 $subscriberDataResult = $this->basic->get_data("u_subscriber",'',$select,'','',NULL,$order_by='first_name');

		 // getting all ticket questions in list
		 $where = array("where"=>array("active_status"=>1));
		 $select = array("uid", "question");
		 $ticketQuestionDataResult = $this->basic->get_data("ticket_questions",$where,$select,'','',NULL,$order_by='question');


		 // $data['openTicketSubscriberEmailInput'] = $openTicketSubscriberEmailInput;
		 $data['openTicketQuestionInput'] = $openTicketQuestionInput;
		 $data['openTicketDetailInput'] = $openTicketDetailInput;

		 $data['subscriberDataResult'] = $subscriberDataResult;
		 $data['ticketQuestionDataResult'] = $ticketQuestionDataResult;

		 $data['msgType'] = $msgType;
		 $data['msg'] = $msg;

		 $data['username'] = $_SESSION['user_name'];
		 $data['useremail'] = $_SESSION['email'];
		 $data['userid'] = $userid;
		 $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
		 $userimg = $uservalue[0]['photo'];
		 $data['userimg'] = $userimg;

			$B = $this->load->view('user/tvbox_ticket', $data , TRUE);
			$this->_O( $B );
				 // $this->_O('user/open_ticket', $data);
		}

}
