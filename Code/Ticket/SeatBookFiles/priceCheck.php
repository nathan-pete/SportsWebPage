<?php
	require dirname(__DIR__, 2) . "/Utils/session.php";
	require dirname(__DIR__, 2) . "/Utils/Database.php";
	
	// This file can only be called by AJAX to calculate the total amount the user has to pay, based on the selected seats
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (
		  preg_match("/^Zone\d(a|b|s|vip)\d{1,3}$/", filter_input(INPUT_POST, "zoneID", FILTER_UNSAFE_RAW)) and
		  $eventID = $_SESSION["eventID"]
		) {
			
			$zoneID = filter_input(INPUT_POST, "zoneID", FILTER_UNSAFE_RAW);
			if (list($sqlGood, $DB) = prepareAndConnect("SELECT P.price  FROM stadiumseatingzone
						JOIN pricelist P ON stadiumseatingzone.seatingType = P.seatingType AND eventId = ?
						WHERE stadiumSeatingZoneId = ?;")) {
				
				mysqli_stmt_bind_param($sqlGood, "is", $eventID, $zoneID);
				if (mysqli_stmt_execute($sqlGood)) {
					mysqli_stmt_store_result($sqlGood);
					if (mysqli_stmt_num_rows($sqlGood) === 1) {
						mysqli_stmt_bind_result($sqlGood, $zonePrice);
						mysqli_stmt_fetch($sqlGood);
						
						echo $zonePrice;
					}
				}
				closeConnection($DB, $sqlGood);
			}
		}
	}
	
