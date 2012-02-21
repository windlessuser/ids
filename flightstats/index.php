<?php
	error_reporting(0);
	require_once("functions.php");
	require_once("variables.php");
	////////////////////////////////////////////////////////////////////////////////////////
	//service logic starts here
	$error_flag = false;
	////////////////////////////////////////////////////////////////////////////////////////
	if (!isset($_GET["airportcode"]))
	{
		param_error("airportcode");
		$error_flag = true;
	}
	////////////////////////////////////////////////////////////////////////////////////////
	if (!isset($_GET["direction"]))
	{
		param_error('direction');
		$error_flag = true;
	}
	////////////////////////////////////////////////////////////////////////////////////////
	if ($error_flag)
		print_instructions();
	else 
	{
		$airportparam = strtolower($_GET["airportcode"]);
		$directionparam = strtolower($_GET["direction"]);
	}
	////////////////////////////////////////////////////////////////////////////////////////
	if ($airportparam == $norman_manley_code)
		if ($directionparam == $arrivals)
			echo flightXML($url . $normanArrGUID);
		elseif ($directionparam == $departures)
			echo flightXML($url . $normanDepGUID);
		else
		{
			param_error('direction');
			print_instructions();
		}
	/*else if ($airportparam == $sangster_code)
		if ($directionparam == $arrivals)
			echo flightXML($url . $sangsterArrGUID);
		elseif ($directionparam == $departures)
			echo flightXML($url . $sangsterDepGUID);
		 
		else
		{
			param_error('direction');
			print_instructions();
		}
	else
	{
		param_error('airportcode');
		print_instructions();
	}*/
	////////////////////////////////////////////////////////////////////////////////////////
?>