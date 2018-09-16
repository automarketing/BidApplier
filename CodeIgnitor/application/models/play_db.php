<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play_db extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function get_live($category)
	{
		    $admin_db= $this->load->database('ChannelProvider', TRUE);
        $query = $admin_db->query("select a.*,b.company as channelname from channel as a
				                    left join company as b on b.uid = a.company
				where alive = '1' and category = '$category'");
        return $query->result_array();
	}
	function get_count($category)
	{
		    $admin_db= $this->load->database('ChannelProvider', TRUE);
				$query = $admin_db->where('category', '$category')->get('channel');
			//	$rowcount = $query->num_rows();
        return $query->num_rows();
	}
	function get_count_vod($category)
	{
		    $admin_db= $this->load->database('ChannelProvider', TRUE);
				$query = $admin_db->where('category', '$category')->get('vod');
        return $query->num_rows();
	}

	function search_live($country_id){
				$admin_db= $this->load->database('ChannelProvider', TRUE);
				$query = $admin_db->query("select a.*,b.company as channelname from channel as a left join company as b on b.uid = a.company
				           where b.company like '%$country_id%'");
				//return $query->result_array();
				return $query->result();
}
function search_vod($country_id){
			$admin_db= $this->load->database('ChannelProvider', TRUE);
			$query = $admin_db->query("select a.*,b.company as channelname from vod as a left join company as b on b.uid = a.company
								 where b.company like '%$country_id%'");
			//return $query->result_array();
			return $query->result();
}

	function get_masjid()
	{
				$admin_db= $this->load->database('ChannelProvider', TRUE);
				$query = $admin_db->query("select * from zone where flag = '5' ");
				return $query->result_array();
	}

	function get_zone($flags)
	{
			$admin_db= $this->load->database('ChannelProvider', TRUE);
			$query = $admin_db->query("select * from zone where flag = '$flags'");
			return $query->result_array();
	}

	function get_zonelist($uid)
	{
			$admin_db= $this->load->database('ChannelProvider', TRUE);
			$query = $admin_db->query("select * from zone where parent_uid = '$uid'");
			return $query->result_array();
	}

	function get_list($uid)
	{
			$admin_db= $this->load->database('ChannelProvider', TRUE);
			$query = $admin_db->query("select * from zone where parent_uid = '$uid'");
			return $query->result();
	}

	function get_vod($category)
	{
				$admin_db= $this->load->database('ChannelProvider', TRUE);
				$query = $admin_db->query("select * from vod where alive = '1' and category = '$category'");
				return $query->result_array();
	}

	function get_service()
	{
		 $query = $this->db->get('u_subscriber_plan');
	   return $query->result_array();
	}

	function get_serviceplan($sid)
	{
		 $this->db->where('uid', $sid);
		 $query = $this->db->get('u_subscriber_plan');
	   return $query->result_array();
	}

	function insert_serviceplan($type , $userid , $price)
	{
		$this->db->query( "insert into subscriber_plan (s_id , type , price)
										values('$userid' , '$type' , '$price')" );
		return true;
	}

	function update_serviceplan($type , $userid , $price)
	{
		$this->db->query( "update subscriber_plan set type='$type' , price='$price' where s_id = '$userid' " );
		return true;
	}

	public function get_pagedata($category, $limit = NULL, $start = NULL)
{
	      $admin_db= $this->load->database('ChannelProvider', TRUE);
        $admin_db->limit($limit, $start);
				$admin_db->select('channel.*,company.company AS channelname');
				$admin_db->from('channel');
				$admin_db->join('company', 'channel.company = company.uid','left');
				$admin_db->where('category', $category);
				$query = $admin_db->get();
        if ($query->num_rows() > 0 ) {

            return $query->result();
        }
        else
            return false;
}

public function get_pagedata_vod($category, $limit = NULL, $start = NULL)
{
			$admin_db= $this->load->database('ChannelProvider', TRUE);
			$admin_db->limit($limit, $start);
			$admin_db->select('vod.*,company.company AS channelname');
			$admin_db->from('vod');
			$admin_db->join('company', 'vod.company = company.uid','left');
			$admin_db->where('category', $category);
			$query = $admin_db->get();
			if ($query->num_rows() > 0 ) {

					return $query->result();
			}
			else
					return false;
}

}
?>
