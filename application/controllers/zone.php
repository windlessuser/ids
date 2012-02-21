<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zone Extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
			redirect('admin');
		$this->load->model('zone_model');			
	}

	function index(){
	   $this->load->library('table');
           $data['zones'] = $this->zone_model->get_zones();
           $data['title'] = "Zone table";
           $data['main_content'] = 'zone_table';
           $this->load->view('includes/template',$data);
	}


	function new_zone(){
		$data['title'] = 'Add new Zone';
		$data['main_content'] = 'new_zone';
		$this->load->view('includes/template', $data);
	}

	function add_zone(){
		$zone = trim($this->input->post('zone'));
		if(!$this->zone_model->zone_exists($zone)){
			$this->zone_model->insert_zone($zone);
			redirect('zone');
		}
	}

	function remove_zone($id){
		$this->zone_model->delete_zone($id);
		redirect('zone');
	}

	function change_zone($id){
		$zone = $this->zone_model->get_zone($id);
		$this->session->set_userdata('zone',$zone->name);
		redirect('admin');
	}


}
