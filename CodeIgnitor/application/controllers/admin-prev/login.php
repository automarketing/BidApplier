<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	 public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('user_model');
	}
    public function index()
    {
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
			$uresult = $this->user_model->get_user($username, $password);
			if (count($uresult) > 0)
			{
				// set session
				$sess_data = array('login' => TRUE, 'uname' => $uresult[0]->fname, 'uid' => $uresult[0]->id);
				$this->session->set_userdata($sess_data);
				redirect("profile/index");
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Wrong Email-ID or Password!</div>');
				redirect('login/index');
			}
		}
    }

    public function menu()
	{
		$username = $this->input->post("username");
        $password = $this->input->post("password");
        $usercnt = $this->user_model->get_user($username , $password);
       // $userinfo = $usercnt[0]['username'];
        if( count($usercnt) > 0 )
	        redirect('/admin/play_vod');
		else
			$this->load->view('admin/sign-in');
	}
	public function menunew()
{
	$username = $this->input->post("username");
			$password = $this->input->post("password");
			$usercnt = $this->user_model->get_user($username , $password);
		 // $userinfo = $usercnt[0]['username'];
			if( count($usercnt) > 0 )
				redirect('/admin/play_vod');
	else
		$this->load->view('admin/sign-up');
}
	 public function signup()
	{
	    $this->load->view('admin/sign-up');
	}
	 public function fotget()
	{
	    $this->load->view('admin/forgot-password');
	}
	public function homeload()
	{
	    $this->load->view('index.php');
	}

/*
	public function index()
	{		signup
		$this->load->view('admin/sign-in.php');
	}  */
}
