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


		$data['Ledger'] = $this->ID->Ledger();

		// 		echo "<pre>";
		// print_r($data['Ledger']);
		// 		echo "</pre>";
				$this->load->view('Ledger', $data);

		
    }
			


}
