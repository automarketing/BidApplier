<?php
require_once('base_controller.php');
class Service extends Base_controller {

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
		 $this->load->helper(array('form','url','html'));
			 $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
		 $this->load->model ( 'acount_db' );
		 $this->load->model ( 'user_model' );
		 $this->load->model ('play_db');
		 $this->load->model('basic');
    }
    public function index()
    {
				$username = $_SESSION['user_name'];
				$userid = $_SESSION['user_id'];
				$useremail = $_SESSION['email'];
				$uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
				$userimg = $uservalue[0]['photo'];
				$server_list = $this->play_db->get_service();
			//	$service_plan = $this->play_db->get_serviceplan($userid);

				$where = array("where"=>array("uid"=>$userid));
		    $service_plan = $this->basic->get_data("u_subscriber",$where);
				if (count($service_plan) > 0)
				           $service_check = $service_plan[0]['plan_id'];
				else
				           $service_check = 0;
        $B = $this->load->view('user/service', array('username' => $username, 'userid'=>$userid
				                  ,'userimg'=>$userimg , 'server_list'=>$server_list,'useremail' => $useremail,
													'service_check'=>$service_check) , TRUE);
        $this->_O( $B );
    }
		public function datasave()
		{
			$type  = $_REQUEST['type'];
			$price  = $_REQUEST['price'];
			$userid   = $_SESSION['user_id'];
			$where = array("uid"=>$userid);
			$data = array("plan_id"=>$type);
			$service_checkpart = $this->basic->get_data("u_subscriber",$where);
      $this->basic->update_data("u_subscriber",$where,$data);
			// $service_checkpart = $this->play_db->get_serviceplan($userid);
			// if (count($service_checkpart) > 0)
			// 	  $this->play_db->update_serviceplan($type , $userid , $price);
			// else
			//     $this->play_db->insert_serviceplan($type , $userid , $price);
			echo ("Yes");
		}


}
