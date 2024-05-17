<?php

class Westage1 extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS1', 'ID');
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



		$this->load->view('westage1', $data);
	}

	public function json_by_machine_balance($Kits)
	{

		$data = $this->ID->getKitbalance($Kits);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

    public function getAuditID()
	{
        $AUDIT_ID = $_POST['AUDIT_ID'];

		$data = $this->ID->getAuditID1($AUDIT_ID);
		// print_r($data);
		// var_dump($data);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

    public function insertWastage()
	{
		// print_r($_POST);
		// die;
		$data = $this->ID->insertWastage($_POST['kits'], $_POST['Bal'], $_POST['Westage'], $_POST['issuedate'], $_POST['westageCons'], $_POST['auditID']);
		// print_r($data);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

    public function loadWastageAudit()
	{
		$data = $this->ID->loadWastageAudit($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

}