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

    function _O($content , $param='' , $banner_data='' , $menu_data = '' , $footer_data ='' )
    {

        $banner = $this->load->view('frame/banner', array( 'banner_data' => $banner_data ) , TRUE );
        $menu = $this->load->view('frame/menu', array( 'menu_data' => $menu_data ) , TRUE );
        $footer = $this->load->view('frame/footer', array( 'footer_data' => $footer_data ) , TRUE );

        $this->load->view('user/base_template', array('content' => $content,'banner' => $banner,'menu' => $menu,'footer' => $footer ));
    }

    function _P($content , $param='' , $banner_data='' , $menu_data = '' , $footer_data ='' )
    {

        $banner = $this->load->view('frame/banner', array( 'banner_data' => $banner_data ) , TRUE );
        $menu = $this->load->view('frame/menu', array( 'menu_data' => $menu_data ) , TRUE );
        $footer = $this->load->view('frame/footer', array( 'footer_data' => $footer_data ) , TRUE );

        $this->load->view('user/base_play_template', array('content' => $content,'banner' => $banner,'menu' => $menu,'footer' => $footer ));
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
