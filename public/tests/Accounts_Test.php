<?php

class Accounts_Test extends PHPUnit_Framework_TestCase
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
		$this->CI->load->model('Accounts_model');

		// create new member to test with
		$this->email_address = 'someoneelseagain@domain.com';
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

	function testSearch()
	{
		$test = $this->CI->Accounts_model->search($this->member->id, 50, 0, '', '');
		$this->assertEquals('array', gettype($test), "Account model search returns array");
	}
	
	function testLoad()
	{
		$ret = $this->CI->Accounts_model->search($this->member->id, 50, 0, '', '');
		$id = $ret['rows'][0]->id;
		$test = $this->CI->Accounts_model->load($id);
		$this->assertEquals('object', gettype($test), "Ensure load method returns object. Returned: ".print_r($test,true));
	}
}
