<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index($name = "",$limit = 0){
		//$this->output->cache(10);
		$this->load->model('site_model');
		$data['limit'] = $limit;
		$data['site'] = $this->site_model->get_site($name,$limit);
		$this->load->view('site',$data);
	}
	
	function all($limit = 0){
		//$this->output->cache(60);
		$this->load->model('site_model');
		$data['sites'] = $this->site_model->get_all_sites($limit);
		$data['limit'] = $limit;
		$this->load->view('site',$data);
	}
        
        function top_ten($limit){
           $this->load->model('site_model');
           $data['sites'] = $this->site_model->get_top_ten_sites($limit);
           $data['limit'] = $limit;
           $this->load->view('site',$data);    
        }
        
        function top_ten_map($host_id){
            $this->load->model('site_model');
            redirect($this->site_model->get_top_ten_sites($limit));
        }
	
}