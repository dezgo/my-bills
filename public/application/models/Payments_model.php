<?php
class Payments_model extends CI_Model {

	function search($member_id, $limit, $offset, $sort_by, $sort_order)
	{
	
		$sort_order = ($sort_order =='desc') ? 'desc' : 'asc';
		$sort_columns = array('account', 'payment_date_u', 'amount');
	
		// if the sort_by column is in the columns array, return it, other return default value
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'account';
	
		// results query
		$query = $this->db->select('id, account, amount, unix_timestamp(payment_date) as payment_date_u, ')
				->from('payments')
				->where('member_id', $member_id)
				->limit($limit, $offset)
				->order_by($sort_by, $sort_order);
		$ret['rows'] = $query->get()->result();
	
		// count query
		$query = $this->db->select('COUNT(*) as count', FALSE)
		->from('payments')
		->where('member_id', $member_id);
	
		$tmp = $query->get()->result();
	
		$ret['num_rows'] = $tmp[0]->count;
	
		return $ret;
	}
	
	function get_payment($payment_id)
	{
		$this->db->where('id', $payment_id);
		$query = $this->db->get('payments');
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return null;
	}
	
	// note: payment date defaults to today via mysql trigger
	function insert($member_id, $account, $amount, $payment_date)
	{
		
		
		$data['member_id'] = $member_id;
		$data['amount'] = $amount;
		$data['account'] = $account;
		$data['payment_date'] = md_unix_to_mysql($payment_date);
		$this->db->trans_start();
		if ($this->db->insert('payments', $data))
		{
			$id = $this->db->insert_id();
			$this->db->trans_complete();				
			return $this->get_payment($id);
		}
		else
		{	
			$this->db->trans_complete();				
			return null;
		}
	}
	
	// used when uploading via csv
	function insertArray($member_id, $array, $overwrite, $date_format_php, $timezone, $dst)
	{
		// if user wants to overwrite, then clear out records first
		if ($overwrite != '')
		{
			$this->db->where('member_id',$member_id);
			$this->db->delete('payments');
		}
		
		// load codeigniter date helpe to use now() function
		$this->load->helper('date');
	
		foreach ($array as $payment)
		{
			// initialise variables, use these defaults if not present in import file
			$account = ''; 
			$amount = 0; 
			$payment_date = now();
			
			// now update to what's in array - if found
			if (array_key_exists('account', $payment)) 
			{
				$account = $this->db->escape_str($payment['account']);
			}
			if (array_key_exists('amount', $payment) and is_numeric($payment['amount'])) 
			{
				$amount = $payment['amount'];
			}
			if (array_key_exists('payment_date', $payment)) 
			{
				if (md_validate_local($payment['payment_date'], $date_format_php))
					$payment_date = md_local_to_unix($payment['payment_date'], $date_format_php, $timezone, $dst);
			}
			
			// and assuming account is not still empty, insert record
			if ($account != '') 
			{
				$this->insert($member_id, $account, $amount, $payment_date);
			}
		}
	}
}
