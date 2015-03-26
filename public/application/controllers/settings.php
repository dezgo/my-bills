<?php
class Settings extends MY_Controller 
{
	function index()
	{
		$this->load->model('Settings_model');
		$date_format = $this->Settings_model->date_format_get();
		$email_reminder_days = $this->Settings_model->email_reminder_days_get();
		$items_per_page = $this->Settings_model->items_per_page_get();
		
		$data['main_content'] = 'settings_view';
		$data['date_format'] = $date_format;
		$data['email_reminder_days'] = $email_reminder_days;
		$data['items_per_page'] = $items_per_page;
		$data['message'] = '';
		$this->load->view('includes/template.php', $data);
	}
	
	function update()
	{
		$date_format = $this->input->post('date_format');
		$email_reminder_days = $this->input->post('email_reminder_days');
		$items_per_page = $this->input->post('items_per_page');
		$this->load->model('Settings_model');
		$this->Settings_model->date_format_set($date_format);
		$this->Settings_model->email_reminder_days_set($email_reminder_days);
		$this->Settings_model->items_per_page_set($items_per_page);
		
		$data['date_format'] = $date_format;
		$data['email_reminder_days'] = $email_reminder_days;
		$data['items_per_page'] = $items_per_page;
		$data['message'] = 'Settings updated';
		$data['main_content'] = 'settings_view';
		$this->load->view('includes/template.php', $data);
	}
	
	function set_timezone()
	{
		echo 'hi';
		die();
	}
}