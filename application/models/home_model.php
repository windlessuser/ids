<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_model{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function get_top_ten(){
		$this->db->trans_start();
		
		$this->db->select('Point_of_interest.name,Dining_and_nightlife.name,shopping_and_entertainment.name,Site.id,latitude,longitude,description');
		$this->db->from('Site, Point_of_Interest, Dining_and_Nightlife, Shopping_and_Entertainment');
		$this->db->where('Site.id = ','Point_of_interest.id');
		$this->db->or_where('Site.id =', 'Dining_and_nightlife,id');
		$this->db->or_where('site.id = ', 'Shopping_and_entertainment.id');
		$this->db->order_by('Site.rank','asc');
		$this->db->limit(10);
		
		$result = $this->db->get()->row_array();
		
		$this->db->trans_complete();
		
		return $result;
	}
	
	function get_weather_feeds(){
		
		$dom = new DOMDocument();
		$dom->load("http://rss.weather.com/weather/rss/local/JMXX0002?cm_ven=LWO&cm_cat=rss&par=LWO_rss");
		return $dom->saveXML();
	}
	
	function get_airline_feeds(){
		return "";
	}
	
	function get_hotel_feeds(){
		return "";
	}
}
