<?php

class Membership_model extends CI_Model {
	
	function validate() 
	{
		require_once 'crypto/PasswordHash.php';
		
		$this->db->where('email_address', $this->input->post('email_address'));
		$query = $this->db->get('membership');
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			if (validate_password($this->input->post('password'), $row->params))
				return $row->id;
			else 
				return 0;
		}
		else
			return 0;
	}
	
	// returns the url to the QR code, and populates pass-by-reference variable $secret
	function google_auth_disable()
	{
		$this->db->where('id',$_SESSION['member_id']);
		$data['google_auth_secret'] = '';
		$this->db->update('membership',$data);
	}
	
	function google_auth_enable(&$secret)
	{
		// get new instance of google auth class
		require_once 'crypto/PasswordHash.php';
		$ga = new PHPGangsta_GoogleAuthenticator();

		// generate a new secret and store in database
		$secret = $ga->createSecret();
		$this->db->where('id',$_SESSION['member_id']);
		$data['google_auth_secret'] = $secret;
		$this->db->update('membership',$data);

		// return url of QRCode
		return $ga->getQRCodeGoogleUrl( 'remember-my-bills' , $secret );
	}

	function google_auth_check_code($OneCode)
	{
		// get new instance of google auth class
		require_once 'crypto/PasswordHash.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		
		// get user's google auth secret
		$this->db->where('id',$_SESSION['member_id']);
		$query = $this->db->get('membership');
		$row = $query->row();
		$secret = $row->google_auth_secret;
		
		$checkResult  = $ga->verifyCode( $secret , $OneCode , 2);     // 2 = 2 * 30sec clock tolerance
		return  $checkResult;
	}
	
	function create_member()
	{
		require_once 'crypto/PasswordHash.php';
		
		$new_member_insert_data = array(
			'email_address' => $this->input->post('email_address'),
			'params' => create_hash($this->input->post('password'))
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
	
	function update_member()
	{
		$data['email_address'] = $this->input->post('email_address');
		if ($this->input->post('password') != '')
			$data['password'] = md5($this->input->post('password'));
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		
		$this->db->where('id',$_SESSION['member_id']);
		$this->db->update('membership', $data);
	}
	
	function check_if_email_exists($email)
	{
		$this->db->where('email_address', $email);
		if (isset($_SESSION['member_id']) && $_SESSION['member_id'] != '')
			$this->db->where('id !=',$_SESSION['member_id']);
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
	
	// return details for a given member
	function get_member()
	{
		$this->db->where('id', $_SESSION['member_id']);
		return $this->db->get('membership')->row();
	}
	
	function get_members()
	{
		$this->db->select('id,email_address');
		$query = $this->db->get('membership');
		return $query->result();
	}
	
	function create_password_reset_token()
	{
		$email_address = $this->input->post('email_address');
		$data['retieve_token'] = md5($email_address.time());
		
		echo 'token:'.$data['retieve_token'];
		echo 'email: '.$email_address;
		die();
	}
}

?>