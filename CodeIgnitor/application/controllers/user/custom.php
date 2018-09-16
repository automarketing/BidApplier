<?php
require_once('base_controller.php');
class Custom extends Base_controller {

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
			  $this->load->helper(array('form','url','html'));
			  $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
			  $this->load->model('basic');

    }
    public function index()
    {
        $this->load->view('custom-video');
    }
		public function platform()
		{
				$this->load->view('platform-video');
		}
		public function contactpage(){
			 $this->load->view('contact');
		}
		public function privacypage(){
			 $this->load->view('privacy');
		}

}
