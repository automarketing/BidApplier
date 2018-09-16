<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once('');
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
		$this->load->model('basic');
		$this->load->model ( 'acount_db' );
		if (session_id () == '') {
	       session_start ();
      }
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
			$this->load->view('user/sign-in');
		}
		else
		{
			// check for user credentials
			$uresult = $this->user_model->get_user($username, $password);
			if (count($uresult) > 0)
			{
				// set session
				$sess_data = array('login' => TRUE, 'uname' => $uresult[0]->fname, 'uid' => $uresult[0]->id, 'utype'=>'subscriber');
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
		public function set_session($userdata)
    {
        $_SESSION['user_id'] = $userdata[0]['uid'];
        $_SESSION['user_name']=$userdata[0]['username'];
        $_SESSION['password']=$userdata[0]['password'];
        $_SESSION['email'] = $userdata[0]['email'];
    }

    public function menu()
	{
		    $username = $this->input->post("username");
        $password = $this->input->post("password");
        $usercnt = $this->user_model->get_user($username , $password);

        if( count($usercnt) > 0 )
        {
					$this->set_session($usercnt);
					// redirect('/user/address');
					require_once('address.php');
					$test = new address();
					$test -> index();
        }
				else
		    {

			    $this->load->view('user/register');
				}
	}
	public function menunew()
{
	    $username = $this->input->post("username");
			$password = $this->input->post("password");
			$usercnt = $this->user_model->get_user($username , $password);
		 // $userinfo = $usercnt[0]['username'];
			if( count($usercnt) > 0 )
		//	$this->load->view('/user/play_vod.html');
{
require_once('play_live.php');
$test = new play_live();
$test -> index();
}
	else
		$this->load->view('user/sign-up');
}
	 public function signup()
	{
	    $this->load->view('user/sign-up');
	}
	 public function fotget()
	{
	    $this->load->view('user/forgot-password');
	}
	public function homeload()
	{
		$front1 = $this->basic->get_data("v_video_section",array("where"=>array("uid"=>4)));
		if($front1[0]['sort'] = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		$part1 = $this->user_model->get_videolist($front1[0]['category'],$front1[0]['partcnm'],$sortvalue);
		$i=0;
		foreach ($part1 as $part1Data) {
			$part1DataArr[$i] = array(
				"id" => $part1Data["id"],
				"name" => $part1Data['name'],
				"category" => $part1Data['category'],
				"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part1Data['id']."/flavorId/".$part1Data['flavorid']."/forceproxy/true/name/".$part1Data['name'].$part1Data['file_ext'],
				"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part1Data['id']."/version/100002/width=".$part1Data['width']."/height=".$part1Data['height'],
				"date" => $part1Data['date']
			);
			$i++;
		}

		$front2 = $this->basic->get_data("v_video_section",array("where"=>array("uid"=>3)));
		if($front2[0]['sort'] = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		$part2 = $this->user_model->get_videolist($front2[0]['category'],$front2[0]['partcnm'],$sortvalue);
		$i=0;
		foreach ($part2 as $part2Data) {
			$part2DataArr[$i] = array(
				"id" => $part2Data["id"],
				"name" => $part2Data['name'],
				"category" => $part2Data['category'],
				"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part2Data['id']."/flavorId/".$part2Data['flavorid']."/forceproxy/true/name/".$part2Data['name'].$part2Data['file_ext'],
				"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part2Data['id']."/version/100002/width=".$part2Data['width']."/height=".$part2Data['height'],
				"date" => $part2Data['date']
			);
			$i++;
		}

		$front3 = $this->basic->get_data("v_video_section",array("where"=>array("uid"=>6)));
		if($front3[0]['sort'] = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		$part3 = $this->user_model->get_videolist($front3[0]['category'],$front3[0]['partcnm'],$sortvalue);
		$i=0;
		foreach ($part3 as $part3Data) {
			$part3DataArr[$i] = array(
				"id" => $part3Data["id"],
				"name" => $part3Data['name'],
				"category" => $part3Data['category'],
				"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part3Data['id']."/flavorId/".$part3Data['flavorid']."/forceproxy/true/name/".$part3Data['name'].$part3Data['file_ext'],
				"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part3Data['id']."/version/100002/width=".$part3Data['width']."/height=".$part3Data['height'],
				"date" => $part3Data['date']
			);
			$i++;
		}

		$front4 = $this->basic->get_data("v_video_section",array("where"=>array("uid"=>7)));
		if($front4[0]['sort'] = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		$part4 = $this->user_model->get_videolist($front4[0]['category'],$front4[0]['partcnm'],$sortvalue);
		$i=0;
		foreach ($part4 as $part4Data) {
			$part4DataArr[$i] = array(
				"id" => $part4Data["id"],
				"name" => $part4Data['name'],
				"category" => $part4Data['category'],
				"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part4Data['id']."/flavorId/".$part4Data['flavorid']."/forceproxy/true/name/".$part4Data['name'].$part4Data['file_ext'],
				"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part4Data['id']."/version/100002/width=".$part4Data['width']."/height=".$part4Data['height'],
				"date" => $part4Data['date']
			);
			$i++;
		}
		 //	$this->_O('admin/channel_list', $data);
	   // $this->load->view('index.php');
			$this->load->view('index.php', array('part1'=>$part1DataArr,'part2'=>$part2DataArr,'part3'=>$part3DataArr,'part4'=>$part4DataArr));
	}

	public function increase_num()
	{
		$videourl = $this->input->post("videourl");
		$entryvalue = explode('/',$videourl);
		$entryid = $entryvalue[9];
		$this->user_model->increase_popular($entryid);
	}

	public function newcredit()
{
	    $username = $this->input->post("username");
			$password = $this->input->post("password");
			$usercnt = $this->user_model->get_user($username , $password);
			if( count($usercnt) > 0 )
			{
				$this->load->view('user/secret');
				$this->set_session($usercnt);
			}
	    else
						{
							$userin =$this->user_model->insert_user($username , $password);
							$this->set_session($userin);
					    $this->load->view('user/secret');
					  }
}

public function creditinfo()
{
		$phonenumber = $this->input->post("phone");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$email = $this->input->post("email");

		$_SESSION['email'] = $email;

		$usercnt = $this->user_model->get_user($username , $password);
			if( count($usercnt) > 0 )
					{
						$this->load->view('user/register');
					}
			else
					{
						$userin =$this->user_model->insert_user($username , $password ,$email,$phonenumber);
						$this->set_session($userin);
					}
					$where = array("where"=>array("flag"=>1));
				  $countryDataResult = $this->basic->get_data("b_countries",$where,"","","","",'b_countries.country ASC');
					$this->load->view('user/information', array('countryDataResult' => $countryDataResult));
	        // $this->_O( $B );
}
public function profile()
	{
		$uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$userimg = $uservalue[0]['photo'];
		if(isset($userimg))
	   	$this->load->view('user/profile', array('pro_image' => $userimg ));
		else
		  $this->load->view('user/profile', array('pro_image' => '' ) );
	}

public function update()
		{
			$photo_file = $this->input->post("photo_file");
			$this->load->view('user/upload', array('photo_file' => $photo_file ,'userid' => $_SESSION['user_id']) );
		}

public function logout()
    {
		// session_unset();
		session_destroy();
		$this->load->view('user/register');
	//	die();
	}
	public function masjid_view()
 {
		 $this->load->view('masjid_view');
 }
 public function masjid_con()
{
		$this->load->view('masjid_con');
}
public function masjid_product()
{
	 $this->load->view('masjid_product');
}
public function user_register()
{
	 $this->load->view('user/register');
}

}
