<?php

class Accounts_test extends MY_Controller {

	private $ret;
	
	function __construct()
	{
		parent::__construct();
		
		// put any startup stuff here
		$this->load->library('unit_test');
		$this->load->model('Accounts_model');
		$_SESSION['member_id'] = 1;
	}
	
	function index()
	{
		$this->testSearch();
		$this->testLoad();
		
		echo $this->unit->report();
	}

	function testSearch()
	{
		$this->ret = $this->Accounts_model->search($_SESSION['member_id'], 50, 0, '', '');
		
		$test = $this->ret;
		$expected_result = 'is_array';
		$test_name = 'Ensure account search returns array';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	function testLoad()
	{
		$id = $this->ret['rows'][0]->id;
		$row = $this->Accounts_model->load($id);
		
		$test = $row;
		$expected_result = 'is_object';
		$test_name = 'Ensure load method returns object';
		$this->unit->run($test, $expected_result, $test_name, print_r($row,true));
	}
}
