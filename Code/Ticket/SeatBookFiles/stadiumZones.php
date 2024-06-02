<?php
	// Displaying the zones from the database
	$isSuccessful = FALSE;
	// $eventId = $_SESSION["eventID"] check is implemented for preventing errors if the user clears the cache while on this page
	if (list($sqlGood, $DB) = prepareAndConnect(
		"SELECT stadiumSeatingZoneId Zone,
       				(SELECT name FROM seatingzone WHERE stadiumseatingzone.seatingType = seatingzone.seatingType) Type,
       					capacity FROM stadiumseatingzone
                        WHERE stadiumId IN (SELECT stadiumId
                                            FROM event
                                            WHERE eventId=?)
						ORDER BY Type, Zone DESC, capacity"
	  ) and $eventID = $_SESSION["eventID"]) {
		mysqli_stmt_bind_param($sqlGood, "i", $eventID);
		if (mysqli_stmt_execute($sqlGood)) {
			mysqli_stmt_store_result($sqlGood);
			if (mysqli_stmt_num_rows($sqlGood) >= 1) {
				mysqli_stmt_bind_result($sqlGood, $stadiumZone, $seatingType, $zoneCapacity);
				$zoneNr = mysqli_stmt_num_rows($sqlGood);
				// Storing half of the zones and their type in one array, and the other part in another array
				$zoneWidth = $zoneNr / 2;
				$seatDisplayZones1 = [];
				$seatDisplayZones2 = [];
				$zon = 0;
				while (mysqli_stmt_fetch($sqlGood)) {
					if ($zon < $zoneWidth) {
						$seatDisplayZones1 += [$stadiumZone => [$seatingType => $zoneCapacity]];
					} else {
						$seatDisplayZones2 += [$stadiumZone => [$seatingType => $zoneCapacity]];
					}
					$zon++;
				}
				$isSuccessful = TRUE;
			}
		}
		//=========================================================================================================
		// Second sql query
		// Display the price
		
		$sql = "SELECT (SELECT name FROM seatingzone WHERE seatingzone.seatingType = pricelist.seatingType) Name, price
                FROM pricelist
                JOIN event e ON pricelist.eventId = e.eventId
                WHERE e.eventId = ?
                ORDER BY price";
		
		if ($sqlGood = prepareStatement($DB, $sql) and $isSuccessful) {
			$isSuccessful = FALSE;
			mysqli_stmt_bind_param($sqlGood, "i", $eventID);
			if (mysqli_stmt_execute($sqlGood)) {
				mysqli_stmt_bind_result($sqlGood, $seatTypeName, $seatTypePrice);
				mysqli_stmt_store_result($sqlGood);
				if (mysqli_stmt_num_rows($sqlGood) > 1) {
					$seats = [];
					while (mysqli_stmt_fetch($sqlGood)) {
						$seats += [$seatTypeName => $seatTypePrice];
					}
					$isSuccessful = TRUE;
				}
			}
		}
		closeConnection($DB, $sqlGood);
	}
	
	if (!$isSuccessful) {
		$_SESSION["errorMessage"] = "We have technical issued. Please try again later or inform the administrator!";
		redirectError();
	}
	
	
