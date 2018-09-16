<?php
require_once('base_controller.php');
class Card extends Base_controller {

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
			 $this->load->model('basic');
			 $this->load->helper(array('form','url','html'));
			 $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
	 }

    public function index()
    {
			$cardvalue = $this->acount_db->get_card($_SESSION['user_id']);
      $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
			$cardtype = $cardvalue[0]['type'];
			$cardnumber = $cardvalue[0]['card_no'];
			$exmonth = $cardvalue[0]['exp_month'];
			$exyear = $cardvalue[0]['exp_year'];
			$password = $cardvalue[0]['verification_no'];
			$username = $_SESSION['user_name'];
			$useremail = $_SESSION['email'];
			$userid = $_SESSION['user_id'];
			$userimg = $uservalue[0]['photo'];

        $B = $this->load->view('user/card' , array( 'cardtype' => $cardtype, 'cardnumber'=>$cardnumber ,
				       'exmonth'=>$exmonth,'exyear' => $exyear, 'password'=>$password ,'username' => $username
					     ,'userid'=>$userid ,'userimg'=>$userimg,'useremail' => $useremail) , TRUE);
        $this->_O( $B );
    }

		public function datasave()
		{
			$cardtype    = $_REQUEST['cardtype'];
			$cardnumber  = $_REQUEST['cardnumber'];
			$exmonth     = $_REQUEST['exmonth'];
			$exyear      = $_REQUEST['exyear'];
			$password 	 = $_REQUEST['password'];
			$checkbox    = $_REQUEST['md_checkbox_1'];
      //$exp_date    = $cardyear.$cardmonth;
      if($checkbox =="on")  $checkbox = 1;
			        else          $checkbox = 0;

			$cardint = $this->acount_db->get_card($_SESSION['user_id']);
			if( count($cardint) > 0 )
			     $this->acount_db->update_card($cardtype , $cardnumber , $exyear,$exmonth , $password , $checkbox ,$_SESSION['user_id']);
      else
			     $this->acount_db->insert_card($cardtype , $cardnumber , $exyear,$exmonth , $password , $checkbox ,$_SESSION['user_id']);
			echo ("Yes");
		}
		public function secretcard(){
			$backvalue = $this->input->post("backvalue");
			if($backvalue == "0")
			{
				 $cardnumber = $this->input->post("cardnumber");
				 $cardtype = $this->input->post("cardtype");
				 $exmonth = $this->input->post("exmonth");
				 $exyear = $this->input->post("exyear");
				 $password = $this->input->post("password");
				 $this->acount_db->insert_card($cardtype , $cardnumber , $exyear,$exmonth , $password , 1 ,$_SESSION['user_id']);
				 require_once('address.php');
				 $test = new address();
				 $test -> index();
				}else{
					$where = array("where"=>array("flag"=>1));
				  $countryDataResult = $this->basic->get_data("b_countries",$where,"","","","",'b_countries.country ASC');
					$this->load->view('user/information', array('countryDataResult' => $countryDataResult));
				}
			//  $this->load->view('user/address');
		}



}
