<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_site Extends CI_Controller{
		
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
			redirect('admin');
        $this->load->model('edit_site_model');
	}
        function index($site_id){
            $site = $this->edit_site_model->get_name_and_rank($site_id);
            $data['title'] = 'Edit Site';
            $data['main_content'] = 'edit_site';
            $site['id'] = $site_id;
            $data['site'] = $site;
            $this->load->view('includes/template', $data);
        }
        
        function site_name($site_id){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('rank', 'Rank', 'required|trim|is_natural_no_zero');
            if ($this->form_validation->run()){
                    if(!$this->input->post('ignore_name')) $site['name'] = $this->input->post('name');
                    if(!$this->input->post('ignore_rank')) $site['rank'] = $this->input->post('rank');
                    if(isset($site)) $this->edit_site_model->update_name_and_rank($site_id,$site);
                    $data['title'] = 'Edit Site - Address for ' . $this->input->post('name');
                    $data['home'] = 'http://maps.googleapis.com/maps/api/staticmap?center=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&markers=Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica&zoom=14&size=400x300&maptype=roadmap&sensor=false';
                    $data['main_content'] = 'edit_site_address';
					$data['site'] =  $this->edit_site_model->get_address($site_id);
                    $this->load->view('includes/template', $data);
            }else{
		$data['title'] = 'Edit Site';
		$data['main_content'] = 'edit_site';
		$site = $this->edit_site_model->get_name_and_rank($site_id);
		$site['id'] = $site_id;
		$data['site'] = $site;
		$this->load->view('includes/template', $data);	
            }
	}
        
        function get_map($site_id){
        	if($this->input->post('ignore')){
        	   $site = $this->edit_site_model->get_description($site_id);
			   $site['id'] = $site_id;
			   $data['site'] = $site;
			   $data['title'] = 'Edit Site - Description';
               $data['main_content'] = 'edit_site_description';
               $this->load->view('includes/template', $data);  
           } else{
	            $site = $this->edit_site_model->get_map($site_id);
	            $data['title'] = 'Edit Site - Address';
	            $data['main_content'] = 'edit_site_address';
	            $data['map'] = $site['map'];
	            $data['home'] = $site['map'];
		        $data['site'] = $site;
	            $this->load->view('includes/template', $data);
		   }     
        }
		
     function conf_map($site_id){
           if($this->input->post('yes')){	   
               $data['title'] = 'Edit Site - Description';
               $data['main_content'] = 'edit_site_description';
			   $site = $this->input->post('site');
			   $this->edit_site_model->update_address($site_id,$site);
			   $site = $this->edit_site_model->get_description($site_id);
			   $site['id'] = $site_id;
			   $data['site'] = $site;
               $this->load->view('includes/template', $data);  
           }
           else{
                $data['title'] = 'Edit Site - Address';
                $data['main_content'] = 'edit_site_address';
                $data['map'] = $this->input->post('map');
                $data['home'] = $this->input->post('map');
				$data['site'] = $this->edit_site_model->get_address($site_id);
                $this->load->view('includes/template', $data); 
           }
        }
		
	function description($site_id){
             if(!$this->input->post('ignore_desc')) $site['description'] = $this->input->post('description');
             if(!$this->input->post('ignore_sub')) $site['sub_type'] = $this->input->post('sub_type');
			 if(isset($site)){
			 	$site['type'] = $this->input->post('type');
				$this->edit_site_model->update_description($site_id,$site);
				unset($site);
			 }
            $data['title'] = 'Edit Site - Image';
            $data['main_content'] = 'edit_site_image';
			$site['id'] = $site_id;
			$data['site'] = $site;
            $this->load->view('includes/template', $data);
        }
        
        function image($site_id){
        	if($this->input->post('ignore')){
        		$data['title'] = 'Edit Site - miscelleanous';
				$data['site'] = $this->edit_site_model->get_miscelleanous($site_id);
                $data['main_content'] = 'edit_site_miscellaneous';
                $this->load->view('includes/template', $data);
        	} else{
	            $config['upload_path'] = '/var/www/ids/images/';
	            $config['allowed_types'] = 'gif|jpg|png';
	            $config['overwrite'] = true;
	            
	            $this->load->library('upload', $config);
	            
	            if ( ! $this->upload->do_upload('image'))
	            {
	                   $data['error'] = $this->upload->display_errors();
	
	                   $data['title'] = 'Edit Site - Image';
	                   $data['main_content'] = 'edit_site_image';
	                   $this->load->view('includes/template', $data);
	            }
	            else
	            {
	                    $data = $this->upload->data();
	                    $site['images'] = site_url('images/'.$data['file_name']);
			            $this->edit_site_model->update_image($site_id,$site);
					   unset($data);
	                   $data['title'] = 'Edit Site - miscelleanous';
					   $data['site'] = $this->edit_site_model->get_miscelleanous($site_id);
	                   $data['main_content'] = 'edit_site_miscellaneous';
	                   $this->load->view('includes/template', $data);
	                    
	            }
            }
        }
		
		function miscelleanous($site_id){
			$this->load->library('form_validation');
                        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            			$this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[7]|max_length[9]');
			if ($this->form_validation->run()){
				$open = $this->input->post('open_hour') . ':' .$this->input->post('open_min') .' '.$this->input->post('open_am_pm');
				$close = $open = $this->input->post('close_hour') . ':' .$this->input->post('close_min') .' '.$this->input->post('close_am_pm');
				if(!$this->input->post('ignore_open')) $site['open'] = $open;
				if(!$this->input->post('ignore_close')) $site['close'] = $close;
				if(!$this->input->post('ignore_phone')) $site['phone'] = $this->input->post('phone');
				if(!$this->input->post('ignore_email'))$site['email'] = $this->input->post('email');
				if(!$this->input->post('ignore_url')) $site['url'] = $this->input->post('url');
				if(isset($site)) $this->edit_site_model->update_miscelleanous($site_id,$site);
				redirect('host');
			}
			else{
                  $data['title'] = 'Edit site - miscelleanous data';
            	  $data['main_content'] = 'edit_site_miscellaneous';
				  $data['site'] = $this->edit_site_model->get_miscelleanous($site_id);
            	  $this->load->view('includes/template', $data);
			}
		}
        
        function insert_data(){
            $this->edit_site_model->insert_data($this->site);
            redirect('host');
        }
}