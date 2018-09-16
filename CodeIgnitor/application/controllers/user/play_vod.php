<?php
require_once('base_controller.php');
class play_vod extends Base_controller {



    public function __construct() {
      parent::__construct ();
      $this->load->helper(array('form','url','html'));
  		$this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
  		$this->load->database();
  		$this->load->model('basic');
      $this->load->model ( 'acount_db' );
      $this->load->model ( 'user_model' );
      $this->load->model ('play_db');
    }

    public function getname()
    {
          $username = $_SESSION['user_name'];
          $userid = $_SESSION['user_id'];
          $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
          $userimg = $uservalue[0]['photo'];

          $name_id = $_REQUEST['term'];
          if(isset($name_id))
                {
                  $searchlist = $this->user_model->vodlist_search($name_id);

                  $searchvalue="";
                  foreach ($searchlist as $infoval){
                    $url = "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$infoval['id']."/flavorId/".$infoval['flavorid']."/forceproxy/true/name/".$infoval['name'].$infoval['file_ext'];
                    $imgpath = "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$infoval['id']."/version/100002/width=".$infoval['width']."/height=".$infoval['height'];
                      $searchvalue .="<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 homepageMiddleContentLeftTextDiv showVideoPopup'
                               data-url='".$url."' style='padding:10px 40px;'>
                        <img src='".$imgpath."' class='homepageMiddleContentLeftTextThumbImgDiv'
                               style='-webkit-border-radius: 0.6em;' />
                               <span style='text-align: center;font-size:18px;' class='homepageMiddleContentLeftText1Span'>".$infoval["name"]."</span>
                         <div id='play'></div>
                      </div>";
                    }
                    echo $searchvalue;
                }
          else
                redirect("/");

    }
    public function index()
    {
       $useremail = $_SESSION['email'];
       $username = $_SESSION['user_name'];
       $userid = $_SESSION['user_id'];

       $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
       $userimg = $uservalue[0]['photo'];

        $limit = 14;
        $start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);
        $category_data = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_category.php')), true);

        $paginationLink1 = "";
        $data1 = array();
        if(isset($category_data[0]['id']))
        {
            $count_data1 = $this->user_model->user_vodlist($category_data[0]['id'],'','');
         	  $part1 = $this->user_model->user_vodlist($category_data[0]['id'],$limit,$start);
            $this->init_pagination(site_url('user/play_vod/index'), count($count_data1), $limit);
            $paginationLink1 = $this->pagination->create_links();
         	  $i=0;
           	foreach ($part1 as $part1Data) {
           		$data1[$i] = array(
           			"id" => $part1Data["id"],
           			"name" => $part1Data['name'],
           			"category" => $part1Data['category'],
           			"url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part1Data['id']."/flavorId/".$part1Data['flavorid']."/forceproxy/true/name/".$part1Data['name'].$part1Data['file_ext'],
           			"imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part1Data['id']."/version/100002/width=".$part1Data['width']."/height=".$part1Data['height'],
           			"date" => $part1Data['date']
           		);
           		$i++;
           	}
        }

        $paginationLink2 = "";
        $data2 = array();
        if(isset($category_data[1]['id']))
        {
              $count_data2 = $this->user_model->user_vodlist($category_data[1]['id'],'','');
              $this->init_pagination(site_url('user/play_vod/index'), count($count_data2), $limit);
              $paginationLink2 = $this->pagination->create_links();
              $part2 = $this->user_model->user_vodlist($category_data[1]['id'],$limit,$start);
              $i=0;
              foreach ($part2 as $part2Data) {
                $data2[$i] = array(
                  "id" => $part2Data["id"],
                  "name" => $part2Data['name'],
                  "category" => $part2Data['category'],
                  "url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part2Data['id']."/flavorId/".$part2Data['flavorid']."/forceproxy/true/name/".$part2Data['name'].$part2Data['file_ext'],
                  "imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part2Data['id']."/version/100002/width=".$part2Data['width']."/height=".$part2Data['height'],
                  "date" => $part2Data['date']
                );
                $i++;
              }
       }

        $paginationLink3 = "";
        $data3 = array();
        if(isset($category_data[2]['id']))
        {
            $count_data3 = $this->user_model->user_vodlist($category_data[2]['id'],'','');
            $this->init_pagination(site_url('user/play_vod/index'), count($count_data3), $limit);
            $paginationLink3 = $this->pagination->create_links();
            $part3 = $this->user_model->user_vodlist($category_data[2]['id'],$limit,$start);
            $i=0;
            foreach ($part3 as $part3Data) {
              $data3[$i] = array(
                "id" => $part3Data["id"],
                "name" => $part3Data['name'],
                "category" => $part3Data['category'],
                "url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part3Data['id']."/flavorId/".$part3Data['flavorid']."/forceproxy/true/name/".$part3Data['name'].$part3Data['file_ext'],
                "imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part3Data['id']."/version/100002/width=".$part3Data['width']."/height=".$part3Data['height'],
                "date" => $part3Data['date']
              );
              $i++;
            }
        }

        $paginationLink4 = "";
        $data4 = array();
        if(isset($category_data[3]['id']))
        {
            $count_data4 = $this->user_model->user_vodlist($category_data[3]['id'],'','');
            $this->init_pagination(site_url('user/play_vod/index'), count($count_data4), $limit);
            $paginationLink4 = $this->pagination->create_links();
            $part4 = $this->user_model->user_vodlist($category_data[3]['id'],$limit,$start);
            $i=0;
            foreach ($part4 as $part4Data) {
              $data4[$i] = array(
                "id" => $part4Data["id"],
                "name" => $part4Data['name'],
                "category" => $part4Data['category'],
                "url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part4Data['id']."/flavorId/".$part4Data['flavorid']."/forceproxy/true/name/".$part4Data['name'].$part4Data['file_ext'],
                "imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part4Data['id']."/version/100002/width=".$part4Data['width']."/height=".$part4Data['height'],
                "date" => $part4Data['date']
              );
              $i++;
            }
        }

        $paginationLink5 = "";
        $data5 = array();
        if(isset($category_data[4]['id']))
        {
            $count_data5 = $this->user_model->user_vodlist($category_data[4]['id'],'','');
            $this->init_pagination(site_url('user/play_vod/index'), count($count_data5), $limit);
            $paginationLink5 = $this->pagination->create_links();
            $part5 = $this->user_model->user_vodlist($category_data[4]['id'],$limit,$start);
            $i=0;
            foreach ($part5 as $part5Data) {
              $data5[$i] = array(
                "id" => $part5Data["id"],
                "name" => $part5Data['name'],
                "category" => $part5Data['category'],
                "url" => "http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$part5Data['id']."/flavorId/".$part5Data['flavorid']."/forceproxy/true/name/".$part5Data['name'].$part5Data['file_ext'],
                "imgpath" => "http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$part5Data['id']."/version/100002/width=".$part5Data['width']."/height=".$part5Data['height'],
                "date" => $part5Data['date']
              );
              $i++;
            }
       }
    //  print_r($data1);
       $B = $this->load->view('user/play_vod' , array('data1'=>$data1, 'data2'=>$data2, 'data3'=>$data3,'data4'=>$data4,'paginationLink4' => $paginationLink4,'data5'=>$data5,'paginationLink5' => $paginationLink5,
       'useremail' => $useremail,'category_data' => $category_data,'paginationLink1' => $paginationLink1,'paginationLink2' => $paginationLink2,'paginationLink3' => $paginationLink3,'username' => $username, 'userid'=>$userid ,'userimg'=>$userimg,'menuflag'=>'0') , TRUE);
       $this->_O( $B );
    }


    public function search_func()
    {
       $catalog  = $_REQUEST['catalog'];
  		 $pagecalc 	= $_REQUEST['pagecalc'];
       $username = $_SESSION['user_name'];
       $userid = $_SESSION['user_id'];
       $useremail = $_SESSION['email'];
       $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
       $userimg = $uservalue[0]['photo'];
       $config['total_rows'] = $this->play_db->get_count_vod($catalog);
       $config['per_page'] = 12;
       $config['uri_segment'] = 2;
       $config['base_url'] = "/user/play_vod/index";
       $new_choice = $config['total_rows'] / $config['per_page'];
       $config['num_links'] = round($new_choice);
       $this->pagination->initialize($config);
       $page =($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       $page = $page + $pagecalc;

       $data['supplier'] = $this->play_db->get_pagedata_vod($catalog,$config['per_page'],$page);
      //  $data['links'] = $this->pagination->create_links();

      //  $B = $this->load->view('user/play_live' , array('data1'=>'', 'data2'=>'', 'data3'=>'',
      //  'data4'=>'' ,'data'=>$data ,'menuflag'=>$catalog ,
      //      'username' => $username, 'userid'=>$userid ,'userimg'=>$userimg) , TRUE);
      //  $this->_P( $B );
      $echovalue="";
      foreach ($data['supplier'] as $info){
          $echovalue .="<div class='col-md-2 col-sm-2 col-xs-6 homepageMiddleContentLeftTextDiv showVideoPopup'
                   data-url='".$info->url."' style='padding:10px 40px;'>
            <img src='/includes/kawnaintv/images/video1.jpg' class='img-responsive homepageMiddleContentLeftTextThumbImgDiv'
                   style='-webkit-border-radius: 0.6em;' />
             <div id='play'></div>
            <span style='text-align: center;font-size:18px;' class='homepageMiddleContentLeftText1Span'>".$info->channelname."</span>
          </div>";
        }
        echo $echovalue;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
