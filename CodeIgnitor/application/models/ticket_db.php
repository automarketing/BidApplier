<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_db extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function get_ticket($majorid)
	{
		//  $this->db->where('major', $majorid);
    //  $query = $this->db->get('ticket');
		$res_arr = $this->db->query( "
		                  (
												select a.* ,b.username as scuser from ticket as a
		                    left join subscriber as b on b.uid = a.s_id
											  where userFlag = 1 and major ='$majorid'
											)
											union all
											(
												select a.*,b.name as scuser from ticket as a
		                    left join admin as b on b.uid = a.s_id
											  where userFlag = 0 and major ='$majorid'
											)

											  " )->result_array();
		     return $res_arr;
	}

	// insert
	function insert_ticket($qtype , $userid , $description , $datevalue , $userflag	 ,$majorid )
    {
			$this->db->query( "insert into ticket (s_id , type , userFlag , description , date , major)
			                values('$userid' , '$qtype' , '$userflag' , '$description','$datevalue' , '$majorid')" );
	  }
}
?>
