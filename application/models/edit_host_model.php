<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_Host_Model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
        
        function get_host_info($id){
            $this->db->trans_start();
            $host = $this->db->where('id',$id)->get('Host');
            $this->db->trans_complete();
            if($host->num_rows() > 0){
              $mapstr = $this->__toMapString($host);
              $map = "http://maps.googleapis.com/maps/api/staticmap?center=$mapstr&markers=$mapstr&zoom=15&size=768x672&maptype=roadmap&sensor=false";
              $host = $host->row_array();
              $host['map'] = $map;
              return $host;
            }
            else
                return null;
        }
        
        function update_host($id,$host){
            $this->db->trans_start();
            $this->db->where('id',$id)->update('Host',$host);
            $this->db->trans_complete();
        }
        
        function get_map($site_id){
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
			if(isset($add_array[0])) $edit_site_address['street'] = $add_array[0];
			if(isset($add_array[1])) $edit_site_address['district'] = $add_array[1];
			if(isset($add_array[2])) $edit_site_address['town'] = $add_array[2];
			if(isset($add_array[3])) $edit_site_address['parish'] = $add_array[3];
			$edit_site_address['full'] = $this->input->post('address');
            $address = substr($address, 0, -1);
	    $edit_site_address['id'] = $site_id;
            $edit_site_address['map'] = "http://maps.googleapis.com/maps/api/staticmap?center=$address&markers=$address&zoom=$zoom&size=768x672&maptype=roadmap&sensor=false";
			return $edit_site_address;
        }
        
        function __toMapString($host){
            $address = '';
            if(isset($host)){
                foreach ($host->result() as $row){
                   $add_array = explode(',',$row->full); 
                    foreach($add_array as $sec){
                       $sec_array = explode(' ', $sec);
                       foreach($sec_array as $frag){
                           $address .= $frag . '+';
                       }
                        $address = substr($address, 0, -1);
                        $address .=',';
                    }
                    $address = substr($address, 0, -1);
                    $address .="|";
                }
                return substr($address, 0, -1);
            }
            else
                return "";
        }
}