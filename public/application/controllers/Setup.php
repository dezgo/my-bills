<?php
class Setup extends MY_Controller
{
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
			$this->load->model('Setup_model');
			$this->Setup_model->checkDB(TRUE);
			$data['message'] = 'Finished creating database';
			if ($add_demo_data != '') {
				$this->Setup_model->addDemoData();	
				$data['message'] .= ' and adding demo data';
			}
		}
					
		// show results
		$data['main_content'] = 'setup_view';
		$this->load->view('includes/template.php', $data);
	}
}