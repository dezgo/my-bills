<?php

class Settings_test extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// put any startup stuff here
		$this->load->model('Settings_model');
		$this->load->library('unit_test');
	}
	
	function index()
	{
		$this->testDateFormat();
		
		echo $this->unit->report();
	}
	
	function testDateFormat()
	{
		$date_format = 'd.mm.y';
		$expected_result = 'j.m.y';
		$test = $this->Settings_model->date_format_to_PHP($date_format);
		$test_name = 'Date format to PHP';
		$notes = 'Standard format of '.$date_format.' should be '.$expected_result.' in PHP. Function returned '.$test;
		$this->unit->run($test, $expected_result, $test_name, $notes);

		$date_format = 'yY-m-dd';
		$expected_result = true;
		$test = $this->Settings_model->date_format_check($date_format);
		$test_name = 'Date format check';
		$notes = 'Checks if format "'.$date_format.'" is valid';
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
}
?>