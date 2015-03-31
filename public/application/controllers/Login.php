<?php

class Login extends MY_Controller {
	
	private $data;
	
	function __construct() {
		parent::__construct();
		$this->data['failed'] = 0;
	}
	
	function index()
	{
		$this->data['main_content'] = 'login_form';
		$this->load->view('includes/template', $this->data);
	}
	
	function validate_credentials()
	{
		$this->load->model('membership_model');
		$member_id = $this->membership_model->validate();
		
		if($member_id !== 0) // if the user's credentials validated...
		{
			//  set the member id first as it's required for other functions in settings model
			$this->load->model('Settings_model');
			$_SESSION['member_id'] = $member_id;
			
			$_SESSION['email_address'] = $this->input->post('email_address');
			$_SESSION['timezone'] = $this->Settings_model->timezone_get();
			$_SESSION['dst'] = $this->Settings_model->dst_get();
			
			redirect('site/members_area');
		}
		
		else
		{
			$this->data['failed']++;
			$this->index();
		}
	}
	
	function signup()
	{
		$this->data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $this->data);
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|callback_check_if_email_exists');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');

		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
				$this->validate_credentials();
			}
			else
			{
				$this->data['main_content'] = 'signup_form';
				$this->load->view('includes/template', $this->data);
			}
		}
	}

	function check_if_email_exists($requested_email)	// custom callback function
	{
		$this->load->model('membership_model');
		return $this->membership_model->check_if_email_exists($requested_email);
	}
}