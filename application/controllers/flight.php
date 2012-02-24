<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight Extends CI_Controller {

	  function __construct() {
        parent::__construct();
        $this->load->model('flight_model');
        $this->load->helper('xml');
    	}
    	
    var $norman_manley_code = "kin";
	var $sangster_code = "mbj";
	var $arrivals = "arrivals";
	var $departures = "departures";
    
    
    function index(){
    	$this->flight_model->update_cache();
    	
	    	if (isset($_GET["airportcode"]) && isset($_GET["direction"]))
	    	{
	    		$airportparam = strtolower($_GET["airportcode"]);
	    		$directionparam = strtolower($_GET["direction"]);
	    		if ($airportparam == $this->norman_manley_code)
					if ($directionparam == $this->arrivals)
						$feed = $this->flight_model->get_kin_ariv();
					elseif($directionparam == $this->departures)
						$feed = $this->flight_model->get_kin_dept();
				elseif($airportparam == $this->sangster_code)
					if ($directionparam == $this->arrivals)
						$feed = $this->flight_model->get_mbj_ariv();
					elseif($directionparam == $this->departures)
						$feed = $this->flight_model->get_mbj_dept();
			}
			else
				$feed = null;
		$data['feed'] = $feed;
		$this->load->view('flight',$data);
    }

}