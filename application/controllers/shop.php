<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('shop_model');
        $this->load->helper('xml');
    }
    
    function index($host = 1,$limit = 0,$site_rank = 0){
        $data['limit'] = $limit;
	$data['site'] = $this->shop_model->get_site($host,$site_rank);
	$this->load->view('site',$data);
    }
    
    function all($limit = 0){
        $data['sites'] = $this->shop_model->get_all_sites();
	$data['limit'] = $limit;
	$this->load->view('site',$data);
    }
    
    function top($start = 0, $stop = 10, $limit = 0){
        $data['sites'] = $this->shop_model->get_top($start,$stop);
        $data['limit'] = $limit;
        $this->load->view('site',$data);
    }
    
    function top_map($host = 1,$start = 0, $stop = 10){
        $data['map'] = $this->shop_model->get_top_map($host,$start,$stop);
        $this->load->view('top_ten_map',$data);
    }
	
	function xml_feeds(){
		$data['title'] = "Shopping and Transportation";
		$data['main_content'] = 'shop_xml';
		$this->load->view('includes/template',$data);
	}
	
	function map_feeds(){
		$data['title'] = "Shopping and Transportation";
		$data['main_content'] = 'shop_map_xml';
		$this->load->view('includes/template',$data);
	}
	
	function categories(){
		$this->load->model('new_site_model');
		$data['categories'] = $this->new_site_model->get_cats();
		$data['title'] = "Shopping Categories";
		$data['main_content'] = 'shop_cats';
		$this->load->view('includes/template',$data);
	}

	function cats($id = 1, $limit=0){
		$data['sites'] = $this->shop_model->get_sub_cat_feeds($id);
		$data['limit'] = $limit;
		$this->load->view('site',$data);
	}
    
    function site_table($host = 1){
           $this->load->library('table');
           $data['site_table'] = $this->shop_model->get_site_table();
           $data['host'] = $host;
           $data['title'] = "Shopping and Transportation Table for host# $host";
           $data['main_content'] = 'shop_table';
           $this->load->view('includes/template',$data);
        }
}

