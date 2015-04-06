<?php
class Payments_model extends CI_Model {

	function search($member_id, $limit, $offset, $sort_by, $sort_order)
	{
	
		$sort_order = ($sort_order =='desc') ? 'desc' : 'asc';
		$sort_columns = array('account', 'payment_date', 'amount');
	
		// if the sort_by column is in the columns array, return it, other return default value
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'account';
	
		// results query
		$query = $this->db->select('id, account, amount, payment_date, ')
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
	
	// note payment date defaults to today via mysql trigger
	function insert($account, $amount, $payment_date)
	{
		$data['member_id'] = $_SESSION['member_id'];
		$data['amount'] = $amount;
		$data['account'] = $account;
		$data['payment_date'] = date('Y-m-d H:i:s', local_to_gmt($payment_date));
		//echo $data['payment_date']."<BR>";
		//$data['payment_date'] = date('Y-m-d H:i:s', $payment_date);
		//echo $data['payment_date'];
			//die();
		$this->db->insert('payments', $data);
	}
	
	function insertArray($array, $overwrite)
	{
		// if user wants to overwrite, then clear out records first
		if ($overwrite != '')
		{
			$this->db->empty_table('payments');
		}
		
		foreach ($array as $payment)
		{
			// load codeigniter date helpe to use now() function
			$this->load->helper('date');
			
			// initialise variables, use these defaults if not present in import file
			$account = ''; 
			$amount = 0; 
			$payment_date = now();
			
			// now update to what's in array - if found
			if (array_key_exists('account', $payment)) 
			{
				$account = $payment['account'];
			}
			if (array_key_exists('amount', $payment)) 
			{
				$amount = $payment['amount'];
			}
			if (array_key_exists('payment_date', $payment)) 
			{
				$payment_date = strtotime($payment['payment_date']);
			}
			
			// and assuming account is not still empty, insert record
			if ($account != '') 
			{
				$this->insert($account, $amount, $payment_date);
			}
		}
	}
}
