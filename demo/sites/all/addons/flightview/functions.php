<?php
	function execute($xml)
	{
		echo makeTable(getHeaders($xml), getValues($xml));
	}	
	function getHeaders($xml)
	{
		$headers = array();
		foreach ($xml->children()->children() as $item)
			array_push($headers, $item->getName());
		return $headers;
	}
	function getValues($xml)
	{
		$valuez = array();
		foreach ($xml->children() as $row)
		{
			$values = array();
			foreach ($row->children() as $item)
			{
				array_push($values, $item);
			}	
			array_push($valuez, $values);
		}
		return $valuez;
	}
	function makeTable($headers, $values)
	{
		$airline_name = 1;
		$flight_number = 6;
		$status = 8;
		$origin_city = 9;
		$origin_airport_name = 10;
		$destination_city = 12;
		$destination_airport_name = 13;
		$remarks_with_time = 23;
		$sched_time = 18;
		
		$div = '<div style="padding-bottom:30px" id="display"><table text-align="center" width="100%" border="5">';
		$div .= '<tr>';
			$div .= '<th>' . $headers[$airline_name] . '</th>';
			$div .= '<th>' . $headers[$flight_number] . '</th>';
			$div .= '<th>' . $headers[$status] . '</th>';
			$div .= '<th>' . $headers[$origin_city] . '</th>';
			$div .= '<th>' . $headers[$origin_airport_name] . '</th>';
			$div .= '<th>' . $headers[$destination_city] . '</th>';
			$div .= '<th>' . $headers[$destination_airport_name] . '</th>';
			$div .= '<th>' . $headers[$sched_time] . '</th>';
			$div .= '<th>' . $headers[$remarks_with_time] . '</th>';
		$div .= '</tr>';
		
		for($i = 0; $i < count($values); $i++)
		{
			$div .= '<tr>';
				$div .= '<td>' . $values[$i][$airline_name] . '</td>';
				$div .= '<td>' . $values[$i][$flight_number] . '</td>';
				$div .= '<td>' . $values[$i][$status] . '</td>';
				$div .= '<td>' . $values[$i][$origin_city] . '</td>';
				$div .= '<td>' . $values[$i][$origin_airport_name] . '</td>';
				$div .= '<td>' . $values[$i][$destination_city] . '</td>';
				$div .= '<td>' . $values[$i][$destination_airport_name] . '</td>';
				$div .= '<td>' . $values[$i][$sched_time] . '</td>';
				if (isset($values[$i][$remarks_with_time]))						
					$div .= '<td>' . $values[$i][$remarks_with_time] . '</td>';
				else
					$div .= '<td>N/A</td>';
			$div .= '</tr>';
		}
		$div .= '</table></div>';
		return $div;
	}
?>
