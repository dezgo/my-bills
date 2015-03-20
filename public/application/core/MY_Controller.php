<?php
class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		// Do any code you want run every time a controller loads

		// load and run sql to create database if required (when no tables in db)
		$this->load->model('setup_model');
		if ($this->setup_model->dbEmpty()) {
			$this->load->helper('file');
			$this->setup_model->runSQL('application/models/setup.sql');
		}
	}
}
?>