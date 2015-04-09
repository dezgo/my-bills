<?php

class Membership_test extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		// put any startup stuff here
		$this->load->model('Setup_model');
		$this->Setup_model->checkDB(true);
		$this->Setup_model->addDemoData();
		
		$this->load->library('unit_test');
		$this->load->model('Membership_model');
		$_SESSION['member_id'] = 1;
	}
	
	function index()
	{
		$this->testValidate();
		$this->testGoogleAuth();
		$this->testCreateMember();
		$this->testUpdateMember();
		$this->testGetMember();
		$this->testGetMembers();
		$this->testCreatePasswordResetToken();
		$this->testCheckIfEmailExists();
		$this->testCountMembers();
		
		echo $this->unit->report();
	}

	function testValidate()
	{
		$email_address = 'mybills@derekgillett.com';
		$password = 'wrong password';
		$id = $this->Membership_model->validate($email_address, $password);
		
		$test = $id == 0;
		$expected_result = true;
		$test_name = 'Validate returns zero for wrong entry';
		$this->unit->run($test, $expected_result, $test_name);

		$password = 'password';
		$id = $this->Membership_model->validate($email_address, $password);
		
		$test = $id == 0;
		$expected_result = false;
		$test_name = 'Validate returns non-zero for correct entry';
		$this->unit->run($test, $expected_result, $test_name,'id is '.$id);
	}
	
	function testGoogleAuth()
	{
		$secret = $this->Membership_model->google_auth_get_new_secret();
		$test = $secret != '';
		$expected_result = true;
		$test_name = 'Get google auth secret and check it\'s not empty';
		$notes = 'Secret is '.$secret;
		$this->unit->run($test, $expected_result, $test_name, $notes);
		
		$qr_url = $this->Membership_model->google_auth_get_qr_url($secret, 'mybills@derekgillett.com');
		$test = $qr_url != '';
		$expected_result = true;
		$test_name = 'Get google auth qr code url and check it\'s not empty';
		$notes = 'URL is '.$qr_url;
		$this->unit->run($test, $expected_result, $test_name, $notes);

		$secret = $this->Membership_model->google_auth_get_secret(1);
		$test = $secret == '';
		$expected_result = true;
		$test_name = 'Get google auth secret for user 1, should be empty';
		$notes = '';
		$this->unit->run($test, $expected_result, $test_name, $notes);

		$test = !$this->Membership_model->google_auth_check_code('asdf', 1);
		$expected_result = true;
		$test_name = 'Validate QR code';
		$notes = '';
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	function testCreateMember()
	{
		$email_address = 'newemail@derekgillett.com';
		$password = 'pass';
		$result = $this->Membership_model->create_member($email_address, $password);		

		$test = $result;
		$expected_result = true;
		$test_name = 'Create new member';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	function testUpdateMember()
	{
		$email_address = 'mybills1@derekgillett.com';
		$password = 'newpassword';
		$first_name = 'Joe';
		$last_name = 'Bloe';
		$google_auth_enabled = false;
		$google_auth_secret = '';
		$google_auth_code = '';

		$this->Membership_model->update_member($_SESSION['member_id'], $email_address, $password, $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code);
		$test = true;
		$expected_result = true;
		$test_name = 'Update member';
		$this->unit->run($test, $expected_result, $test_name);

		$email_address = 'mybills@derekgillett.com';
		$password = 'password';
		$this->Membership_model->update_member($_SESSION['member_id'], $email_address, $password, $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code);
	}
	
	function testGetMember()
	{
		$test = $this->Membership_model->get_member($_SESSION['member_id']);
		$expected_result = 'is_object';
		$test_name = 'Get member';
		$notes = print_r($test,true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	function testGetMembers()
	{
		$test = $this->Membership_model->get_members();
		$expected_result = 'is_array';
		$test_name = 'Get members';
		$notes = print_r($test,true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	function testCreatePasswordResetToken()
	{
		$email_address = 'mybills@derekgillett.com';
		$this->Membership_model->create_password_reset_token($email_address);
		
		$test = true;
		$expected_result = true;
		$test_name = 'Create password reset token';
		$notes = print_r($this->Membership_model->get_member($_SESSION['member_id']),true);
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
	
	function testCheckIfEmailExists()
	{
		$email_address = 'mybills@derekgillett.com';
		$test = $this->Membership_model->check_if_email_exists($email_address);
		
		$expected_result = true;
		$test_name = 'Check if email exists - true';
		$this->unit->run($test, $expected_result, $test_name);
		
		$email_address = 'mybills@derekgillettt.com';
		$test = $this->Membership_model->check_if_email_exists($email_address);
		
		$expected_result = false;
		$test_name = 'Check if email exists - false';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	function testCountMembers()
	{
		$num_members = $this->Membership_model->count_members();
		$test = $num_members > 0;
		$expected_result = true;
		$test_name = 'Test count members function, should return > 0';
		$notes = 'Number of members: '.$num_members;
		$this->unit->run($test, $expected_result, $test_name, $notes);
	}
}
