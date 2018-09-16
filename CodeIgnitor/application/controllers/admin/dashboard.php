<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Dashboard extends Base_controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('basic');

		if(!$this->isLoggedIn()){
			redirect(site_url('admin/login'),'refresh');
		}
	}
	
	public function index(){
		// setting session data to menu selection
		$this->session->set_userdata("menuSelect", "dashboard/index");

		$data = array();


		$data["welcomeText"] = "Welcome to KawnainTV";
        $this->_O('admin/dashboard', $data);
	}	
}