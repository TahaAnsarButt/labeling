<?php

class KitIssuance1 extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

	public function index()
	{

		$this->load->view('KitIssue1');
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
	public function 	 getPO($date1, $date2)
	{
		$data['getPO'] = $this->ID->getpo($date1, $date2);
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
			$_POST['PO'],
			$_POST['pquantity'],
			$_POST['issuedate'],
			$_POST['PData'],
			$_POST['KitsiD']
		);

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function getkitsissuance($date1, $date2, $fc)
	{
		// print_r($_POST);
		// die;
		$data['getkitsissuance'] =  $this->ID->getkitsissuance($date1, $date2, $fc);
		$data['dates'] = $date1;
		$data['datee'] = $date2;
		// print_r($data['getkitsissuance']);
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

		$data = $this->ID->insertionAllKits($_POST['mbalance'], $_POST['kits'], $_POST['kitsName'], $_POST['printDate'], $_POST['pdate']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
}
