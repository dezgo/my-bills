<?php
if(!function_exists('get_local_date'))
{
	// return local date based on timezone as per settings
	function get_local_date($date)
	{
		$CI = & get_instance();
		$timezone = $CI->session->userdata('timezone');
		$dst = $CI->session->userdata('dst');
		
		// used to get default date format
		$CI->load->model('Settings_model');
		$date_format = $CI->Settings_model->date_format_get();		

		return date($date_format, gmt_to_local(mysql_to_unix($date),$timezone,$dst));
	}
}