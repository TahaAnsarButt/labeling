<?php

class Project extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AMS', 'ID');
		$this->load->library('session');
	}

    public function index()
	{
 
		$data['ProjectValues'] = $this->ID->getProjectValues();
		$data['DepartmentValues'] = $this->ID->CallDept();
		$data['ProValues'] = $this->ID->CallProject();
    
        $this->load->view('add_project', $data);

//		$this->load->view('page_login');
		
    }

    public function Report(){
        //$data['ProValues'] = $this->ID->getReport();

		
		

        $this->load->view('Report');

    }
	


}
