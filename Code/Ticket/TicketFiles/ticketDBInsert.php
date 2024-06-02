<?php
	function ticketInsert($zoneID, $uRow, $uColumn): int|string
	{
		global $success;
		
		if (list($sqlGood, $DB) = prepareAndConnect("INSERT INTO ticket (clientId, eventId, stadiumSeatingZoneId, row, `column`)
				VALUES (?, ?, ?, ?, ?);")) {
			mysqli_stmt_bind_param($sqlGood, "iisis", $_SESSION["clientID"], $_SESSION["eventID"], $zoneID, $uRow, $uColumn);
			if (mysqli_stmt_execute($sqlGood)) {
				// Getting the id of the latest inserted ticket
				$ticketID = mysqli_insert_id($DB);
				$success += 1;
				return $ticketID;
			}
		}
		
		return FALSE;
	}
