<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
                //$this->clean_up();
	}
        
        function insert_event(){
           $start_year = $this->input->post('start_year');
           $start_month = $this->input->post('start_month');
           $start_day = $this->input->post('start_day');
           $start_hour = $this->input->post('start_hour');
           $start_min = $this->input->post('start_min');
		   $start_am_pm = $this->input->post('start_am_pm');
		   $date  = "$start_year-$start_month-$start_day";
           $start = "$start_hour:$start_min";
           $end_year = $this->input->post('end_year');
           $end_month = $this->input->post('end_month');
           $end_day = $this->input->post('end_day');
           $end_hour = $this->input->post('end_hour');
           $end_min = $this->input->post('end_min');
		   $end_am_pm = $this->input->post('end_am_pm');
           $end = "$end_hour:$end_min";
           $event = $this->input->post('event');
           $location = $this->input->post('location');
           $company = $this->input->post('company');
           $this->db->trans_start();
		   $this->db->set('date',$date);
           $this->db->set('start',"TIME(STR_TO_DATE('$start $start_am_pm', '%h:%i %p'))",FALSE);
           $this->db->set('end',"TIME(STR_TO_DATE('$end $end_am_pm', '%h:%i %p'))",FALSE);
           $this->db->set('event',$event);
           $this->db->set('location',$location);
           $this->db->set('company',$company);
           $this->db->insert('Event');
           $this->db->trans_complete();
        }
        
        function get_events(){
            $this->db->trans_start();
            $this->db->select("id,date,TIME_FORMAT( `start`, '%h:%i %p' ) as start,TIME_FORMAT( `end`, '%h:%i %p' ) as end,event,location,company",FALSE)->from('Event');
			$this->db->order_by('date','asc')->order_by('start','asc')->order_by('end','asc');
			$query = $this->db->get();
            $this->db->trans_complete();
            if($query->num_rows() > 0)
                return $query;
            else
                return null;       
        }
        
        function get_event($id){
           $this->db->trans_start();
            $query = $this->db->select("id,date,TIME_FORMAT( `start`, '%h:%i %p' ) as start,TIME_FORMAT( `end`, '%h:%i %p' ) as end,event,location,company",FALSE)
            				->from('Event')
            				->where('id',$id)->get();
            $this->db->trans_complete();
            if($query->num_rows() > 0)
                return $query;
            else
                return null;   
        }
        
        function delete_event($id){
            $this->db->trans_start();
            $this->db->where('id',$id)->delete('Event');
            $this->db->trans_complete();
        }
        
        function edit_event($id){
           $start_year = $this->input->post('start_year');
           $start_month = $this->input->post('start_month');
           $start_day = $this->input->post('start_day');
           $start_hour = $this->input->post('start_hour');
           $start_min = $this->input->post('start_min');
		   $start_am_pm = $this->input->post('start_am_pm');
		   $date = "$start_year-$start_month-$start_day";
           $start = "$start_hour:$start_min";
           $end_year = $this->input->post('end_year');
           $end_month = $this->input->post('end_month');
           $end_day = $this->input->post('end_day');
           $end_hour = $this->input->post('end_hour');
           $end_min = $this->input->post('end_min');
		   $end_am_pm = $this->input->post('end_am_pm');
           $end = "$end_hour:$end_min";
           $event = $this->input->post('event');
           $location = $this->input->post('location');
           $company = $this->input->post('company');
           $this->db->trans_start();
		   $this->db->set('date',$date);
           $this->db->set('start',"TIME(STR_TO_DATE('$start $start_am_pm', '%h:%i %p'))",FALSE);
           $this->db->set('end',"TIME(STR_TO_DATE('$end $end_am_pm', '%h:%i %p'))",FALSE);
           $this->db->set('event',$event);
           $this->db->set('location',$location);
           $this->db->set('company',$company);
           $this->db->where('id',$id)->update('Event');
           $this->db->trans_complete(); 
        }

		function get_companies(){
			$this->db->trans_start();
			$query = $this->db->select('*')->from('Company')->get();
			$this->db->trans_complete();
			if($query->num_rows() > 0)
                return $query;
            else
                return null;  
		}
		
		function get_company_events($id){
			$this->db->trans_start();
			$this->db->select('*')->from('Event')
					->join('Company','Company.name = Event.company','Left')
					->where('Company.id',$id);
			$this->db->trans_complete();
		}
		
		function insert_company(){
			$this->db->trans_start();
			$this->db->set('name',$this->input->post('name'));
			$this->db->insert('Company');
			$this->db->trans_complete();
		}
        
        function clean_up(){
            $events = $this->get_events();
            $todays_date = date("Y-m-d h:i a");
            $today = strtotime($todays_date);
			if(isset($events)){
	            foreach($events->result() as $row){
		                $expiration_date = strtotime($row->date .' '.$row->end);
		                if($today - $expiration_date < 0){
		                    $this->db->trans_start();
		                    $this->db->where('id',$row->id)->delete('Event');
		                    $this->db->trans_complete();
		                }
		        }
			}
        }
}