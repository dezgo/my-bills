<?php

class Site extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) redirect('');
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
		
		// used to get default date format
		$this->load->model('Settings_model');
		$data['date_format'] = $this->Settings_model->date_format_get(); 
		
		$data['main_content'] = 'accounts_list';
		$this->load->view('includes/template', $data);
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		
		$data['main_content'] = 'logout';
		$this->load->view('includes/template', $data);
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