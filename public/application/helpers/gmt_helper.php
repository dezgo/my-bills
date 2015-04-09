<?php
if(!function_exists('get_local_date'))
{
	// return local date based on timezone as per settings
	function get_local_date($date)
	{
		$timezone = $_SESSION['timezone'];
		$dst = $_SESSION['dst'];
		return date($_SESSION['date_format_php'], gmt_to_local(mysql_to_unix($date),$timezone,$dst));
	}
}
