<?php
/* this command goes in the crontab file
 * php -f /home/a8228193/public_html/application/controllers/email.php
 */
class Email extends MY_Controller
{
	function index()
	{
		$this->load->model('Email_model');
		$this->Email_model->send_upcoming_bills_reminder_email();
	}
}