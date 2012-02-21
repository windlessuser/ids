<?php
	function flightXML($url)
	{
		header('content-type:text/xml');
		$feed = simplexml_load_file($url);
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<table>"; 
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
		$xml .= "\n</table>";
		return $xml;
	}
	function param_error($param)
	{
		echo '<span style="font-size:30px;color:red">The "' . $param . '" parameter is either missing or invalid!</span><br />';
	}
	function print_instructions()
	{
		die('<span style="font-size:30px">Both the "airportcode" and "direction" parameters are required!
		<ul><li>aiportcode: three (3) letter code associated with the airport. eg "KIN"<br /></li>
		<li>direction: "arrivals" or "departures"</li></ul>
		Query example: ?airportcode=kin&direction=departures</span>');
	}
?>