<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('base_controller.php');
class Frontpage extends Base_controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'pagination', 'form_validation', 'paypal_payment'));
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('basic');

		if(!$this->isLoggedIn()){
			redirect(site_url('admin/login'),'refresh');
		}
	}

	public function index()
	{
		  $frontpage_part = "";
			$sortdata = "";
			$partcnm = "";
			$thsize = "";
			$frontDataArr = array();
			$paginationLink = "";
			$limit = 18;
			$start = empty($this->uri->segment(4)) ? 0 : $this->uri->segment(4);
			if(!empty($event) && !strcmp($event, "frontpagesearch")){
				$frontpage_part = $this->input->post("frontpage_part");
				$sortdata = $this->input->post("sortdata");
				$partcnm = $this->input->post("partcnm");
				$thsize = $this->input->post("thsize");
        $this->session->set_userdata("sortdata", $sortdata);
				$this->session->set_userdata("partcnm", $partcnm);
				$this->session->set_userdata("thsize", $thsize);
				$this->session->set_userdata("frontpage_part", $frontpage_part);
			}
			$where = array();
			if($this->session->userdata("frontpage_part") != ""){
				$frontpage_part = $this->session->userdata("frontpage_part");
				$where['where']["v_video_section.part"] = $frontpage_part;
			}

	   	$input_data = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_list.php')), true);
			$i=0;
			foreach ($input_data as $inputData) {
				$frontDataArr[$i] = array(
					"id" => $inputData["id"],
					"name" => $inputData['name'],
					"category" => $inputData['category'],
					"url" => $inputData['url'],
					"imgpath" => $inputData['imgpath'],
					"date" => $inputData['date']
				);
				$i++;
			}

			$category_data = json_decode(trim(file_get_contents('http://34.195.115.143/start/get_category.php')), true);
			$j=0;
			foreach ($category_data as $categoryData) {
				$categoryDataArr[$j] = array(
					"id" => $categoryData["id"],
					"parentId" => $categoryData['parentId'],
					"depth" => $categoryData['depth'],
					"name" => $categoryData['name'],
					"date" => $categoryData['date']
				);
				$j++;
			}
			$this->init_pagination(site_url('admin/frontpage'), count($input_data), $limit);
			$paginationLink = $this->pagination->create_links();

			$data['part'] = $this->basic->get_data("v_video_section","","","","","","");
			// $data['category'] = $input_data['category'];
			// $data['name'] = $input_data['name'];
			// $data['imgpath'] = $input_data['imgpath'];
			// $data['url'] = $input_data['url'];
			$data['frontDataArr'] = $frontDataArr;
			$data['categoryDataArr'] = $categoryDataArr;
			$data['frontpage_part'] = $frontpage_part;
			$data['sortdata'] = $sortdata;
			$data['partcnm'] = $partcnm;
			$data['thsize'] = $thsize;
      $data['paginationLink'] = $paginationLink;
			$this->_O('admin/frontpage', $data);
	}

	public function addData()
	{
		$msgType = "";
		$msg = "";

		$frontInput = $this->input->post("frontInput");
		$addCategoryInput = $this->input->post("addCategoryInput");
		$addpartcnm = $this->input->post("addpartcnm");
		$addthsize = $this->input->post("addthsize");
		$addsortdata = $this->input->post("addsortdata");

		if(!empty($frontInput) && !empty($addCategoryInput) && !empty($addpartcnm) && !empty($addthsize)
			&& !empty($addsortdata)){
			$select = array("uid");
			$where = array("part"=>$frontInput, "category"=>$addCategoryInput, "partcnm"=>$addpartcnm, "size"=>$addthsize, "sort"=>$addsortdata);
			if($this->basic->is_unique("v_video_section",$where,$select)){
				$data = array("part"=>$frontInput, "category"=>$addCategoryInput, "partcnm"=>$addpartcnm, "size"=>$addthsize, "sort"=>$addsortdata, "type"=>1);
				if($this->basic->insert_data("v_video_section",$data)){
					$msgType = "success";
					$msg = "This Section data saved Successfully";
				}
				else{
					$msgType = "error";
					$msg = "Problem to save This Section data.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Section data is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Section required data cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function updateData()
	{
		$msgType = "";
		$msg = "";
		$frontid = $this->input->post("FrontID", TRUE);
		$categoryinput = $this->input->post("categoryinput", TRUE);
		$partcnm = $this->input->post("partcnm", TRUE);
		$thsize = $this->input->post("thsize", TRUE);
		$sortdata = $this->input->post("sortdata", TRUE);
		// $partupdate = $this->input->post("frontpage_part");
		// $categoryupdate = $this->input->post("SearchCategoryInput");
		// $partcnmupdate = $this->input->post("searchpartcnm");
		// $thsizeupdate = $this->input->post("searchthsize");
		// $sortdataupdate = $this->input->post("searchsortdata");
		// $frontid = $this->input->post("frontid");

		if(!empty($frontid) && !empty($categoryinput) && !empty($partcnm) && !empty($thsize) && !empty($sortdata)){
			$select = array("uid");
			$where = array("uid"=>$frontid, "category"=>$categoryinput, "partcnm"=>$partcnm, "size"=>$thsize, "sort"=>$sortdata);
			if($this->basic->is_unique("v_video_section",$where,$select)){
				$where = array("uid"=>$frontid);
				$data = array("category"=>$categoryinput, "partcnm"=>$partcnm, "size"=>$thsize, "sort"=>$sortdata, "type"=>1);
				if($this->basic->update_data("v_video_section",$where,$data)){
					$msgType = "success";
					$msg = "Country updated successfully.";
				}
				else{
					$msgType = "error";
					$msg = "Problem to update Country.";
				}
			}
			else{
				$msgType = "error";
				$msg = "This Country is already exist.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Country and Country id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}
	public function deleteData(){
		// // loading custom database
		// $this->basic->loadCustomDB("ChannelProvider");

		$msgType = "";
		$msg = "";

		$frontid = $this->input->post("FrontID", TRUE);

		if(!empty($frontid)){
			$where = array("uid"=>$frontid);
			if($this->basic->delete_data("v_video_section",$where)){
				$msgType = "success";
				$msg = "This Section deleted successfully.";
			}
			else{
				$msgType = "error";
				$msg = "Problem to delete this Section.";
			}
		}
		else{
			$msgType = "error";
			$msg = "Section id cannot be empty.";
		}

		echo json_encode(array("msgType"=>$msgType, "msg"=>$msg));
	}

	public function previewData()
	{
		$msgType = "";
		$msg = "";
		$frontid = $this->input->post("FrontID", TRUE);

		// $where = array("where"=>array("uid"=>$frontid));
    // $previewid = $this->basic->get_data("v_video_section",$where);
		// $preview = "http://34.195.115.143/start/get_list.php?categorynum=".$previewid[0]['category']."&pagenm=".$previewid[0]['partcnm'];
		// $preview_data = json_decode(trim(file_get_contents($preview)), true);
		//
		 $preview ="";
		// 					$i=0;
		$previewid = $this->basic->get_data("v_video_section",array("where"=>array("uid"=>$frontid)));
		if($previewid[0]['sort'] = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		$preview_data = $this->user_model->get_videolist($previewid[0]['category'],$previewid[0]['partcnm'],$sortvalue);
		$i=0;
							foreach($preview_data as $row){
							    $preview .=	"<div class='col-md-2 showVideoPopup' data-url='http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$row['id']."/flavorId/".$row['flavorid']."/forceproxy/true/name/".$row['name'].$row['file_ext']."'>
									<img src='http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$row['id']."/version/100002/width=".$row['width']."/height=".$row['height']."' class='img-responsive' alt=''>
									<span align='center'>".$row['name']."(".$row['date'].")</span>
									</div>";
																				$i++;
																		}
    echo $preview;

	}

	public function selectData()
	{
		$msgType = "";
		$msg = "";
		$preview ="";

		$category = $this->input->post("category", TRUE);
    $pagenm = $this->input->post("pagenm", TRUE);
		$sortdata = $this->input->post("sortvalue", TRUE);
		if($sortdata = '1')
					$sortvalue = "a.updated_at";
		else
					$sortvalue = "a.popular";
		if($category !='') $category_whr =" and a.categories_ids = $category";
		          else     $category_whr="";
		if($pagenm !='') $pagenm_whr =" order by $sortvalue";
		          else     $pagenm_whr="";
		if($sortdata !='') $sortdata_whr =" limit $pagenm";
		          else     $sortdata_whr="";
		$preview_data = $this->user_model->select_videolist($category_whr , $pagenm_whr , $sortdata_whr);
		$i=0;
							foreach($preview_data as $row){
							    $preview .=	"<div class='col-md-2 showVideoPopup' data-url='http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/".$row['id']."/flavorId/".$row['flavorid']."/forceproxy/true/name/".$row['name'].$row['file_ext']."'>
									<img src='http://34.195.115.143/p/101/sp/10100/thumbnail/entry_id/".$row['id']."/version/100002/width=".$row['width']."/height=".$row['height']."' class='img-responsive' alt=''>
									<span align='center'>".$row['name']."(".$row['date'].")</span>
									</div>";
																				$i++;
																		}
    echo $preview;

	}

}
