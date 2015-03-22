<?php
class Email extends MY_Controller
{
	function __construct()
	{
//		global $cronjob;
// 		$cronjob = TRUE;
 		parent::__construct();	
 		$this->load->library('email');
	}
	
	function init()
	{
		$config['protocol'] = 'mail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		
		$this->email->initialize($config);
	}
	
	function send_email()
	{
		$this->init();
		$this->email->from('my-bills@derekgillett.com', 'my-bills');
		$this->email->to('mybillsto@derekgillett.com'); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
	function index()
	{
		$this->send_email();
		$data['main_content'] = 'email_view';
		$this->load->view('includes/template.php', $data);
	}
}