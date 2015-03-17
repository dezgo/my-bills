<?php

class Site extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) redirect('');
	}
	
	function members_area($sort_by = 'last_due', $sort_order = 'asc', $offset = 0)
	{
		$limit = 20;
		$data['main_content'] = 'accounts_list';
		$data['fields'] = array(
			'account' => 'Account',
			'last_due_formatted' => 'Last Due',
			'times_per_year' => 'Times&nbsp;p/a',
			'next_due_formatted' => 'Next Due',
			'amount' => 'Amount'
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
		
		$this->load->view('includes/template', $data);
	}
	
	function logout()
	{
		$this->session->set_userdata('member_id', 0);	
		
		$data['main_content'] = 'logout';
		$this->load->view('includes/template', $data);
	}
	
	function edit_account($id) {
		$this->load->library('table');
		
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->load($id);
		$data['main_content'] = 'edit_account';
		
		$data['id'] = $id;
		$data['account'] = $row->account;
		$data['last_due'] = $row->last_due;
		$data['times_per_year'] = $row->times_per_year;
		$data['amount'] = $row->amount;
		$this->load->view('includes/template', $data);
	}
	
	function delete_account($id) {
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->delete($id);
		
		// and back to the list
		$this->members_area();
//		$data['main_content'] = 'm';
	//	$this->load->view('includes/template', $data);
	}

	function update_account() {
		$id = $this->input->post('id'); 
		$data = array(
			'account' => $this->input->post('account'), 
			'last_due' => $this->input->post('last_due'),
			'times_per_year' => $this->input->post('times_per_year'), 
			'amount' => $this->input->post('amount')
		);
		
		$this->load->model('Accounts_model');
		$row = $this->Accounts_model->update($id, $data);
		
		// and back to the list
		$this->members_area();
//		$data['main_content'] = 'm';
	//	$this->load->view('includes/template', $data);
	}
}