<?php
class Accounts_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	function search($member_id, $limit, $offset, $sort_by, $sort_order)
	{
		
		$sort_order = ($sort_order =='desc') ? 'desc' : 'asc';
		$sort_columns = array('account', 'last_due_u', 'times_per_year', 'next_due_u', 'amount', 'days');

		// if the sort_by column is in the columns array, return it, other return default value
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'days';
		
		// results query
		$query = $this->db->select('id, account, amount, times_per_year, '.
					'unix_timestamp(adddate(last_due,365/times_per_year)) as next_due_u, unix_timestamp(last_due) as last_due_u, '.
					'datediff(adddate(last_due,365/times_per_year), now()) as days', FALSE)
				->from('accounts')
				->where('member_id', $member_id)
				->limit($limit, $offset)
				->order_by($sort_by, $sort_order);		
		$ret['rows'] = $query->get()->result();
		
		// count query
		$query = $this->db->select('COUNT(*) as count', FALSE)
				->from('accounts')
				->where('member_id', $member_id);
		
		$tmp = $query->get()->result();
		
		$ret['num_rows'] = $tmp[0]->count;
		
		return $ret;
	}
	
	function load($id) {
		$query = $this->db->select('id, account, times_per_year, amount, '.
					'unix_timestamp(adddate(last_due,365/times_per_year)) as next_due_u, unix_timestamp(last_due) as last_due_u', FALSE)
				->from('accounts')
				->where('id',$id);
		return $query->get()->row();
	}
	
	function update($id, $account, $last_due, $times_per_year, $amount) {
		$data = array(
			'account' => $account,
			'last_due' => md_unix_to_mysql($last_due),
			'times_per_year' => $times_per_year,
			'amount' => $amount
		);
		$this->db->where('id',$id);
		$this->db->update('accounts', $data);
	}
	
	function delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('accounts');
	}
	
	function insert($member_id, $account, $last_due, $times_per_year, $amount) {
		$data = array(
			'member_id' => $member_id,
			'account' => $account,
			'last_due' => md_unix_to_mysql($last_due),
			'times_per_year' => $times_per_year,
			'amount' => $amount
		);
		$this->db->insert('accounts', $data);
	}
	
	function pay($member_id, $account_id, $amount) {
		$query = $this->db->select('unix_timestamp(adddate(last_due,365/times_per_year)) as next_due_u, account', FALSE)
				->from('accounts')
				->where('id',$account_id);
		$row = $query->get()->row();

		$this->db->where('id',$account_id);
		$this->db->update('accounts', array('last_due' => md_unix_to_mysql($row->next_due_u)));
		
		// and record this payment
		$this->load->model('Payments_model');
		$this->Payments_model->insert($member_id, $row->account, $amount, now());
	}

	function get_accounts_due($member_id)
	{
		$this->load->model('Settings_model');
		$days = $this->Settings_model->email_reminder_days_get_by_member($member_id);
//		$this->db->order_by('adddate(last_due,365/times_per_year)','asc');
		$query = $this->db->select('account, unix_timestamp(last_due) as last_due_u, amount, unix_timestamp(adddate(last_due,365/times_per_year)) as next_due_u', FALSE)
				->from('accounts')
				->where('adddate(last_due,365/times_per_year) < adddate(now(),'.-$days.')')
				->where('member_id',$member_id)
				->where('autopay',FALSE);
		return $query->get()->result();
	}
}