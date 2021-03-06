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
	
	function google_auth_get_qr_url($secret, $email_address)
	{
		// get new instance of google auth class
		require_once 'crypto/GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		
		return $ga->getQRCodeGoogleUrl($email_address, $secret , 'remember-my-bills');
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
			return null;
		}
		else
		{
			require_once 'crypto/PasswordHash.php';
			
			$new_member_insert_data = array(
				'email_address' => $email_address,
				'params' => create_hash($password)
			);
			
			$this->db->trans_start();
			if (!$this->db->insert('membership', $new_member_insert_data)) 
			{
				$this->db->trans_complete();				
				return null;
			}
			else
			{
				$member_id = $this->db->insert_id();
				$this->db->trans_complete();				
				return $this->get_member($member_id);
			}
		}
	}
	
	function delete_member($member_id)
	{
		$this->db->where('member_id',$member_id);
		$this->db->delete('payments');

		$this->db->where('member_id',$member_id);
		$this->db->delete('accounts');
		
		$this->db->where('id',$member_id);
		$this->db->delete('membership');
	}
	
	function update_member($member_id, $email_address, $password = '', $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code)
	{
		$data['email_address'] = $email_address;
		$_SESSION['email_address'] = $email_address;	// updating session var here at the point where it changes
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
		
		$this->db->where('id',$member_id);
		$this->db->update('membership', $data);
	}
	
	// returns true if email exists, false otherwise
	function check_if_email_exists($email_address)
	{
		$this->db->where('email_address', $email_address);
		$result = $this->db->get('membership');
		
		return $result->num_rows() > 0;
	}
	
	function get_member_by_email($email_address)
	{
		$this->db->where('email_address', $email_address);
		return $this->db->get('membership')->row();
	}
	
	// return details for a given member
	function get_member($member_id)
	{
		$this->db->where('id', $member_id);
		return $this->db->get('membership')->row();
	}
	
	function get_members()
	{
		$this->db->select('id,email_address,first_name');
		$query = $this->db->get('membership');
		return $query->result();
	}
	
	// get password reset token if exists and hasn't expired
	// then clear info out - token is single use only
	function retrieve_password_reset_token($member_id)
	{
		$this->db->where('id',$member_id);
		$this->db->select('retrieve_token, unix_timestamp(retrieve_expiration) as retrieve_expiration');
		$query = $this->db->get('membership');

		if ($query->num_rows() == 0)
		{
			$token = '';
		}
		else
		{
			$row = $query->row();
			if ($row->retrieve_expiration >= time())
			{
				$token = $row->retrieve_token;
			}
			else
			{ 
				$token = '';
			}
			
			$data['retrieve_token'] = '';
			$data['retrieve_expiration'] = null;
	
			$this->db->where('id',$member_id);
			$this->db->update('membership', $data);
		}
		return $token;
	}
	
	function create_password_reset_token($member_id)
	{
		$data['retrieve_token'] = bin2hex(openssl_random_pseudo_bytes(20));
		$data['retrieve_expiration'] = md_unix_to_mysql(time() + 60*15);	// expire in 15 minutes

		$this->db->where('id',$member_id);
		$this->db->update('membership', $data);
		
		return $data['retrieve_token'];
	}

	function initial_login_setup($member_id, $email_address = '')
	{
		if ($email_address == '')
		{
			$member = $this->get_member($member_id);
			$email_address = $member->email_address;
		}
		$this->load->model('Settings_model');
		$_SESSION['member_id'] = $member_id;
		$_SESSION['email_address'] = $email_address;
		$_SESSION['timezone'] = $this->Settings_model->timezone_get($member_id);
		$_SESSION['dst'] = $this->Settings_model->dst_get($member_id);
		$_SESSION['date_format'] = $this->Settings_model->date_format_get($member_id);
	}
	
	function count_members()
	{
		$query = $this->db->query('SELECT Count(*) as count_members FROM membership');
		$row = $query->row();
		return $row->count_members;
	}
	
	function member_id_is_valid($member_id)
	{
		if (!is_numeric($member_id))
			return false;
		else
		{
			$this->db->where('id', $member_id);
			$query = $this->db->get('membership');
			return $query->num_rows() > 0;
		}		
	}
}

?>