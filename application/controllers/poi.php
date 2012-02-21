<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class POI extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('poi_model');
        $this->load->helper('xml');
    }
    
    function index($host = 1,$limit = 0,$site_rank = 0){
        $data['limit'] = $limit;
	$data['site'] = $this->poi_model->get_site($host,$site_rank);
	$this->load->view('site',$data);
    }
    
    function all($limit = 0){
        $data['sites'] = $this->poi_model->get_all_sites();
	$data['limit'] = $limit;
	$this->load->view('site',$data);
    }
    
    function top($start = 0, $stop = 10, $limit = 0){
        $data['sites'] = $this->poi_model->get_top($start,$stop);
        $data['limit'] = $limit;
        $this->load->view('site',$data);
    }
    
    function top_map($host = 1,$start = 0, $stop = 10){
        $data['map'] = $this->poi_model->get_top_map($host,$start,$stop);
        $this->load->view('top_ten_map',$data);
    }
    function site_table($host = 1){
           $this->load->library('table');
           $data['site_table'] = $this->poi_model->get_site_table();
           $data['host'] = $host;
           $data['title'] = "Point of Interest Table for host# $host";
           $data['main_content'] = 'poi_table';
           $this->load->view('includes/template',$data);
        }
}

