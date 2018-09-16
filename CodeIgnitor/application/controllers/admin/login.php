<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once('');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('basic');
		if (session_id () == '') {
	       	session_start ();
      	}
	}

	public function index(){
		// get form input
		$username = $this->input->post("username");
        $password = $this->input->post("password");


		// form validation
		$this->form_validation->set_rules("username", "Email-ID", "trim|required|xss_clean");
		$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean");

		if ($this->form_validation->run() == FALSE)
        {
			// validation fail
			$this->load->view('admin/sign-in');
		}
		else
		{
			// check for user credentials
			$where = array('where'=>array('userid'=>$username,'password'=>md5($password)));
			$userResult = $this->basic->get_data('u_admin',$where);

			if(count($userResult) > 0){
				// set session
				$sess_data = array('loginUserID'=>$userResult[0]['uid'],'loginUser'=>$userResult[0]['userid'],'loginUserName'=>$userResult[0]['first_name']." ".$userResult[0]['last_name'],'loginUserType'=>'admin');
				$this->session->set_userdata($sess_data);

				$this->session->set_userdata('menuSelect', 'dashboard/index');

				redirect(site_url("admin/dashboard"), 'refresh');
			}
			else{
				redirect(site_url("admin/login"), 'refresh');
			}
		}
	}

	public function logout(){
		$this->session->set_userdata('menuSelect', '');

		$this->session->set_userdata('loginUserID', '');
		$this->session->set_userdata('loginUser', '');
		$this->session->set_userdata('loginUserName', '');
		$this->session->set_userdata('loginUserType', '');
		$this->session->sess_destroy();
		redirect(site_url("admin/login"), 'refresh');
	}

}
