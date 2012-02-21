<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_Host Extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_logged_in'))
            redirect('admin');
        $this->load->model('edit_host_model');
    }
    
    function index($id){
            $host = $this->edit_host_model->get_host_info($id);
            $data['title'] = 'Edit Site - Address';
            $data['main_content'] = 'edit_host';
            $data['map'] = $host['map'];
            $data['home'] = $host['map'];
            $data['id'] = $id;
	    $data['old_host'] = $host;
            $this->load->view('includes/template', $data); 
    }
    
    function conf_host_map($id){
            $old_host = $this->edit_host_model->get_map($id);
            $data['old_host'] = $old_host;
            $name = $this->input->post('name');
            $data['title'] = 'Host - edit_host ';
            $data['main_content'] = 'edit_host';
            $data['map'] = $old_host['map'];
            $data['home'] = $old_host['map'];
            $data['id'] = $id;
            $this->load->view('includes/template', $data); 
	}
        
        function update_host($id){
            if($this->input->post('yes')){
               $host = $this->input->post('host');
               $this->edit_host_model->update_host($id,$host);
               redirect('host');
           }
           else{
                $data['title'] = 'Admin Page - Edit host';
                $data['main_content'] = 'add_host';
                $data['map'] = $this->input->post('map');
                $data['home'] = $this->input->post('map');
                $this->load->view('includes/template', $data); 
           }
        }
    
}