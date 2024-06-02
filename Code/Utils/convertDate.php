<?php
	// Function to convert {year:month:day} format from the DB to {day OF month, year} format
	function convertDate($date): array {
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, -2);
		
		// Match works same as switch, but is only supported in PHP 8 and higher
		$monthStr = match ($month) {
			"01" => "January",
			"02" => "February",
			"03" => "March",
			"04" => "April",
			"05" => "May",
			"06" => "June",
			"07" => "July",
			"08" => "August",
			"09" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December",
			default => $month,
		};
		
		return [$day, $monthStr, $year];
	}
?>
