<?php
class Contact extends MY_Controller 
{
	function index()
	{
		$data['main_content'] = 'contact_form';
		$this->load->view('includes/template', $data);
	}

	function submit()
	{
		$contact_name = $this->input->post('name');
		$email_address = $this->input->post('email');
		$message = $this->input->post('message');
		
		$this->load->model('Email_model');
		$this->Email_model->send_contact_us_email($contact_name, $email_address, $message);
		
		$data['main_content'] = 'contact_submitted';
		$this->load->view('includes/template', $data);		
	} 
}
?>
