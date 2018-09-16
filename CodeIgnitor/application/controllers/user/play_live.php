<?php
require_once('base_controller.php');
class play_live extends Base_controller {



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


       // $banner = $this->load->view('banner');
      //  $menu = $this->load->view('menu', array( 'banner_data' => $menu_data ) , TRUE );
      //  $sider = $this->load->view('sider', array( 'banner_data' => $sider_data ) , TRUE );
      //  $foter = $this->load->view('foter', array( 'banner_data' => $foter_data ) , TRUE );
// public function index()
//     {
//         $username = $_SESSION['user_name'];
//         $userid = $_SESSION['user_id'];
//         $userimg = $_SESSION['photo'];
//         $news_list = $this->play_db->get_live(1);
//         $movie_list = $this->play_db->get_live(2);
//         $kids_list = $this->play_db->get_live(3);
//         $sport_list = $this->play_db->get_live(4);
//         $B = $this->load->view('user/play_live' ,array('news_list' => $news_list,'movie_list' => $movie_list,
//             'kids_list' => $kids_list,'sport_list' => $sport_list,'username' => $username, 'userid'=>$userid ,
//             'userimg'=>$userimg) , TRUE);
//         $this->_P( $B );
//     }
    public function getname()
    {
          $username = $_SESSION['user_name'];
          $userid = $_SESSION['user_id'];
          $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
          $userimg = $uservalue[0]['photo'];

          $name_id = $_REQUEST['term'];
          if(isset($name_id))
                {
                  $select = array("l_channel.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "l_channel.url as url", "l_channel.alive as alive", "l_channel.date as date", "l_channel.img_path as img_path");
                  $join = array("l_category"=>"l_category.uid=l_channel.category, left", "b_countries"=>"b_countries.id=l_channel.country, left", "l_company"=>"l_company.uid=l_channel.company, left", "b_language"=>"b_language.uid=l_channel.language, left");
                  $where['where']["l_company.company LIKE "] = "%".$name_id."%";
                  $searchlist = $this->basic->get_data("l_channel",$where,$select,$join,"","","");
                  // $searchlist['supvalue'] = $this->play_db->search_live($name_id);
                  $searchvalue="";
                  foreach ($searchlist as $infoval){
                      $searchvalue .="<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 homepageMiddleContentLeftTextDiv showVideoPopup'
                               data-url='".$infoval["url"]."' style='padding:10px 40px;'>
                        <img src='".$infoval["img_path"]."' height='90px' class='homepageMiddleContentLeftTextThumbImgDiv'
                               style='-webkit-border-radius: 0.6em;' />
                               <span style='text-align: center;font-size:18px;' class='homepageMiddleContentLeftText1Span'>".$infoval["company_name"]."</span>
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
        $select = array("l_channel.uid as uid", "l_category.category as category_name", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "l_channel.url as url", "l_channel.alive as alive", "l_channel.date as date", "l_channel.img_path as img_path");
        $join = array("l_category"=>"l_category.uid=l_channel.category, left", "b_countries"=>"b_countries.id=l_channel.country, left", "l_company"=>"l_company.uid=l_channel.company, left", "b_language"=>"b_language.uid=l_channel.language, left");

        $paginationLink1 = "";
        $data1 = array();
        $where1['where']["l_channel.category = "] = "1";
   			$CountDataResult1 = $this->basic->get_data("l_channel",$where1,"","","",NULL,'l_channel.category ASC','',1);
   			$totalRows1 = $CountDataResult1['extra_index']['num_rows'];
        $datavalue1 = $this->basic->get_data("l_channel",$where1,$select,$join,$limit,$start,'l_channel.category DESC');
        $this->init_pagination(site_url('user/play_live/index'), $totalRows1, $limit);
    		$paginationLink1 = $this->pagination->create_links();
        $i=0;
        foreach ($datavalue1 as $countryData1) {
        $data1[$i] = array(
          "uid" => $countryData1["uid"],
          "company_name" => $countryData1['company_name'],
          "img_path" => $countryData1["img_path"],
          "url" => $countryData1['url']
        );
        $i++;
      }

      $paginationLink2 = "";
      $data2 = array();
      $where2['where']["l_channel.category = "] = "2";
      $CountDataResult2 = $this->basic->get_data("l_channel",$where2,"","","",NULL,'l_channel.category ASC','',1);
      $totalRows2 = $CountDataResult2['extra_index']['num_rows'];
      $datavalue2 = $this->basic->get_data("l_channel",$where2,$select,$join,$limit,$start,'l_channel.category DESC');
      $this->init_pagination(site_url('user/play_live/index'), $totalRows2, $limit);
      $paginationLink2 = $this->pagination->create_links();
      $i=0;
      foreach ($datavalue2 as $countryData2) {
      $data2[$i] = array(
        "uid" => $countryData2["uid"],
        "company_name" => $countryData2['company_name'],
        "img_path" => $countryData2["img_path"],
        "url" => $countryData2['url']
      );
      $i++;
    }

    $paginationLink3 = "";
    $data3 = array();
    $where3['where']["l_channel.category = "] = "3";
    $CountDataResult3 = $this->basic->get_data("l_channel",$where3,"","","",NULL,'l_channel.category ASC','',1);
    $totalRows3 = $CountDataResult3['extra_index']['num_rows'];
    $datavalue3 = $this->basic->get_data("l_channel",$where3,$select,$join,$limit,$start,'l_channel.category DESC');
    $this->init_pagination(site_url('user/play_live/index'), $totalRows3, $limit);
    $paginationLink3 = $this->pagination->create_links();
    $i=0;
    foreach ($datavalue3 as $countryData3) {
    $data3[$i] = array(
      "uid" => $countryData3["uid"],
      "company_name" => $countryData3['company_name'],
      "img_path" => $countryData3["img_path"],
      "url" => $countryData3['url']
    );
    $i++;
  }


  $paginationLink4 = "";
  $data4 = array();
  $where4['where']["l_channel.category = "] = "4";
  $CountDataResult4 = $this->basic->get_data("l_channel",$where4,"","","",NULL,'l_channel.category ASC','',1);
  $totalRows4 = $CountDataResult4['extra_index']['num_rows'];
  $datavalue4 = $this->basic->get_data("l_channel",$where4,$select,$join,$limit,$start,'l_channel.category DESC');
  $this->init_pagination(site_url('user/play_live/index'), $totalRows4, $limit);
  $paginationLink4 = $this->pagination->create_links();
  $i=0;
  foreach ($datavalue4 as $countryData4) {
  $data4[$i] = array(
    "uid" => $countryData4["uid"],
    "company_name" => $countryData4['company_name'],
    "img_path" => $countryData4["img_path"],
    "url" => $countryData4['url']
  );
  $i++;
}

    //  print_r($data1);
       $B = $this->load->view('user/play_live' , array('data1'=>$data1, 'data2'=>$data2, 'data3'=>$data3,'data4'=>$data4,'paginationLink4' => $paginationLink4,
       'useremail' => $useremail,'paginationLink1' => $paginationLink1,'paginationLink2' => $paginationLink2,'paginationLink3' => $paginationLink3,'username' => $username, 'userid'=>$userid ,'userimg'=>$userimg,'menuflag'=>'0') , TRUE);
       $this->_P( $B );
    }


    public function search_func()
    {
       $catalog  = $_REQUEST['catalog'];
  		 $pagecalc 	= $_REQUEST['pagecalc'];
       $username = $_SESSION['user_name'];
       $userid = $_SESSION['user_id'];
       $uservalue = $this->user_model->get_user_by_id($_SESSION['user_id']);
       $userimg = $uservalue[0]['photo'];
       $config['total_rows'] = $this->play_db->get_count($catalog);
       $config['per_page'] = 12;
       $config['uri_segment'] = 2;
       $config['base_url'] = "/user/play_live/index";
       $new_choice = $config['total_rows'] / $config['per_page'];
       $config['num_links'] = round($new_choice);
       $this->pagination->initialize($config);
       $page =($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       $page = $page + $pagecalc;

       $data['supplier'] = $this->play_db->get_pagedata($catalog,$config['per_page'],$page);
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

    public function getlist(){
         $categoryData = $this->basic->get_data("l_category","","","","","","");
         $livecategory ="";

        foreach ($categoryData as $row) {
              $category = $row["category"];
              $nouid     = $row["uid"];
              $livecategory = $livecategory." {\"uid\":\"$nouid\",\"kind_name\":\"$category\",\"kind_description\":\"$category\"},";
        }
      $livecategory_value = substr($livecategory, 0, -1);
      echo "[ [ ".$livecategory_value." ],";

      $masjidData = $this->basic->get_data("m_masjid","","","","","","");
      $masjidheader ="";
      foreach ($masjidData as $row) {
            $zone_flag = $row["alive"];
            $parentid  = $row["parent_uid"];
            $desc      = $row["name"];
            $homeurl   = $row["homeurl"];
            $nouid     = $row["uid"];
              if($zone_flag != '5')
              {
               $masjidheader = $masjidheader." {\"uid\":\"$nouid\",\"parent_uid\":\"$parentid\",\"zone_name\":\"$desc\",\"zone_type\":\"$zone_flag\",\"zone_description\":\"$desc\"},";
              }
     }
     $masjidheader_value = substr($masjidheader, 0, -1);
     echo "[ ".$masjidheader_value." ],";

   $vod_category = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_category.php')), true);
   $vodheader ="";
   foreach ($vod_category as $row) {
         $desc      = $row["name"];
         $nouid     = $row["id"];
         $vodheader = $vodheader." {\"uid\":\"$nouid\",\"parent_uid\":\"0\",\"kind_name\":\"$desc\",\"kind_type\":\"0\",\"kind_description\":\"$desc\"},";
        }
    $vodcategory_value = substr($vodheader, 0, -1);
    echo "[ ".$vodcategory_value." ],";

    $select = array("l_channel.uid as uid", "l_category.uid as categoryid", "b_countries.country as country_name", "l_company.company as company_name", "b_language.language as language_name", "l_channel.url as url", "l_channel.alive as alive", "l_channel.date as date");
    $join = array("l_category"=>"l_category.uid=l_channel.category, left", "b_countries"=>"b_countries.id=l_channel.country, left", "l_company"=>"l_company.uid=l_channel.company, left", "b_language"=>"b_language.uid=l_channel.language, left");
    $where['where']["l_channel.alive"] = "1";
    $channelData = $this->basic->get_data("l_channel",$where,$select,$join,"","","");
    $livetv ="";
    foreach ($channelData as $row) {
          $name  = $row["company_name"];
          $categoryid  = $row["categoryid"];
          $url     = $row["url"];
          $nouid       = $row["uid"];
          $livetv = $livetv." {\"uid\":\"$nouid\",\"kind\":\"$categoryid\",\"icon_url\":\"\",\"rtmp_url\":\"$url\",\"description\":\"$name\"},";
         }
     $livetv_value = substr($livetv, 0, -1);
     echo "[ ".$livetv_value." ],";

     $masjidresult = $this->basic->get_data("m_masjid","","","","","","");
     $masjidvalue ="";
     foreach ($masjidresult as $row) {
           $zone_flag = $row["alive"];
           $parentid  = $row["parent_uid"];
           $desc      = $row["name"];
           $homeurl   = $row["homeurl"];
           $nouid     = $row["uid"];
             if($zone_flag > '4')
             {
              $masjidvalue = $masjidvalue." {\"uid\":\"$nouid\",\"zone\":\"$parentid\",\"icon_url\":\"\",\"rtmp_url\":\"$homeurl\",\"description\":\"$desc\"},";
             }
    }
    $masjidvalue_result = substr($masjidvalue, 0, -1);
    echo "[ ".$masjidvalue_result." ],";

    $platform_vod = $this->user_model->jsonlist_value();
    $platformvalue ="";
    $i=1;
    foreach ($platform_vod as $row) {
          $categoryid = $row["categories_ids"];
          $name = $row["name"];
          $url = "http://video.kawnain.com/p/101/sp/10100/serveFlavor/entryId/".$row['mainentryid']."/flavorId/".$row['flavorid']."/forceproxy/true/name/".$row['name'].".".$row['file_ext'];
          $imgpath = "http://video.kawnain.com/p/101/sp/10100/thumbnail/entry_id/".$row['mainentryid']."/version/100002/width=".$row['width']."/height=".$row['height'];

          $platformvalue = $platformvalue." {\"uid\":\"$i\",\"kind\":\"$categoryid\",\"icon_url\":\"$imgpath\",\"rtmp_url\":\"$url\",\"description\":\"$name\"},";
          $i++;
         }
     $platformvod_value = substr($platformvalue, 0, -1);
     echo "[ ".$platformvod_value." ] ]";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
