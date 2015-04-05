<?php
class Email_model extends CI_Model {
	
	function __construct()
	{
 		parent::__construct();	
 		$this->load->library('email');
	}
	
	private function init()
	{
		$config['protocol'] = 'mail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
	}
	
/*
 * returns an array with email_address, subject, and message
 * 
 */	private function get_emails()
	{
		$recipients = array();
		$recipient = array();
		$this->load->model('Membership_model');
		$this->load->model('Accounts_model');
		$this->load->model('Settings_model');
		
		$result = $this->Membership_model->get_members();
		foreach ($result as $member)
		{
			$days = $this->Settings_model->email_reminder_days_get_by_member($member->id);
			if ($days > 0) // only do this if they want email reminders 
			{
				$recipient['email_address'] = $member->email_address;
				$billcount = 0;
				$accounts_due = $this->Accounts_model->get_accounts_due_by_member($member->id);
				$data['message'] = "The following bills are due within the next ".$days." days<hr>";
				foreach ($accounts_due as $account) {
					//print_r($accounts_due);
					//die();
					$billcount += 1;
					$data['message'] .= 
						$account->account." bill for ".
						$account->amount." is due by ".
						date($this->Settings_model->date_format_get_by_member($member->id), strtotime($account->next_due))."<br>";
				}
				$recipient['subject'] = "You have ".$billcount." bill".($billcount > 1 ? "s" : "")." due within the next ".$days." day".($days > 1 ? "s" : "");
				$data['ignoreMenu'] = 'true';
				$data['main_content'] = 'email_view';
				$recipient['message'] = $this->load->view('includes/template.php', $data, true);
				
				array_push($recipients, $recipient);
			}
		}
		return $recipients;
	}
	
	function send_email()
	{
		$this->init();
		$this->email->from('info@remembermybills.com', 'my-bills');
		
		$this->load->model('email_model');
		$recipients = $this->email_model->get_emails();

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
	
	function send_password_reset_email($email_address, $token)
	{
		$this->init();
		$this->email->from('info@remembermybills.com', 'my-bills');
		
		$this->load->model('email_model');
		$this->email->to($email_address);
		
		$this->email->subject($this->lang->line('password_reset_email_subject'));
		$this->email->message("Here's that password reset email you wanted<br><br>Token is ".$token);
		
		$this->email->send();
		
		if (ENVIRONMENT == 'development')
			echo $this->email->print_debugger();
	}
	
}
?>