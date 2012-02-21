<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class POI_Model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function get_site($host,$rank){
        $this->db->trans_start();
        $this->db->select("Site.id,name,url,description,images,Point_Of_interest.rank,map,TIME_FORMAT( open, '%h:%i %p' ) as open, TIME_FORMAT( close, '%h:%i %p' ) as close,phone,email,url,street,town,district,parish,full",FALSE)
                ->from('Site')
                ->join('Address','Address.id = Site.id','left')
                ->join('Point_Of_interest','Point_Of_interest.id = Site.id','left')
                ->where('Point_Of_interest.rank',$rank,FALSE);
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
    
    function get_all_sites(){
        $this->db->trans_start();
        $this->db->select("Site.id,name,url,description,images,Point_Of_interest.rank,map,TIME_FORMAT( open, '%h:%i %p' ) as open, TIME_FORMAT( close, '%h:%i %p' ) as close,phone,email,url,street,town,district,parish,full",FALSE)
                ->from('Site')
                ->join('Address','Address.id = Site.id','left')
                ->join('Point_Of_interest','Point_Of_interest.id = Site.id','left')
                ->where('Point_Of_interest.id','Site.id',FALSE);
		$zone = $this->session->userdata('zone');
	/*if(strcmp($zone,'Kingston') == 0){
					$this->load->library('Subquery');
					$sub = $this->subquery->start_subquery('where_in');
					$sub->like('full',$zone)
						->or_like('full','Fort Charles')
						->or_like('full','Port Royal');
					$this->subquery->end_subquery();	
	}else*/
		$this->db->like('full',$this->session->userdata('zone'));
                $this->db->order_by('Point_Of_interest.rank','asc');
        $site = $this->db->get();
        $this->db->trans_complete();
        if($site->num_rows > 0)
            return $site;
        else
            return null;
    }
    
    function get_top($start,$stop){
        $this->db->trans_start();
        $this->db->select("Site.id,name,url,description,images,Point_Of_interest.rank,map,TIME_FORMAT( open, '%h:%i %p' ) as open, TIME_FORMAT( close, '%h:%i %p' ) as close,phone,email,url,street,town,district,parish,full",FALSE)
                ->from('Site')
                ->join('Address','Address.id = Site.id','left')
                ->join('Point_Of_interest','Point_Of_interest.id = Site.id','left')
                ->where('Point_Of_interest.rank >=',$start)
                ->where('Point_Of_interest.rank <=',$stop)
                ->where('Point_Of_interest.id','Site.id',FALSE);
		$zone = $this->session->userdata('zone');
	/*if(strcmp($zone,'Kingston') == 0){
					$this->load->library('Subquery');
					$sub = $this->subquery->start_subquery('where_in');
					$sub->like('full',$zone)
						->or_like('full','Fort Charles')
						->or_like('full','Port Royal');
					$this->subquery->end_subquery();	
	}else*/
		$this->db->like('full',$this->session->userdata('zone'));
        $this->db->order_by('Point_Of_interest.rank','asc');
        $site = $this->db->get();
        $this->db->trans_complete();
        if($site->num_rows > 0)
            return $site;
        else
            return null;
    }
    
    function get_top_map($host,$start,$stop){
        $this->db->trans_start();
        $host = $this->db->where('id',$host)
                    ->get('Host');
        $top_sites = $this->get_top($start, $stop);
        $this->db->trans_complete();
        $host_add = '';
        if($host->num_rows == 0)
           $host_add = 'Swallowfield+Rd,Kingston,St+Andrew+Parish,Jamaica';
        else{
            $host = $host->row();
            $host_pre_add = $host->street .' '. $host->district .' '. $host->town .' '.$host->parish;
            $sec_array = explode(' ', $host_pre_add);
               foreach($sec_array as $frag){
                   $host_add .= $frag . '+';
			   }
                $host_add = substr($host_add, 0, -1);
                $host_add .=',';
            $host_add = substr($host_add, 0, -1);
            $top_sites_add = $this->__to_map_address($top_sites);
            return "http://maps.googleapis.com/maps/api/staticmap?center=$host_add&markers=$host_add|$top_sites_add&zoom=13&size=768x672&maptype=roadmap&sensor=false";
        }  
    }
    
    function get_site_table(){
             $this->db->trans_start();
             $this->db->select('Site.id,name,Point_Of_interest.rank,FLOOR(count / 2) as count',FALSE)
                     ->from('Site')
                     ->join('Address', 'Address.id = Site.id', 'left')
                     ->join('Point_Of_interest', 'Point_Of_interest.id = Address.id', 'left');
		     $zone = $this->session->userdata('zone');
	/*if(strcmp($zone,'Kingston') == 0){
					$this->load->library('Subquery');
					$sub = $this->subquery->start_subquery('where_in');
					$sub->like('full',$zone)
						->or_like('full','Fort Charles')
						->or_like('full','Port Royal');
					$this->subquery->end_subquery();	
	}else*/
		$this->db->like('full',$this->session->userdata('zone'));
                $this->db->where('Point_Of_interest.id ','Site.id',FALSE)
                     ->order_by('Point_Of_interest.rank','asc');
             $sites = $this->db->get();
             $this->db->trans_complete();
               if($sites->num_rows > 0)
                   return $sites;
               else
                   return null;
        }
    
    function __to_map_address($site){
        $address = '';
        if(isset($site)){
            foreach ($site->result() as $row){
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

