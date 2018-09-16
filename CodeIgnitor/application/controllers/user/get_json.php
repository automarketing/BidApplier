<?php
require_once('base_controller.php');
class Get_json extends Base_controller {
	 public function __construct() {
		 parent::__construct ();
		 $this->load->database();
		 $this->load->helper(array('form','url','html'));
 		 $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
     $this->load->model('basic');
    }
    public function register()
    {
			  // $deviceArray = json_decode($data, true);
				$email = trim($_GET['email']);
				$password = trim($_GET['password']);
				$device_id = trim($_GET['device_id']);
				$device_type = trim($_GET['device_type']);
				// $where = array();
				// $where = array("id != "=>$countryID, "country"=>$countryEditInput);
				// $where['where']["email = "] = $email;
				// $where['where']["password = md5('"] = $password."')";
				$where = array('where'=>array('email'=>$email,'password'=>md5($password)));
				$check = $this->basic->get_data('u_subscriber',$where);
				if(count($check) > 0)
				{
					if($device_type ="1")
            {
							$data = array("device_id_mobile"=>$device_id);
						}
					else
					{
						 $data = array("device_id_tv"=>$device_id);
					}
					  $where1 = array("email"=>$email);
					  // $where = array('where'=>array('email'=>$email,'password'=>md5($password)));
            $this->basic->update_data("u_subscriber",$where1,$data);
						echo "Yes";
				}
					else {
						echo "No";
					}
    }
		public function check()
		{
			$email = trim($_GET['email']);
			$device_id = trim($_GET['device_id']);
			$device_type = trim($_GET['device_type']);
			$date_format = "Y-m-d";
			$yesterday = strtotime('-1 day');
			$tomorrow = strtotime('+1 day');
			$yesterday_value = date($date_format, $yesterday);
	    $today_value = date($date_format);
	    $tomorrow_value = date($date_format, $tomorrow);
			$where['where']["email = "] = $email;
			$check_value = $this->basic->get_data("u_subscriber",$where);
			if($device_type ="1")
			{
				 $md1 = md5($check_value[0]['device_id_mobile'].$yesterday_value);
				 $md2 = md5($check_value[0]['device_id_mobile'].$today_value);
				 $md3 = md5($check_value[0]['device_id_mobile'].$tomorrow_value);
				 if($md1 = $device_id || $md2 = $device_id || $md3 = $device_id)
				     echo "Yes";
				 else
				     echo "No";
			}
			else
			{
				$md1 = md5($check_value[0]['device_id_tv'].$yesterday_value);
				$md2 = md5($check_value[0]['device_id_tv'].$today_value);
				$md3 = md5($check_value[0]['device_id_tv'].$tomorrow_value);
				if($md1 = $device_id || $md2 = $device_id || $md3 = $device_id)
						echo "Yes";
				else
						echo "No";
			}
		}
}
