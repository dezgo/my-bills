<?php
class Setup extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	// seeing as anyone with the right URL can run this, added this
	// key to lock it down more. 
	// have to get key right before it will run
	function create($key, $add_demo_data = '')
	{
		if ($key !== 'wer34345ertgdffjERDFG') {
			$data['message'] = 'Unauthorised access denied';
			
		}
		
		else {
			// load and run sql
			$this->load->model('setup_model');
			$this->load->helper('file');
			$this->setup_model->runSQL('application/models/setup.sql');
			$data['message'] = 'Finished creating database';
			if ($add_demo_data !== '') {
				$this->setup_model->runSQL('application/models/demo_data.sql');		
				$data['message'] .= ' and adding demo data';
			}
		}
					
		// show results
		$data['main_content'] = 'setup_view';
		$this->load->view('includes/template.php', $data);
	}
}