<?php
class Email extends MY_Controller
{
	function __construct()
	{
 		parent::__construct();	
 		$this->load->library('email');
	}
	
	function init()
	{
		$config['protocol'] = 'mail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
	}
	
	function send_email()
	{
		$this->init();
		$this->email->from('my-bills@derekgillett.com', 'my-bills');
		
		$this->load->model('email_model');
		$recipients = $this->email_model->get_emails();
		//print_r($recipients);
		//die();
		foreach ($recipients as $recipient)
		{
			$this->email->to($recipient['email_address']);
			
			$this->email->subject($recipient['subject']);
			$this->email->message($recipient['message']);
			
			$this->email->send();
			
			if (ENVIRONMENT == 'development')
				echo $this->email->print_debugger();
		}
	}
	
	function index()
	{
		$this->send_email();
		$data['main_content'] = 'email_view';
		$this->load->view('includes/template.php', $data);
	}
}