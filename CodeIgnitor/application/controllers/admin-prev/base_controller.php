<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class Base_controller extends CI_Controller {

    public $title = '';
    // The template will use this to include default.css by default
    public $styles = array('default');

    public function __construct() {
        parent::__construct ();

        if (session_id () == '') {
            session_start ();
        }


    }

    function _O($content , $param='' , $banner_data='' , $menu_data = '' , $sider_data = '' , $footer_data ='' )
    {

        $banner = $this->load->view('frame/banner.html', array( 'banner_data' => $banner_data ) , TRUE );
        $menu = $this->load->view('frame/menu.html', array( 'menu_data' => $menu_data ) , TRUE );
        $sider = $this->load->view('frame/sider.html', array( 'sider_data' => $sider_data ) , TRUE );
        $footer = $this->load->view('frame/footer.html', array( 'footer_data' => $footer_data ) , TRUE );

        $this->load->view('admin/base_template.php', array('content' => $content,'banner' => $banner,'menu' => $menu,'sider' => $sider,'footer' => $footer ));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
