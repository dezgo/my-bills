<?php

class Setup_Test extends PHPUnit_Framework_TestCase
{
	private $CI;
	
	function __construct()
	{
		ob_start();
		parent::__construct();
	}
	
    function setUp()
    {
	   	// Load CI instance normally
    	$this->CI = &get_instance();
		
		// put any startup stuff here
		$this->CI->load->model('Setup_model');
		$this->CI->load->dbutil();
		
		$this->CI->Setup_model->checkDB(true);
		
	}
	
	function testDBExists()
	{
		$this->assertTrue($this->CI->dbutil->database_exists($this->CI->db->database));
	}
	
	function testCheckDB()
	{
		// remove all tables (if there are any)
		$tables = $this->CI->db->list_tables();
		foreach ($tables as $table)
		{
			$this->CI->db->query('DROP TABLE `'.$table.'`;');
		}
		
		// now run check db which should create them all again
		$this->CI->Setup_model->checkDB();
		$this->CI->Setup_model->checkDB(true);
		
		$this->assertGreaterThan(0, count($this->CI->db->list_tables()));
	}
	
	function testAddDemoData()
	{
		$this->CI->Setup_model->addDemoData();
		
		$query = $this->CI->db->get('accounts');
		
		$test = $query->num_rows() > 0;
		$expected_result = true;
		$this->assertEquals($expected_result, $test);
	}
	
}
?>