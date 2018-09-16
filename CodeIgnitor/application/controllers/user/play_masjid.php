<?php
require_once('base_controller.php');
class play_masjid extends Base_controller {



    public function __construct() {
      parent::__construct ();
      $this->load->database();
      $this->load->helper(array('form','url','html'));
      $this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
      $this->load->model ( 'acount_db' );
      $this->load->model ( 'user_model' );
      $this->load->model ('play_db');

    }


       // $banner = $this->load->view('banner');
      //  $menu = $this->load->view('menu', array( 'banner_data' => $menu_data ) , TRUE );
      //  $sider = $this->load->view('sider', array( 'banner_data' => $sider_data ) , TRUE );
      //  $foter = $this->load->view('foter', array( 'banner_data' => $foter_data ) , TRUE );
public function index()
    {
      $username = $_SESSION['user_name'];
      $userid = $_SESSION['user_id'];
      $useremail = $_SESSION['email'];
      $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
      $userimg = $uservalue[0]['photo'];
      $play_list = $this->play_db->get_masjid();
      $countrylist = $this->play_db->get_zone(0);
      $statelist = $this->play_db->get_zone(1);
      $citylist = $this->play_db->get_zone(2);
      $B = $this->load->view('user/play_masjid' ,array('play_list' => $play_list,
         'username' => $username, 'userid'=>$userid ,'userimg'=>$userimg ,'useremail' => $useremail,
         'countrylist' => $countrylist, 'statelist'=>$statelist ,'citylist'=>$citylist) , TRUE);
      $this->_P( $B );

    }
public function getlocation($uid)
  {
      $zonelist = $this->play_db->get_zonelist($uid);

      $B = $this->load->view('user/play_masjid' ,array('play_list' => $play_list,
         'username' => $username,'useremail' => $useremail, 'userid'=>$userid ,'userimg'=>$userimg ,
         'countrylist' => $countrylist, 'statelist'=>$statelist ,'citylist'=>$citylist) , TRUE);
      $this->_P( $B );
  }

 public function get_list()
  {
        $username = $_SESSION['user_name'];
        $userid = $_SESSION['user_id'];
        $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
        $userimg = $uservalue[0]['photo'];
        $suid = $_REQUEST['suid'];
        $statelist = $this->play_db->get_zonelist($suid);
        if($statelist[0]['flag'] =='5') $valueuid = $suid;
        if($statelist[0]['flag'] =='2')
        {
          $state1 = $statelist[0]['uid'];
          $citypart1 = $this->play_db->get_zonelist($state1);
          $valueuid = $citypart1[0]['uid'];
        }
        if($statelist[0]['flag'] =='1')
        {
          $country1 = $statelist[0]['uid'];
          $citypart2 = $this->play_db->get_zonelist($country1);
          // $country2 = $citypart2[0]['uid'];
          // $statepart2 = $this->play_db->get_zonelist($country2);
          $valueuid = $citypart2[0]['uid'];
        }
        $searchlist['supvalue'] = $this->play_db->get_list($valueuid);
      //  $searchvalue ="";
        $searchvalue="<ul id='rightSidebarLightSlider' class='rightSidebarLightSliderUL'>";
        foreach ($searchlist['supvalue'] as $infoval){
            $searchvalue .=" <li onclick=\"play_change('".$infoval->homeurl."');\" style='cursor:pointer;' class='rightSidebarSingleContentLI'>
               <img src='".$infoval->img_path."' height='100px' class='rightSidebarSingleContentThumbImg'>
               <div class='rightSidebarSingleContentTextDiv'>
                 <a style='font-size:18px;'>".$infoval->description."</a>
               </div>
             </li>";
          }
          $searchvalue .="</ul>";

          echo $searchvalue;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
