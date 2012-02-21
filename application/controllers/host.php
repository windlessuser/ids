<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Host Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
		redirect('admin');
	}
	
	function index(){
		$this->load->model('host_model');
		   $this->load->library('table');
           $data['host_table'] = $this->host_model->get_host_table();
           $zone = $this->session->userdata('zone');
           $data['title'] = "Host Table for zone: $zone";
           $data['main_content'] = 'host_table';
           $this->load->view('includes/template',$data);
	}
	
	function add_host(){
            $data['title'] = 'Host - Add Host';
            $data['home'] = 'http://maps.googleapis.com/maps/api/staticmap?center=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&markers=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&zoom=14&size=400x300&maptype=roadmap&sensor=false';
            $data['main_content'] = 'add_host';
            $this->load->view('includes/template', $data);
	}
	
	function conf_host_map(){
            $this->load->model('new_site_model');
            $map = $this->new_site_model->get_map();
            $name = $this->input->post('name');
            $host = $this->session->userdata('new_site');
            $host['name'] = $name;
            $host['map'] = $map;
            $this->session->set_userdata('new_host',$host);
            $data['title'] = 'Host - Add host ';
            $data['main_content'] = 'add_host';
            $data['map'] = $map;
            $data['home'] = $map;
            $this->load->view('includes/template', $data); 
	}
        
        function insert_host(){
        	$this->load->model('host_model');
            if($this->input->post('yes')){
               $this->host_model->add_host();
               redirect('host');
           }
           else{
                $data['title'] = 'Admin Page - Add host';
                $data['main_content'] = 'add_host';
                $data['map'] = $this->input->post('map');
                $data['home'] = $this->input->post('map');
                $this->load->view('includes/template', $data); 
           }
        }
	
	function delete_host($id){
		$this->load->model('host_model');
			$this->host_model->remove_host($id);
			redirect('host');
		}

}
