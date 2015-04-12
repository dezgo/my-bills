<?php

class Settings_Test extends PHPUnit_Framework_TestCase
{
	private $CI;
	private $member;
	private $email_address;
	private $password;
	
	function __construct()
	{
		ob_start();
		parent::__construct();
	}
	
    function setUp()
    {
	   	// Load CI instance normally
    	$this->CI = &get_instance();
    	
		// load models
    	$this->CI->load->model('Settings_model');
    	$this->CI->load->model('Membership_model');
    	
		// create new member to test with
		$this->email_address = 'someoneelseagain@domain.com';
		$this->password = 'verycomplexpasswordhere';
		$this->member = $this->CI->Membership_model->create_member($this->email_address, $this->password);
		$this->assertNotNull($this->member);
		
	}
	
	function tearDown()
	{
		// get rid of that test member once we're done
		$this->CI->Membership_model->delete_member($this->member->id);
	}
	
	function testDateFormat()
	{
		// check a few random combinations of date format
		$this->CI->Settings_model->date_format_set($this->member->id, 'd.mm.y');
		$this->assertEquals($_SESSION['date_format_php'], 'j.m.y');

		$this->CI->Settings_model->date_format_set($this->member->id, 'd/m/yy');
		$this->assertEquals($_SESSION['date_format_php'], 'j/n/Y');
		
		$this->CI->Settings_model->date_format_set($this->member->id, 'yy-mm-dd');
		$this->assertEquals($_SESSION['date_format_php'], 'Y-m-d');
		
		$this->CI->Settings_model->date_format_set($this->member->id, 'd.mm.y');
		$this->assertEquals($_SESSION['date_format_php'], 'j.m.y');
		
		// almost right date format should return a standard format
		$this->CI->Settings_model->date_format_set($this->member->id, 'd.mm.yyy');
		$this->assertEquals($_SESSION['date_format_php'], 'j.m.Y');
		
		// dodgy date format should return a standard format
		$this->CI->Settings_model->date_format_set($this->member->id, 'abc');
		$this->assertEquals($_SESSION['date_format_php'], 'j.m.Y');
		
		// test check date format function - these are valid
		$this->assertTrue($this->CI->Settings_model->date_format_check('yY-m-dd'));
		$this->assertTrue($this->CI->Settings_model->date_format_check('yY-m-dd'));
		$this->assertTrue($this->CI->Settings_model->date_format_check('d/m/y'));
		
		// test check date format function - these are invalid
		$this->assertFalse($this->CI->Settings_model->date_format_check('yyy-m-dd'));
		$this->assertFalse($this->CI->Settings_model->date_format_check('m/y/d'));
		$this->assertFalse($this->CI->Settings_model->date_format_check('y/d/m'));
		$this->assertFalse($this->CI->Settings_model->date_format_check('a.b.c'));
	}
	
}
?>