<?php

class Membership_Test extends PHPUnit_Framework_TestCase
{
	private $CI;
	private $member;
	private $email_address;
	private $password;

	function __construct()
	{
		ob_start();
		parent::__construct();
	}
	
    function setUp()
    {
      	// Load CI instance normally
    	$this->CI = &get_instance();
		$this->CI->load->model('Accounts_model');
		$this->CI->load->model('Setup_model');
		$this->CI->load->model('Membership_model');

		// check the database is ok
		$this->CI->Setup_model->checkDB(true);
		
		// create new member to test with
		$this->email_address = 'someone@domain.com';
		$this->password = 'verycomplexpasswordhere';
		$this->member = $this->CI->Membership_model->create_member($this->email_address, $this->password);
		$this->assertNotNull($this->member);
	}
	
	function tearDown()
	{
		// get rid of that test member once we're done
		$this->CI->Membership_model->delete_member($this->member->id);
	}

	function testValidateLogin()
	{
		$id = $this->CI->Membership_model->validate($this->email_address, 'wrong password');
		$this->assertEquals($id, 0, 'Validate returns zero for wrong entry');

		$id = $this->CI->Membership_model->validate($this->email_address, $this->password, 'Validate returns member id when correct email/password supplied');
		$this->assertEquals($id, $this->member->id);
	}
	
	function testGoogleAuth()
	{
		$secret = $this->CI->Membership_model->google_auth_get_new_secret();
		$this->assertNotEquals($secret, '', 'Get google auth secret and check it\'s not empty');
		
		$qr_url = $this->CI->Membership_model->google_auth_get_qr_url($secret, $this->email_address);
		$this->assertNotEquals($qr_url, '', 'Get google auth qr code url and check it\'s not empty');
		
		$secret = $this->CI->Membership_model->google_auth_get_secret($this->member->id);
		$this->assertEquals($secret, '', 'Google auth secret for user '.$this->member->id.', should be empty');
		
		$test = $this->CI->Membership_model->google_auth_check_code('asdf', 1);
		$this->assertEquals($test, false, 'Validate QR code should return false for invalid entry');
	}
	
	function testCreateUpdateDeleteMember()
	{
		$email_address = 'newemail@derekgillett.com';
		$password = 'pass';

		$member = $this->CI->Membership_model->create_member($email_address, $password);
		$this->assertInternalType('object', $member, 'Create new member with email '.$email_address.' and password '.$password.'. Should return member object');
		
		$member_id = $member->id;
		$password = 'newpassword';
		$first_name = 'Joe';
		$last_name = 'Bloe';
		$google_auth_enabled = false;
		$google_auth_secret = '';
		$google_auth_code = '';

		$this->CI->Membership_model->update_member($member->id, $email_address, $password, $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code);
		$member_updated = $this->CI->Membership_model->get_member($member->id);
		
		$message = 'Update member then get memeber and ensure values are as per updated';
		$this->assertEquals($member_id, $member_updated->id, $message);
		$this->assertEquals($email_address, $member_updated->email_address, $message);
		$this->assertEquals($first_name, $member_updated->first_name, $message);
		$this->assertEquals($last_name, $member_updated->last_name, $message);
		$this->assertEquals($google_auth_secret, $member_updated->google_auth_secret, $message);
		
		$this->CI->Membership_model->delete_member($member_id);
		$member = $this->CI->Membership_model->get_member($member_id);
		$this->assertNull($member, 'Delete member just created, then try to get member and ensure null returned');
	}
	
	function testGetMembers()
	{
		$members = $this->CI->Membership_model->get_members();
		$this->assertInternalType('array', $members);
	}
	
	function testPasswordResetToken()
	{
		$token = $this->CI->Membership_model->create_password_reset_token($this->member->id);
		$this->assertNotEmpty($token);

		$token = $this->CI->Membership_model->retrieve_password_reset_token($this->member->id);
		$this->assertNotEmpty($token);
		
		$token = $this->CI->Membership_model->retrieve_password_reset_token(23564);
		$this->assertEmpty($token);
	}
	
	function testCheckIfEmailExists()
	{
		$this->assertTrue($this->CI->Membership_model->check_if_email_exists($this->email_address));
		$this->assertFalse($this->CI->Membership_model->check_if_email_exists('somedodgyaddress@dodgytown.co.uk'));

		// try putting some dodgy characters in the address
		$this->assertFalse($this->CI->Membership_model->check_if_email_exists('somedodgyaddress@dodgytown.co.uk />'));
	}
	
	function testCountMembers()
	{
		$this->assertGreaterThan(0, $this->CI->Membership_model->count_members());
	}
	
	function testMemberIdIsValid()
	{
		$this->assertTrue($this->CI->Membership_model->member_id_is_valid($this->member->id));
		$this->assertFalse($this->CI->Membership_model->member_id_is_valid('asdf'));
		$this->assertFalse($this->CI->Membership_model->member_id_is_valid(235435));
	}
}
