<?php

class Site extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		boot_non_member();
	}
	
	function members_area($sort_by = 'days', $sort_order = 'asc', $offset = 0)
	{
		$this->load->model('Settings_model');
		$limit =  $this->Settings_model->items_per_page_get();
		$data['fields'] = array(
			'account' => 'Account',
			'last_due' => 'Last Due',
			'amount' => 'Amount',
			'times_per_year' => 'Times p/a',
			'next_due' => 'Next Due',
			'days' => 'Days'
		);
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$this->load->model('Accounts_model');
		$results = $this->Accounts_model->search($limit, $offset, $sort_by, $sort_order);
		
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
		
		$data['main_content'] = 'accounts_list';
		$this->load->view('includes/template', $data);
	}
	
	function profile($message = '')
	{
		// get member details
		$this->load->model('membership_model');
		$member = $this->membership_model->get_member();
		
		$data['message'] = $message;
		$data['firstname'] = $this->input->post('first_name') == '' ? $member->first_name : $this->input->post('first_name');
		$data['lastname'] = $this->input->post('last_name') == '' ? $member->last_name : $this->input->post('last_name');
		$data['email_address'] = $this->input->post('email_address') == '' ? $member->email_address : $this->input->post('email_address');
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
		
		if($this->form_validation->run() == TRUE)
		{
			$this->load->model('membership_model');
			$this->membership_model->update_member();
			
		}
		$this->profile('Details Updated');
	}
	
	function check_if_email_exists($requested_email)	// custom callback function
	{
		$this->load->model('membership_model');
		return $this->membership_model->check_if_email_exists($requested_email);
	}
	
	function logout()
	{
		session_destroy();
		redirect('Home');
	}
	
	function edit_account($id) {
		// will be used in view to create table
		$this->load->library('table');
		
		// used to get default date format
		$this->load->model('Settings_model');
		$data['date_format'] = $this->Settings_model->date_format_get(); 
		
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->load($id);
		$data['main_content'] = 'edit_account';
		
		$data['id'] = $id;
		$data['account'] = $row->account;
		$data['last_due'] = $row->last_due;

		//$data['last_due_formatted'] = $row->last_due_formatted;// unix_to_human($row->last_due, FALSE, 'euro');
		$data['times_per_year'] = $row->times_per_year;
		$data['amount'] = $row->amount;
		$this->load->view('includes/template', $data);
	}
	
	function insert_account() {
		$this->load->library('table');
		
		$this->load->model('Accounts_model');
		$data['main_content'] = 'edit_account';
		
		$data['id'] = 0;
		$data['account'] = "";
		$data['last_due'] = "";
		//$data['last_due_formatted'] = "";
		$data['times_per_year'] = "";
		$data['amount'] = "";
		$this->load->view('includes/template', $data);
	}
	
	function delete_account($id) {
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->delete($id);
		
		// and back to the list
		$this->members_area();
	}

	// includes adding a new account - do this if id == 0
	function update_account() {
		$this->load->helper('date');
		
		$id = $this->input->post('id'); 
		$data = array(
			'account' => $this->input->post('account'), 
			'last_due' => date('Y-m-d', strtotime($this->input->post('last_due'))),
			'times_per_year' => $this->input->post('times_per_year'), 
			'amount' => $this->input->post('amount')
		);
		
		$this->load->model('Accounts_model');
		if ($id == 0) {
			$row = $this->Accounts_model->insert($data);
		} else {
			$row = $this->Accounts_model->update($id, $data);
		}
		
		// and back to the list
		$this->members_area();
	}
	
	// mark account as paid and reschedule
	function pay_account($id,$amount) {
		$this->load->model('Accounts_model');
		$this->Accounts_model->pay($id,$amount);		

		// and back to the list
		$this->members_area();
	}
	
}