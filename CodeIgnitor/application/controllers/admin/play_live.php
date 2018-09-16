<?php
require_once('base_controller.php');
class play_live extends Base_controller {



    public function __construct() {
        parent::__construct ();

        if (session_id () == '') {
            session_start ();
        }

    }


       // $banner = $this->load->view('banner');
      //  $menu = $this->load->view('menu', array( 'banner_data' => $menu_data ) , TRUE );
      //  $sider = $this->load->view('sider', array( 'banner_data' => $sider_data ) , TRUE );
      //  $foter = $this->load->view('foter', array( 'banner_data' => $foter_data ) , TRUE );
public function index()
    {
        // $this->load->view('admin/base_template.php');
        $B = $this->load->view('admin/play_live.php');
        $this->_O( $B );
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
