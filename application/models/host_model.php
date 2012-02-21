<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Host_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function add_host(){
            $host = $this->session->userdata('new_host');
            $address = $host['address'];
            $address['name'] = $host['name'];
            $this->db->trans_start();
            $this->db->insert('Host',$address);
            $this->db->trans_complete();
        }
	
	function remove_host($id){
			$this->db->trans_start();
			$this->db->where('id',$id)->delete('Host');
			$this->db->trans_complete();
		}
	
	function get_host_table(){
            $this->db->trans_start();
            $this->db->select('id,name')->from('Host')->order_by('id','asc')->like('full',$this->session->userdata('zone'));
            $hosts= $this->db->get();
            $this->db->trans_complete();
            if($hosts->num_rows > 0)
               return $hosts;
            else
               return null;
		}
}
