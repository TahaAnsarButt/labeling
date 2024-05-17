<?php

class kitsReceived extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

	public function index()
	{
		$data['Assettype'] = $this->ID->getAssetTypes();
		$data['AssetChart'] = $this->ID->getAssetChart();
		$data['labelinfor'] = $this->ID->getlabelinfo();


		$data['ID'] = $this->ID->getlabelinfo();

		$KitID = '';



		$data['ID'][1]['KitID'];



		$this->load->view('Assettype', $data, $KitID);
	}
	public function updateRecord($RIDValue, $RStatus, $IssueDte)
	{
		if ($RStatus == 'on') {
			$Status = 1;
		} else {
			$Status = 0;
		}
		$data = $this->ID->updateRecord($RIDValue, $Status, $IssueDte);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function getData($date1, $date2, $Type)
	{
		$data['received'] =  $this->ID->getData($date1, $date2, $Type);
		// print_r($data['received']);
		// die;
		$this->load->view('Data', $data);
	}
	public function insert_data($start_quantity, $end_quantity, $kitid, $labelid, $RDate)
	{

		$data = $this->ID->insert_data($start_quantity, $end_quantity, $kitid, $labelid, $RDate);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
	public function json_by_machine($Type)
	{

		$data = $this->ID->Kitinformation($Type);


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
	public function updateKits()
	{
		$RID = $this->input->post('RID');
		echo $RID;
		die;
	}
}
