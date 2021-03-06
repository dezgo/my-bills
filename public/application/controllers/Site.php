<?php

class Site extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('cookie');
		$member_id = get_cookie('stay_logged_in');
		if ($member_id != '') 
		{
			$this->load->model('Membership_model');
			$this->Membership_model->initial_login_setup($member_id);
		} 

		// only allow members to get to anything but the index function
		if (uri_string() != '' and uri_string() != 'Site' and uri_string() != 'Site/index')
			boot_non_member();
	}
	
	function index()
	{
		$this->data['main_content'] = 'home_view';
		$this->load->view('includes/template', $this->data);
	}
	
	function members_area($sort_by = 'days', $sort_order = 'asc', $offset = 0)
	{
		$this->load->model('Settings_model');
		$limit =  $this->Settings_model->items_per_page_get($_SESSION['member_id']);
		$data['fields'] = array(
			'account' => 'Account',
			'last_due_u' => 'Last Due',
			'amount' => 'Amount',
			'times_per_year' => 'Times p/a',
			'next_due_u' => 'Next Due',
			'days' => 'Days'
		);
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$this->load->model('Accounts_model');
		$results = $this->Accounts_model->search($_SESSION['member_id'], $limit, $offset, $sort_by, $sort_order);
		
		$data['records'] = $results['rows'];
		$data['num_results'] = $results['num_rows'];
		
		$config['base_url']	= site_url("site/members_area/$sort_by/$sort_order");
		$config['total_rows'] = $data['num_results'];
		$config['per_page'] = $limit;
		$config['num_links'] = 20;
		$config['uri_segment'] = 5;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		
		$this->pagination->initialize($config);
		
		$data['sort_by'] = $sort_by;
		$data['sort_order'] = $sort_order;
		
		$data['date_format_php'] = $_SESSION['date_format_php'];
		$data['timezone'] = $_SESSION['timezone'];
		$data['dst'] = $_SESSION['dst'];
		
		$data['main_content'] = 'accounts_list';
		$this->load->view('includes/template', $data);
	}
	
	function profile($message = '')
	{
		// get member details
		$this->load->model('Membership_model');
		$member = $this->Membership_model->get_member($_SESSION['member_id']);
		
		$data['message'] = $message;
		$data['firstname'] = $this->input->post('first_name') == '' ? $member->first_name : $this->input->post('first_name');
		$data['lastname'] = $this->input->post('last_name') == '' ? $member->last_name : $this->input->post('last_name');
		$data['email_address'] = $this->input->post('email_address') == '' ? $member->email_address : $this->input->post('email_address');
		$qr_url = '';
		$secretDB = $this->Membership_model->google_auth_get_secret($_SESSION['member_id']);
		$secret = $this->input->post('google_auth_secret') == '' ? $secretDB : $this->input->post('google_auth_secret');
		if ($secretDB == '')
		{
			$data['google_auth_enabled'] = false;
			if ($secret == '')	// only get a new secret if one hasn't already been generated
			{	
				$secret = $this->Membership_model->google_auth_get_new_secret();
			}
		}
		else
		{
			$data['google_auth_enabled'] = true;
		}
		$_SESSION['google_auth_secret'] = $secret;
		$data['google_auth_secret'] = $secret;
		$data['qr_url'] = $this->Membership_model->google_auth_get_qr_url($secret, $data['email_address']);
		
		$data['main_content'] = 'profile_view';
		$this->load->view('includes/template', $data);
	}
	
	function update_profile()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|callback_check_if_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('google_auth_code', 'Google verification code', 'callback_check_google_auth_code');
		
		if($this->form_validation->run() == TRUE)
		{
			$this->load->model('membership_model');
			$email_address = $this->input->post('email_address');
			$password = $this->input->post('password');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$google_auth_secret = $this->input->post('google_auth_secret');
			$google_auth_code = $this->input->post('google_auth_code');
			$google_auth_enabled = $this->input->post('chkGoogleAuthEnabled') != '';
						
			$result = $this->membership_model->update_member($_SESSION['member_id'], $email_address, $password, $first_name, $last_name, $google_auth_enabled, $google_auth_secret, $google_auth_code);
			
			$this->profile('Details Updated');
		}
		else
			$this->profile('');
	}
	
	function check_if_email_exists($requested_email)	// custom callback function
	{
		$this->load->model('Membership_model');
		return !$this->Membership_model->check_if_email_exists($requested_email) or $requested_email == $_SESSION['email_address'];
	}
	
	function check_google_auth_code($google_auth_code)
	{
		if ($google_auth_code == '')
		{
			return true;
		}
		else 
		{
			require_once APPPATH.'models/crypto/GoogleAuthenticator.php';
			$ga = new PHPGangsta_GoogleAuthenticator();
			return $ga->verifyCode($_SESSION['google_auth_secret'], $google_auth_code, 2);
		}
	}
	
	// logout, kill session and delete cookie that keeps user logged in
	function logout()
	{
		session_destroy();
		$this->load->helper('cookie');
		delete_cookie('stay_logged_in');
		redirect('');
	}

	function validate_date($date)
	{
		$valid = md_validate_local($date, $_SESSION['date_format_php']);
		return $valid;
	}

	function edit_account($id = 0) {
		// get data, either from post or database
		$this->load->model('Accounts_model');
		if ($id != 0)
		{
			$row = $this->Accounts_model->load($id);
			$account = $row->account;
			$last_due = $row->last_due_u;
			$times_per_year = $row->times_per_year;
			$amount = $row->amount;
		}
		else
		{
			$id = $this->input->post('id');
			$account = $this->input->post('account');
			$last_due = md_local_to_unix($this->input->post('last_due'), $_SESSION['date_format_php'], $_SESSION['timezone'], $_SESSION['dst']);
			$times_per_year = $this->input->post('times_per_year');
			$amount = $this->input->post('amount');				
		}

		// will be used in view to create table
		$this->load->library('table');
		
		$this->load->library('form_validation');
		$this->load->helper('form','url');
		
		$this->form_validation->set_rules('account', 'Account', 'required');
		$this->form_validation->set_rules('last_due', 'Last Due', 'required|callback_validate_date');
		$this->form_validation->set_rules('times_per_year', 'Times/year', 'required|numeric');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			// used to get default date format
			$data['date_format'] = $_SESSION['date_format']; 
			$data['date_format_php'] = $_SESSION['date_format_php'];
			$data['timezone'] = $_SESSION['timezone'];
			$data['dst'] = $_SESSION['dst'];
					
			$data['id'] = $id;
			$data['account'] = $account;
			$data['last_due'] = $last_due;
			$data['times_per_year'] = $times_per_year;
			$data['amount'] = $amount;
	
			$data['main_content'] = 'edit_account';
			$this->load->view('includes/template', $data);
		}
		else
		{
			if ($id == 0) {
				$row = $this->Accounts_model->insert($_SESSION['member_id'], $account, $last_due, $times_per_year, $amount);
			} else {
				$row = $this->Accounts_model->update($id, $account, $last_due, $times_per_year, $amount);
			}
			
			// and back to the list
			$this->members_area();
		}
	}
	
	function insert_account() {
		$this->load->library('table');
		
		// get default date format
		$data['date_format'] = $_SESSION['date_format']; 
		$data['date_format_php'] = $_SESSION['date_format_php'];
		$data['timezone'] = $_SESSION['timezone'];
		$data['dst'] = $_SESSION['dst'];

		$this->load->model('Accounts_model');
		
		$data['id'] = 0;
		$data['account'] = "";
		$data['last_due'] = "";
		$data['times_per_year'] = "";
		$data['amount'] = "";
		
		$data['main_content'] = 'edit_account';
		$this->load->view('includes/template', $data);
	}
	
	function delete_account($id) {
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->delete($id);
		
		// and back to the list
		$this->members_area();
	}

	// mark account as paid and reschedule
	function pay_account($account_id, $amount)
	{
		$this->load->model('Accounts_model');
		$this->Accounts_model->pay($_SESSION['member_id'], $account_id, $amount);

		// and back to the list
		$this->members_area();
	}
	
}
