<?php
class Payments extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) redirect('');
	}
	
	function show_list($sort_by = 'account', $sort_order = 'asc', $offset = 0)
	{
		$this->load->model('Settings_model');
		$limit =  $this->Settings_model->items_per_page_get();
		$data['fields'] = array(
				'account' => 'Account',
				'payment_date' => 'Payment Date',
				'amount' => 'Amount'
		);
	
		$this->load->library('pagination');
		$this->load->library('table');
	
		$this->load->model('Payments_model');
		$results = $this->Payments_model->search($limit, $offset, $sort_by, $sort_order);
	
		$data['records'] = $results['rows'];
		$data['num_results'] = $results['num_rows'];
	
		$config['base_url']	= site_url("payments/show_list/$sort_by/$sort_order");
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
	
		$data['main_content'] = 'payments_view';
		$this->load->view('includes/template', $data);
	}
	
}
?>