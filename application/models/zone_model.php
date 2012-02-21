<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zone_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}

	function zone_exists($zone){
		$test = $this->db->where('name',$zone)->get('Zone');
		return $test->num_rows() == 1;
	}

	function insert_zone($zone){
		$this->db->set('name',$zone);
		$this->db->insert('Zone');
	}

	function remove_zone($id){
		$this->where('id',$id)->delete('Zone');	
	}

	function get_zone($id){
		return $this->db->where('id',$id)
				->select('name')
				->from('Zone')
				->get()->row();
	}

	function get_zones(){
		return $this->db->get('Zone')->result();	
	
	}

	
}
