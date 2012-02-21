<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event Extends CI_Controller{

    function __construct()
	{
            parent::__construct();
            if(!$this->session->userdata('is_logged_in'))
		redirect('admin');
            $this->load->model('event_model');
	}
        
    function index(){
        $data['title'] = 'Add Event';
        $data['main_content'] = 'new_event';
		$companies = $this->event_model->get_companies();
		if(!isset($companies)) redirect('event/add_company');
		$data['companies'] = $companies;
        $this->load->view('includes/template', $data);   
    }
    
    function add_event(){
      $this->event_model->insert_event();
      redirect('admin');
    }
	
	function add_company(){
		$data['title'] = 'Add Event';
        $data['main_content'] = 'new_company';
        $this->load->view('includes/template', $data);   
	}
	
	function add_company_commit(){
		$this->event_model->insert_company();
		redirect('event');
	}
	
	function company_events($id){
		$data['events'] = $this->event_model->get_company_events($id);
		$this->load->view('event',$data);
		
	}
    
    function remove($id){
        $this->event_model->delete_event($id);
        redirect('event/table');
    }
    
    function edit($id){
        $data['title'] = 'Edit Event';
        $data['main_content'] = 'edit_event';
        $data['event'] = $this->event_model->get_event($id);
		$companies = $this->event_model->get_companies();
		if(!isset($companies)) redirect('event/add_company');
		$data['companies'] = $companies;
        $this->load->view('includes/template', $data);       
    }
    
    function edit_commit($id){
        $this->event_model->edit_event($id);
        redirect('event/table');
    }
    
    
    function xml(){
        $data['events'] = $this->event_model->get_events();
        $this->load->view('event',$data);
    }
    
    function table(){
        $this->load->library('table');
        $data['events'] = $this->event_model->get_events();
        $data['title'] = "Events Table";
        $data['main_content'] = 'event_table';
        $this->load->view('includes/template',$data); 
    }
    
    
}