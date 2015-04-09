<?php
if(!function_exists('md_date_to_local'))
{
// $date is a gmt date passed as unix timestamp
	// returns local date string formatted as per user date format setting
	function md_date_to_local($date)
	{
		$date_local = gmt_to_local($date, $_SESSION['timezone'], $_SESSION['dst']);
		return date($_SESSION['date_format_php'], $date_local);
	}
}
	
if(!function_exists('md_local_to_date'))
{
// $date is date entered by user in user specified format
	// returns gmt date as unix timestamp
	function md_local_to_date($date)
	{
		$date_ts = DateTime::createFromFormat($_SESSION['date_format_php'], $date);
		return local_to_gmt(date_timestamp_get($date_ts));
	}
}

if(!function_exists('md_date_to_mysql'))
{
	// $date is a gmt date passed as unix timestamp
	// returns date formatted to be used in mysql query
	function md_date_to_mysql($date)
	{
		return date('Y-m-d', $date);
	}
}

if(!function_exists('md_mysql_to_date'))
{
	// $date is a gmt date passed as unix timestamp
	// returns date formatted to be used in mysql query
	function md_mysql_to_date($date)
	{
		$date_ts = DateTime::createFromFormat('Y-m-d', $date);
		return date_timestamp_get($date_ts);
	}
}