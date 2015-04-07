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
	
	private function send_emails($recipients, $fromEmail = 'info@remembermybills.com', $fromName = 'remember-my-bills')
	{
		$this->init();
		$this->email->from($fromEmail, $fromName);
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
	
/*
 * returns an array with email_address, subject, and message for reminders of upcoming bills
 * 
 */	private function upcoming_bills_reminder()
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
				$recipient['message'] = "G'day";
				if ($member->first_name != '') $recipient['message'] .= "&nbsp;".$member->first_name;
				$recipient['message'] .= ",<br><br>Derek from remember-my-bills here. As promised, here's a list of bills due in the next ".$days." days<hr>";
				foreach ($accounts_due as $account) {
					$billcount += 1;
					$recipient['message'] .= 
						$account->account." bill for ".
						$account->amount." is due by ".
						date($this->Settings_model->date_format_get_by_member($member->id), strtotime($account->next_due))."<br>";
				}
				$recipient['message'] .= "<Br><br>Go to <a href='http://rememberthebills.com'>http://rememberthebills.com</a> to pay them.";
				$recipient['message'] .= "<Br><br>Enjoy your day!<br><br>The remember-the-bills team.";
				
				$recipient['subject'] = "You have ".$billcount." bill".($billcount > 1 ? "s" : "")." due within the next ".$days." day".($days > 1 ? "s" : "");
				//$data['ignoreMenu'] = 'true';
				//$data['main_content'] = 'email_view';
				//$recipient['message'] = $this->load->view('includes/template.php', $data, true);
				
				array_push($recipients, $recipient);
			}
		}
		return $recipients;
	}
	
	function send_upcoming_bills_reminder_email()
	{
		$this->send_emails($this->upcoming_bills_reminder());		
	}
	
	function send_password_reset_email($email_address, $token)
	{
		$recipient = array();
		$recipients = array();
		$recipient['email_address'] = $email_address;
		$recipient['subject'] = $this->lang->line('password_reset_email_subject');
		$recipient['message'] = "Here's that password reset email you wanted<br><br>Token is ".$token;
		array_push($recipients, $recipient);
		
		$this->send_emails($recipients);
	}
	
	function send_contact_us_email($contact_name, $email_address, $message)
	{
		$recipient = array();
		$recipients = array();
		$recipient['email_address'] = 'info@remembermybills.com';
		$recipient['subject'] = $contact_name . ' wants a word';
		$recipient['message'] = $message;
		array_push($recipients, $recipient);
		
		$this->send_emails($recipients,$email_address, $contact_name);
	}
}
?>