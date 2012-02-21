<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('site_model');
        $this->load->helper('xml');
	}
	
	function index($host = 1,$type = 0,$site_rank = 0){
		$data['limit'] = 1;
		$data['site'] = $this->site_model->get_site($host,$type,$site_rank);
		$this->load->view('site',$data);
	}
	
	function all($limit = 0){
		$data['sites'] = $this->site_model->get_all_sites($limit);
		$data['limit'] = $limit;
		$this->load->view('site',$data);
	}
        
        function top_ten($limit = 0){
           $data['sites'] = $this->site_model->get_top_ten($limit);
           $data['limit'] = $limit;
           $this->load->view('site',$data);    
        }
        
        function top_ten_map($host_id =  1){
            $data['map'] = $this->site_model->get_top_ten_map($host_id);
	    	$this->load->view('top_ten_map',$data);
        }
		
		function top_11_20($limit = 0){
           $data['sites'] = $this->site_model->get_top_11_20($limit);
           $data['limit'] = $limit;
		   //echo $this->db->last_query();
           $this->load->view('site',$data);    
        }
        
        function poi($limit = 0){
           $data['sites'] = $this->site_model->get_points_of_interest($limit);
           $data['limit'] = $limit;
	   	   $this->load->view('site',$data); 
        }
		
		function top_ten_poi($limit = 0){
			$data['sites'] = $this->site_model->get_top_ten_poi($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}
		
		function top_11_20_poi($limit = 0){
			$data['sites'] = $this->site_model->get_top_11_20_poi($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}
        
        function poi_map($host_id = 0){
            $data['map'] = $this->site_model->get_poi_map($host_id);
	    	$this->load->view('top_ten_map',$data);
        }
		
		function diner($limit = 0){
			$data['sites'] = $this->site_model->get_dining_and_nightlife($limit);
           	$data['limit'] = $limit;
			//echo $this->db->last_query();
	   	   	$this->load->view('site',$data);
		}
		
		function top_ten_diner($limit = 0){
			$data['sites'] = $this->site_model->get_top_ten_diner($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}
		
		function top_11_20_diner($limit = 0){
			$data['sites'] = $this->site_model->get_top_11_20_diner($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}
		
		function diner_map($host_id = 0){
            $data['map'] = $this->site_model->get_diner_map($host_id);
	    	$this->load->view('top_ten_map',$data);
        }
		
		function shop($limit = 0){
           $data['sites'] = $this->site_model->get_shopping_and_entertainment($limit);
           $data['limit'] = $limit;
	   	   $this->load->view('site',$data); 
        }
		
		function top_ten_shop($limit = 0){
			$data['sites'] = $this->site_model->get_top_ten_shop($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}
		
		function top_11_20_shop($limit = 0){
			$data['sites'] = $this->site_model->get_top_11_20_shop($limit);
           	$data['limit'] = $limit;
	   	   	$this->load->view('site',$data);
		}

		function shop_map($host_id = 0){
            $data['map'] = $this->site_model->get_shop_map($host_id);
	    	$this->load->view('top_ten_map',$data);
        }
		    
        function site_table($host = 1){
           $this->load->library('table');
           $data['site_table'] = $this->site_model->get_site_table();
           $data['host'] = $host;
           $data['title'] = "Site Table for host# $host";
           $data['main_content'] = 'site_table';
           $this->load->view('includes/template',$data);
        }
		
		function poi_table($host = 1){
			$this->load->library('table');
           $data['site_table'] = $this->site_model->get_poi_table();
           $data['host'] = $host;
           $data['title'] = "Site Table for host# $host";
           $data['main_content'] = 'site_table';
           $this->load->view('includes/template',$data);
		}
		
		function diner_table($host = 1){
			$this->load->library('table');
           $data['site_table'] = $this->site_model->get_diner_table();
           $data['host'] = $host;
           $data['title'] = "Site Table for host# $host";
           $data['main_content'] = 'site_table';
           $this->load->view('includes/template',$data);
		}
		
		function shop_table($host = 1){
		   $this->load->library('table');
           $data['site_table'] = $this->site_model->get_shop_table();
           $data['host'] = $host;
           $data['title'] = "Site Table for host# $host";
           $data['main_content'] = 'site_table';
           $this->load->view('includes/template',$data);
		}
        
        function delete_site($host,$id){
            $this->site_model->remove_site($id);
            redirect("admin");
	}
		
}