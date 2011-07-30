<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home Extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$this->load->model('home_model');
		$data['top_ten'] = $this->home_model->get_top_ten();
		$data['hotel_feeds'] = $this->home_model->get_hotel_feeds();
		$data['weather_feeds'] = $this->home_model->get_weather_feeds();
		$data['airline_feeds'] = $this->home_model->get_airline_feeds();
		$data['title'] = "Home";
		$data['main_content'] = "home_view";
		$this->load->view('includes/template', $data);
	}
}
