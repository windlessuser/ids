<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight_Model extends CI_Model {
	
	function __construct() {
        parent::__construct();
        $this->airportparam = isset($_GET["airportcode"]) ? strtolower($_GET["airportcode"]) : null;
		$this->directionparam = isset($_GET["direction"]) ? strtolower($_GET["direction"]) : null;
		$this->update_cache();
    }
    
    var $url = "http://www.flightstats.com/go/WebResources/webletAirportFIDSUpdate.do?guid=";
	var $normanDepGUID = "70cbe593c1d6de05:3aa6e0f5:131af3332ad:4a1e";
	var $normanArrGUID = "e1025fac5c859390:-70549957:131af3ed575:2da1";
	var $sangsterDepGUID = "49e3481552e7c4c9:70981398:131aff121a1:610b";
	var $sangsterArrGUID = "70cbe593c1d6de05:3aa6e0f5:131aff64241:-3af2";
	//airport codes
	var $norman_manley_code = "kin";
	var $sangster_code = "mbj";
	//required direction parameter
	var $arrivals = "arrivals";
	var $departures = "departures";
	//'get' parameters
	var $airportparam = "";
	var $directionparam = "";
	var  $kin_arive;
	var  $kin_dept;
	
	
	function flightXML($feed)
	{
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<table>";
		if(isset($feed)){
			if(isset($_GET["num"])){
				$id = (is_numeric($_GET["num"])) ? (int)$_GET["num"] - 1 : 0;
				$feed = $this->simpleXMLToArray($feed,"Flight");
				$xml .= "\n\t<row>";
				foreach($feed['Flight'][$id]['Flight'] as $a => $b)
					$xml .= "\n\t\t<" . $a .">" . $b . "</" . $a . ">";
				$xml .= "\n\t</row>";
			}	
			else{ 
				foreach($feed->children() as $flight)
				{
					if (strtolower($flight->getName()) == "flight")
					{
						$xml .= "\n\t<row>";
						foreach($flight->attributes() as $a => $b)
							$xml .= "\n\t\t<" . $a .">" . $b . "</" . $a . ">";
						$xml .= "\n\t</row>";
					}
				}
			}
		$xml .= "\n</table>";
		return $xml;
		}
	}
	
	function param_error($param)
	{
		return '<span style="font-size:30px;color:red">The "' . $param . '" parameter is either missing or invalid!</span><br />';
	}
	function print_instructions()
	{
		die('<span style="font-size:30px">Both the "airportcode" and "direction" parameters are required!
		<ul><li>aiportcode: three (3) letter code associated with the airport. eg "KIN"<br /></li>
		<li>direction: "arrivals" or "departures"</li></ul>
		Query example: ?airportcode=kin&direction=departures</span>');
	}
	
	function update_cache(){
		$this->cache->write(simplexml_load_file($this->url . $this->normanArrGUID)->asXML(), 'kin_arive',360);
		$this->kin_arive = new SimpleXMLElement($this->cache->get('kin_arive'));
		$this->cache->write(simplexml_load_file($this->url . $this->normanDepGUID)->asXML(), 'kin_dept',360);
		$this->kin_dept = new SimpleXMLElement($this->cache->get('kin_dept'));
	}
	
	function get_kin_dept(){
		return $this->flightXML($this->kin_dept);
	}
	
	function get_kin_dept_id(){
		return $this->flightXML($this->kin_dept);
	}
	
	function get_kin_ariv(){
		return $this->flightXML($this->kin_dept_arive);
	}
	
	function get_kin_ariv_id(){
		return $this->flightXML($this->kin_arive);
	}
	
	function get_mbj_dept(){
		return $this->flightXML($this->url . $this->$sangsterDepGUID);
	}
	
	function get_mbj_dep_id(){
		return $this->flightXML($this->url . $this->$sangsterDepGUID);
	}
	
	function get_mbj_ariv(){
		return $this->flightXML($this->url . $this->$sangsterArrGUID);
	}
	
	function get_mbj_ariv_id(){
		return $this->flightXML($this->url . $this->$sangsterArrGUID);
	}
	
	
	function simpleXMLToArray(SimpleXMLElement $xml,$attributesKey=null,$childrenKey=null,$valueKey=null){ 

	    if($childrenKey && !is_string($childrenKey)){$childrenKey = '@children';} 
	    if($attributesKey && !is_string($attributesKey)){$attributesKey = '@attributes';} 
	    if($valueKey && !is_string($valueKey)){$valueKey = '@values';} 
	
	    $return = array(); 
	    $name = $xml->getName(); 
	    $_value = trim((string)$xml); 
	    if(!strlen($_value)){$_value = null;}; 
	
	    if($_value!==null){ 
	        if($valueKey){$return[$valueKey] = $_value;} 
	        else{$return = $_value;} 
	    } 
	
	    $children = array(); 
	    $first = true; 
	    foreach($xml->children() as $elementName => $child){ 
	        $value = $this->simpleXMLToArray($child,$attributesKey, $childrenKey,$valueKey); 
	        if(isset($children[$elementName])){ 
	            if(is_array($children[$elementName])){ 
	                if($first){ 
	                    $temp = $children[$elementName]; 
	                    unset($children[$elementName]); 
	                    $children[$elementName][] = $temp; 
	                    $first=false; 
	                } 
	                $children[$elementName][] = $value; 
	            }else{ 
	                $children[$elementName] = array($children[$elementName],$value); 
	            } 
	        } 
	        else{ 
	            $children[$elementName] = $value; 
	        } 
	    } 
	    if($children){ 
	        if($childrenKey){$return[$childrenKey] = $children;} 
	        else{$return = array_merge($return,$children);} 
	    } 
	
	    $attributes = array(); 
	    foreach($xml->attributes() as $name=>$value){ 
	        $attributes[$name] = trim($value); 
	    } 
	    if($attributes){ 
	        if($attributesKey){$return[$attributesKey] = $attributes;} 
	        else{$return = array_merge($return, $attributes);} 
	    } 	
	    return $return; 
	} 
}