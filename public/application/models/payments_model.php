<?php
class Payments_model extends CI_Model {

	function search($limit, $offset, $sort_by, $sort_order)
	{
	
		$sort_order = ($sort_order =='desc') ? 'desc' : 'asc';
		$sort_columns = array('account', 'payment_date', 'amount');
	
		// if the sort_by column is in the columns array, return it, other return default value
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'account';
	
		// results query
		$query = $this->db->select('id, account, amount, payment_date, ')
				->from('payments')
				->where('member_id', $this->session->userdata('member_id'))
				->limit($limit, $offset)
				->order_by($sort_by, $sort_order);
		$ret['rows'] = $query->get()->result();
	
		// count query
		$query = $this->db->select('COUNT(*) as count', FALSE)
		->from('payments')
		->where('member_id', $this->session->userdata('member_id'));
	
		$tmp = $query->get()->result();
	
		$ret['num_rows'] = $tmp[0]->count;
	
		return $ret;
	}
	
	// note payment date defaults to today via mysql trigger
	function insert($account, $amount)
	{
		$data['member_id'] = $this->session->userdata('member_id');
		$data['amount'] = $amount;
		$data['account'] = $account;
		$this->db->insert('payments', $data);
	}
}
