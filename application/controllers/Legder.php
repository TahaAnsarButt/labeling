<?php

class Ledger extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

    public function index()
	{
 		$this->ID->getLedgerValue();
// print_r($data['Kits']);
// die;
        $this->load->view('Ledger',$data);

		
    }
			


}