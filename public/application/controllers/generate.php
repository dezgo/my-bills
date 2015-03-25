<?php

class Generate extends MY_Controller
{

    function index()
    {
        //parent::__construct();
        $this->load->helper('url');
        $this->load->helper('csv');
        $this->create_csv();
    }

        function create_csv(){

            $fields = $this->db->list_fields('payments');
            $fname = '';
            foreach ($fields as $field)
            {
            	if ($fname != '') $fname .= ',';
            	$fname .= $field;
            }
			
            $this->db->select($fname);
            $quer = $this->db->get('payments');
            
            query_to_csv($quer,TRUE,'payments_'.date('dMy').'.csv');
            //echo query_to_csv($quer,TRUE);
            
        }
}
