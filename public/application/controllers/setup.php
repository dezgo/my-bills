<?php
class Setup extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		//is_logged_in();
	}

	function create($add_demo_data = '')
	{
		
		// load and run sql
		$this->load->model('setup_model');
		$this->load->helper('file');
		$this->setup_model->runSQL('application/models/setup.sql');
		if ($add_demo_data !== '') 
			$this->setup_model->runSQL('application/models/demo_data.sql');		

		// show results
		$data['main_content'] = 'setup_view';
		$this->load->view('includes/template.php', $data);
	}
}