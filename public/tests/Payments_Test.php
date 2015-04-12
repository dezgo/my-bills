<?php

class Payments_Test extends PHPUnit_Framework_TestCase
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
		
		$this->CI->load->library('unit_test');
		$this->CI->load->model('Payments_model');
		
    		// create new member to test with
		$this->email_address = 'someoneelseagain@domain.com';
		$this->password = 'verycomplexpasswordhere';
		$this->member = $this->CI->Membership_model->create_member($this->email_address, $this->password);
		$this->assertNotNull($this->member);
				
		// and add some accounts
		$this->CI->Payments_model->insert($this->member->id, 'Mobile', 30, time());
		$this->CI->Payments_model->insert($this->member->id, 'Rates', 550.5, time());
    }
	
	function tearDown()
	{
		// get rid of that test member once we're done
		$this->CI->Membership_model->delete_member($this->member->id);
	}
	
	function testSearch()
	{
		$limit = 20;
		$offset = 0;
		$sort_by = '';
		$sort_order = '';
		$result = $this->CI->Payments_model->search($this->member->id, $limit, $offset, $sort_by, $sort_order);
		$test_name = 'search';
		$notes = print_r($result, true);
		$this->assertInternalType('array', $result, $test_name.' '.$notes);
		$this->assertArrayHasKey('rows', $result);
		$this->assertArrayHasKey('num_rows', $result);
		$this->assertEquals(2, $result['num_rows']);
	}
	
	function testInsert()
	{
		$member_id = 1;
		$account = 'Worldvision';
		$amount = 10;
		$payment_date = DateTime::createFromFormat('j.m.Y', '2.10.2014')->getTimestamp();
		$test = $this->CI->Payments_model->insert($this->member->id, $account, $amount, $payment_date);
		$test_name = 'search';
		$notes = print_r($test, true);
		$this->assertInternalType('object', $test, $test_name.' '.$notes);
	}
}


