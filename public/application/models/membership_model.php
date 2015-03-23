<?php

class Membership_model extends CI_Model {
	
	function validate() 
	{
		$this->db->where('email_address', $this->input->post('email_address'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('membership');
		
		if($query->num_rows == 1)
		{
			$row = $query->row();
			return $row->id;
		}
		else
			return 0;
	}
	
	function create_member()
	{
		$new_member_insert_data = array(
			'email_address' => $this->input->post('email_address'),
			'password' => md5($this->input->post('password'))
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
	
	function check_if_email_exists($email)
	{
		$this->db->where('email_address', $email);
		$result = $this->db->get('membership');
		
		if ($result->num_rows() > 0)
		{
			return FALSE;	// email taken
		}
		else
		{
			return TRUE;	// email can be registered
		}
	}
	
	// for a given member, return their email address (to send out bill reminders)
	function get_email($member_id)
	{
		$this->db->where('member_id', $member_id);
		$result = $this->db->get('membership')->row();
		return $result->email_address;
	}
	
	function get_members()
	{
		$this->db->select('id,email_address');
		$query = $this->db->get('membership');
		return $query->result();
	}
	
}

?>