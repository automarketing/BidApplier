<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class acount_db extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function get_card($sid)
	{
		  $this->db->where('s_id', $sid);
      $query = $this->db->get('p_card');
		return $query->result_array();
	}

	// get user
	function get_user_by_id($id)
	{
		$this->db->where('id', $id);
        $query = $this->db->get('u_subscriber');
		return $query->result();
	}

	// insert
	function insert_card($type , $card_no , $exp_year,$exp_month , $verifynm , $checkbox , $s_id)
    {
			$this->db->query( "insert into p_card (s_id , type , card_no , exp_year,exp_month , verification_no , checkFlag)
			                values('$s_id' , '$type' , '$card_no' , '$exp_year','$exp_month' , '$verifynm' , '$checkbox')" );
			return true;
	  }

	function update_card($type , $card_no , $exp_year,$exp_month , $verifynm , $checkbox , $s_id)
	    {
				$this->db->query( "update p_card set type = '$type' , card_no = '$card_no', exp_year = '$exp_year', exp_month = '$exp_month'
				        , verification_no = '$verifynm', checkFlag = '$checkbox' where s_id = '$s_id'" );
				return true;
		  }
	function insert_address($firstnm , $lastnm , $country , $address1 , $address2,
				 $state , $zipcode , $city , $fax , $company,$telephone,$sid,$email)
		{
			$this->db->query( "update u_subscriber set first_name = '$firstnm', last_name = '$lastnm', company = '$company',
			      telephone = '$telephone', fax = '$fax' ,address_street_1 = '$address1',address_street_2 = '$address2',active_status = '1'
			      ,city = '$city', state = '$state' , zipcode = '$zipcode',country = '$country',email = '$email'  where uid ='$sid'" );
			return true;
		}
	function infor_address($firstname , $lastname , $country , $state , $city,
				 $zipcode , $biaddr , $appart , $userid)
				 {
					 $this->db->query( "update u_subscriber set first_name = '$firstname', last_name = '$lastname',active_status = '1'
		 			      ,city = '$city', state = '$state' , zipcode = '$zipcode',country = '$country' , address_street_1 = '$biaddr',address_street_2 = '$appart'  where uid ='$userid'" );
		 			return true;
				 }
}
?>
