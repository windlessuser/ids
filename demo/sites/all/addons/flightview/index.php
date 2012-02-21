<?php
	error_reporting(0);
	include('functions.php');
	$nordep = simplexml_load_file('http://caribtech-db1.dyndns-server.com/ids/flightstats/?airportcode=kin&direction=departures') or die('Link unavailable.');
	$norarr = simplexml_load_file('http://caribtech-db1.dyndns-server.com/ids/flightstats/?airportcode=kin&direction=arrivals') or die('Link unavailable.');
	$sandep = simplexml_load_file('http://caribtech-db1.dyndns-server.com/ids/flightstats/?airportcode=mbj&direction=departures') or die('Link unavailable.');
	$sanarr = simplexml_load_file('http://caribtech-db1.dyndns-server.com/ids/flightstats/?airportcode=mbj&direction=arrivals') or die('Link unavailable.');
	//$nordep = simplexml_load_file('ndep.xml');
	//$norarr = simplexml_load_file('narr.xml');
	//$sandep = simplexml_load_file('sandep.xml');
	//$sanarr = simplexml_load_file('sanarr.xml');
	echo '<span style="font-size:30px">Norman Manley Departures</span>';
	execute($nordep);
	echo '<span style="font-size:30px">Norman Manley Arrivals</span>';
	execute($norarr);
	echo '<span style="font-size:30px">Sangster Departures</span>';
	execute($sandep);
	echo '<span style="font-size:30px">Sangster Arrivals</span>';
	execute($sanarr);
?>
