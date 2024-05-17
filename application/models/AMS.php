<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AMS extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function Balance()
	{

		$user_id =  $this->session->userdata('user_id');

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        SUM(KitQty) AS Expr1, SUM(IssueQty) AS Expr2, SUM(KitQty - IssueQty) AS Balance
        FROM            dbo.view_All_Kits_Data");
		// print_r($query);
		$data =  $query->result_array();
		// print_r($data);

		return $data;
	}

	// public function IssueBalance()
	// {
	//     $user_data = $this->session->userdata();
	//     // $time = strtotime($date);
	//     // $time1 = strtotime($date1);
	//     // $newformat = date('Y-m-d', $time);
	//     // $newformat1 = date('Y-m-d', $time1);
	//     $user_id = $user_data['user_id'];
	//     $MIS = $this->load->database('MIS', TRUE);
	//     $query = $MIS->query("SELECT        POCode, SerialNo, KitQty, IssuanceDate, IDate, PDate, OrderQty, Type, Issuedby, Receivedby, IssueDate, IssueQty, Wastage, RecQty, AvailableBalance, user_id, Days, KeyNum
	//     FROM            dbo.view_All_Kits_Data
	//     WHERE        (KitQty <> IssueQty)");
	//     return $query->result_array();
	// }



	public function IssueBalance()
	{
		$user_data = $this->session->userdata();
		// $time = strtotime($date);
		// $time1 = strtotime($date1);
		// $newformat = date('Y-m-d', $time);
		// $newformat1 = date('Y-m-d', $time1);
		$user_id = $user_data['user_id'];
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT * FROM View_PrintedStockk");
		return $query->result_array();
	}

	public function getKitsData()
	{
		$user_data = $this->session->userdata();
		// $time = strtotime($date);
		// $time1 = strtotime($date1);
		// $newformat = date('Y-m-d', $time);
		// $newformat1 = date('Y-m-d', $time1);
		$user_id = $user_data['user_id'];
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TOP (100) PERCENT dbo.tbl_kit_issuance.TID, dbo.tbl_kit_issuance.PO, dbo.tbl_kit_issuance.KitID, dbo.tbl_kit_issuance.PrintQty, CONVERT(varchar, dbo.tbl_kit_issuance.PrintDate, 103) AS [issued Date], 
        dbo.View_Label.SerialNo, dbo.View_Label_PO_1.POCode, dbo.View_Label_PO_1.OrderQty, dbo.tbl_kit_issuance.Issuedby, dbo.tbl_kit_issuance.Receivedby, CONVERT(Varchar, dbo.tbl_kit_issuance.IssueDate, 103) 
        AS IssueDate, dbo.tbl_kit_issuance.PrintDate, dbo.tbl_kit_issuance.PlanDate, dbo.View_Label_PO_1.FactoryCode, dbo.tbl_kit_issuance.Type
FROM            dbo.View_Label INNER JOIN
        dbo.tbl_kit_issuance ON dbo.View_Label.RecID = dbo.tbl_kit_issuance.KitID INNER JOIN
        dbo.View_Label_PO_1 ON dbo.tbl_kit_issuance.PO = dbo.View_Label_PO_1.PO
WHERE        (dbo.tbl_kit_issuance.Receivedby IS NULL) AND (CONVERT(Varchar, dbo.tbl_kit_issuance.IssueDate, 103) IS NULL)
ORDER BY dbo.tbl_kit_issuance.TID DESC");
		return $query->result_array();
	}

	public function loginn($username, $password)
	{

		$query = $this->db->query("SELECT        LoginName, passwd, UserSataus, UserID
      FROM            tbl_MIS_User
      WHERE        (LoginName = '$username') AND (passwd = '$password') ");

		if ($query->num_rows() > 0) {
			$result = $query->row();
			$session_data = array(
				'user_id' => $result->UserID,
				'user_name' => $result->LoginName,
				'userStus' => 1,
				'Status' => $result->UserSataus,

			);
			$Status = $result->UserSataus;

			//echo $Status;
			// Die;

			if ($Status == 0) {
				$this->session->set_flashdata('info', 'Your Account Has Been Disable');
				redirect('Login/page_dashboard');
			} else {
				if ($password == '123') {
					$this->session->set_flashdata('info', 'Please Change Your Password First');
				} else {
					$this->session->set_flashdata('info', 'Welcome in LSM');
				}

				$this->session->set_userdata($session_data);
			}
		} else {
			//echo "Hello";
			//Die;

			$this->session->set_flashdata('info', 'Your User Name OR Password is In Correct ');
			redirect('');
		}
	}
	public function report()
	{
		$user_data = $this->session->userdata();
		// $time = strtotime($date);
		// $time1 = strtotime($date1);
		// $newformat = date('d/m/Y', $time);
		// $newformat1 = date('d/m/Y', $time1);
		$user_id = $user_data['user_id'];
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT   POCode, SerialNo, KitQty,IDate,PDate, IssuanceDate, OrderQty, Type, Issuedby, Receivedby, IssueDate, IssueQty, Wastage, RecQty, AvailableBalance, user_id
       FROM  dbo.view_All_Kits_Data WHERE  user_id=$user_id
       "
		);
		return $query->result_array();
	}

	public function reportFilter($date, $date1)
	{
		$user_data = $this->session->userdata();
		$time = strtotime($date);
		$time1 = strtotime($date1);
		$newformat = date('Y-m-d', $time);
		$newformat1 = date('Y-m-d', $time1);
		$user_id = $user_data['user_id'];
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT  POCode, SerialNo, KitQty, IssuanceDate,IDate,PDate,
             OrderQty, Type, Issuedby, Receivedby, IssueDate, IssueQty, Wastage, RecQty, 
             AvailableBalance, user_id
FROM  dbo.view_All_Kits_Data WHERE
        (IssueDate BETWEEN CONVERT(DATETIME, '$newformat 00:00:00', 102) 
AND CONVERT(DATETIME, '$newformat1 00:00:00', 102))"

		);

		return $query->result_array();
	}
	public function getProjectValues()
	{

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT        dbo.view_Project_head.*
        FROM            dbo.view_Project_head');
		return $query->result_array();
	}

	public function getProjectValue($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT  dbo.view_Project_head.*
        FROM            dbo.view_Project_head
        WHERE ProjectHID='$proId'"
		);
		return $query->result_array();
	}

	public function getLedgerValue($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT *
       FROM            dbo.view_Kits_Balance_Ledger"
		);
		return $query->result_array();
	}


	public function CallDept()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT        CustName, LocalCustID
        FROM            dbo.tbl_Inv_LocalCust');
		return $query->result_array();
	}

	public function CallMid()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT   dbo.view_Project_middel.*
        FROM     dbo.view_Project_middel');
		return $query->result_array();
	}

	public function addProject($prName, $prStrtDte, $prEndDte, $prDptNme,  $prStatus,  $prEntryDate, $prNarration, $user)
	{

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO dbo.tbl_Project_H
        (ProjectName
        ,StartDate
        ,CompDate
        ,DeptID
        ,CompStatus
        ,EntryDate
        ,Narration
        ,UserID)
  VALUES
        ('$prName',
        '$prStrtDte',
        '$prEndDte',
        '$prDptNme',
        '$prStatus',
        '$prEntryDate',
        '$prNarration',
        '$user')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Project has been added.');

			redirect('Project');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating project.');
			redirect('Project');
		}
	}

	public function editProject($prName, $prStrtDte, $prEndDte, $prDptNme,  $prStatus,  $proId, $prNarration, $user)
	{

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("UPDATE tbl_Project_H 
        SET  ProjectName  =  '$prName' , StartDate  =  '$prStrtDte'  , CompDate  =  '$prEndDte'
           , DeptID  =  '$prDptNme'  , CompStatus  =  '$prStatus' , Narration  =  '$prNarration' WHERE   ProjectHID  =  '$proId' ");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Project has been Updated. ');
			redirect('Project');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating project.');
			redirect('Project');
		}
	}


	public function deleteProject($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("DELETE FROM tbl_Project_H
        WHERE ProjectHID='$proId'");
		if ($query) {
			$this->session->set_flashdata('ProDelinfo', 'Project has been added. ');
			redirect('Project');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating project.');
			redirect('Project');
		}
	}

	public function AddDepartment($depProName, $depName, $ProCurDate, $user)
	{
		$MIS = $this->load->database('MIS', TRUE);

		$query = $MIS->query("INSERT INTO  dbo.tbl_Project_M 
        (
            DeptID 
        , EntryDate 
        , UserID 
        , ProjectHID )
  VALUES
        (
        '$depName',
        '$ProCurDate',
        $user,
        '$depProName')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department has been added. ');
			redirect('Department');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Department.');
			redirect('Department');
		}
	}

	public function deleteDepartment($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("DELETE FROM  dbo . tbl_Project_M 
        WHERE ProjectID='$proId'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Project has been added. ');
			redirect('Department');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating project.');
			redirect('Department');
		}
	}

	public function getMidValue($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT  dbo.view_Project_middel.*
        FROM            dbo.view_Project_middel
        WHERE ProjectID='$proId'"
		);
		return $query->result_array();
	}

	public function editDep($depProName, $depName, $user, $Proid)
	{

		$MIS = $this->load->database('MIS', TRUE);

		$query = $MIS->query("UPDATE  dbo . tbl_Project_M 
   SET  ProjectHID  =  '$depProName'
      , DeptID  =  '$depName' 
      , UserID  =  '$user'
     WHERE   ProjectID  =  '$Proid' ");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department has been Updated. ');
			redirect('Department');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating project.');
			redirect('Department');
		}
	}

	function CallProject()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT        ProjectHID, ProjectName
        FROM            dbo.tbl_Project_H');
		return $query->result_array();
	}


	function getDependentValue($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT dbo.tbl_Project_M.ProjectHID, dbo.tbl_Inv_LocalCust.CustName, dbo.tbl_Inv_LocalCust.LocalCustID
        FROM            dbo.tbl_Project_M INNER JOIN
                                 dbo.tbl_Inv_LocalCust ON dbo.tbl_Project_M.DeptID = dbo.tbl_Inv_LocalCust.LocalCustID
        WHERE        (dbo.tbl_Project_M.ProjectHID = '$proId')"
		);
		return $query->result_array();
	}

	public function CallMat()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT L4Name, Code
        FROM    dbo.tbl_Inv_L4');
		return $query->result_array();
	}

	public function CallUom()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT        UOM
        FROM            dbo.tbl_Pur_UnitofMeasurementDtl
        GROUP BY UOM');
		return $query->result_array();
	}

	public function AddMaterial($matProName, $matDepName, $matName, $matQty, $matUom, $matNar, $user, $ProCurDate)
	{

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO  dbo . tbl_Project_D 
        ( ProjectHID 
           , DeptID  
           , Code 
           , Qty 
           , UOM 
           , Narration 
           , UserID 
           , EntryDate )
  VALUES
        ( '$matProName' , '$matDepName'   , '$matName'     , '$matQty'    , '$matUom'  , '$matNar'     , '$user'  ,  '$ProCurDate' )");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Material has been added. ');
			redirect('Material');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Material.');
			redirect('Material');
		}
	}


	function CallMatData()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT  dbo.View_Project_Material.*
            FROM            dbo.View_Project_Material');
		return $query->result_array();
	}


	public function deleteMaterial($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("DELETE FROM  dbo . tbl_Project_D 
        WHERE  ProjectDID='$proId'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Material has been Deleted. ');
			redirect('Material');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Material.');
			redirect('Material');
		}
	}


	public function getMaterialValue($proId)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			"SELECT  dbo.View_Project_Material.*
            FROM            dbo.View_Project_Material
            WHERE ProjectDID='$proId'"
		);
		return $query->result_array();
	}


	public function editMaterial($matDid, $matPName, $matDName, $matName, $matQtyy, $matUomm, $matNarrat, $user)
	{


		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("UPDATE  dbo . tbl_Project_D 
            SET  ProjectHID  =  '$matPName'  
               , DeptID  =  ' $matDName' 
               , Code  =  '$matName'  
               , Qty  =  '$matQtyy'  
               , UOM  =  '$matUomm'  
               , Narration  =  '$matNarrat'  
               , UserID  =  '$user'  
               
          WHERE ProjectDID='$matDid'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Material has been Updated. ');
			redirect('Material');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Material.');
			redirect('Material');
		}
	}


	/////////////////////////////////////// Asset Type ///////////////////////////////////////////////////////////////

	public function AddAssetType($type, $status)
	{


		$query = $this->db->query("INSERT INTO dbo.tbl_Asserts_Type
                        (AssertType,status )
                          VALUES
                        ('$type', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Asset Type has been added. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Asset Type.');
			redirect('assettype');
		}
	}



	public function getAssetTypes()
	{
		$query = $this->db->query('  SELECT *
               FROM tbl_Asserts_Type ');
		return $query->result_array();
	}


	public function deleteAssetType($Id)
	{

		$query = $this->db->query("DELETE FROM  tbl_Asserts_Type
          WHERE  TID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Asset Type has been Deleted. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Asset Type.');
			redirect('assettype');
		}
	}

	public function getAssetType($Id)
	{
		$query = $this->db->query(
			"SELECT   *
            FROM            tbl_Asserts_Type
            WHERE  TID = '$Id'"
		);
		return $query->result_array();
	}

	public function editAssetType($id, $type, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_Asserts_Type 
            SET  AssertType  =  '$type', 
            status  =  '$status' 
          WHERE  TID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Asset Type has been Updated. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Asset Type.');
			redirect('assettype');
		}
	}


	///////////////////////////////////////// Asset Location ///////////////////////////////////////////////////////////////


	public function AddAssetLocation($location, $status)
	{

		$query = $this->db->query("INSERT INTO dbo.tbl_Building
          (BuildingName ,Status) VALUES('$location','$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Asset Location has been added. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Asset Location.');
			redirect('assetlocation');
		}
	}

	public function EditBuilding($id, $location, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_Building 
            SET  BuildingName  =  '$location', 
                Status  =  '$status' 
          WHERE  BID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Building has been Updated. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Building.');
			redirect('assetlocation');
		}
	}

	public function getAssetBuildings()
	{
		$query = $this->db->query('  SELECT        BID, BuildingName, Status
            FROM tbl_Building ');
		return $query->result_array();
	}

	public function deleteLocation($proId)
	{

		$query = $this->db->query("DELETE FROM  dbo.tbl_Building
         WHERE  BID='$proId'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Building has been Deleted. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Building.');
			redirect('assetlocation');
		}
	}

	public function getBuildValue($proId)
	{
		$query = $this->db->query(
			"SELECT        BID, BuildingName, Status
             FROM            tbl_Building
             WHERE  BID = '$proId'"
		);
		return $query->result_array();
	}

	//////////////////////////////// Chart of Assets /////////////////////////////////////////////////////

	public function AddAssetChart($prodType, $chartType, $name, $code, $uom, $status)
	{


		$query = $this->db->query("INSERT INTO tbl_Assets_Catagory
    (   PrdType ,
        AssetType ,
        Name ,
        Code,
        UOM ,
        Status )
      VALUES
    ('$prodType','$chartType','$name','$code','$uom', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Chart of Asset has been added. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Chart of Asset.');
			redirect('assettype');
		}
	}

	public function editAssetChart($id, $prodType, $chartType, $name, $code, $uom, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_Assets_Catagory 
    SET   PrdType  =  '$prodType',
        AssetType  =  '$chartType' ,
        Name  =  '$name' ,
        Code  =    '$code',
        UOM  =  '$uom'  ,
        Status  =  '$status' 
  WHERE  ID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Chart of Asset has been Updated. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Chart of Asset.');
			redirect('assettype');
		}
	}


	public function getAssetChart()
	{
		$query = $this->db->query('  SELECT *
    FROM view_chart_Of_Asset');
		return $query->result_array();
	}


	public function deleteAssetChart($Id)
	{

		$query = $this->db->query("DELETE FROM  dbo.tbl_Assets_Catagory
        WHERE  ID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Chart of Asset has been Deleted. ');
			redirect('assettype');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Chart of Asset.');
			redirect('assettype');
		}
	}

	public function getChartValue($Id)
	{
		$query = $this->db->query(
			"SELECT  *
    FROM            tbl_Assets_Catagory
    WHERE  ID = '$Id'"
		);
		return $query->result_array();
	}


	/////////////////////////////////////////////// Assets Location Departments ///////////////////////////////////////

	public function getDepartmentsLocation()
	{
		$query = $this->db->query('  SELECT *
    FROM tbl_HRM_Dept');
		return $query->result_array();
	}


	public function AddAssetDepartment($deptBuild, $deptName, $status)
	{

		$query = $this->db->query("INSERT INTO tbl_HRM_Dept
      (  BID ,
      DeptName ,
      Status )
         VALUES
            ('$deptBuild','$deptName', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department of Asset has been added. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Department of Asset.');
			redirect('assetlocation');
		}
	}


	public function getDepartmentValue($Id)
	{
		$query = $this->db->query(
			"SELECT  *
            FROM            tbl_HRM_Dept
            WHERE  DeptID = '$Id'"
		);
		return $query->result_array();
	}

	public function EditDepartment($id, $deptBuild, $deptName, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_HRM_Dept 
            SET   BID  =  '$deptBuild',
            DeptName  =  '$deptName' ,
            Status  =  '$status' 
          WHERE  DeptID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department of Asset has been Updated. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Chart of Department.');
			redirect('assetlocation');
		}
	}





	/////////////////////////////////////////////// Assets Location Sections /////////////////////////////////////////////////////////

	public function getSectionsLocation()
	{
		$query = $this->db->query('  SELECT *
    FROM tbl_HRM_Dept');
		return $query->result_array();
	}

	public function getAssetSectionsLocation()
	{
		$query = $this->db->query("  SELECT *
        FROM tbl_HRM_Section
        ");
		return $query->result_array();
	}

	public function getAssetSectionsLocation1($ID)
	{
		$query = $this->db->query("  SELECT *
        FROM tbl_HRM_Section
        WHERE DeptID = '$ID'
        ");
		return $query->result_array();
	}
	public function AddAssetSection($deptBuild, $deptName, $status)
	{

		$query = $this->db->query("INSERT INTO tbl_HRM_Dept
      (  BID ,
      DeptName ,
      Status )
         VALUES
            ('$deptBuild','$deptName', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department of Asset has been added. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Department of Asset.');
			redirect('assetlocation');
		}
	}


	public function getSectionValue($Id)
	{
		$query = $this->db->query(
			"SELECT  *
            FROM            tbl_HRM_Dept
            WHERE  DeptID = '$Id'"
		);
		return $query->result_array();
	}

	public function EditSection($id, $deptBuild, $deptName, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_HRM_Dept 
            SET   BID  =  '$deptBuild',
            DeptName  =  '$deptName' ,
            Status  =  '$status' 
          WHERE  DeptID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Department of Asset has been Updated. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Chart of Department.');
			redirect('assetlocation');
		}
	}

	public function deleteSection($Id)
	{

		$query = $this->db->query("DELETE FROM  tbl_HRM_Dept 
            WHERE  DeptID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Department has been Deleted. ');
			redirect('assetlocation');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Department.');
			redirect('assetlocation');
		}
	}

	////////////////////////////////////////////////////////// Depreciation Method ///////////////////////////////////////////////////

	public function getDepreciations()
	{
		$query = $this->db->query('SELECT *
    FROM Tbl_Assets_Depression_method');
		return $query->result_array();
	}


	public function AddDepreciation($name, $status)
	{

		$query = $this->db->query("INSERT INTO Tbl_Assets_Depression_method
      (  DepresionMethod ,
      Status )
         VALUES
            ('$name', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Depreciation Method of Asset has been added. ');
			redirect('AssetsDepreciationMethod');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Depreciation Method of Asset.');
			redirect('AssetsDepreciationMethod');
		}
	}


	public function getDepreciation($Id)
	{
		$query = $this->db->query(
			"SELECT  *
            FROM            Tbl_Assets_Depression_method
            WHERE  ID = '$Id'"
		);
		return $query->result_array();
	}

	public function EditDepreciation($id, $name, $status)
	{

		$query = $this->db->query("UPDATE  dbo . Tbl_Assets_Depression_method 
            SET   DepresionMethod  =  '$name',
            Status  =  '$status' 
          WHERE  ID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Depreciation Method of Asset has been Updated. ');
			redirect('AssetsDepreciationMethod');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Chart of Depreciation Method.');
			redirect('AssetsDepreciationMethod');
		}
	}

	public function deleteDepreciation($Id)
	{

		$query = $this->db->query("DELETE FROM  Tbl_Assets_Depression_method 
            WHERE  ID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Depreciation Method has been Deleted. ');
			redirect('AssetsDepreciationMethod');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Depreciation Method.');
			redirect('AssetsDepreciationMethod');
		}
	}


	////////////////////////////////////////////////////////// Original Life ///////////////////////////////////////////////////////////

	public function getOriginalLifes()
	{
		$query = $this->db->query('  SELECT *
    FROM tbl_Assert_OR_Life');
		return $query->result_array();
	}


	public function AddOriginalLife($name, $status)
	{

		$query = $this->db->query("INSERT INTO tbl_Assert_OR_Life
      (  OriginalLife ,
      Status )
         VALUES
            ('$name', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Original Life of Asset has been added. ');
			redirect('AssetsOriginalLife');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Original Life of Asset.');
			redirect('AssetsOriginalLife');
		}
	}


	public function getOriginalLife($Id)
	{
		$query = $this->db->query(
			"SELECT  *
            FROM            tbl_Assert_OR_Life
            WHERE  ID = '$Id'"
		);
		return $query->result_array();
	}

	public function EditOriginalLife($id, $name, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_Assert_OR_Life 
            SET   OriginalLife  =  '$name',
            Status  =  '$status' 
          WHERE  ID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Original Life of Asset has been Updated. ');
			redirect('AssetsOriginalLife');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Chart of Original Life.');
			redirect('AssetsOriginalLife');
		}
	}

	public function deleteOriginalLife($Id)
	{

		$query = $this->db->query("DELETE FROM  tbl_Assert_OR_Life
            WHERE  ID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Original Life Method has been Deleted. ');
			redirect('AssetsOriginalLife');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Original Life.');
			redirect('AssetsOriginalLife');
		}
	}

	////////////////////////////////////////////////////////// Vendors ///////////////////////////////////////////////////////////

	public function getVendors()
	{
		$query = $this->db->query('  SELECT *
    FROM tbl_Vendors');
		return $query->result_array();
	}


	public function AddVendor($name, $address, $number, $status)
	{

		$query = $this->db->query("INSERT INTO tbl_Vendors
      (  VendorName , Address, Phone,
      Status )
         VALUES
            ('$name', '$address', '$number', '$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Vendor of Asset has been added. ');
			redirect('vendors');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Vendor of Asset.');
			redirect('vendors');
		}
	}


	public function getVendor($Id)
	{
		$query = $this->db->query(
			"SELECT  *
            FROM            tbl_Vendors
            WHERE  VendorID = '$Id'"
		);
		return $query->result_array();
	}

	public function EditVendor($Id, $name, $address, $number, $status)
	{

		$query = $this->db->query("UPDATE  dbo . tbl_Vendors 
            SET   VendorName  =  '$name',Address  =  '$address',Phone  =  '$number', Status  =  '$status' 
          WHERE  VendorID='$Id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Vendor of Asset has been Updated. ');
			redirect('vendors');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Vendor.');
			redirect('vendors');
		}
	}

	public function deleteVendor($Id)
	{

		$query = $this->db->query("DELETE FROM  tbl_Vendors
            WHERE  VendorID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Vendor has been Deleted. ');
			redirect('vendors');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Vendor.');
			redirect('vendors');
		}
	}


	////////////////////////////////////////////////////////// Asset Functions ///////////////////////////////////////////////////////////

	public function getAssets()
	{
		$query = $this->db->query('  SELECT        dbo.view_asset.*
    FROM            dbo.view_asset');
		return $query->result_array();
	}


	public function AddAsset($type, $name, $build, $dept, $sec, $cost, $pDate, $exp, $orig, $ven, $status, $overcost, $overDate, $state, $code, $des, $depMeth, $pic, $insdate, $user, $brand)
	{
		date_default_timezone_set("Asia/Karachi");
		$query = $this->db->query("INSERT INTO tbl_Assert
      (  
       BID 
      , DeptID 
      , SecID 
      , AsTypeID 
      , AssetChartId
      , image
      , PurcaseDate 
      , OverHallDate 
      , OriginalLifeID 
      , ExpiryDate 
      , Cost 
      , OverHallCost 
      , DpMethodID 
      , State
      , TransCode
      , VendorID
      , status
      , des
      ,InstallationDate
      ,Assignto
      ,BrandType
 )
         VALUES
            ('$build', '$dept', '$sec', '$type','$name', '$pic','$pDate', '$overDate', '$orig','$exp', '$cost', '$overcost', '$depMeth','$state','$code','$ven','$status', '$des','$insdate','$user','$brand')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Asset has been added. ');
			redirect('AssetsPurchase');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Asset.');
			redirect('AssetsPurchase');
		}
	}


	public function EditAsset($id, $type, $name, $build, $dept, $sec, $cost, $pDate, $exp, $orig, $ven, $status, $overcost, $overDate, $state, $des, $depMeth, $pic, $insdate, $user, $brand)
	{
		date_default_timezone_set("Asia/Karachi");
		$query = $this->db->query("UPDATE  dbo . tbl_Assert 
            SET   BID  =  '$build',DeptID  =  '$dept',SecID  =  '$sec', AsTypeID  =  '$type' , 
            AssetChartId  =  '$name',image = '$pic',PurcaseDate  =  '$pDate',OverHallDate  =  '$overDate', OriginalLifeID  =  '$orig',

            ExpiryDate  =  '$exp',Cost  =  '$cost',OverHallCost  =  '$overcost', DpMethodID  =  '$depMeth' , 
            State  =  '$state',VendorID  =  '$ven',status  =  '$status', des  =  '$des' , InstallationDate  =  '$insdate' , Assignto  =  '$user' , BrandType  =  '$brand' 
          WHERE  AsstID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Vendor of Asset has been Updated. ');
			redirect('AssetsPurchase');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Vendor.');
			redirect('AssetsPurchase');
		}
	}

	public function EditAssetWithoutPicture($id, $type, $name, $build, $dept, $sec, $cost, $pDate, $exp, $orig, $ven, $status, $overcost, $overDate, $state, $des, $depMeth, $insdate, $user, $brand)
	{
		date_default_timezone_set("Asia/Karachi");
		$query = $this->db->query("UPDATE  dbo . tbl_Assert 
            SET   BID  =  '$build',DeptID  =  '$dept',SecID  =  '$sec', AsTypeID  =  '$type' , 
            AssetChartId  =  '$name',PurcaseDate  =  '$pDate',OverHallDate  =  '$overDate', OriginalLifeID  =  '$orig',
            ExpiryDate  =  '$exp',Cost  =  '$cost',OverHallCost  =  '$overcost', DpMethodID  =  '$depMeth' , 
            State  =  '$state',VendorID  =  '$ven',status  =  '$status', des  =  '$des' ,InstallationDate  =  '$insdate' , Assignto  =  '$user' , BrandType  =  '$brand'
          WHERE  AsstID='$id'");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Vendor of Asset has been Updated. ');
			redirect('AssetsPurchase');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Updating Vendor.');
			redirect('AssetsPurchase');
		}
	}
	public function getAsset($Id)
	{
		$query = $this->db->query("SELECT  *
            FROM            tbl_Assert
            WHERE  AsstID = '$Id'");
		return $query->result_array();
	}



	public function deleteAsset($Id)
	{

		$query = $this->db->query("DELETE FROM  tbl_Assert
            WHERE  AsstID='$Id'");
		if ($query) {
			$this->session->set_flashdata('ProDelDepinfo', 'Asset has been Deleted. ');
			redirect('AssetsPurchase');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while Deleting Asset.');
			redirect('AssetsPurchase');
		}
	}

	public function  getChartOfAssets($Id)
	{
		$query = $this->db->query("  SELECT *
        FROM tbl_Assets_Catagory
        WHERE AssetType='$Id'");
		return $query->result_array();
	}

	public function AddAssetMovingLocation($assMove, $buildMove, $depMove, $sectionMove, $status)
	{
		date_default_timezone_set("Asia/Karachi");
		$date = date('Y-m-d');
		$query = $this->db->query("INSERT INTO tbl_Assets_location
              (  
               AssetID   
            ,  BID 
              , DeptID 
              , SectionID 
              , Date
              , Status
         )
                 VALUES
                    ('$assMove', '$buildMove', '$depMove', '$sectionMove','$date','$status')");

		if ($query) {
			$this->session->set_flashdata('Proinfo', 'Asset has been added. ');
			redirect('AssetsPurchase');
		} else {
			$this->session->set_flashdata('danger', 'There is an error while creating Asset.');
			redirect('AssetsPurchase');
		}
	}




	public function getimages()
	{
		$query = $this->db->query("SELECT        dbo.View_156.CNIC, dbo.View_156.EmpPic
FROM            dbo.Table_10 INNER JOIN
                         dbo.View_156 ON dbo.Table_10.CNICN = dbo.View_156.CNIC
WHERE        (dbo.View_156.EmpPic IS NOT NULL)");
		return $query->result_array();
	}
	public function getlabelinfo()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        KitID, LabelType, ID
        FROM            dbo.tbl_Label_Info
        WHERE        (ID <> 2)");
		return $query->result_array();
	}

	public function Kitinformation($Type)
	{
		$MIS = $this->load->database('MIS', TRUE);

		return  $MIS
			->where("ID", $Type)
			->get("tbl_Label_Info")
			->result();
	}

	public function insert_data($start_quantity, $end_quantity, $kitid, $labelid, $RDate)
	{
		$user_id =  $this->session->userdata('user_id');
		$query = false;
		$MIS = $this->load->database('MIS', TRUE);
		for ($start_quantity; $start_quantity <= $end_quantity; $start_quantity++) {
			$date = $RDate;
			if ($labelid == 1 || $labelid == 3) {
				$query = $MIS->query("INSERT INTO tbl_Label_Rec
      (ID,KitName,Qty,EntryDate,SerialNO,RullQty, NoOFRulls,user_id) VALUES ('$labelid', '$kitid',1,'$date', $start_quantity,'4','11245', $user_id)");;
			} else {
				$query = $MIS->query("INSERT INTO tbl_Label_Rec
      (ID,KitName,Qty,EntryDate,SerialNO,RullQty, NoOFRulls,user_id) VALUES ('$labelid', '$kitid',1,'$date', $start_quantity,'8','4813')");
			}
		}

		return $query;
	}

	public function getData($date1, $date2, $Type)
	{

		$SYear = substr($date1, 0, 4);
		$SMonth = substr($date1, 5, 2);
		$SDay = substr($date1, -2, 2);
		$EYear = substr($date2, 0, 4);
		//echo "<br>";
		$EMonth = substr($date2, 5, 2);
		//echo "<br>";
		$EDay = substr($date2, -2, 2);
		$StartDate = $SDay . '/' . $SMonth . '/' . $SYear;
		$EndDate = $EDay . '/' . $EMonth . '/' . $EYear;

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT  
                 TranDate,KitName, Qty, CONVERT(varchar, IssueDate, 103) AS IssueDate,
                  ISNULL(IssueStatus, 0) AS IssueStatus, SerialNo, ID, EntryDate, RecID, balance1, Reclabel
FROM            dbo.View_Label
WHERE       (EntryDate BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) 
AND CONVERT(DATETIME, '$date2 00:00:00', 102)) AND (ID = $Type)");

		return $query->result_array();
	}
	public function updateRecord($RIDValue, $Status, $IssueDte)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("UPDATE tbl_Label_Rec 
            SET   IssueStatus  =  '$Status',IssueDate  =  '$IssueDte'
          WHERE  RecID='$RIDValue'");
	}
	public function getpo($date1, $date2, $fc)
	{

		$MIS = $this->load->database('MIS', TRUE);

		// return  $MIS
		//         ->where("printDate =>", $date1)
		//         ->where("printDate =<", $date2)
		//         ->get("view_label_print")
		//         ->result();


		if ($fc == 'Sample_Label') {
			$query = $MIS->query("SELECT        POCode, PO, OrderQty, printDate,Balance,PlanDate, FactoryCode, PlanType, Balance
        FROM            view_label_print_final
WHERE        (planDate BETWEEN '$date1' AND '$date2') AND PlanType ='Sample Label' AND Balance > 0 ");
		} else {

			$query = $MIS->query("SELECT        POCode, PO, OrderQty, printDate,Balance,PlanDate, FactoryCode, PlanType, Balance
        FROM            view_label_print_final
WHERE        (planDate BETWEEN '$date1' AND '$date2') AND FactoryCode='$fc' AND Balance > 0");
		}

		return $query->result_array();
	}
	public function POQty($PO)
	{
		$MIS = $this->load->database('MIS', TRUE);

		return  $MIS
			->where("PO", $PO)
			->get("view_label_print_final")
			->result();
	}
	public function getKits()
	{

		$MIS = $this->load->database('MIS', TRUE);
		//         $query = $MIS->query("SELECT       view_Final_Kits.*
		// FROM            view_Final_Kits");
		//         return $query->result_array();
		$query = $MIS->query("SELECT        view_Kits_Ready_for_use3.* FROM            dbo.view_Kits_Ready_for_use3
ORDER BY SerialNo");
		return $query->result_array();
	}
	public function getKitbalance($Kits)
	{

		$MIS = $this->load->database('MIS', TRUE);
		return  $MIS
			->where("RecID", $Kits)
			->get("view_Kits_Ready_for_use3")
			->result();
	}


	function getWastageD($audit1, $MontVal, $YearVal)
	{
		$MIS = $this->load->database('MIS', TRUE);




		$query = $MIS->query("SELECT * FROM View_WASTE_KIT_DETAIL where AuditMonth='$audit1'");

		return $query->result_array();
	}


	function getWastageD1($audit1, $MontVal, $YearVal)
	{
		$MIS = $this->load->database('MIS', TRUE);




		$query = $MIS->query("SELECT * FROM View_WASTE_KIT_DETAIL where AuditMonth='$audit1' AND (Month='$MontVal' AND Year='$YearVal')");

		return $query->result_array();
	}


	public function getWastageS($audit1, $month, $year)
	{
		$MIS = $this->load->database('MIS', TRUE);

		// Convert month and year from string to integer
		$monthInt = (string) $month;
		$yearInt = (string) $year;
		// print_r($month);
		// print_r($year);
		// print_r($audit1);
		// die;

		$query = $MIS->query("SELECT        SUM(Wastage) AS Wastage, AuditID, AuditMonth, westage_description, Narration, RollQty, InkRibbonQty
        FROM            dbo.View_Waste_Month_YEAR
        GROUP BY AuditID, AuditMonth, westage_description, Narration, RollQty, InkRibbonQty
        HAVING        (AuditMonth = '$audit1') ");


		return $query->result_array();
	}



	public function getWastageSByAudit($audit1, $month, $year)
	{
		$MIS = $this->load->database('MIS', TRUE);

		// Convert month and year from string to integer
		$monthInt = (string) $month;
		$yearInt = (string) $year;
		// print_r($month);
		// print_r($year);
		// print_r($audit1);
		// die;

		$query = $MIS->query("SELECT * FROM View_KIT_ISSuance WHERE AuditMonthh='$audit1'");



		return $query->result_array();
	}






	public function getWastageSByAuditM($audit1, $month, $year)
	{
		$MIS = $this->load->database('MIS', TRUE);

		// Convert month and year from string to integer
		$monthInt = (string) $month;
		$yearInt = (string) $year;
		// print_r($month);
		// print_r($year);
		// print_r($audit1);
		// die;

		$query = $MIS->query("SELECT * FROM View_KIT_ISSuance WHERE AuditMonthh='$audit1' AND Month=$month AND Year=$year");



		return $query->result_array();
	}



	function getWastageS3($audit1, $month, $year)
	{
		$MIS = $this->load->database('MIS', TRUE);

		$monthInt = (string) $month;
		$yearInt = (string) $year;

		$query = $MIS->query("    SELECT        SUM(dbo.tbl_kit_Westage.Wastage) AS Expr1, dbo.tbl_kit_Westage.AuditID, dbo.tbl_labeling_audit.AuditMonth, MONTH(dbo.tbl_kit_Westage.IssuanceDate) AS Month, YEAR(dbo.tbl_kit_Westage.IssuanceDate) AS Year, 
    dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.IssuanceDate
FROM            dbo.tbl_kit_Westage INNER JOIN
    dbo.tbl_labeling_audit ON dbo.tbl_kit_Westage.AuditID = dbo.tbl_labeling_audit.TID
GROUP BY dbo.tbl_kit_Westage.AuditID, dbo.tbl_labeling_audit.AuditMonth, MONTH(dbo.tbl_kit_Westage.IssuanceDate), YEAR(dbo.tbl_kit_Westage.IssuanceDate), dbo.tbl_kit_Westage.westage_description, 
    dbo.tbl_kit_Westage.IssuanceDate
HAVING        (dbo.tbl_kit_Westage.AuditID IS NOT NULL) AND (dbo.tbl_labeling_audit.AuditMonth = '$audit1') AND (MONTH(dbo.tbl_kit_Westage.IssuanceDate) = $month) AND (YEAR(dbo.tbl_kit_Westage.IssuanceDate) = $year)");

		return $query->result_array();
	}


	function getWastageS1($audit1, $month, $year)
	{
		$MIS = $this->load->database('MIS', TRUE);

		$monthInt = (string) $month;
		$yearInt = (string) $year;

		$query = $MIS->query("SELECT * FROM View_Waste_Month_YEAR  where AuditMonth='$audit1' AND Month=$monthInt AND Year=$yearInt");

		return $query->result_array();
	}

	public function Kits_issuance_insert_data($PlanDate, $KitsiD, $pquantity, $issuedate)
	{

		print_r($PlanDate);
		die;

		$user_name =  $this->session->userdata('user_name');
		$MIS = $this->load->database('MIS', TRUE);
		$user_id =  $this->session->userdata('user_id');

		$query = $MIS->query("INSERT INTO tbl_kit_issuance (PlanDate, PO, KitID, PrintQty, PrintDate, Issuedby, user_id) 
                             VALUES ('$PlanDate','0', '$KitsiD', $pquantity, '$issuedate', '$user_name', $user_id)");

		// Check if the query was successful
		if ($query) {
			// Query successful, you can fetch the result array if needed
			return $query->result_array();
		} else {
			// Query failed, handle the error (log, return an error message, etc.)
			log_message('error', 'Kits_issuance_insert_data: Query failed');
			return FALSE; // or return an error message or code
		}
	}

	public function Kits_issuance_insert_dataW($KitsiD, $issuedate, $westage, $westageDesc)
	{

		$Status = Null;

		if ($Status == 0) {
			$Type = 'normal';
		} else {
			$Type = 'reprint';
		}
		$user_name =  $this->session->userdata('user_name');
		$MIS = $this->load->database('MIS', TRUE);
		//$date = $RDate;

		$user_id =  $this->session->userdata('user_id');
		$query = $MIS->query("INSERT  INTO tbl_kit_Westage
      (KitID,IssuanceDate,Wastage,Type,Issuedby,user_id,westage_description
      
      ) VALUES ('$KitsiD',$issuedate', $westage,'$Type','$user_name',$user_id,
      '$westageDesc')");;
	}


	// Westage Old Query


// 	SELECT        CONVERT(VARCHAR, dbo.tbl_kit_Westage.IssuanceDate, 103) AS IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, 
//         dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo, dbo.View_Label.KitName, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty
// FROM            dbo.tbl_kit_Westage INNER JOIN
//         dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
// WHERE        (dbo.tbl_kit_Westage.AuditID = '$AuditID')


    public function loadWastageAudit1($AuditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        CONVERT(VARCHAR, dbo.tbl_kit_Westage.IssuanceDate, 103) AS IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, 
		dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo, dbo.View_Label.KitName, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty
FROM            dbo.tbl_kit_Westage LEFT OUTER JOIN
		dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
WHERE        (dbo.tbl_kit_Westage.AuditID = '$AuditID')");

		return $query->result_array();
	}


	public function loadWastageAudit($AuditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT * FROM View_Waste_Month_YEAR WHERE AuditID = '$AuditID'");

		return $query->result_array();
	}

	public function loadWastageAuditRollAndRibbon($AuditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.View_Label.SerialNo, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty
		FROM            dbo.tbl_kit_Westage INNER JOIN
								 dbo.View_Label ON dbo.tbl_kit_Westage.AuditID = dbo.View_Label.AuditMonth
		GROUP BY dbo.View_Label.SerialNo, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty, dbo.tbl_kit_Westage.AuditID
		HAVING        (dbo.tbl_kit_Westage.AuditID = '28')");

		return $query->result_array();
	}


	public function loadMonthWiseRollAndRibbon($date1, $date2)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.View_Label.SerialNo, MAX(dbo.tbl_kit_Westage.RollQty) AS RollQty, MAX(dbo.tbl_kit_Westage.InkRibbonQty) AS InkRibbonQty, MAX(dbo.tbl_kit_Westage.IssuanceDate) AS LatestIssuanceDate
        FROM            dbo.tbl_kit_Westage INNER JOIN
                                 dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
        WHERE        (dbo.tbl_kit_Westage.IssuanceDate BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) AND CONVERT(DATETIME, '$date2 00:00:00', 102))
        GROUP BY dbo.View_Label.SerialNo");

		return $query->result_array();
	}


	public function loadAuditWiseRollAndRibbon($auditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.View_Label.SerialNo, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty
        FROM            dbo.tbl_kit_Westage INNER JOIN
                                 dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
        GROUP BY dbo.View_Label.SerialNo, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty, dbo.tbl_kit_Westage.AuditID
        HAVING        (dbo.tbl_kit_Westage.AuditID = '$auditID')");

		return $query->result_array();
	}




	public function loadWastageAuditD($AuditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TOP (100) PERCENT CONVERT(VARCHAR, dbo.tbl_kit_Westage.IssuanceDate, 103) AS IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, 
        dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo, dbo.View_Label.KitName, dbo.tbl_kit_Westage.RollQty, dbo.tbl_kit_Westage.InkRibbonQty
FROM            dbo.tbl_kit_Westage INNER JOIN
        dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
WHERE        (dbo.tbl_kit_Westage.AuditID = '$AuditID')
ORDER BY dbo.tbl_kit_Westage.KitID DESC");

		return $query->result_array();
	}


	public function TotalWestKits($AuditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        CONVERT(VARCHAR, dbo.tbl_kit_Westage.IssuanceDate, 103) AS IssuanceDate, dbo.View_Label.KitName, dbo.tbl_kit_Westage.AuditID
        FROM            dbo.tbl_kit_Westage INNER JOIN
                                 dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
        GROUP BY CONVERT(VARCHAR, dbo.tbl_kit_Westage.IssuanceDate, 103), dbo.View_Label.KitName, dbo.tbl_kit_Westage.AuditID
        HAVING        (dbo.tbl_kit_Westage.AuditID = '$AuditID')");

		return $query->result_array();
	}


	public function getkitsissuance($date1, $date2, $fc)
	{



		$MIS = $this->load->database('MIS', TRUE);

		// print_r($fc == 'Sample_Label');die;

		if($fc == 'Sample_Label'){
			$query = $MIS->query("SELECT        TID, PO, KitID, KitQty, IssuanceDate, SerialNo, POCode, OrderQty, Issuedby, Receivedby, IssueDate, PrintDate, PlanDate, FactoryCode, Type, Days, KeyNum, Cancel
			FROM            dbo.View_PlanDate_Label
			WHERE        (PlanDate = '$date1 00:00:00') AND (Type = 'Sample Label')
			");
		}
		else{
		$query = $MIS->query("SELECT * FROM View_PlanDate_Label WHERE PlanDate = '$date1 00:00:00' AND FactoryCode='$fc'
             ");
		}



		return $query->result_array();
	}


	public function getkitsissuance1($date1, $date2)
	{


		$MIS = $this->load->database('MIS', TRUE);

		// if($fc === 'Sample Label'){
		// 	$query = $MIS->query("SELECT        TID, PO, KitID, KitQty, IssuanceDate, SerialNo, POCode, OrderQty, Issuedby, Receivedby, IssueDate, PrintDate, PlanDate, FactoryCode, Type, Days, KeyNum, Cancel
		// 	FROM            dbo.View_PlanDate_Label
		// 	WHERE        (PlanDate = '$date1') AND (Type = 'Sample Label')
		// 	");
		// }
		// else{
		$query = $MIS->query("SELECT * FROM View_PlanDate_Label WHERE PlanDate between '$date1 00:00:00'  AND '$date2 00:00:00' 
             ");
		// }



		return $query->result_array();
	}


	public function getkitsPrinted()
	{


		$MIS = $this->load->database('MIS', TRUE);

		$query = $MIS->query("SELECT        TOP (100) PERCENT dbo.tbl_kit_issuance.TID, dbo.tbl_kit_issuance.PO, dbo.tbl_kit_issuance.KitID, dbo.tbl_kit_issuance.PrintQty AS KitQty, CONVERT(varchar, dbo.tbl_kit_issuance.PrintDate, 103) AS IssuanceDate, 
        dbo.View_Label.SerialNo, dbo.View_Label_PO_1.POCode, dbo.View_Label_PO_1.OrderQty, dbo.tbl_kit_issuance.Issuedby, dbo.tbl_kit_issuance.Receivedby, CONVERT(Varchar, dbo.tbl_kit_issuance.IssueDate, 103) 
        AS IssueDate, dbo.tbl_kit_issuance.PrintDate, dbo.tbl_kit_issuance.PlanDate, dbo.View_Label_PO_1.FactoryCode, dbo.tbl_kit_issuance.Type
FROM            dbo.View_Label INNER JOIN
        dbo.tbl_kit_issuance ON dbo.View_Label.RecID = dbo.tbl_kit_issuance.KitID INNER JOIN
        dbo.View_Label_PO_1 ON dbo.tbl_kit_issuance.PO = dbo.View_Label_PO_1.PO
WHERE        (dbo.tbl_kit_issuance.Receivedby IS NULL) AND (CONVERT(Varchar, dbo.tbl_kit_issuance.IssueDate, 103) IS NULL)
ORDER BY dbo.tbl_kit_issuance.TID DESC
        ");
		return $query->result_array();
	}




	public function getkitsissuancew($date1, $date2)
	{


		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.tbl_kit_Westage.KitQty, CONVERT(varchar, dbo.tbl_kit_Westage.IssuanceDate, 103) AS IssuanceDate1, dbo.tbl_kit_Westage.Wastage, 
        dbo.tbl_kit_Westage.westage_description, dbo.View_Label.SerialNo, dbo.tbl_kit_Westage.Type, dbo.tbl_kit_Westage.Issuedby, dbo.tbl_kit_Westage.Receivedby, CONVERT(Varchar, dbo.tbl_kit_Westage.IssueDate, 103) 
        AS IssueDate, dbo.View_Label.IssuanceDate
FROM            dbo.View_Label INNER JOIN
        dbo.tbl_kit_Westage ON dbo.View_Label.RecID = dbo.tbl_kit_Westage.KitID
WHERE        (dbo.View_Label.IssuanceDate BETWEEN '$date1' AND '$date2') AND (dbo.tbl_kit_Westage.Type IS NOT NULL)");
		return $query->result_array();
	}
	public function updateKitsissuance($RBy, $iDate, $RID)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("UPDATE tbl_kit_issuance  
            SET   Receivedby  =  '$RBy',IssueDate  =  '$iDate'
          WHERE  TID='$RID'");
	}
	public function Deleteissuance($TID)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("DELETE FROM tbl_kit_issuance
        WHERE TID='$TID'");
	}



	public function Ledger()
	{

		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT * FROM dbo.view_Kits_Balance_Ledger");
		return $query->result_array();
	}

	public function Kitcount()
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query('SELECT        dbo.view_All_Kits_Data.*
	FROM            dbo.view_All_Kits_Data');
		return print_r($query->result_array());
	}

	public function getkitsissuanceCount($date1, $date2)
	{

		$user_id =  $this->session->userdata('user_id');

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT      dbo.tbl_kit_issuance.TID, 
        dbo.tbl_kit_issuance.PO, dbo.tbl_kit_issuance.KitID,
         dbo.tbl_kit_issuance.KitQty, CONVERT(varchar, dbo.tbl_kit_issuance.IssuanceDate, 103) AS IssuanceDate, 
         dbo.tbl_kit_issuance.Wastage, 
                             dbo.tbl_kit_issuance.westage_description,dbo.View_Label.SerialNo,View_Label.NO,
                              dbo.View_Label_PO.POCode, dbo.View_Label_PO.OrderQty, 
                              dbo.tbl_kit_issuance.Type, dbo.tbl_kit_issuance.Issuedby, 
                              dbo.tbl_kit_issuance.Receivedby, CONVERT(Varchar, 
                             dbo.tbl_kit_issuance.IssueDate, 103) AS IssueDate
    FROM            dbo.View_Label INNER JOIN
                             dbo.tbl_kit_issuance ON dbo.View_Label.RecID = dbo.tbl_kit_issuance.KitID INNER JOIN
                             dbo.View_Label_PO ON dbo.tbl_kit_issuance.PO = dbo.View_Label_PO.PO
    WHERE        (dbo.tbl_kit_issuance.Type IS NOT NULL) 
    AND (tbl_kit_issuance.IssuanceDate BETWEEN '$date1' AND '$date2') and (dbo.View_Label.NO >1256)");
		return $query->result_array();
	}

	public function getkitsissuanceCountPrinted($date)
	{

		$user_id =  $this->session->userdata('user_id');

		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.tbl_kit_issuance.TID, dbo.tbl_kit_issuance.PO, dbo.tbl_kit_issuance.KitID, dbo.tbl_kit_issuance.KitQty, CONVERT(varchar, dbo.tbl_kit_issuance.IssuanceDate, 103) AS IssuanceDate, dbo.tbl_kit_issuance.Wastage, 
        dbo.tbl_kit_issuance.westage_description, dbo.View_Label.SerialNo, dbo.View_Label_PO.POCode, dbo.View_Label_PO.OrderQty, dbo.tbl_kit_issuance.Type, dbo.tbl_kit_issuance.Issuedby, dbo.tbl_kit_issuance.Receivedby, 
        CONVERT(Varchar, dbo.tbl_kit_issuance.IssueDate, 103) AS IssueDate
FROM            dbo.View_Label INNER JOIN
        dbo.tbl_kit_issuance ON dbo.View_Label.RecID = dbo.tbl_kit_issuance.KitID INNER JOIN
        dbo.View_Label_PO ON dbo.tbl_kit_issuance.PO = dbo.View_Label_PO.PO
WHERE        (dbo.tbl_kit_issuance.Type IS NOT NULL) 
AND (CONVERT(varchar, dbo.tbl_kit_issuance.IssueDate, 103) = '$date')");
		return $query->result_array();
	}
	public function getkitsissuanceCountIssuedate($date1, $date2)
	{


		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TOP (100) PERCENT SUM(dbo.tbl_kit_issuance.KitQty) AS KitQty, dbo.tbl_kit_issuance.IssueDate
        FROM            dbo.View_Label INNER JOIN
                                 dbo.tbl_kit_issuance ON dbo.View_Label.RecID = dbo.tbl_kit_issuance.KitID INNER JOIN
                                 dbo.View_Label_PO ON dbo.tbl_kit_issuance.PO = dbo.View_Label_PO.PO
        GROUP BY dbo.tbl_kit_issuance.IssueDate
        HAVING        (dbo.tbl_kit_issuance.IssueDate BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) AND CONVERT(DATETIME, '$date2 00:00:00', 102))");
		return $query->result_array();
	}




	// SELECT        Qty, user_id, RecID, KitName
	//         FROM            dbo.view_label1
	//         WHERE        (IssueStatus IS NULL)

	public function instockData()
	{

		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);

		$query = $MIS->query("SELECT        ID, RecID, DayID, KitName, Qty, EntryDate, SysIP, IssueDate, OpratorName, IssueStatus, Narration, SerialNO, RullQty, NoOFRulls, user_id, IssueQty
        FROM            dbo.tbl_Label_Rec
        WHERE        (IssueStatus IS NULL)");

		return $query->result_array();
	}

	public function issuedkits()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("             SELECT        Qty
                            FROM            dbo.view_label1
                            WHERE        (IssueStatus = 1)");

		return $query->result_array();
	}

	public function totalKits()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        Qty, KitName, IssueStatus, TranDate
        FROM            dbo.view_label1");

		return $query->result_array();
	}
	public function issuedKits1()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        Qty, KitName, IssueStatus, TranDate, CONVERT(varchar, IssuanceDate, 103) AS IssuanceDate, CONVERT(varchar, IssueDate, 103) AS IssueDate
        FROM            dbo.view_label1
        WHERE        (IssueStatus = 1)");

		return $query->result_array();
	}

	public function issuedKitsByDate($startDate, $endDate)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        Qty, KitName, IssueStatus, TranDate, CONVERT(varchar, IssuanceDate, 103) AS IssuanceDate, CONVERT(varchar, IssueDate, 103) AS IssueDate
        FROM            dbo.view_label1
        WHERE        (IssueStatus = 1) AND IssueDate BETWEEN '$startDate' AND '$endDate'");

		return $query->result_array();
	}

	public function instockKits()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TranDate, KitName, Qty, CONVERT(varchar, IssueDate, 103) AS IssueDate, ISNULL(IssueStatus, 0) AS IssueStatus, SerialNo, ID, EntryDate, RecID, balance1, Reclabel, IssueDate AS IsssueDate, 
        IssueStatus AS IsssueStatus
FROM            dbo.View_Label
WHERE        (IssueDate IS NULL) AND (IssueStatus IS NULL)");

		return $query->result_array();
	}


	public function getWastageMonthWise($date1, $date2)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.View_Kit_Wastage.TID, dbo.View_Kit_Wastage.KitID, dbo.View_Kit_Wastage.KitQty, dbo.View_Kit_Wastage.KitName, dbo.View_Kit_Wastage.IssuanceDate, dbo.View_Kit_Wastage.Wastage, 
        dbo.View_Kit_Wastage.Receivedby, dbo.View_Kit_Wastage.Narration, dbo.View_Kit_Wastage.Type, dbo.View_Kit_Wastage.Issuedby, dbo.View_Kit_Wastage.IssueDate, dbo.View_Kit_Wastage.user_id, 
        dbo.View_Kit_Wastage.westage_description, dbo.View_Kit_Wastage.Auto, dbo.View_Kit_Wastage.AuditID, dbo.View_Kit_Wastage.EntryDate, dbo.View_Kit_Wastage.RollQty, dbo.View_Kit_Wastage.InkRibbonQty, 
        dbo.tbl_labeling_audit.AuditMonth, dbo.View_Label.KitName AS Expr1, dbo.View_Label.SerialNo
FROM            dbo.View_Kit_Wastage INNER JOIN
        dbo.tbl_labeling_audit ON dbo.View_Kit_Wastage.AuditID = dbo.tbl_labeling_audit.TID INNER JOIN
        dbo.View_Label ON dbo.View_Kit_Wastage.KitID = dbo.View_Label.RecID
WHERE        (dbo.View_Kit_Wastage.IssuanceDate BETWEEN '$date1' AND '$date2')");

		return $query->result_array();
	}



	public function getWastageByAudit($auditID)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TOP (100) PERCENT dbo.View_Kit_Wastage.TID, dbo.View_Kit_Wastage.KitID, dbo.View_Kit_Wastage.KitQty, dbo.View_Kit_Wastage.KitName, dbo.View_Kit_Wastage.IssuanceDate, dbo.View_Kit_Wastage.Wastage, 
        dbo.View_Kit_Wastage.Receivedby, dbo.View_Kit_Wastage.Narration, dbo.View_Kit_Wastage.Type, dbo.View_Kit_Wastage.Issuedby, dbo.View_Kit_Wastage.IssueDate, dbo.View_Kit_Wastage.user_id, 
        dbo.View_Kit_Wastage.westage_description, dbo.View_Kit_Wastage.Auto, dbo.View_Kit_Wastage.AuditID, dbo.View_Kit_Wastage.EntryDate, dbo.View_Kit_Wastage.RollQty, dbo.View_Kit_Wastage.InkRibbonQty, 
        dbo.tbl_labeling_audit.AuditMonth, dbo.View_Label.KitName AS Expr1, dbo.View_Label.SerialNo
FROM            dbo.View_Kit_Wastage INNER JOIN
        dbo.tbl_labeling_audit ON dbo.View_Kit_Wastage.AuditID = dbo.tbl_labeling_audit.TID INNER JOIN
        dbo.View_Label ON dbo.View_Kit_Wastage.KitID = dbo.View_Label.RecID
WHERE        (dbo.View_Kit_Wastage.AuditID = '$auditID')
ORDER BY dbo.View_Kit_Wastage.IssuanceDate DESC");

		return $query->result_array();
	}





	public function getPrintedStock()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        Qty, KitName, IssueStatus, TranDate
        FROM            dbo.view_label1
        WHERE        (IssueStatus IS NULL)");

		return $query->result_array();
	}

	public function insertWastage($kit, $wastage, $issueDate, $wastageDes, $auditID)
	{

		//         echo($auditID);
		// die;
		$date = date("Y/m/d H:i:s");
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO  dbo.tbl_kit_Westage (KitID,KitQty, IssuanceDate,Wastage,westage_description,AuditID,user_id, EntryDate, RollQty, InkRibbonQty)
                VALUES ($kit,0, '$issueDate', $wastage,'$wastageDes', $auditID ,$user_id, '$date', 4,2)");


		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function getresult($date1, $date2)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			//             "SELECT  * 
			// FROM  dbo.tbl_lable_reprinting 
			// "

			"SELECT        dbo.tbl_lable_reprinting.quantity, dbo.tbl_lable_reprinting.type, dbo.tbl_lable_reprinting.reason, dbo.tbl_lable_reprinting.PlanDate, dbo.tbl_lable_reprinting.id, dbo.tbl_Pro_PO_H.POCode, dbo.tbl_lable_reprinting.po, 
dbo.tbl_Pro_PO_H.FactoryCode
FROM            dbo.tbl_lable_reprinting INNER JOIN
dbo.tbl_Pro_PO_H ON dbo.tbl_lable_reprinting.po = dbo.tbl_Pro_PO_H.PO
WHERE        (dbo.tbl_lable_reprinting.PlanDate BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) AND CONVERT(DATETIME, '$date2 00:00:00', 102))"


		);

		return $query->result_array();
	}

	public function LabelFilter($sdate, $edate)
	{
		$user_data = $this->session->userdata();
		$time = strtotime($sdate);
		$time1 = strtotime($edate);
		$newformat = date('Y-m-d', $time);
		$newformat1 = date('Y-m-d', $time1);
		$user_id = $user_data['user_id'];
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query(
			//             "SELECT  * 
			// FROM  dbo.tbl_lable_reprinting WHERE
			//         (PlanDate BETWEEN CONVERT(DATETIME, '$newformat 00:00:00', 102) 
			// AND CONVERT(DATETIME, '$newformat1 00:00:00', 102))"

			"SELECT        dbo.tbl_lable_reprinting.quantity, dbo.tbl_lable_reprinting.type, dbo.tbl_lable_reprinting.reason, dbo.tbl_lable_reprinting.PlanDate, dbo.tbl_lable_reprinting.id, dbo.tbl_Pro_PO_H.POCode, dbo.tbl_lable_reprinting.po, 
dbo.tbl_Pro_PO_H.FactoryCode
FROM            dbo.tbl_lable_reprinting INNER JOIN
dbo.tbl_Pro_PO_H ON dbo.tbl_lable_reprinting.po = dbo.tbl_Pro_PO_H.PO
WHERE        (dbo.tbl_lable_reprinting.PlanDate BETWEEN CONVERT(DATETIME, '$newformat 00:00:00', 102) AND CONVERT(DATETIME, '$newformat1 00:00:00', 102))"

		);

		return $query->result_array();
	}

	public function loadwastagemonth($auditID)
	{

		//         echo($auditID);
		// die;

		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.tbl_kit_Westage.IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo
        FROM            dbo.tbl_kit_Westage INNER JOIN
                                 dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
        WHERE        AuditID = '$auditID'");

		return $query->result_array();
	}

	public function loadWastageMasterForm()
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT  AuditMonth, Description, Duration, EntryDate, TID, Narration
                FROM            dbo.tbl_labeling_audit");

		return $query->result_array();
	}

	public function AddWastageForm($AuditMonth, $Description, $Duration)
	{

		// $Year = date('Y');
		// $Month = date('m');
		// $Day = date('d');
		// $EntryDate = $Year.'-'.$Month.'-'.$Day;
		$EntryDate = date('Y-m-d');
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO  dbo.tbl_labeling_audit (AuditMonth,Description, Duration,EntryDate)
                VALUES ('$AuditMonth', '$Description', '$Duration', '$EntryDate')");

		return 1;
	}
	public function UpdateWastageForm($AuditMonth, $Description, $Duration, $TID)
	{


		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("UPDATE  dbo.tbl_labeling_audit SET AuditMonth = '$AuditMonth',Description = '$Description', Duration = '$Duration'
                where TID = $TID
                ");

		return 1;
	}
	public function getID($TID)
	{
		$user_id = $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);

		// Use parameterized query to prevent SQL injection
		$query = $MIS->query("SELECT * FROM dbo.tbl_labeling_audit WHERE TID = ?", array($TID));

		// Check if the query was successful
		if ($query) {
			// Return the result as an associative array
			return $query->row_array();
		} else {
			// Return an empty array or handle the error as needed
			return array();
		}
	}
	public function getAuditID()
	{
		$user_id = $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);

		// Use parameterized query to prevent SQL injection
		$query = $MIS->query("SELECT AuditMonth, TID FROM dbo.tbl_labeling_audit");

		// Check if the query was successful
		if ($query) {
			// Return the result as an associative array
			$data = $query->result_array();
			// print_r($data);
			return $data;
		} else {
			// Return an empty array or handle the error as needed
			return array();
		}
	}

	public function deleteByID($TID)
	{
		$user_id = $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);

		// Use parameterized query to prevent SQL injection
		$query = $MIS->query("DELETE FROM dbo.tbl_labeling_audit WHERE TID = ?", array($TID));

		// Check if the query was successful
		if ($MIS->affected_rows() > 0) {
			// Return a success indicator or any meaningful result
			return true;
		} else {
			// Return a failure indicator or handle the error as needed
			return false;
		}
	}

	public function DeleteWastageForm($kit, $wastage, $issueDate, $wastageDes, $auditMonth)
	{


		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO  dbo.tbl_kit_Westage (KitID,KitQty, IssuanceDate,Wastage,westage_description,AuditMonth,user_id)
                VALUES ($kit,0, '$issueDate', $wastage,'$wastageDes', $auditMonth ,$user_id)");

		return 1;
	}
	public function submitWastage($kit, $wastage, $issueDate, $wastageDes, $auditMonth)
	{


		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("INSERT INTO  dbo.tbl_kit_Westage (KitID,KitQty, IssuanceDate,Wastage,westage_description,AuditMonth,user_id)
                VALUES ($kit,0, '$issueDate', $wastage,'$wastageDes', $auditMonth ,$user_id)");

		return 1;
	}

	public function wastageTable($date, $date1)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("                SELECT        dbo.tbl_kit_Westage.IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo
                FROM            dbo.tbl_kit_Westage INNER JOIN
                                         dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
                WHERE        (dbo.tbl_kit_Westage.IssuanceDate BETWEEN CONVERT(DATETIME, '$date 00:00:00', 102) AND CONVERT(DATETIME, '$date1 00:00:00', 102)) AND (dbo.tbl_kit_Westage.user_id = $user_id)");

		return $query->result_array();
	}

	public function loadWastage($date, $date1)
	{
		$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        dbo.tbl_kit_Westage.IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo
                FROM            dbo.tbl_kit_Westage INNER JOIN
                                         dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
                WHERE        (dbo.tbl_kit_Westage.IssuanceDate BETWEEN CONVERT(DATETIME, '$date 00:00:00', 102) AND CONVERT(DATETIME, '$date1 00:00:00', 102)) AND (dbo.tbl_kit_Westage.user_id = $user_id)");

		return $query->result_array();
	}

	public function Reprinting()
	{
		// view_label_Reprinted
		//$user_id =  $this->session->userdata('user_id');
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT  view_label_Reprinted.*
        From view_label_Reprinted");
		return $query->result_array();
	}

	public function issuedAll($date, $name, $kits)
	{


		$MIS = $this->load->database('MIS', TRUE);
		foreach ($kits as $kitID) {
			$query = $MIS->query("UPDATE tbl_kit_issuance  
             SET   Receivedby  =  '$name',IssueDate  =  '$date'
             WHERE  TID='$kitID'");
		}
		return true;
	}

	public function insertionAllKits($mbalance, $kits, $kitsname, $printDate, $pdate, $PlanType)
	{
		$date = date("Y/m/d H:i:s");
		$user_name =  $this->session->userdata('user_name');
		$MIS = $this->load->database('MIS', TRUE);
		$user_id =  $this->session->userdata('user_id');
		for ($i = 0; $i < count($mbalance); $i++) {
			$query = $MIS->query("INSERT  INTO tbl_kit_issuance
            (PO,KitID,PrintQty,PrintDate,PlanDate,Type,Issuedby,user_id, EntryDate) 
            VALUES ('$kits[$i]', '$kitsname', $mbalance[$i],'$printDate','$pdate','$PlanType','$user_name',$user_id, '$date')");
		}
		return true;
	}
}
