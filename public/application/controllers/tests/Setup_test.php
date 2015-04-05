<?php

class Setup_test extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// put any startup stuff here
		$this->load->model('Setup_model');
		$this->Setup_model->checkDB(true);
		$this->Setup_model->addDemoData();
		
		$this->load->library('unit_test');
		$this->load->dbutil();
	}
	
	function index()
	{
		$this->testDBExists();
		$this->testCheckDB();
		$this->testAddDemoData();
		
		echo $this->unit->report();
	}
	
	function testDBExists()
	{
		$test = $this->dbutil->database_exists($this->db->database);
		$expected_result = true;
		$test_name = 'Check database '.$this->db->database.' exists';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	function testCheckDB()
	{
		// remove all tables (if there are any)
		$tables = $this->db->list_tables();
		foreach ($tables as $table)
		{
			$this->db->query('DROP TABLE `'.$table.'`;');
		}
		
		// now run check db which should create them all again
		$this->Setup_model->checkDB();
		$this->Setup_model->checkDB(true);
		
		$tables = $this->db->list_tables();

		$test = count($tables) == 0;
		$expected_result = false;
		$test_name = 'testCheckDB';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	function testAddDemoData()
	{
		$this->load->model('Setup_model');
		$this->Setup_model->addDemoData();
		
		$query = $this->db->get('accounts');
		
		$test = $query->num_rows() > 0;
		$expected_result = true;
		$test_name = 'testAddDemoData - make sure data exists';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
}
?>