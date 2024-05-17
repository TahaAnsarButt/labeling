<?php

class Westage extends CI_Controller
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



		$this->load->view('westage', $data);
	}

	public function loadWastageForm()
	{
		$this->load->view('wastageForm');
		// $data = $this->ID->insertWastage($_POST['kits'], $_POST['Westage'], $_POST['issuedate'], $_POST['westageCons']);
		// return $this->output
		// 	->set_content_type('application/json')
		// 	->set_status_header(200)
		// 	->set_output(json_encode($data));
	}
	public function loadWastageDate()
	{
		$data = $this->ID->loadWastage($_POST['sdate'], $_POST['edate']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function submitWastage()
	{
		$data = $this->ID->submitWastage($_POST['kits'], $_POST['Westage'], $_POST['issuedate'], $_POST['westageCons'], $_POST['auditMonth']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function insertWastage()
	{
		// print_r($_POST);
		// die;
		$data = $this->ID->insertWastage($_POST['kits'], $_POST['Westage'], $_POST['issuedate'], $_POST['westageCons'], $_POST['auditID']);
		// print_r($data);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function loadwastagemonth()
	{
		// print_r($_POST);
		// die;
		$data = $this->ID->loadwastagemonth($_POST['auditID']);
		// print_r($data);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function loadWastageMasterForm()
	{
		$data = $this->ID->loadWastageMasterForm();
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function AddWastageForm()
	{
		$data = $this->ID->AddWastageForm($_POST['AuditMonth'], $_POST['Description'], $_POST['Duration']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function getID()
	{
		$data = $this->ID->getID($_POST["TID"]);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function getAuditID()
	{
		$data = $this->ID->getAuditID();
		// print_r($data);
		// var_dump($data);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function deleteByID()
	{
		$data = $this->ID->deleteByID($_POST["TID"]);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function UpdateWastageForm()
	{
		$data = $this->ID->UpdateWastageForm($_POST['AuditMonth'], $_POST['Description'], $_POST['Duration'], $_POST['TID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function DeleteWastageForm($TID)
	{
		$data = $this->ID->UpdateWastageForm($_POST['AuditMonth'], $_POST['Description'], $_POST['Duration'], $_POST['TID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function loadWastage()
	{
		$data = $this->ID->loadWastage($_POST['sdate'], $_POST['edate']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function report()
	{
		$data['report'] = $this->ID->report();



		$data['total'] = 0;
		foreach ($data['report'] as $d) {
			$data['total'] = $data['total'] + $d['RecQty'];
		}


		$this->load->view('report', $data);
	}

	public function AddAssetType()
	{

		$type = $this->input->post('assetName');
		$status = $this->input->post('assetStatus');
		if ($status == "on") {
			$status = 1;
		} else {
			$status = 0;
		}
		$this->ID->AddAssetType($type, $status);
	}

	public function getAssetType()
	{
		$Id = $_POST['llid'];

		$data['tpyeValue'] = $this->ID->getAssetType($Id);
		$arr = $data['tpyeValue'];
		echo json_encode($arr);
	}

	public function getAssetTypes()
	{
		$data['tpyeValue'] = $this->ID->getAssetTypes();
		$arr = $data['tpyeValue'];
		echo json_encode($arr);
	}

	public function editAssetTypes()
	{

		/* 		$location = $this->input->post('locationName');
		$status = $this->input->post('status'); */
		$Id =  $this->input->post('tid');
		$type = $this->input->post('assetName');
		$status = $this->input->post('assetStatus');
		if ($status == "on") {
			$status = 1;
		} else {
			$status = 0;
		}
		$this->ID->editAssetType($Id, $type, $status);
	}

	public function deleteAssetType()
	{
		$Id = $_POST['llid'];
		$this->ID->deleteAssetType($Id);
	}

	public function AddAssetChart()
	{

		$prodType = $this->input->post('assetProdType');
		$chartType = $this->input->post('assetChartType');
		$name = $this->input->post('assetNameChart');

		$code = $prodType + $chartType + rand();

		$uom = $this->input->post('UOM');

		$status = $this->input->post('assetChartStatus');
		if ($status == "on") {
			$status = 1;
		} else {
			$status = 0;
		}

		$this->ID->AddAssetChart($prodType, $chartType, $name, $code, $uom, $status);
	}

	public function getChartValue()
	{
		$Id = $_POST['llid'];

		$data['assetChart'] = $this->ID->getChartValue($Id);
		$arr = $data['assetChart'];
		echo json_encode($arr);
	}

	public function editAssetCharts()
	{

		/* 		$location = $this->input->post('locationName');
		$status = $this->input->post('status'); */
		$Id =  $this->input->post('cid');
		$prodType = $this->input->post('assetProdType');
		$chartType = $this->input->post('assetChartType');
		$name = $this->input->post('assetNameChart');
		$code = $this->input->post('assetCode');
		$uom = $this->input->post('UOM');

		$status = $this->input->post('assetChartStatus');
		if ($status == "on") {
			$status = 1;
		} else {
			$status = 0;
		}
		$this->ID->editAssetChart($Id, $prodType, $chartType, $name, $code, $uom, $status);
	}


	public function deleteAssetChart()
	{
		$Id = $_POST['llid'];
		$this->ID->deleteAssetChart($Id);
	}
	public function 	 getPO($date1, $date2)
	{

		$data['getPO'] = $this->ID->getpo($date1, $date2);
		$this->load->view('PO_Date', $data);
	}
	public function json_by_machine($PO)
	{

		$data = $this->ID->POQty($PO);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function json_by_machine_balance($Kits)
	{

		$data = $this->ID->getKitbalance($Kits);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function Label_Reprinting()
	{
		// $data['reprinted'] = $this->ID->Reprinting();
		// echo "<pre>";
		// print_r($data['reprinted']);
		// echo "</pre>";
		$this->load->view('Label_Reprinting');
	}


	public function loadWastageAudit1()
	{
		$data = $this->ID->loadWastageAudit1($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function AssignAuditM()
	{
		// $data['reprinted'] = $this->ID->Reprinting();
		// echo "<pre>";
		// print_r($data['reprinted']);
		// echo "</pre>";
		$this->load->view('assignAuditM');
	}


	public function loadWastageAudit()
	{
		$data = $this->ID->loadWastageAudit($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function loadWastageAuditRollAndRibbon()
	{
		$data = $this->ID->loadWastageAuditRollAndRibbon($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function loadWastageAuditD()
	{
		$data = $this->ID->loadWastageAuditD($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}



	public function TotalWestKits()
	{
		$data = $this->ID->TotalWestKits($_POST['AuditID']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function insert_data($KitsiD, $issuedate, $westage, $westageDesc)
	{



		$data = $this->ID->Kits_issuance_insert_dataW($KitsiD, $issuedate, $westage, str_replace("%20", " ", $westageDesc));
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function getkitsissuance($date1, $date2)
	{
		$data['getkitsissuance'] =  $this->ID->getkitsissuancew($date1, $date2);
		// print_r($data['received']);
		// die;
		$this->load->view('getkitsissuance', $data);
	}
	public function updateRecord($Receivedby, $iDate, $RID)
	{
		$RBy = str_replace("%20", " ", $Receivedby);
		//$this->ID->updateKitsissuance($RBy,$iDate ,$RID);

		$data = $this->ID->updateKitsissuance($RBy, $iDate, $RID);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function Delete($TID)
	{

		$data = $this->ID->Deleteissuance($TID);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function Reprinting()
	{
		$data['reprinted'] = $this->ID->Reprinting();
		// echo "<pre>";
		// print_r($data['reprinted']);
		// echo "</pre>";
		$this->load->view('reprinting', $data);
	}
}
