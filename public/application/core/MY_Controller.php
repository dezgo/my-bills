<?php
class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		// Do any code you want run every time a controller loads

		// load and run sql to create database if required (when no tables in db)
		$this->load->model('Setup_model');
		$this->Setup_model->checkDB();

		//set num members for footer
		if (!isset($_SESSION['count_members']))
		{
			$this->load->model('Membership_model');
			$_SESSION['count_members'] = $this->Membership_model->count_members();
		}

		//echo 'uri: '.$_SERVER['REQUEST_URI'];
		//echo 'URI: '.uri_string();
		//die();
		if ((!isset($_SESSION['date_format']) or $_SESSION['date_format'] == '') 
				and $this->uri->segment(1) == 'Site'
				and $this->uri->segment(2) != 'logout')
		{
			redirect('Settings');
		}
	}
}
?>