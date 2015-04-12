<?php

class Settings_model extends CI_Model {

	private function setting_exists($member_id, $name) {
		// pre-condition - member_id session variable set
		assert($member_id != '', 'Check member_id session variable not empty') or die();
				
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $member_id);
		$query = $this->db->get('settings');
		return $query->num_rows() > 0;
	}
	
	private function setting_get($member_id, $name) {
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

	private function setting_set($member_id, $name, $value) {
		// pre-condition - member_id session variable set
		assert($member_id != '', 'Check member_id session variable not empty') or die();
				
		if ($this->setting_exists($member_id, $name)) {
			$this->db->where('setting_name', $name);
			$this->db->where('member_id', $member_id);
			$this->db->update('settings', array('setting_value' => $value));
		}
		else {
			$data = array(
				'member_id' => $member_id,
				'setting_name' => $name,
				'setting_value' => $value
			);

			$this->db->insert('settings', $data);
		}
	}
	
	function date_format_set($member_id, $value) {
		// if date format isn't valid, go with a defaut format
		if (!$this->date_format_check($value)) $value = 'd.mm.yy';
		
		$this->setting_set($member_id, 'date_format', $value);
		$_SESSION['date_format'] = $value;
		$_SESSION['date_format_php'] = $this->date_format_to_PHP($value);
	}
	function date_format_get($member_id) {
		$value = $this->setting_get($member_id, 'date_format');
		$_SESSION['date_format'] = $value;
		$_SESSION['date_format_php'] = $this->date_format_to_PHP($value);
		return $value;
	}
	function date_format_get_php($member_id) {
		$value = $this->setting_get($member_id, 'date_format');
		$value_php = $this->date_format_to_PHP($value);
		$_SESSION['date_format'] = $value;
		$_SESSION['date_format_php'] = $value_php;
		return $value_php;
	}
	private function date_format_convert($date_format)
	{
		// expecting everything lowercase
		$date_format = strtolower($date_format);
		
		// convert to intermediary format, should now be all uppercase
		$date_format_new = str_replace('dd', '2D', $date_format);
		if ($date_format == $date_format_new) $date_format_new = str_replace('d', '1D', $date_format); else $date_format_new = $date_format_new;
		$date_format_new = str_replace('mm', '2M', $date_format_new);
		$date_format_new = str_replace('m', '1M', $date_format_new);
		$date_format_new = str_replace('yyyy', 'yy', $date_format_new); // just in case they use yyyy, change to yy
		$date_format_new = str_replace('yy', '2Y', $date_format_new);
		$date_format_new = str_replace('y', '1Y', $date_format_new);
		
		return $date_format_new;
	}
	private function date_format_to_PHP($date_format)
	{
		$php_date_format = $this->date_format_convert($date_format);
		$php_date_format = str_replace('1D', 'j', $php_date_format);
		$php_date_format = str_replace('2D', 'd', $php_date_format);
		$php_date_format = str_replace('1M', 'n', $php_date_format);
		$php_date_format = str_replace('2M', 'm', $php_date_format);
		$php_date_format = str_replace('1Y', 'y', $php_date_format);
		$php_date_format = str_replace('2Y', 'Y', $php_date_format);
		
		return $php_date_format;
	}
	// check if date format string is valid
	// looks for d,m,y and separators dot, dash, slash, or space
	// no month at end or year in middle
	function date_format_check($date_format)
	{
		return preg_match("/^(d|m|y){1,2}(\.| |-|\/)(d|m){1,2}(\.| |-|\/)(d|y){1,2}$/", strtolower($date_format)) > 0;
	}
	
	function email_reminder_days_set($member_id, $value) {
		$this->setting_set($member_id, 'email_reminder_days', $value);
	}
	function email_reminder_days_get($member_id) {
		return $this->setting_get($member_id, 'email_reminder_days');
	}
	
	function items_per_page_set($member_id, $value) {
		$this->setting_set($member_id, 'items_per_page', $value);
	}
	function items_per_page_get($member_id) {
		return $this->setting_get($member_id, 'items_per_page');
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
	function timezone_set($member_id, $value) {
		$this->setting_set($member_id, 'timezone', $value);
		$_SESSION['timezone'] = $value;
	}
	function timezone_get($member_id) {
		return $this->setting_get($member_id, 'timezone');
	}
	function dst_set($member_id, $value) {
		$this->setting_set($member_id, 'dst', $value);
		$_SESSION['dst'] = $value;
	}
	function dst_get($member_id) {
		return $this->setting_get($member_id, 'dst');
	}
		
	
}

