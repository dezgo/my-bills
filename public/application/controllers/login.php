<?php

class Login extends CI_Controller {
	
	function index()
	{
		$data['main_content'] = 'login_form';
		$this->load->view('includes/template', $data);
	}
	
	function validate_credentials()
	{
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query) // if the user's credentials validated...
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
			);
			
			$this->session->set_userdata($data);
			redirect('site/members_area');
		}
		
		else
		{
			$this->index();
		}
	}
	
	function signup()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|callback_check_if_email_exists');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[25]|callback_check_if_username_exists');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
				$data['account_created'] = 'Your account has been created.<br/><br/>You may now login';
				$data['main_content'] = 'login_form';
				$this->load->view('includes/template', $data);
			}
			else
			{
				$data['main_content'] = 'signup_form';
				$this->load->view('includes/template', $data);
			}
		}
	}
	
	function check_if_username_exists($requested_username)	// custom callback function
	{
		
		$this->load->model('membership_model');
		
		$username_available = $this->membership_model->check_if_username_exists($requested_username);
		
		if ($username_available) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function check_if_email_exists($requested_email)	// custom callback function
	{
		
		$this->load->model('membership_model');
		
		$email_available = $this->membership_model->check_if_email_exists($requested_email);
		
		if ($email_available) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}