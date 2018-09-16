<?php
require_once('base_controller.php');
class History extends Base_controller {

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
		 $this->load->library('pagination');
		 $this->load->model ( 'acount_db' );
		 $this->load->model ( 'user_model' );
		 $this->load->model ('play_db');
		 $this->load->helper('url');
		 $this->load->library('form_validation');
	 }
    public function index()
    {
				$username = $_SESSION['user_name'];
				$userid = $_SESSION['user_id'];
				$useremail = $_SESSION['email'];
				$uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
				$userimg = $uservalue[0]['photo'];
        $B = $this->load->view('user/history', array('username' => $username, 'userid'=>$userid ,
				        'userimg'=>$userimg,'useremail' => $useremail) , TRUE);
        $this->_O( $B );
    }


}
