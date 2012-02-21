<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index($name){
		$this->load->model('site_model');
		$data['site'] = $this->site_model->get_site($name);
		$this->load->view('site',$data);
	}
	
	function all(){
		$this->load->model('site_model');
		$data['sites'] = $this->site_model->get_all_sites();
		var_dump($data);
		$this->load->view('site',$data);
	}
	
}