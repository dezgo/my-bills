<?php

class Login extends MY_Controller {
	
	private $data;
	
	function __construct()
	{
		parent::__construct();
		$this->data['failed'] = 0;
	}
	
	function index()
	{
		$this->data['main_content'] = 'login_form';
		$this->load->view('includes/template', $this->data);
	}
	
	function validate_credentials()
	{
		$email_address = $this->input->post['email_address'];
		$password = $this->input->post['password'];
		
		$this->load->model('membership_model');
		$member_id = $this->membership_model->validate($email_address, $password);
		
		if($member_id !== 0) // if the user's credentials validated...
		{
			//  set the member id first as it's required for other functions in settings model
			$this->load->model('Settings_model');
			$_SESSION['member_id'] = $member_id;
			
			$_SESSION['email_address'] = $email_address;
			$_SESSION['timezone'] = $this->Settings_model->timezone_get();
			$_SESSION['dst'] = $this->Settings_model->dst_get();
			
			redirect('site/members_area');
		}
		
		else
		{
			$this->data['failed']++;
			$this->index();
		}
	}
	
	function signup()
	{
		$this->data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $this->data);
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|callback_check_if_email_exists');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');

		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->load->model('membership_model');
			$email_address = $this->input->post('email_address');
			$password = $this->input->post('password');
			if($query = $this->membership_model->create_member($email_address, $password))
			{
				$this->validate_credentials();
			}
			else
			{
				$this->data['main_content'] = 'signup_form';
				$this->load->view('includes/template', $this->data);
			}
		}
	}

	function check_if_email_exists($requested_email)	// custom callback function
	{
		$this->load->model('membership_model');
		return !$this->membership_model->check_if_email_exists($requested_email);
	}

	function check_if_email_exists_to_reset($requested_email)	// custom callback function
	{
		$this->load->model('membership_model');
		return $this->membership_model->check_if_email_exists($requested_email);
	}
	
	function captcha_is_correct($captcha)
	{
		return strcmp(strtolower($captcha),strtolower($_SESSION['captchaWord'])) == 0;
	}

	function forgot_password()
	{
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		
		/* Set form validation rules */
		$this->form_validation->set_rules('email_address', 'lang:email_address', 'trim|required|valid_email|max_length[50]|callback_check_if_email_exists_to_reset');
		$this->form_validation->set_rules('captcha', "Captcha", 'required|callback_captcha_is_correct');
	    
	    /* Get the user's entered captcha value from the form */
	    $userCaptcha = $this->input->post('captcha');
	    
	    // initialise session variable if required
	    if (!isset($_SESSION['captchaWord'])) $_SESSION['captchaWord'] = '';
	    
	    /* Check if form (and captcha) passed validation*/
	    if ($this->form_validation->run() == TRUE && $this->captcha_is_correct($userCaptcha)) {
		    /** Validation was successful; show the Success view **/
		    /* Clear the session variable */
		    $this->session->unset_userdata('captchaWord');
		    
			$this->load->model('Membership_model');
			$this->load->model('Email_model');

			// create the reset token
			$email_address = $this->input->post('email_address');
			$token = $this->Membership_model->create_password_reset_token($email_address);

			// send off password reset email
			$this->Email_model->send_password_reset_email($email_address, $token);

			$this->data['main_content'] = 'reset_password_form_success';
			$this->load->view('includes/template', $this->data);
			
			
		} else {
			/** Validation was not successful - Generate a captcha **/
			/* Setup vals to pass into the create_captcha function */
			$vals = array(
				'img_path' => 'captcha/',
				'img_url' => base_url().'captcha/',
				'font_path' => 'fonts/ostrich-black.ttf',
				'img_width' => '250',
				'font_size' => 30,
				'word_length' => 6,
				'img_height' => 60,
				'expiration' => 7200
				);
			/* Generate the captcha */
			$this->data = create_captcha($vals);
			
		    // save the email address
		    $this->data['email_address'] = $this->input->post('email_address');
		    
			/* Store the captcha value (or 'word') in a session to retrieve later */
			$_SESSION['captchaWord'] = $this->data['word'];
			/* Load the captcha view containing the form (located under the 'views' folder) */
			$this->data['main_content'] = 'reset_password_form';
			$this->load->view('includes/template', $this->data);
		}		
	}
	
}