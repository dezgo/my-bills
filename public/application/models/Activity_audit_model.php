<?php
/*
 `member_id` int(11) NULL,
 `activity_type` varchar(20),
 `remote_addr` varchar(40),
 `notes` varchar(256),
 */
class Activity_audit_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}

	private function create_entry($member_id, $activity_type, $notes = '')
	{
		$data['member_id'] = $member_id;
		$data['activity_type'] = $activity_type;
		$data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
		$data['notes'] = $notes;

		$this->db->insert('activity_audit',$data);		
	}
	
	function login_success($member_id)
	{
		$this->create_entry($member_id, 'Login success');
	}
	
	function login_fail($email_address)
	{
		$this->create_entry(0, 'Login failure', $email_address);
	}
	
	function google_auth_success($member_id)
	{
		$this->create_entry($member_id, 'Google Auth success');
	}
	
	function google_auth_fail($member_id)
	{
		$this->create_entry($member_id, 'Google Auth fail');
	}
	
	function signup($email_address)
	{
		$this->create_entry(0, 'Signup', $email_address);
	}
	function logout($member_id)
	{
		$this->create_entry($member_id, 'Logout');
	}
	
	function change_password($member_id)
	{
		$this->create_entry($member_id, 'Change Password');
	}

	function enable_google_auth($member_id)
	{
		$this->create_entry($member_id, 'Enable Google Auth');
	}

	function disable_google_auth($member_id)
	{
		$this->create_entry($member_id, 'Disable Google Auth');
	}
}

?>