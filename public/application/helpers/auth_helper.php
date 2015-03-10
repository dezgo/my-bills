<?php
if(!function_exists('is_logged_in'))
{
	function is_logged_in()
	{
		$CI = & get_instance();
		$is_logged_in = $CI->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			// redirect back to the login page if no longer logged in
			redirect('');
		}
	}
}
