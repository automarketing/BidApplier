<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function get_user($user, $pwd)
	{
		$this->db->where('username', $user);
		$this->db->where('password', md5($pwd));
        $query = $this->db->get('u_subscriber');
		return $query->result_array();
	}

	// get user
	function get_user_by_id($uid)
	{
		$this->db->where('uid', $uid);
        $query = $this->db->get('u_subscriber');
		return $query->result_array();
	}

	// insert
	function insert_user($username,$password,$email,$phonenumber)
  {
			$this->db->query( "insert into u_subscriber (username , password ,email,telephone)
			                values('$username' , md5('$password') ,'$email','$phonenumber')" );
			$this->db->where('username', $username);
			$this->db->where('password', md5($password));
		  $query = $this->db->get('u_subscriber');
			return $query->result_array();
	}
	function increase_popular($entryid)
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		$query = $admin_db->query("update entry set `popular`=(`popular`+1) where `id` = '$entryid'");
		return $query->result_array();
	}
	function get_videolist($category,$pagenm,$ordervalue)
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		$query = $admin_db->query("select a.id as id,a.name as name ,a.categories as category ,
		     b.id as flavorid,a.updated_at as date,b.width,b.height,b.file_ext
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where a.categories_ids = $category and b.flavor_params_id=3 order by $ordervalue limit $pagenm");
		return $query->result_array();
	}
	function select_videolist($category_whr,$pagenm_whr ,$sortdata_whr)
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		$query = $admin_db->query("select a.id as id,a.name as name ,a.categories as category ,
		     b.id as flavorid,a.updated_at as date,b.width,b.height,b.file_ext
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where b.flavor_params_id = 3 $category_whr $pagenm_whr $sortdata_whr");
		return $query->result_array();
	}

	function get_vodlist($limit, $start)
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		// $admin_db->limit($limit, $start);
		$query = $admin_db->query("select a.id as id,a.name as name ,a.categories as category ,
		     b.id as flavorid,a.updated_at as date,b.width,b.height,b.file_ext
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where b.flavor_params_id=3 and b.status != 3  LIMIT $start , $limit");
		return $query->result_array();
	}
	function user_vodlist($category,$limit, $start)
	{
		if($limit=='' && $start=='') $whrstr="";
		         else              $whrstr="LIMIT $start , $limit";
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		// $admin_db->limit($limit, $start);
		$query = $admin_db->query("select a.id as id,a.name as name ,a.categories as category ,
		     b.id as flavorid,a.updated_at as date,b.width,b.height,b.file_ext
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where a.categories_ids = $category and b.flavor_params_id=3 and b.status != 3 $whrstr");
		return $query->result_array();
	}

	function jsonlist_value()
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		// $admin_db->limit($limit, $start);
		$query = $admin_db->query("select a.*,b.*,a.id as mainentryid,b.id as flavorid
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where b.flavor_params_id=3 and b.status != 3");
		return $query->result_array();
	}
	function vodlist_search($searchname)
	{
		$admin_db= $this->load->database('VideoPlatform', TRUE);
		// $admin_db->limit($limit, $start);
		$query = $admin_db->query("select a.id as id,a.name as name ,a.categories as category ,
		     b.id as flavorid,a.updated_at as date,b.width,b.height,b.file_ext
		    from entry as a
       	left join flavor_asset as b on a.id = b.entry_id
	      where a.name like '%$searchname%' and b.flavor_params_id=3 and b.status != 3");
		return $query->result_array();
	}
}?>
