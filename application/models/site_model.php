<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function get_site($host,$type,$rank){
        $this->db->trans_start();
        $this->db->select("Site.id,name,url,description,images,rank,map,TIME_FORMAT( open, '%h:%i %p' ) as open, TIME_FORMAT( close, '%h:%i %p' ) as close,phone,email,url,street,town,district,parish,full",FALSE)
                ->from('Site')
                ->join('Address','Address.id = Site.id','left');
        if($type == 1){
            $this->db->join('Point_Of_interest','Point_Of_interest.id = Site.id','left')
                  ->where('Point_Of_interest.rank',$rank,FALSE);
        }
        else{
            if($type == 2){
                $this->db->join('Dining_And_Nightlife','Dining_And_Nightlife.id = Site.id','left')
                        ->where('Dining_And_Nightlife.rank',$rank,FALSE);
            }
            else{
                $this->db->join('Shopping_And_Entertainment','Shopping_And_Entertainment.id = Site.id','left')
                ->where('Shopping_And_Entertainment.rank',$rank,FALSE);
            }
        }
                
        $site = $this->db->get();
        $this->db->trans_complete();
        if($site->num_rows() > 0){
            $site = $site->row_array();
            $this->db->trans_start();
            $this->db->set('count','count + 1',FALSE)
                    ->where('id',$site['id'])
                    ->update('Site');
            $this->db->trans_complete();
            return $site;
        }
        else
            return null;
    }
	
	function get_all_sites($data){
		if($data == 1){
			$this->db->trans_start();
			 $this->db->select("name,url,description,count,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
					->like('full',$this->session->userdata('zone'))
					->order_by('count','desc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
			$this->db->order_by('name','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
	}
        function get_top_ten($limit){
         	if($limit == 1){
			$this->db->trans_start();
			 $this->db->select("name,url,description,images,count,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
					->like('full',$this->session->userdata('zone'))
                    ->limit(10);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
			}
			else{
				$this->db->trans_start();
				$this->db->select('name,url,description,images,rank')->from('Site');
				$this->db->join('Address', 'Address.id = Site.id', 'left');
	            $this->db->where('rank <=',10);
				$this->db->order_by('rank','asc');
	            $this->db->limit(10);
				$query = $this->db->get();
				$this->db->trans_complete();
				if($query->num_rows > 0)
					return $query;
				else
					return null;
			}   
        }
        
        function get_top_11_20($limit){
         	if($limit == 1){
			$this->db->trans_start();
			 $this->db->select("name,url,description,count,images,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
					->like('full',$this->session->userdata('zone'))
                    ->limit(11,20);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
			}
			else{
				$this->db->trans_start();
				$this->db->select('name,url,description,images,rank')->from('Site');
				$this->db->join('Address', 'Address.id = Site.id', 'left');
	            $this->db->where('rank >=','11')
						->where('rank <=','20');
				$this->db->order_by('rank','asc');
	            $this->db->limit(10);
				$query = $this->db->get();
				$this->db->trans_complete();
				if($query->num_rows > 0)
					return $query;
				else
					return null;
			}   
        }
        
 
        
        function get_top_ten_map($host){
            $host_row= $this->db->select('street,district,town,parish')
                                ->from('Host')
                                ->where('id',$host)
                                ->get()->row();
            $top_ten_rows = $this->get_top_ten(1)->result();
            $host_pre_add = $host_row->street .' '. $host_row->district .' '. $host_row->town .' '.$host_row->parish;
            $top_ten_add = '';
            $host_add = '';

               $sec_array = explode(' ', $host_pre_add);
               foreach($sec_array as $frag){
                   $host_add .= $frag . '+';
			   }
                $host_add = substr($host_add, 0, -1);
                $host_add .=',';
            $host_add = substr($host_add, 0, -1);
            foreach($top_ten_rows as $row){
               $row_pre_add = $row->street .' '. $row->district .' '. $row->town .' '.$row->parish;
               
                   $sec_array = explode(' ', $row_pre_add );
                   foreach($sec_array as $frag){
                       $top_ten_add .= $frag . '+';
                   }
                $top_ten_add = substr($top_ten_add, 0, -1);
                $top_ten_add .=',';
                $top_ten_add = substr($top_ten_add, 0, -1);
                $top_ten_add .='|';
            }
            $top_ten_add = substr($top_ten_add, 0, -1);
            return "http://maps.googleapis.com/maps/api/staticmap?center=$host_add&markers=$host_add|$top_ten_add&zoom=13&size=768x672&maptype=roadmap&sensor=false";
        }

		function remove_site($id){
			$this->db->trans_start();
			$this->db->where('id',$id)->delete('Address');
			$this->db->trans_complete();
		}
             
        function get_site_table(){
             $this->db->trans_start();
             $this->db->select('id,name,rank,FLOOR(count / 2) as count')->from('Site')->order_by('rank','asc');
             $sites = $this->db->get();
             $this->db->trans_complete();
               if($sites->num_rows > 0)
                   return $sites;
               else
                   return null;
        }
		
		function get_poi_table(){
			 $this->db->trans_start();
             $this->db->select('Site.id,name,rank,count')->from('Site')
			 		->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left')
					->where('Point_Of_interest.id ','Site.id',FALSE)
             		->order_by('rank','asc');
             $sites = $this->db->get();
             $this->db->trans_complete();
               if($sites->num_rows > 0)
                   return $sites;
               else
                   return null;
		}
		
		function get_diner_table(){
			$this->db->trans_start();
             $this->db->select('Site.id,name,rank,count')->from('Site')
			 		->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Dining_And_Nightlife','Dining_And_Nightlife.id = Site.id', 'left')
					->where('Dining_And_Nightlife.id ','Site.id',FALSE)
					->order_by('rank','asc');
             $sites = $this->db->get();
             $this->db->trans_complete();
               if($sites->num_rows > 0)
                   return $sites;
               else
                   return null;
		}
		
		function get_shop_table(){
			$this->db->trans_start();
             $this->db->select('Site.id,name,rank,count')->from('Site')
			 		->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left')
					->where('Shopping_And_Entertainment.id ','Site.id',FALSE)
					->order_by('rank','asc');
             $sites = $this->db->get();
             $this->db->trans_complete();
               if($sites->num_rows > 0)
                   return $sites;
               else
                   return null;
		}
        
        function get_points_of_interest($data){
           if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left')
					->where('Point_Of_interest.id ','Site.id',FALSE)
					->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left');
			$this->db->where('Point_Of_interest.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
        }
        
        function get_top_ten_poi($data){
        	if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left')
					->where('Point_Of_interest.id ','Site.id',FALSE)
					->where('rank <=',10)
					->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left');
			$this->db->where('Point_Of_interest.id ','Site.id',FALSE);
			$this->db->where('rank <=',10);
			$this->db->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
        }
        
        function get_top_11_20_poi($data){
        	if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left')
					->where('Point_Of_interest.id ','Site.id',FALSE)
					->where('rank >=',11)
					->where('rank <=',20)
					->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left');
			$this->db->where('Point_Of_interest.id ','Site.id',FALSE);
			$this->db->where('rank >=',11)
					 ->where('rank <=',20);
			$this->db->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
        }
        
        function get_poi_map($host){
          $host_row= $this->db->select('street,district,town,parish')
                                ->from('Host')
                                ->where('id',$host)
                                ->get()->row();
            $top_ten_rows = $this->get_top_ten_poi(1)->result();
            $host_pre_add = $host_row->street .' '. $host_row->district .' '. $host_row->town .' '.$host_row->parish;
            $top_ten_add = '';
            $host_add = '';

               $sec_array = explode(' ', $host_pre_add);
               foreach($sec_array as $frag){
                   $host_add .= $frag . '+';
			   }
                $host_add = substr($host_add, 0, -1);
                $host_add .=',';
            $host_add = substr($host_add, 0, -1);
            foreach($top_ten_rows as $row){
               $row_pre_add = $row->street .' '. $row->district .' '. $row->town .' '.$row->parish;
               
                   $sec_array = explode(' ', $row_pre_add );
                   foreach($sec_array as $frag){
                       $top_ten_add .= $frag . '+';
                   }
                $top_ten_add = substr($top_ten_add, 0, -1);
                $top_ten_add .=',';
                $top_ten_add = substr($top_ten_add, 0, -1);
                $top_ten_add .='|';
            }
            $top_ten_add = substr($top_ten_add, 0, -1);
            return "http://maps.googleapis.com/maps/api/staticmap?center=$host_add&markers=$host_add|$top_ten_add&zoom=13&size=768x672&maptype=roadmap&sensor=false";  
        }

	function get_dining_and_nightlife($data){
		if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Dining_And_Nightlife','Dining_And_Nightlife.id = Site.id', 'left')
					->where('Dining_And_Nightlife.id ','Site.id',FALSE)
					->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site,Dining_And_Nightlife');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Dining_And_Nightlife', 'Dining_And_Nightlife.id = Site.id', 'left');
			$this->db->where('Dining_And_Nightlife.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
	}
	
	function get_top_ten_diner($data){
		if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Dining_And_Nightlife', 'Dining_And_Nightlife.id = Site.id', 'left')
					->where('Dining_And_Nightlife.id ','Site.id',FALSE)
					->order_by('rank','asc')
					->limit(0,9);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Dining_And_Nightlife', 'Dining_And_Nightlife.id = Site.id', 'left');
			$this->db->where('Dining_And_Nightlife.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$this->db->limit(0,10);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
	}
	
	function get_top_11_20_diner($data){
		if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Dining_And_Nightlife', 'Dining_And_Nightlife.id = Site.id', 'left')
					->where('Dining_And_Nightlife.id ','Site.id',FALSE)
					->order_by('rank','asc')
					->limit(10,19);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Dining_And_Nightlife', 'Dining_And_Nightlife.id = Site.id', 'left');
			$this->db->where('Dining_And_Nightlife.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$this->db->limit(10,19);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
	}
	
	

	function get_diner_map($host){
          $host_row= $this->db->select('street,district,town,parish')
                                ->from('Host')
                                ->where('id',$host)
                                ->get()->row();
			$test = $this->get_top_ten_diner(1);
			if(isset($test)){
				$top_ten_rows = $test;
	            $host_pre_add = $host_row->street .' '. $host_row->district .' '. $host_row->town .' '.$host_row->parish;
	            $top_ten_add = '';
	            $host_add = '';
	
	               $sec_array = explode(' ', $host_pre_add);
	               foreach($sec_array as $frag){
	                   $host_add .= $frag . '+';
				   }
	                $host_add = substr($host_add, 0, -1);
	                $host_add .=',';
	            $host_add = substr($host_add, 0, -1);
	            foreach($top_ten_rows as $row){
	               $row_pre_add = $row->street .' '. $row->district .' '. $row->town .' '.$row->parish;
	               
	                   $sec_array = explode(' ', $row_pre_add );
	                   foreach($sec_array as $frag){
	                       $top_ten_add .= $frag . '+';
	                   }
	                $top_ten_add = substr($top_ten_add, 0, -1);
	                $top_ten_add .=',';
	                $top_ten_add = substr($top_ten_add, 0, -1);
	                $top_ten_add .='|';
	            }
	            $top_ten_add = substr($top_ten_add, 0, -1);
	            return "http://maps.googleapis.com/maps/api/staticmap?center=$host_add&markers=$host_add|$top_ten_add&zoom=13&size=768x672&maptype=roadmap&sensor=false";
	            } else{
	            	return "";
	            }  
        }

	function get_shopping_and_entertainment($data){
           if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left')
					->where('Shopping_And_Entertainment.id ','Site.id',FALSE)
					->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left');
			$this->db->where('Shopping_And_Entertainment.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
        }
        
     function get_top_ten_shop($data){
     	if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left')
					->where('Shopping_And_Entertainment.id ','Site.id',FALSE)
					->order_by('rank','asc')
					->limit(0,9);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left');
			$this->db->where('Shopping_And_Entertainment.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$this->db->limit(0,9);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
     }
     
     function get_top_11_20_shop($data){
     	if($data == 1){
			$this->db->trans_start();
			$this->db->select("name,url,description,images,rank,map,TIME_FORMAT( `open`, '%h:%i %p' ) as open,TIME_FORMAT( `close`, '%h:%i %p' ) as close,phone,email,url,Address.street,Address.town,Address.district,Address.parish,Address.full",FALSE)
					->from('Site')
					->join('Address', 'Address.id = Site.id', 'left')
                    ->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left')
					->where('Shopping_And_Entertainment.id ','Site.id',FALSE)
					->order_by('rank','asc')
					->limit(10,19);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
		}
		else{
			$this->db->trans_start();
			$this->db->select('name,url,description,images,rank')->from('Site');
			$this->db->join('Address', 'Address.id = Site.id', 'left');
            $this->db->join('Shopping_And_Entertainment', 'Shopping_And_Entertainment.id = Site.id', 'left');
			$this->db->where('Shopping_And_Entertainment.id ','Site.id',FALSE);
			$this->db->order_by('rank','asc');
			$this->db->limit(10,19);
			$query = $this->db->get();
			$this->db->trans_complete();
			if($query->num_rows > 0)
				return $query;
			else
				return null;
                }
     }

	 function get_shop_map($host){
          $host_row= $this->db->select('street,district,town,parish')
                                ->from('Host')
                                ->where('id',$host)
                                ->get()->row();
			$test = $this->get_top_ten_shop(1);
			if(isset($test)){
	            $top_ten_rows = $test;
	            $host_pre_add = $host_row->street .' '. $host_row->district .' '. $host_row->town .' '.$host_row->parish;
	            $top_ten_add = '';
	            $host_add = '';
	
	               $sec_array = explode(' ', $host_pre_add);
	               foreach($sec_array as $frag){
	                   $host_add .= $frag . '+';
				   }
	                $host_add = substr($host_add, 0, -1);
	                $host_add .=',';
	            $host_add = substr($host_add, 0, -1);
	            foreach($top_ten_rows as $row){
	               $row_pre_add = $row->street .' '. $row->district .' '. $row->town .' '.$row->parish;
	               
	                   $sec_array = explode(' ', $row_pre_add );
	                   foreach($sec_array as $frag){
	                       $top_ten_add .= $frag . '+';
	                   }
	                $top_ten_add = substr($top_ten_add, 0, -1);
	                $top_ten_add .=',';
	                $top_ten_add = substr($top_ten_add, 0, -1);
	                $top_ten_add .='|';
	            }
	            $top_ten_add = substr($top_ten_add, 0, -1);
	            return "http://maps.googleapis.com/maps/api/staticmap?center=$host_add&markers=$host_add|$top_ten_add&zoom=13&size=768x672&maptype=roadmap&sensor=false";
            } else{
            	return "";
            }
        }

}
