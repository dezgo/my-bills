<?php
class Email extends MY_Controller
{
	function index()
	{
		$this->load_model('Email_model');
		$this->Email_model->send_email();
	}
}