<?php
class Home extends MY_Controller
{

	function index()
	{
		$data['main_content'] = 'home_view';
		$this->load->view('includes/template.php', $data);
	}

}