<?php

class Settings_model extends CI_Model {

	private function setting_exists($name) {
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $this->session->userdata('member_id'));
		$query = $this->db->get('settings');
		return $query->num_rows > 0;
	}
	
	private function setting_get($name) {
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $this->session->userdata('member_id'));
		$query = $this->db->get('settings');
		
		if ($query->num_rows() == 0)
			return '';
		else {
			$row = $query->row();
			return $row->setting_value;
		}
	}
	
	private function setting_set($name, $value) {
		if ($this->setting_exists($name)) {
			$this->db->where('setting_name', $name);
			$this->db->where('member_id', $this->session->userdata('member_id'));
			$this->db->update('settings', array('setting_value' => $value));
		}
		else {
			$data = array(
				'member_id' => $this->session->userdata('member_id'),
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
}

