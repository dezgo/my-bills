<?php
class Payments extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		boot_non_member();
	}
	
	function index()
	{
		$this->show_list();
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
		$results = $this->Payments_model->search($_SESSION['member_id'], $limit, $offset, $sort_by, $sort_order);
	
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
		$data['date_format_php'] = $this->Settings_model->date_format_to_php($data['date_format']);
		
		// import csv errors
		$data['error'] = '';
		
		$data['main_content'] = 'payments_view';
		$this->load->view('includes/template', $data);
	}
	
	function import_csv()
	{
		$this->load->library('Csvimport');
		$array = $this->Csvimport->get_array('test.csv');		
		print_r($array);
	}
	
	function export_csv()
	{
		$this->load->helper('csv');
		$quer = $this->db->get('payments');
		query_to_csv($quer,TRUE,'payments_'.date('dMy').'.csv');
	}
	
	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
	
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$data['upload_data'] = '';
			$data['error'] = $this->upload->display_errors();
			$data['main_content'] = 'upload_form';
		}
		else
		{
			$data['upload_data'] = $this->upload->data();
			$data['error'] = '';
			$data['main_content'] = 'upload_success';

			$this->load->library('Csvimport');
			$this->load->model('Payments_model');
			$array = $this->Csvimport->get_array('uploads/'.$data['upload_data']['file_name']);
			$overwrite = $this->input->post('chkOverwrite');
			$this->Payments_model->insertArray($array, $overwrite);
		}
		$this->load->view('includes/template', $data);
	}
	
	function upload_get_file()
	{
		$data['error'] = '';
		$data['main_content'] = 'upload_form';
		$this->load->view('includes/template', $data);
	}
}
?>
