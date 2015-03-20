<?php
if(!function_exists('is_logged_in'))
{
	// return TRUE if logged in, FALSE otherwise
	function is_logged_in()
	{
		$CI = & get_instance();
		$member_id = $CI->session->userdata('member_id');
		
		return !(!isset($member_id) || $member_id == 0);
	}
	
	function is_admin()
	{
		$CI = & get_instance();
		$email = $CI->session->userdata('email_address');
		return $email == 'mybills@derekgillett.com';
	}
}
