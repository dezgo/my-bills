<?php

class Membership_model extends CI_Model {
	
	function validate() 
	{
		$this->db->where('username', $this->input->post('username'));
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
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
	
	function check_if_username_exists($username)
	{
		$this->db->where('username', $username);
		$result = $this->db->get('membership');
		
		if ($result->num_rows() > 0)
		{
			return FALSE;	// username taken
		}
		else
		{
			return TRUE;	// username can be registered
		}
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
}

?>