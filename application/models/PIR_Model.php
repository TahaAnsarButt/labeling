<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PIR_Model extends CI_Model
{

    public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        
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


	public function getAll($date1, $date2)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT       *
FROM            dbo.view_label_Days1
WHERE        (PlanDate1 BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) AND CONVERT(DATETIME, '$date2 00:00:00', 102))");
		return $query->result_array();
	}

	public function getAllcanceled($date1, $date2)
	{
		$MIS = $this->load->database('MIS', TRUE);
		$query = $MIS->query("SELECT        TOP (100) PERCENT DATEDIFF(dd, PlanDate, IssueDate) AS Days, SerialNo AS KitName, POCode, KitQty, CONVERT(varchar, IssueDate, 103) AS IssueDate, CONVERT(varchar, PlanDate, 103) AS IssuanceDate, 
		CASE WHEN DATEDIFF(dd, PlanDate, IssueDate) = 0 THEN '' ELSE '10' END AS KeyNum, PlanDate AS PlanDate1, Cancel, ReceiveDate
FROM            dbo.view_All_Kits_Data
WHERE        (Cancel = 1) AND (PlanDate BETWEEN CONVERT(DATETIME, '$date1 00:00:00', 102) AND CONVERT(DATETIME, '$date2 00:00:00', 102))");
		return $query->result_array();
	}

	public function cancel($ReceiveDate, $POCode, $AuditMonth, $ReceivedBy)
	{
		$MIS = $this->load->database('MIS', TRUE);
		// print_r($POCode);
	$query = $MIS->query("UPDATE dbo.tbl_Pro_PO_H SET ReceiveDate = '$ReceiveDate', Cancel = 1, AuditMonthID=$AuditMonth, ReceivedBy='$ReceivedBy' WHERE POCode = '$POCode'");
	return $query;
	}
    
}
