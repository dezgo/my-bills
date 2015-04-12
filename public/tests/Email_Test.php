<?php

class Email_Test extends PHPUnit_Framework_TestCase
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
		$this->CI->load->model('Email_model');
		
		// create new member to test with
		$this->email_address = 'testingemail@derekgillett.com';
		$this->password = 'verycomplexpasswordhere';
		$this->member = $this->CI->Membership_model->create_member($this->email_address, $this->password);
		$this->assertNotNull($this->member);
				
		// and add some accounts
		$this->CI->Accounts_model->insert($this->member->id, 'Mobile', time(), 12, 30.0);
		$this->CI->Accounts_model->insert($this->member->id, 'Rates', time(), 1, 550.5);
    }
	
	function tearDown()
	{
		// get rid of that test member once we're done
		$this->CI->Membership_model->delete_member($this->member->id);
	}

	function testPasswordReset()
	{
		$this->assertTrue($this->CI->Email_model->send_password_reset_email($this->member->id));
	}
}