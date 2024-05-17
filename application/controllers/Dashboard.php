<?php

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

    public function index()
	{

        $this->load->view('page_dashboard');
//		$this->load->view('page_login');
		
    }
	public function dailyPrintedDetail(){
		
		$time = date("Y-m-d");
        $time1 = date("Y-m-d");
		$data['getkitsissuanceCount'] =  $this->ID->getkitsissuanceCount($time,$time1);
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}
    public function dashboard()
	{
		
		$time = date("Y-m-d");
        $time1 = date("Y-m-d");
		$date = date("d/m/Y");
		
		$data['getkitsissuanceCount'] =  $this->ID->getkitsissuanceCount($time,$time1);
		$data['getkitsissuanceCountIssuedate'] =  $this->ID->getkitsissuanceCountIssuedate($time,$time1);
		$data['instockData'] =  $this->ID->instockData();
		$data['getkitsissuanceCountPrinted'] =  $this->ID->getkitsissuanceCountPrinted($date);
		$data['issuedkits']=  $this->ID->issuedkits();
		$data['issuedkits1']=  $this->ID->issuedKits1();

		// print_r($data['issuedkits1']);

		$data['Balance'] =  $this->ID->Balance();
		// print_r($data['Balance']);

		$data['getPrintStock'] =  $this->ID->getPrintedStock();

		// print_r($data['getkitsissuanceCount']);
		// die;



		$data['getkitsPrinted'] =  $this->ID->getkitsPrinted();

		$data['getkitsPrinted']=count($data['getkitsPrinted'] );

		$data['getkitsissuanceCount']=count($data['getkitsissuanceCount'] );
		$data['Printed']=0;
		$data['dailyprinted']=0;
		$data['Available']=count($data['instockData']);
		$data['issuedkits']=count($data['issuedkits']);
		$data['getPrintStock']=count($data['getPrintStock']);

        $data['printedkits']=$data['issuedkits']+$data['Available'];
        $data['dailyIssued']=count($data['getkitsissuanceCountPrinted']);
		// $data['issuebalance']=count($data['balance']);
		// foreach($data['instockData'] as $dailyP){
		// 	$data['Available']=$data['Available']+$dailyP['AvailableBalance'];

		// }
		// foreach($data['getkitsissuanceCount'] as $dailyP){
		// 	$data['dailyprinted']=$data['dailyprinted']+$dailyP['KitQty'];

		// }

		$data['issuedkits1']=count($data['issuedkits1']);

		foreach($data['Balance'] as $Balance){
			$newbalance = $Balance['Balance'];
			// print_r($newbalance);

		}
		foreach($data['getkitsissuanceCountPrinted'] as $dailyP){
			$data['Printed']=$data['Printed']+$dailyP['KitQty'];

		}
        $this->load->view('dashboard',$data);
//		$this->load->view('page_login');
		
    }
	
	public function totalKits(){
		
		$data =  $this->ID->totalKits();
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}
	public function issuedKits(){
		
		$data =  $this->ID->issuedKits1();
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}

	public function issuedKitsByDate(){
		
		$data =  $this->ID->issuedKitsByDate($_POST['startDate'], $_POST['endDate']);
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}

	public function instockKits(){
		
		$data =  $this->ID->instockKits();
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}

	public function dailyPrintedKits() {
		$time = date("Y-m-d");
        $time1 = date("Y-m-d");
		$date = date("d/m/Y");
		
		$data =  $this->ID->getkitsissuanceCount($time,$time1);
		
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}
	public function dailyIssued(){
		$time = date("Y-m-d");
        $time1 = date("Y-m-d");
		$date = date("d/m/Y");
		
		$data =  $this->ID->getkitsissuanceCountPrinted($date);
		return $this->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($data));
	}
  /*  
    public function dashboard(){
        $this->load->view('page_dashboard');        
    }

    public function process_login(){

        $user = $this->input->post('username');
		$password = $this->input->post('password');
		$this->ID->loginn($user, $password);
	
		if($this->session->has_userdata('user_id')){
			if($password=='123'){
				redirect('changepwd');
			}else{
			redirect('login/dashboard');
			}

		}
    }

	public function logout()
    {
		$this->session->sess_destroy();
		redirect('');
    }
*/

}