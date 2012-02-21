<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_site Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
			redirect('admin');			
	}
	
	function index(){
		$data['title'] = 'Create new Site';
		$data['main_content'] = 'new_site';
		$this->load->view('includes/template', $data);
	}
	
	function site_name(){
            $this->load->model('new_site_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('rank', 'Rank', 'required|trim|is_natural_no_zero');
            if ($this->form_validation->run()){
                if(!$this->new_site_model->site_exists($this->input->post('name'))){
                    $site['name']= $this->input->post('name');
                    $site['type']= $this->input->post('type');
                    $site['rank']= $this->input->post('rank');
                    $this->session->set_userdata('new_site',$site);
                    $data['title'] = 'Admin Page - Address for ' . $this->input->post('name');
                    $data['home'] = 'http://maps.googleapis.com/maps/api/staticmap?center=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&markers=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&zoom=14&size=400x300&maptype=roadmap&sensor=false';
                    $data['main_content'] = 'new_site_address';
                    $this->load->view('includes/template', $data);	
		}else{
                    $data['title'] = 'Create new Site';
                    $data['main_content'] = 'new_site';
                    $data['error'] = '<p>Site Already Exists</p>';
                    $this->load->view('includes/template', $data);	 
                 }
            }else{
		$data['title'] = 'Create new Site';
		$data['main_content'] = 'new_site';
		$this->load->view('includes/template', $data);	
            }
	}

	function get_map(){
		$this->load->model('new_site_model');
            $map = $this->new_site_model->get_map();
            $site = $this->session->userdata('new_site');
            $site['map'] = $map;
            $data['title'] = 'Create new site - Address for '.$site['name'];
            $data['main_content'] = 'new_site_address';
            $data['map'] = $map;
            $data['home'] = $map;
            $this->load->view('includes/template', $data);      
        }
		
     function conf_map(){
     	$this->load->model('new_site_model');
           $site = $this->session->userdata('new_site');
           if($this->input->post('yes')){
           	 	$map = $this->input->post('map');
				$site['map'] = $map;
			   $this->session->set_userdata('new_site',$site);	   
               $data['title'] = 'Create new Site - Description for '.$site['name'];
			   $data['site'] = $site;
			   if(strcasecmp($site['type'],'shop') == 0){
			   	$data['categories'] = $this->new_site_model->get_cats();
			   }
               $data['main_content'] = 'new_site_description';
               $this->load->view('includes/template', $data);  
           }
           else{
                $data['title'] = 'Create new Site - Address for '.$site['name'];
                $data['main_content'] = 'new_site_address';
                $data['map'] = $this->input->post('map');
                $data['home'] = $this->input->post('map');
                $this->load->view('includes/template', $data); 
           }
        }
		
	function description(){
            $this->load->model('new_site_model');
            $desc =  $this->input->post('description');
            $tp = $this->input->post('type');
            $site = $this->session->userdata('new_site');
            $site['description'] = $desc;
            $site['sub_type'] = $tp;
            $this->session->set_userdata('new_site',$site);
            $data['title'] = 'create new site - Image for '.$site['name'];
            $data['main_content'] = 'new_site_image';
            $this->load->view('includes/template', $data);
        }
        
        function image(){
        	$this->load->model('new_site_model');
            $site = $this->session->userdata('new_site');
            $config['upload_path'] = '/var/www/ids/images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('image'))
            {
                   $data['error'] = $this->upload->display_errors();

                   $data['title'] = 'Create new Site - Image for '.$site['name'];
                   $data['main_content'] = 'new_site_image';
                   $this->load->view('includes/template', $data);
            }
            else
            {
                    $data = $this->upload->data();
                    $site['image'] = site_url('images/'.$data['file_name']);
                    $this->session->set_userdata('new_site',$site);
                    unset($data);
					$data['title'] = 'create new site - miscelleanous data for '.$site['name'];
            		$data['main_content'] = 'new_site_miscellaneous';
            		$this->load->view('includes/template', $data);
                    
            }
        }

		function miscelleanous(){
			$this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[7]|max_length[9]');
			if ($this->form_validation->run()){
				$site = $this->session->userdata('new_site');
				$open = $this->input->post('open_hour') . ':' .$this->input->post('open_min') .' '.$this->input->post('open_am_pm');
				$close = $open = $this->input->post('close_hour') . ':' .$this->input->post('close_min') .' '.$this->input->post('close_am_pm');
				$site['open'] = $open;
				$site['close'] = $close;
				$site['phone'] = $this->input->post('phone');
				$site['email'] = $this->input->post('email');
				$site['url'] = $this->input->post('url');
				$this->session->set_userdata('new_site',$site);
				redirect('new_site/insert_data');
			}
			else{
				  $site = $this->session->userdata('new_site');
                  $data['title'] = 'create new site - miscelleanous data for '.$site['name'];
            	  $data['main_content'] = 'new_site_miscellaneous';
            	  $this->load->view('includes/template', $data);
			}
		}
        
        function insert_data(){
            $this->load->model('new_site_model');
            $this->new_site_model->insert_data();
            $this->session->unset_userdata('new_site');
            redirect('host');
        }
}