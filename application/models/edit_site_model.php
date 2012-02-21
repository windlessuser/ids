<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_Site_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
        
        function get_site_info($site_id){
            $this->db->trans_start();
            $site = $this->db->select('*')
                        ->from('Site,Address')
                        ->where('Site.id',$site_id)
                        ->where('Address.id',$site_id)
                        ->get()->row_array();
            $test = $this->db->select('*')
                    ->from('Point_Of_interest')
                    ->where('id',$site_id)->get();
            if($test->num_rows() > 0){
                $test = $test->row();
                $site['type'] = 'poi';
                $site['sub_type'] = $test->attraction;
            }else{
               $test = $this->db->select('*')
                    ->from('Dining_And_Nightlife')
                    ->where('id',$site_id)->get();
               if($test->num_rows() > 0){
                   $test = $test->result();
                    $site['type'] = 'diner';
                    $site['sub_type'] = $test->type;
               }else{
                   $test = $this->db->select('*')
                    ->from('Shopping_And_Entertainment')
                    ->where('id',$site_id)->get()->result();
                   $site['type'] = 'shop';
                   $site['sub_type'] = $test->type;
                   
               }
            }
            $this->db->trans_complete();
            return $site;
        }

		function get_name_and_rank($id){
			$this->db->trans_start();
			$this->db->select('name')->from('Site')->where('id',$id);
			$site = $this->db->get();
			$this->db->trans_complete();
			if($site->num_rows() > 0){
                           $site = $site->row_array();
                           $this->db->trans_start();
                           $query = $this->db->select('rank')
                                   ->from('Point_Of_interest')
                                   ->where('id',$id)->get();
                           if($query->num_rows > 0){
                               $query = $query->row();
                               $site['rank'] = $query->rank;
                           }
                           else{
                              $query = $this->db->select('rank')
                                   ->from('Dining_And_Nightlife')
                                   ->where('id',$id)->get();
                              if($query->num_rows > 0){
                               $query = $query->row();
                               $site['rank'] = $query->rank;
                               }
                               else{
                                    $query = $this->db->select('rank')
                                   ->from(' Shopping_And_Entertainment')
                                   ->where('id',$id)->get();
                                    if($query->num_rows > 0){
                                        $query = $query->row();
                                        $site['rank'] = $query->rank;
                               }
                               else
                                   $site['rank'] = 99;
                           }
                           }
                           return $site;
                        }

			else
				return null;
		}
		
		function update_name_and_rank($id,$data){
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('Site',$data);
			$this->db->trans_complete();
		}
		
		function get_address($id){
			$this->db->trans_start();
			$query = $this->db->select('Site.id,full,map')->from('Address,Site')->where('Address.id',$id)->where('Site.id',$id)->get();
			$this->db->trans_complete();
			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return null;
		}
		
		function update_address($id,$site){
			$this->db->trans_start();
			if(isset($site['street'])) $address['street'] = $site['street'];
			if(isset($site['district'])) $address['district'] = $site['district'];
			if(isset($site['town'])) $address['town'] = $site['town'];
			if(isset($site['parish'])) $address['parish'] = $site['parish'];
			$address['full'] = $site['full'];
			$this->db->where('id',$id)->update('Address',$address);
			$map = array('map' => $site['map']);
			$this->db->where('id',$id)->update('Site',$map);
			$this->db->trans_complete();
		}
		
		function get_description($id){
			$this->db->trans_start();
			$site = $this->db->select('description')->from('Site')->where('id',$id)->get()->row_array();
			$test = $this->db->select('*')
                    ->from('Point_Of_interest')
                    ->where('id',$id)->get();
            if($test->num_rows() > 0){
                $test = $test->row();
                $site['type'] = 'poi';
                $site['sub_type'] = $test->attraction;
            }else{
               $test = $this->db->select('*')
                    ->from('Dining_And_Nightlife')
                    ->where('id',$id)->get();
               if($test->num_rows() > 0){
                   $test = $test->result();
                    $site['type'] = 'diner';
                    $site['sub_type'] = $test->type;
               }else{
                   $test = $this->db->select('*')
                    ->from('Shopping_And_Entertainment')
                    ->where('id',$id)->get()->result();
                   $site['type'] = 'shop';
                   $site['sub_type'] = $test->type;    
               }
			}
			$this->db->trans_complete();
			$site['id'] = $id;
			return $site;
		}
			
		function update_description($id,$site){
			$this->db->trans_start();
			$this->db->set('description',trim($site['description']));
			$this->db->where('id',$id);
            $this->db->update('Site');
			if(strcmp($site['type'],'poi') == 0){
                $this->db->set('attraction',$site['sub_type']);
                $this->db->where('id',$id);
                $this->db->update('Point_Of_interest');
             }elseif(strcmp($site['type'],'diner') == 0){
                $this->db->set('type',$site['sub_type']);
                $this->db->where('id',$id);
                $this->db->update('Dining_And_Nightlife');
             }else{
                $this->db->set('type',$site['sub_type']);
                $this->db->where('id',$id);
                $this->db->update('Shopping_And_Entertainment'); 
             }
			$this->db->trans_complete();
		}
		
		function update_image($id,$data){
			$this->db->trans_start();
			$this->db->where('id',$id)->update('Site',$data);
			$this->db->trans_complete();
		}
		
		function get_miscelleanous($id){
			$this->db->trans_start();
			$query = $this->db->select('id,phone,email,url')->from('Site')->where('id',$id)->get();
			$this->db->trans_complete();
			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return null;
		}

		function update_miscelleanous($id,$data){
			$this->db->trans_start();
			$open = $data['open'];
			$close = $data['close'];
			$this->db->set('open',"TIME(STR_TO_DATE('$open', '%h:%i %p'))",FALSE);
			$this->db->set('close',"TIME(STR_TO_DATE('$close', '%h:%i %p'))",FALSE);
			$this->db->set('phone',$data['phone']);
			$this->db->set('email',$data['email']);
			$this->db->set('url',$data['url']);
			$this->db->where('id',$id)->update('Site');
			$this->db->trans_complete();
		}
        
        function site_exists($name){
		$this->db->trans_start();
		$query = $this->db->select('name')->from('Site')->where('name',$name)->get();
		$this->db->trans_complete();
		return $query->num_rows() > 0;
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
        
        function update_data($site){
            $address = $site['address'];
            $this->db->trans_start();
            $this->db->where('id',$site['id']);
            $this->db->update('Address',$address);
            $id = $site['id'];
            $this->db->set('id',$id, FALSE);
            $this->db->set('name', $site['name']);
            $this->db->set('rank',$site['rank']);
            $this->db->set('images',$site['image']);
            $this->db->set('description',trim($site['description']));
			$this->db->set('map', $site['map']);
            $this->db->where('id',$site['id']);
            $this->db->update('Site');
            $this->db->set('id',$id, FALSE);
            if(strcmp($site['type'],'poi') == 0){
                $this->db->set('attraction',$site['sub_type']);
                $this->db->where('id',$site['id']);
                $this->db->update('Point_Of_interest');
             }elseif(strcmp($site['type'],'diner') == 0){
                $this->db->set('type',$site['sub_type']);
                $this->db->where('id',$site['id']);
                $this->db->update('Dining_And_Nightlife');
             }else{
                $this->db->set('type',$site['sub_type']);
                $this->db->where('id',$site['id']);
                $this->db->update('Shopping_And_Entertainment'); 
             }
            $this->db->trans_complete();
        }
}
