<?php

class PIR extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PIR_Model', 'PIR');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('PIR');
	}

	public function getAuditID()
	{
		$data = $this->PIR->getAuditID();

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
    

	public function getAll()
	{ 
		$data['PIR'] = $this->PIR->getAll($_POST['date1'], $_POST['date2']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function getAllcanceled()
	{ 
		$data = $this->PIR->getAllcanceled($_POST['date1'], $_POST['date2']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function cancel()
	{ 
		// print_r($_POST);
		// die;
		$data = $this->PIR->cancel($_POST['ReceiveDate'], $_POST['POCode'],  $_POST['AuditMonth'], $_POST['ReceivedBy'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function loadcancelpo()
	{ 
		$this->load->view('canceledPO');
	}
}
