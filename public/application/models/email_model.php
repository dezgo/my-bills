<?php
class Email_model extends CI_Model {
	
/*
 * returns an array with email_address, subject, and message
 * 
 */	function get_emails()
	{
		$recipients = array();
		$recipient = array();
		$this->load->model('membership_model');
		$this->load->model('Accounts_model');
		$this->load->model('settings_model');
		
		$result = $this->membership_model->get_members();
		foreach ($result as $member)
		{
			$days = $this->settings_model->email_reminder_days_get_by_member($member->id);
			if ($days > 0) // only do this if they want email reminders 
			{
				$recipient['email_address'] = $member->email_address;
				$billcount = 0;
				$accounts_due = $this->Accounts_model->get_accounts_due_by_member($member->id);
				$recipient['message'] = "The following bills are due within the next ".$days." days<hr>";
				foreach ($accounts_due as $account) {
					//print_r($accounts_due);
					//die();
					$billcount += 1;
					$recipient['message'] .= 
						$account->account." bill for ".
						$account->amount." is due by ".
						date($this->settings_model->date_format_get_by_member($member->id), strtotime($account->next_due))."<br>";
				}
				$recipient['subject'] = "You have ".$billcount." bill".($billcount > 1 ? "s" : "")." due within the next ".$days." day".($days > 1 ? "s" : "");
				$recipients.array_push($recipients, $recipient);
			}
		}
		return $recipients;
	}
	
}
?>