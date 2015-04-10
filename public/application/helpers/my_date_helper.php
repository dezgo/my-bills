<?php
if(!function_exists('md_timezone_to_mysql'))
{
	// $timezone is the codeigniter timezone code
	// returns mysql timezone code
	function md_timezone_to_mysql($timezone)
	{
		$value = timezones($timezone);
//		echo ($value > 0 ? '+' : '-').date('H:i',abs($value*3600));
	//	die();
		if ($value == 0)
			return '00:00';
		else
			return ($value > 0 ? '+' : '-').date('H:i',abs($value*3600));
	}
}

if(!function_exists('md_validate_local'))
{
	// $date is a local date formatted as per user spec
	// returns unix timestamp
	function md_validate_local($date, $date_format_php)
	{
		$time = DateTime::createFromFormat($date_format_php, $date);
		if (is_object($time))
		{
			$date_back = date($date_format_php, $time->getTimestamp());
			return $date_back == $date;
		}
		else
			return false;
	}
}

if(!function_exists('md_local_to_unix'))
{
	// $date is a local date formatted as per user spec
	// returns unix timestamp
	function md_local_to_unix($date, $date_format, $timezone, $dst)
	{
		if ($date == '')
		{
			return 0;
		}
		elseif (md_validate_local($date, $date_format))
		{
			$time = DateTime::createFromFormat($date_format, $date)->getTimestamp();
			$time -= timezones($timezone) * 3600;

			return ($dst === TRUE) ? $time - 3600 : $time;
		}
		else return 0;
	}
}

if(!function_exists('md_unix_to_local'))
{
	// $date is a unix timestamp
	// returns a local date formatted as per user spec
	function md_unix_to_local($date, $date_format, $timezone, $dst)
	{
		if ($date == '')
		{
			return '';
		}
		else 
		{
			$time = gmt_to_local($date, $timezone, $dst);
			return date($date_format,$time);
		}
	}
}

if(!function_exists('md_unix_to_mysql'))
{
	// $date is a unix timestamp
	// returns date formatted to be used in mysql query
	function md_unix_to_mysql($date)
	{
		return date('Y-m-d H:i:s', $date);
	}
}

if(!function_exists('md_mysql_to_unix'))
{
	// $date is a date returned by mysql
	// returns unix timestamp
	function md_mysql_to_unix($date)
	{
		return DateTime::createFromFormat('Y-m-d H:i:s', $date)->getTimestamp();
	}
}

/*
 * don't use these functions as they create tightly coupled code by going straight from
 * mysql to local and back. the idea is to pass all dates around as unix and only convert
 * at the end points

if(!function_exists('md_mysql_to_local'))
{
	// $date is a date returned by mysql
	// returns unix timestamp
	function md_mysql_to_local($date)
	{
		return md_unix_to_local(md_mysql_to_unix($date));
	}
}

if(!function_exists('md_local_to_mysql'))
{
	// $date is a date returned by mysql
	// returns unix timestamp
	function md_local_to_mysql($date)
	{
		return md_unix_to_mysql(md_local_to_unix($date));
	}
}
*/