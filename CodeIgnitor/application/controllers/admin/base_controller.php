<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class Base_controller extends CI_Controller {

    public $title = '';
    // The template will use this to include default.css by default
    public $styles = array('default');

    public function __construct() {
        parent::__construct ();

        $this->load->library(array('session', 'pagination'));

        if (session_id () == '') {
            session_start ();
        }
    }

    function _O($content , $param='' , $banner_data='' , $menu_data = '' , $sider_data = '' , $footer_data ='' )
    {
        if(!empty($content)){
            $content = $this->load->view($content, $param , TRUE );
        }
        $banner = $this->load->view('frame/banner', array( 'banner_data' => $banner_data ) , TRUE );
        $menu = $this->load->view('frame/menu_admin', array( 'menu_data' => $menu_data ) , TRUE );
        $sider = $this->load->view('frame/sider', array( 'sider_data' => $sider_data ) , TRUE );
        $footer = $this->load->view('frame/footer', array( 'footer_data' => $footer_data ) , TRUE );

        $this->load->view('admin/base_template.php', array('content' => $content,'banner' => $banner,'menu' => $menu,'sider' => $sider,'footer' => $footer ));
    }

    public function isLoggedIn(){
        $loginUserID = $this->session->userdata("loginUserID");
        $loginUser = $this->session->userdata("loginUser");
        $loginUserName = $this->session->userdata("loginUserName");
        $loginUserType = $this->session->userdata("loginUserType");
        if(empty($loginUserID) || empty($loginUser) || empty($loginUserName) || empty($loginUserType)){
            return false;
        }
        return true;
    }

    public function init_pagination($url, $total_rows, $per_page){
        $config = array();
        $config['base_url'] = $url;
        $config['num_links'] = 5;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
    }

    public function getYears($totalYears = 5){
        $yearDataArr = array(); 
        $curYear = date('Y');
        $i=0;
        while($i < $totalYears){
            $yearDataArr[$curYear] = $curYear;
            $curYear++;
            $i++;
        }
        return $yearDataArr;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
