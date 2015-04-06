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
		$name = $this->input->post('name');
		
		$data['main_content'] = 'contact_submitted';
		
		if ($this->input->post('ajax'))
		{
			$this->load->view($data['main_content']);
		}
		else
		{
			$this->load->view('includes/template', $data);		
		}
	} 
}
?>