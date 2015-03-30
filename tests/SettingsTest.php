<?php
class Settings_Test extends PHPUnit_Framework_TestCase
{
	private $CI;

	public function __construct() {
		ob_start();
		parent::__construct();
		$this->CI = &get_instance();
	}
	
	public function testSetGet()
	{
		$this->CI->session->set_userdata('member_id',1);
		$this->CI->load->model('Settings_model');
		$date_format= $this->CI->Settings_model->date_format_get();
		$this->assertTrue('Date format shouldn\'t be empty '.$date_format,$date_format != '');
	}
}