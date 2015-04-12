<?php

class MyDateHelper_Test extends PHPUnit_Framework_TestCase
{
	private $CI;
	private $ret;
	
	function __construct()
	{
		ob_start();
		parent::__construct();
	}
	
    function setUp()
    {
      	// Load CI instance normally
    	$this->CI = &get_instance();
		$this->CI->load->helper('date');
	}
	
	function testUnixToLocal()
	{
		$date = DateTime::createFromFormat('d-m-Y H:i:s', '02-03-2015 0:00:00')->getTimestamp();
		$test = md_unix_to_local($date, 'd-m-Y H:i:s', 'UP10', false);
		$expected_result = '02-03-2015 10:00:00';
		$test_name = 'unix to local';
		$notes = 'Input date: '.date('d-m-Y H:i:s',$date).', Returned date: '.$test;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);
	}
	
	function testLocalToUnix()
	{
		$date = '02-03-2015 4:00:00';
		$test = md_local_to_unix($date, 'd-m-Y G:i:s', 'UP3', true);
		$expected_result = DateTime::createFromFormat('d-m-Y H:i:s', '02-03-2015 0:00:00')->getTimestamp();
		$test_name = 'local to unix';
		$notes = 'Input date: '.$date.', Returned date: '.date('d-m-Y H:i:s',$test);
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);
	}

	function testUnixToMySQL()
	{
		$date = DateTime::createFromFormat('d-m-Y H:i:s', '02-03-2015 0:00:00')->getTimestamp();
		$test = md_unix_to_mysql($date);
		$expected_result = '2015-03-02 00:00:00';
		$test_name = 'unix to mysql';
		$notes = 'Input date: '.date('d-m-Y H:i:s',$date).', Returned date: '.$test;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);
	}

	function testMySQLToUnix()
	{
		$date = '2015-03-02 00:00:00';
		$test = md_mysql_to_unix($date);
		$expected_result = DateTime::createFromFormat('d-m-Y H:i:s', '02-03-2015 0:00:00')->getTimestamp();
		$test_name = 'mysql to unix';
		$notes = 'Input date: '.$date.', Returned date: '.date('d-m-Y H:i:s',$test);
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);
	}
	
	function testValidateLocal()
	{
		$date = '2015-03-02 0:00:00'; $date_format = 'Y-m-d G:i:s';
		$test = md_validate_local($date,$date_format);
		$expected_result = true;
		$test_name = 'validate date';
		$notes = 'Input date: '.$date.' has format '.$date_format;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);

		$date = '2/03/2015'; $date_format = 'j/m/Y';
		$test = md_validate_local($date,$date_format);
		$expected_result = true;
		$test_name = 'validate date';
		$notes = 'Input date: '.$date.' has format '.$date_format;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);

		$date = '3.04.2015'; $date_format = 'j.m.Y';
		$test = md_validate_local($date,$date_format);
		$expected_result = true;
		$test_name = 'validate date';
		$notes = 'Input date: '.$date.' has format '.$date_format;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);

	}

	function testTimezoneToMySQL()
	{
		$timezone = "UM1";
		$test = md_timezone_to_mysql($timezone);
		$expected_result = "-01:00";
		$test_name = 'convert to mysql timezone';
		$notes = 'Input timezone: '.$timezone.' - in mysql it\'s '.$test;
		$this->assertEquals($expected_result, $test, $test_name.' '.$notes);
	}
}
?>