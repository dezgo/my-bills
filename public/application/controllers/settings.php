<?php
class Settings extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) redirect('');
	}
		
	function index()
	{
		$this->load->model('Settings_model');
		
		$date_format = $this->Settings_model->date_format_get();
		$email_reminder_days = $this->Settings_model->email_reminder_days_get();
		$items_per_page = $this->Settings_model->items_per_page_get();
		$timezone = $this->Settings_model->timezone_get();
		$auto_timezone = $this->Settings_model->auto_timezone_get();
		$dst = $this->Settings_model->dst_get();
		
		$data['date_format'] = $date_format;
		$data['email_reminder_days'] = $email_reminder_days;
		$data['items_per_page'] = $items_per_page;
		$data['timezone'] = $timezone;
		$data['auto_timezone'] = $auto_timezone;
		$data['dst'] = $dst;
		
		$data['main_content'] = 'settings_view';
		$data['message'] = '';
		$this->load->view('includes/template.php', $data);
	}
	
	function update()
	{
		$this->load->model('Settings_model');
		
		$date_format = $this->input->post('date_format');
		$email_reminder_days = $this->input->post('email_reminder_days');
		$items_per_page = $this->input->post('items_per_page');
		$timezone = $this->input->post('cmbTimezone');
		$auto_timezone = $this->input->post('auto_timezone') == 'true';
		$dst = $this->input->post('chkDst') == 'true';
		
		$this->Settings_model->date_format_set($date_format);
		$this->Settings_model->email_reminder_days_set($email_reminder_days);
		$this->Settings_model->items_per_page_set($items_per_page);
		$this->Settings_model->timezone_set($timezone);
		$this->Settings_model->auto_timezone_set($auto_timezone);
		$this->Settings_model->dst_set($dst);
		
		$data['date_format'] = $date_format;
		$data['email_reminder_days'] = $email_reminder_days;
		$data['items_per_page'] = $items_per_page;
		if (!$auto_timezone)
		{
			$data['timezone'] = $timezone;	
			$data['dst'] = $dst;
		}
		$data['auto_timezone'] = $auto_timezone;
		
		$data['message'] = 'Settings updated';
		$data['main_content'] = 'settings_view';
		$this->load->view('includes/template.php', $data);
	}
	
	// callback method from settings view page
	// called by JScript to set the timezone based on getTimezoneOffset method of Javascript Date class
	function timezone($time, $dst)
	{
		$this->load->model('Settings_model');
		$this->load->library('session');
    	$this->session->set_userdata('timezone', $this->Settings_model->timezone_getCode($time));
    	$this->session->set_userdata('dst', $dst == 'true');
    	echo 'Timezone is '.$this->session->userdata('timezone').'<br>';
    	if ($this->session->userdata('dst'))
    	{
    		echo "DST is in effect";
    	}
    	else
   		{
    		echo 'DST is NOT in effect';
    	}
	}
}