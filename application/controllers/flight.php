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
						if(isset($_GET["num"]))
							//$feed = $this->cache->model('flight_model','get_kin_ariv_id', '', 360);
							$feed = $this->flight_model->get_kin_ariv_id();
						else
							//$feed = $this->cache->model('flight_model','get_kin_ariv', '', 360);
							$feed = $this->flight_model->get_kin_ariv();
					elseif ($directionparam == $this->departures)
						if(isset($_GET["num"]))
							//$feed = $this->cache->model('flight_model','get_kin_dept_id', '', 360);
							$feed = $this->flight_model->get_kin_dept_id();
						else
							//$feed = $this->cache->model('flight_model','get_kin_dept', '', 360);
							$feed = $this->flight_model->get_kin_dept();
				elseif(($airportparam == $this->$sangster_code))
					if ($directionparam == $this->arrivals)
						if(isset($_GET["num"]))
							$feed = $this->cache->model('flight_model','get_mbj_ariv_id', '', 360);
						else
							$feed = $this->cache->model('flight_model','get_mbj_ariv', '', 360);
					elseif ($directionparam == $this->departures)
						if(isset($_GET["num"]))
							$feed = $this->cache->model('flight_model','get_mbj_dept_id', '', 360);
						else
							$feed = $this->cache->model('flight_model','get_mbj_dept', '', 360);
			}
			else
				$feed = null;
		$data['feed'] = $feed;
		$this->load->view('flight',$data);
    }

}