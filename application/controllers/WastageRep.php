<?php

class WastageRep extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

	public function index()
	{
		$time = date("Y-m-d");
		$time1 = date("Y-m-d");
		$data['getAuditID'] = $this->ID->getAuditID();

		$data['wastageTable'] = $this->ID->wastageTable($time, $time1);
		$data['Assettype'] = $this->ID->getAssetTypes();
		$data['AssetChart'] = $this->ID->getAssetChart();
		$data['Kits'] = $this->ID->getKits();
		$data['atif_array'] = [];
		$data['haroon_array'] = [];
		foreach ($data['Kits'] as $key) {
			$result = substr($key['SerialNo'], 0, 10);
			if ($result == 'PAK-PS325S') {
				array_push($data['atif_array'], ["SerialNo" => $key['SerialNo'], "RecQty" => $key['RecQty'], "IssueQty" => $key['IssueQty'], "AvailableBalance" => $key['AvailableBalance'], "RecID" => $key['RecID']]);
			}
		}
		foreach ($data['Kits'] as $key) {
			$result1 = substr($key['SerialNo'], 0, 8);

			if ($result1 == 'PAK-AG18') {
				array_push($data['haroon_array'], ["SerialNo" => $key['SerialNo'], "RecQty" => $key['RecQty'], "IssueQty" => $key['IssueQty'], "AvailableBalance" => $key['AvailableBalance'], "RecID" => $key['RecID']]);
			}
		}
		// 		echo "<pre>";
		// 		print_r($data['atif_array']);
		// 		die;

		$data['labelinfor'] = $this->ID->getlabelinfo();


		$data['ID'] = $this->ID->getlabelinfo();

		$KitID = '';



		$data['ID'][1]['KitID'];



		$this->load->view('wastageRep', $data);
	}


	public function getAuditID()
	{
		$data['getAuditID'] = $this->ID->getAuditID();

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
    



	public function getWastageD()
	{
		$data = $this->ID->getWastageD($_POST['audit1'], $_POST['MontVal'], $_POST['YearVal']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
    

	public function getWastageD1()
	{
		$data = $this->ID->getWastageD1($_POST['audit1'], $_POST['MontVal'], $_POST['YearVal']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
    
	

	public function getWastageS()
	{
		$data = $this->ID->getWastageS($_POST['audit2'], $_POST['month'], $_POST['month'], $_POST['year'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function getWastageSByAudit()
	{
		$data = $this->ID->getWastageSByAudit($_POST['audit2'], $_POST['month'], $_POST['year'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function getWastageSByAuditM()
	{
		$data = $this->ID->getWastageSByAuditM($_POST['audit2'], $_POST['month'], $_POST['year'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}




	public function getWastageS1()
	{
		$data = $this->ID->getWastageS1($_POST['audit2'],  $_POST['month'], $_POST['year'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	
	public function getWastageS3()
	{
		$data = $this->ID->getWastageS3($_POST['audit2'],  $_POST['month'], $_POST['year'] );
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

    public function getWastageMonthWise()
	{
		$data = $this->ID->getWastageMonthWise($_POST['sdate'], $_POST['edate']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
    

    public function loadMonthWiseRollAndRibbon()
	{
		$data = $this->ID->loadMonthWiseRollAndRibbon($_POST['sdate'], $_POST['edate']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

    
    public function loadAuditWiseRollAndRibbon()
	{
		$data = $this->ID->loadAuditWiseRollAndRibbon($_POST['auditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}


    public function getWastageByAudit()
	{
		$data = $this->ID->getWastageByAudit($_POST['auditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}



}
