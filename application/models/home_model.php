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
		
		$this->db->trans_complete();
		
		return $this->db->get()->row_array();
	}
	
	function get_weather_feeds(){
		
		$dom = new DOMDocument();
		$dom->load("http://rss.weather.com/weather/rss/local/JMXX0002?cm_ven=LWO&cm_cat=rss&par=LWO_rss");
		$arrFeeds = array();
		foreach ($doc->getElementsByTagName('item') as $node) {
			$itemRSS = array (
			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
			);
			array_push($arrFeeds, $itemRSS);
		}
		return $this->__processFeed($arrFeeds);
	}
	
	function get_airline_feeds(){
		return "";
	}
	
	function get_hotel_feeds(){
		return "";
	}
	
	function __processFeed($feed,$max = 5){
		$output = "";
		$numFeeds =0;
		foreach ($feed as $report) {
			if ($numFeeds == $max) { break;}
			foreach ($report as $item) {
				$output .= "" . $item . "<br />";
			}
			$output .= "<br /><br />";
			$numFeeds++;
		}
		return $output;
	}
}
