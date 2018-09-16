<?php
require_once('base_controller.php');
class Address extends Base_controller {

	 public function __construct() {
		 parent::__construct ();
		 $this->load->database();
		 $this->load->model ( 'acount_db' );
		 $this->load->model ( 'user_model' );
		 $this->load->helper(array('form','url','html'));
 		 $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
		 $this->load->model('basic');

    }
   public function index()
    {
			  $where = array("where"=>array("flag"=>1));
			  $countryDataResult = $this->basic->get_data("b_countries",$where,"","","","",'b_countries.country ASC');
				$stateDataResult = $this->basic->get_data("b_states","","","",'',"",'b_states.state ASC');
				$cityDataResult = $this->basic->get_data("b_cities","","","",'',"",'b_cities.city ASC');
			  $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);

				$firstnm = $uservalue[0]['first_name'];
				$lastnm = $uservalue[0]['last_name'];
				$company = $uservalue[0]['company'];
				$telephone = $uservalue[0]['telephone'];
				$city = $uservalue[0]['city'];
				$state = $uservalue[0]['state'];
				$address1 = $uservalue[0]['address_street_1'];
				$address2 = $uservalue[0]['address_street_2'];
				$fax = $uservalue[0]['fax'];
				$zipcode = $uservalue[0]['zipcode'];
				$country = $uservalue[0]['country'];
        $username = $_SESSION['user_name'];
				$useremail = $_SESSION['email'];
				$userid = $_SESSION['user_id'];
				$userimg = $uservalue[0]['photo'];

        $B = $this->load->view('user/address', array( 'firstnm' => $firstnm, 'lastnm'=>$lastnm ,
				   'company'=>$company,'telephone' => $telephone, 'city'=>$city ,'state'=>$state, 'address1'=>$address1 ,
	 				 'address2'=>$address2,'fax' => $fax, 'zipcode'=>$zipcode ,'country'=>$country,'username' => $username,
					 'userid'=>$userid ,'userimg'=>$userimg,'countryDataResult' => $countryDataResult,'useremail' => $useremail,
					 'stateDataResult'=>$stateDataResult ,'cityDataResult'=>$cityDataResult) , TRUE);
        $this->_O( $B );
    }
		public function datasave()
		{
			$firstnm  = $_REQUEST['firstnm'];
			$lastnm 	= $_REQUEST['lastnm'];
			$country  = $_REQUEST['country'];
			$address1 = $_REQUEST['address1'];
			$address2 = $_REQUEST['address2'];
			$state    = $_REQUEST['state'];
			$zipcode 	= $_REQUEST['zipcode'];
			$city     = $_REQUEST['city'];
			$fax      = $_REQUEST['fax'];
			$company  = $_REQUEST['company'];
			$telephone    = $_REQUEST['telephone'];
      $userid   = $_SESSION['user_id'];
			$this->acount_db->insert_address($firstnm , $lastnm , $country , $address1 , $address2,
			       $state , $zipcode , $city , $fax , $company,$telephone,$userid);
			echo ("Yes");
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

		public function infordata(){
			$backvalue = $this->input->post("backvalue");
			if($backvalue == "0")
			{
				  $firstname = $this->input->post("firstname");
				  $lastname = $this->input->post("lastname");
				  $country = $this->input->post("country");
				  $state = $this->input->post("state");
				  $city = $this->input->post("city");
				  $zipcode = $this->input->post("zipcode");
				  $biaddr = $this->input->post("biaddr");
				  $appart = $this->input->post("appart");
				  $userid = $_SESSION['user_id'];
				  $this->acount_db->infor_address($firstname , $lastname , $country , $state , $city,
				       $zipcode , $biaddr , $appart , $userid);
				  $this->load->view('user/secret');
			}else{
                  $this->load->view('user/register');
			}

		}
}
