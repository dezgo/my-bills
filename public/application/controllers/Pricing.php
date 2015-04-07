<?php
class Pricing extends MY_Controller 
{
	function index()
	{
		$data['main_content'] = 'pricing_form';
		$this->load->view('includes/template', $data);
	}
}
?>
