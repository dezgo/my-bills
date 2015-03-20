<?php
class Settings extends MY_Controller 
{
	function index()
	{
		$this->load->model('Settings_model');
		$date_format = $this->Settings_model->setting_get('date_format');

		$data['main_content'] = 'settings_view';
		$data['date_format'] = $date_format;
		$data['message'] = '';
		$this->load->view('includes/template.php', $data);
	}
	
	function update()
	{
		$date_format = $this->input->post('date_format');
		$this->load->model('Settings_model');
		$this->Settings_model->setting_set('date_format', $date_format);
		
		$data['main_content'] = 'settings_view';
		$data['date_format'] = $date_format;
		$data['message'] = 'Settings updated';
		$this->load->view('includes/template.php', $data);
	}
}