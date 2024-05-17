<?php

class Kitsissuance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

	public function index()
	{
		// $data['IssueBalance'] = $this->ID->IssueBalance();
		$data['Assettype'] = $this->ID->getAssetTypes();
		$data['AssetChart'] = $this->ID->getAssetChart();
		$data['Kits'] = $this->ID->getKits();
		// print_r($data['Kits']);
		// die;
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
		// echo "<pre>";
		// print_r($data['haroon_array']);
		// die;

		// echo "<pre>";
		// print_r($data['atif_array']);
		// die;



		$this->load->view('kits_issuance', $data);
	}
	public function report()
	{
		// $Month = date('m');
		// $Year = date('Y');
		// $Day = date('d');
		// $CurrentDate = $Day . '/' . $Month . '/' . $Year;


		//$data['report'] = $this->ID->report();



		// $data['total'] = 0;
		// foreach ($data['report'] as $d) {
		// 	$data['total'] = $data['total'] + $d['RecQty'];
		// }


		$this->load->view('report');
	}


	public function getresult()
	{
		// Echo "I am here";
		// die;
		$data = $this->ID->getresult($_POST['date1'], $_POST['date2']);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function LabelFilter()
	{
		// Echo "I am here";
		// die;
		
		$data = $this->ID->LabelFilter($_POST['sdate'], $_POST['edate']);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function issuanceStock1()
	{
		$this->load->view('issuanceStock');
	}

	public function issuanceStock()
	{
		$data['IssueBalance'] = $this->ID->IssueBalance();
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
		// print_r($data);



		// $this->load->view('issuanceStock', $data);
	}

	
	public function issuanceStockData()
	{
		$data['getKitsData'] = $this->ID->getKitsData();
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
		// print_r($data);



		// $this->load->view('issuanceStock', $data);
	}


	public function reportFilter()
	{
		// Echo "I am here";
		// die;
		$data['report'] = $this->ID->reportFilter($_POST['sdate'], $_POST['edate']);

		$data['total'] = 0;
		foreach ($data['report'] as $d) {
			$data['total'] = $data['total'] + $d['RecQty'];
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
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
	public function getPO($date1, $date2, $fc)
	{
		$data['getPO'] = $this->ID->getpo($date1, $date2, $fc);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
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
	public function insert_data()
	{


		$data = $this->ID->Kits_issuance_insert_data(
			// $_POST['PO'], 
			$_POST['PlanDate'],
			$_POST['KitsiD'],
			$_POST['pquantity'],
			$_POST['issuedate']
		);

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	
	public function getkitsissuance1($date1, $date2)
	{
		$data['getkitsissuance'] =  $this->ID->getkitsissuance1($date1, $date2);
		$data['dates'] = $date1;
		$data['datee'] = $date2;
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
		// print_r($data['getkitsissuance']);
		// die;
		// $this->load->view('getkitsissuance', $data);
	}


	public function getkitsissuance($date1, $date2, $fc)
	{
		$data['getkitsissuance'] =  $this->ID->getkitsissuance($date1, $date2, $fc);
		$data['dates'] = $date1;
		$data['datee'] = $date2;
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
		// print_r($data['getkitsissuance']);
		// die;
		// $this->load->view('getkitsissuance', $data);
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

	public function kitIssue()
	{
		$this->load->view('kitIssue');
	}

	public function issuedAll()
	{
		// print_r($_POST);
		// die;
		$data = $this->ID->issuedAll($_POST['datee'], $_POST['Received'], $_POST['kits']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function insertionAllKits()
	{
		// print_r($_POST);die;
		$data = $this->ID->insertionAllKits($_POST['mbalance'], $_POST['kits'], $_POST['kitsName'], $_POST['printDate'], $_POST['pdate'], $_POST['PlanType']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
}
