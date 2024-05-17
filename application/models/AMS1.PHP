<?php 
class AMS1 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }


    public function insertWastage($kit, $Bal, $wastage, $issueDate, $wastageDes, $auditID)
    {

        //         echo($auditID);
        // die;
        $user_id =  $this->session->userdata('user_id');
        $MIS = $this->load->database('MIS', TRUE);
        $query = $MIS->query("INSERT INTO  dbo.tbl_kit_Westage (KitID,KitQty, IssuanceDate,Wastage,westage_description,AuditID,user_id)
                VALUES ($kit,$Bal, '$issueDate', $wastage,'$wastageDes', $auditID ,$user_id)");


        if ($query) {
            return true;
        } else {
            return false;
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

    public function getKits()
    {

        $MIS = $this->load->database('MIS', TRUE);
        //         $query = $MIS->query("SELECT       view_Final_Kits.*
        // FROM            view_Final_Kits");
        //         return $query->result_array();
        $query = $MIS->query("SELECT        view_Kits_Ready_for_use.* FROM            dbo.view_Kits_Ready_for_use
ORDER BY RecID");
        return $query->result_array();
    }
    
    public function getAssetChart()
    {
        $query = $this->db->query('  SELECT *
    FROM view_chart_Of_Asset');
        return $query->result_array();
    }



    public function getAssetTypes()
    {
        $query = $this->db->query('  SELECT *
               FROM tbl_Asserts_Type ');
        return $query->result_array();
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

    public function getAuditID1($AUDIT_ID)
    {
        $user_id = $this->session->userdata('user_id');
        $MIS = $this->load->database('MIS', TRUE);

        // Use parameterized query to prevent SQL injection
        $query = $MIS->query("SELECT AuditMonth, TID FROM dbo.tbl_labeling_audit WHERE TID=$AUDIT_ID");

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

    public function getKitbalance($Kits)
    {

        $MIS = $this->load->database('MIS', TRUE);
        return  $MIS
            ->where("RecID", $Kits)
            ->get("view_Kits_Ready_for_use")
            ->result();
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

    public function loadWastageAudit($AuditID)
    {
        $user_id =  $this->session->userdata('user_id');
        $MIS = $this->load->database('MIS', TRUE);
        $query = $MIS->query("SELECT        dbo.tbl_kit_Westage.IssuanceDate, dbo.tbl_kit_Westage.westage_description, dbo.tbl_kit_Westage.Wastage, dbo.tbl_kit_Westage.user_id, dbo.tbl_kit_Westage.TID, dbo.tbl_kit_Westage.KitID, dbo.View_Label.SerialNo
                FROM            dbo.tbl_kit_Westage INNER JOIN
                                         dbo.View_Label ON dbo.tbl_kit_Westage.KitID = dbo.View_Label.RecID
                WHERE        AuditID = '$AuditID'");

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

}
?>