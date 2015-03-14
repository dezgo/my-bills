<?php
class Setup extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//is_logged_in();
	}

	function index()
	{
		
		// load and run sql
		$this->load->model('setup_model');
		$this->load->helper('file');
		$this->setup_model->runSQL('application/models/setup.sql');
		
		// show results
		$data['main_content'] = 'setup_view';
		$this->load->view('includes/template.php', $data);
	}
}