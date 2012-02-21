<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Admin Page';
		if(!$this->session->userdata('is_logged_in'))
			$data['main_content'] = 'login_form';
		else
			$data['main_content'] = 'admin';
		$this->load->view('includes/template', $data);	
	}
	
	function validate_credentials(){
		$this->load->model('user_model');
		$query = $this->user_model->validate();
		
		if($query){ // if the user's credentials validated...
			$this->session->set_userdata('is_logged_in',true);
			$this->session->set_userdata('zone','Kingston');
			$this->session->set_userdata('user',$this->input->post('username'));
			redirect('admin');
		}
		else // incorrect username or password
		{
			$data['title'] = 'Admin Page';
			$data['main_content'] = 'login_form';
			$this->load->view('includes/template', $data);	
		}
	}
        
        function site_maintenance(){
            $data['title'] = 'Admin Page - Site';
            $data['main_content'] = 'site_maintenance';
            $this->load->view('includes/template', $data);  
        }
      
        
        function host_maintenance(){
            $data['title'] = 'Admin Page - Host';
            $data['main_content'] = 'host_maintenance';
            $this->load->view('includes/template', $data);  
        }
        
        function event_maintenance(){
            $data['title'] = 'Admin Page - Event';
            $data['main_content'] = 'event_maintenance';
            $this->load->view('includes/template', $data);  
        }
        
        function poi_maintenance(){
            $data['title'] = 'Admin Page - Point of Interest';
            $data['main_content'] = 'poi_maintenance';
            $this->load->view('includes/template', $data); 
        }
        
        function diner_maintenance(){
            $data['title'] = 'Admin Page - Dining And Nightlife';
            $data['main_content'] = 'diner_maintenance';
            $this->load->view('includes/template', $data); 
        }
        
        function shop_maintenance(){
            $data['title'] = 'Admin Page - Shopping And Transportation';
            $data['main_content'] = 'shop_maintenance';
            $this->load->view('includes/template', $data); 
        }
        
        function flightstats(){
            $data['title'] = 'Admin Page - Flight Statistics';
            $data['main_content'] = 'flightstats';
            $this->load->view('includes/template', $data); 
        }

	function zone_maintenance(){
	    $data['title'] = 'Admin Page - Zones';
            $data['main_content'] = 'zone_maintenance';
            $this->load->view('includes/template', $data); 	
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin');
	}
	
}
