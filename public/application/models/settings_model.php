<?php

class Settings_model extends CI_Model {

	private function setting_exists($name) {
		$this->db->where('setting_name', $name);
		$this->db->where('member_id', $this->session->userdata('member_id'));
		$query = $this->db->get('settings');
		return $query->num_rows > 0;
	}
	
	function setting_get($name) {
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
	
	function setting_set($name, $value) {
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
}

