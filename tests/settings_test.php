<?php
class Settings_Test extends PHPUnit_Framework_TestCase
{
	private $CI;

	public function __construct() {
		parent::__construct();
		$this->CI = &get_instance();
	}
	
	public function testSetGet()
	{
		$this->CI->session->set_userdata('member_id',1);
		$this->CI->load->model('Settings_model');
		$exists = $this->CI->Settings_model->setting_exists('blah');
		$this->assertEquals(FALSE, $exists);
	}
}