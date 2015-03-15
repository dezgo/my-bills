<?php
class Accounts_model extends CI_Model {
	
	function search($limit, $offset, $sort_by, $sort_order)
	{
		
		$sort_order = ($sort_order =='desc') ? 'desc' : 'asc';
		$sort_columns = array('account', 'last_due', 'times_per_year', 'next_due', 'amount');

		// if the sort_by column is in the columns array, return it, other return default value 'last_due'
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'last_due';
		
		// results query
		$query = $this->db->select('id, account, date_format(last_due,"%e&nbsp;%b&nbsp;%Y") as last_due_formatted, times_per_year, amount, '.
					'adddate(last_due,365/times_per_year) as next_due, date_format(adddate(last_due,365/times_per_year),"%e&nbsp;%b&nbsp;%Y") as next_due_formatted, last_due', FALSE)
				->from('accounts')
				->limit($limit, $offset)
				->order_by($sort_by, $sort_order);		
		$ret['rows'] = $query->get()->result();
		
		// count query
		$query = $this->db->select('COUNT(*) as count', FALSE)
				->from('accounts');
				
		$tmp = $query->get()->result();
		
		$ret['num_rows'] = $tmp[0]->count;
		
		return $ret;
	}
	
	function load($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('accounts');
		return $query->row();
	}
	
	function update($id, $data) {
		$this->db->where('id',$id);
		$this->db->update('accounts', $data);
	}
	
	function delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('accounts');
	}
}