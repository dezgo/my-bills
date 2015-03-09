<?php

class Site extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
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
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			// redirect back to the login page if no longer logged in
			redirect('');
		}
	}
	
}