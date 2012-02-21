<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_Site_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function site_exists($name){
		$this->db->trans_start();
		$query = $this->db->select('name')->from('Site')->where('name',$name)->get();
		$this->db->trans_complete();
		return $query->num_rows() > 0;
	}
	
	function get_map(){
            $address = '';
            $add_array = explode(',',$this->input->post('address'));
            $zoom = $this->input->post('zoom');
            foreach($add_array as $sec){
               $sec_array = explode(' ', $sec);
               foreach($sec_array as $frag){
                   $address .= $frag . '+';
               }
                $address = substr($address, 0, -1);
                $address .=',';
            }
			if(isset($add_array[0])) $new_site_address['street'] = $add_array[0];
			if(isset($add_array[1])) $new_site_address['district'] = $add_array[1];
			if(isset($add_array[2])) $new_site_address['town'] = $add_array[2];
			if(isset($add_array[3])) $new_site_address['parish'] = $add_array[3];
			$new_site_address['full'] = $this->input->post('address');
            $site = $this->session->userdata('new_site');
            $site['address'] = $new_site_address;
            $this->session->set_userdata('new_site',$site);
             $address = substr($address, 0, -1);
             return "http://maps.googleapis.com/maps/api/staticmap?center=$address&markers=$address&zoom=$zoom&size=768x672&maptype=roadmap&sensor=false";
        }

	function get_cats(){
		$this->db->trans_start();
		$result = $this->db->get('Shop_Categories');
		$this->db->trans_complete();
		return $result->result();
	}
	
	function insert_data(){
            $site = $this->session->userdata('new_site');
            $address = $site['address'];
            $this->db->trans_start();
            $this->db->insert('Address',$address);
            $id = $this->db->select_max('id')->from('Address')->get()->row();
            $this->db->set('id',$id->id, FALSE);
            $this->db->set('name', $site['name']);
            $this->db->set('images',$site['image']);
            $this->db->set('description',trim($site['description']));
			$this->db->set('map', $site['map']);
			$open = $site['open'];
			$close = $site['close'];
			$this->db->set('open',"TIME(STR_TO_DATE('$open', '%h:%i %p'))",FALSE);
            $this->db->set('close',"TIME(STR_TO_DATE('$close', '%h:%i %p'))",FALSE);
			$this->db->set('phone',$site['phone']);
			$this->db->set('email',$site['email']);
			$this->db->set('url',$site['url']);
            $this->db->insert('Site');
            $this->db->set('id',$id->id, FALSE);
            $this->db->set('rank',$site['rank']);
            if(strcmp($site['type'],'poi') == 0){
                $this->db->set('attraction',$site['sub_type']);
                $this->db->insert('Point_Of_interest');
             }elseif(strcmp($site['type'],'diner') == 0){
                $this->db->set('type',$site['sub_type']);
                $this->db->insert('Dining_And_Nightlife');
             }else{
                $this->db->set('type',$site['sub_type']);
                $this->db->insert('Shopping_And_Entertainment'); 
             }
            $this->db->trans_complete();
        }
}