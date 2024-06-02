<?php
	$isSuccessful = FALSE;
	$errorArray = [
	  0 => "This is an invalid event!",
	  1 => "We have technical issued. Please try again later or inform the administrator!"
	];
	$errorCode = 0;
	// Display information about an event
	if ($eventID = filter_input(INPUT_GET, "eventID", FILTER_VALIDATE_INT)) {
		$errorCode = 1;
		if (list($sqlGood, $DB) = prepareAndConnect("
			SELECT
			    team1.name AS team1,
			    team2.name AS team2,
			    event.time AS time,
			    event.date AS date,
			    stadium.location AS stadium
			FROM view_match
			         JOIN event ON event.eventId = view_match.eventId
			         JOIN team AS team1  ON view_match.team1 = team1.teamId
			         JOIN team AS team2 ON view_match.team2 = team2.teamId
			         JOIN stadium ON event.stadiumId = stadium.stadiumId
			WHERE view_match.eventId = ?;")
		) {
			mysqli_stmt_bind_param($sqlGood, "i", $eventID);
			if (mysqli_stmt_execute($sqlGood)) {
				mysqli_stmt_store_result($sqlGood);
				if (mysqli_stmt_num_rows($sqlGood) === 1) {
					mysqli_stmt_bind_result($sqlGood, $team1, $team2, $eventTime, $eventDate, $eventLocation);
					mysqli_stmt_fetch($sqlGood);
					$isSuccessful = TRUE;
					$teams = [$team1, $team2]; // Storing all teams linked to an event
					$_SESSION["eventID"] = $eventID;
					//=========== Variables used for tickets
					$_SESSION["eventTime"] = $eventTime;
					$_SESSION["eventDate"] = $eventDate;
					$_SESSION["eventLocation"] = $eventLocation;
					$_SESSION["teams"] = $teams;
				}
			}
			closeConnection($DB, $sqlGood);
		}
	}
	
	if (!$isSuccessful) {
		$_SESSION["errorMessage"] = $errorArray[$errorCode];
		redirectError();
	}

