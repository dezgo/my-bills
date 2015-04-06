<?php

class Membership_model extends CI_Model {
	
	function validate($email_address, $password) 
	{
		require_once 'crypto/PasswordHash.php';
		
		$this->db->where('email_address', $email_address);
		$query = $this->db->get('membership');
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			if (validate_password($password, $row->params))
				return $row->id;
			else 
				return 0;
		}
		else
			return 0;
	}
	
	function google_auth_get_new_secret()
	{
		// get new instance of google auth class
		require_once 'crypto/GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();

		return $ga->createSecret();
	}
	
	function google_auth_get_qr_url($secret)
	{
		// get new instance of google auth class
		require_once 'crypto/GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		
		return $ga->getQRCodeGoogleUrl( 'remember-my-bills' , $secret );
	}
	
	// get user's google auth secret
	function google_auth_get_secret($member_id)
	{
		$this->db->where('id',$member_id);
		$query = $this->db->get('membership');
		$row = $query->row();
		if ($query->num_rows() > 0) {
			return $row->google_auth_secret;
		} else {
			return '';
		}
	}
	
	function google_auth_check_code($OneCode, $member_id)
	{
		// get new instance of google auth class
		require_once APPPATH.'models/crypto/GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		
		$checkResult  = $ga->verifyCode( $this->google_auth_get_secret($member_id) , $OneCode , 2);     // 2 = 2 * 30sec clock tolerance
		return $checkResult;
	}
	
	function create_member($email_address, $password)
	{
		if ($this->check_if_email_exists($email_address))
		{
			return false;
		}
		else
		{
			require_once 'crypto/PasswordHash.php';
			
			$new_member_insert_data = array(
				'email_address' => $email_address,
				'params' => create_hash($password)
			);
			
			$insert = $this->db->insert('membership', $new_member_insert_data);
			return $insert;
		}
	}
	
	function update_member($email_address, $password = '', $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code)
	{
		$data['email_address'] = $email_address;
		if ($password != '')
		{
			require_once 'crypto/PasswordHash.php';
			$data['params'] = create_hash($password);
		}
		$data['first_name'] = $first_name;
		$data['last_name'] = $last_name;
		if ($google_auth_code != '')
		{
			$data['google_auth_secret'] = $google_auth_secret;
		}
		elseif (!$google_auth_enabled)
		{
			$data['google_auth_secret'] = '';
			$this->load->helper('cookie');
			delete_cookie('google_auth_remember');	// do this so if they re-enable, it'll prompt for the google token again
		}
		
		$this->db->where('id',$_SESSION['member_id']);
		$this->db->update('membership', $data);
	}
	
	// returns true if email exists, false otherwise
	function check_if_email_exists($email_address)
	{
		$this->db->where('email_address', $email_address);
		$result = $this->db->get('membership');
		
		return $result->num_rows() > 0;
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
	
	function create_password_reset_token($email_address)
	{
		$data['retrieve_token'] = bin2hex(openssl_random_pseudo_bytes(20));
		$data['retrieve_expiration'] =  date('Y-m-d H:i:s', local_to_gmt(time() + 60*15));	// expire in 15 minutes

		$this->db->where('email_address',$email_address);
		$this->db->update('membership', $data);
		
		return $data['retrieve_token'];
	}
}

?>