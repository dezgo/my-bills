<?php

class Settings_model extends CI_Model {

	private function setting_exists($name) {
		// pre-condition - member_id session variable set
		assert($_SESSION['member_id'] != '', 'Check member_id session variable not empty') or die();
				
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $_SESSION['member_id']);
		$query = $this->db->get('settings');
		return $query->num_rows() > 0;
	}
	
	private function setting_get_by_member($name, $member_id) {
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $member_id);
		$query = $this->db->get('settings');
		
		if ($query->num_rows() == 0)
			return '';
		else {
			$row = $query->row();
			return $row->setting_value;
		}
	}

	private function setting_get($name) {
		// pre-condition - member_id session variable set
		assert($_SESSION['member_id'] != '', 'Check member_id session variable not empty') or die();

		return $this->setting_get_by_member($name, $_SESSION['member_id']);
	}
	
	private function setting_set($name, $value) {
		// pre-condition - member_id session variable set
		assert($_SESSION['member_id'] != '', 'Check member_id session variable not empty') or die();
				
		if ($this->setting_exists($name)) {
			$this->db->where('setting_name', $name);
			$this->db->where('member_id', $_SESSION['member_id']);
			$this->db->update('settings', array('setting_value' => $value));
		}
		else {
			$data = array(
				'member_id' => $_SESSION['member_id'],
				'setting_name' => $name,
				'setting_value' => $value
			);

			$this->db->insert('settings', $data);
		}
	}
	
	function date_format_set($value) {
		$this->setting_set('date_format', $value);
	}
	function date_format_get() {
		return $this->setting_get('date_format');
	}
	function date_format_get_by_member($member_id) {
		return $this->setting_get_by_member('date_format',$member_id);
	}
	
	function email_reminder_days_set($value) {
		$this->setting_set('email_reminder_days', $value);
	}
	function email_reminder_days_get() {
		return $this->setting_get('email_reminder_days');
	}
	function email_reminder_days_get_by_member($member_id) {
		return $this->setting_get_by_member('email_reminder_days',$member_id);
	}
	
	function items_per_page_set($value) {
		$this->setting_set('items_per_page', $value);
	}
	function items_per_page_get() {
		return $this->setting_get('items_per_page');
	}
	
	function timezone_getCode($value) {
		$this->db->select('timezone');
		$this->db->from('timezones');
		$this->db->where('offset',(float) $value);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->timezone;
		}
		else
		{
			return 'UTC';
		}
	}
	function timezone_set($value) {
		$this->setting_set('timezone', $value);
		$_SESSION['timezone'] = $value;
	}
	function timezone_get() {
		return $this->setting_get('timezone');
	}
	function dst_set($value) {
		$this->setting_set('dst', $value);
		$_SESSION['dst'] = $value;
	}
	function dst_get() {
		return $this->setting_get('dst');
	}
		
	
}
