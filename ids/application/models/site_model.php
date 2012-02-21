<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function get_site($name){
		
		$this->db->select('name,url,description,images,rank')->from('Site')->where('name',$name);
		return $this->db->get()->result();
		
	}
	
	function get_all_sites(){
		return $this->db->select('name,url,description,images,rank')->from('Site')->get()->result();
	}
}