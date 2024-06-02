<?php
	$isSuccessful = FALSE;
	//Connecting to Database
	if (list($sqlTeamsGood, $DB) = prepareAndConnect("
		SELECT
			view_match.eventId,
			team1.name AS team1,
			team2.name AS team2,
			sport.name AS sport,
			event.date AS date
			FROM view_match
				 JOIN event ON event.eventId = view_match.eventId
				 JOIN team AS team1  ON view_match.team1 = team1.teamId
				 JOIN team AS team2 ON view_match.team2 = team2.teamId
				 JOIN sport ON team1.sportId = sport.sportId
			ORDER BY sport, date")
	) {
		
		//Processing Information Pulled
		if (mysqli_stmt_execute($sqlTeamsGood)) {
			mysqli_stmt_store_result($sqlTeamsGood);
			if (mysqli_stmt_num_rows($sqlTeamsGood) > 0) {
				mysqli_stmt_bind_result($sqlTeamsGood, $eventId, $team1, $team2, $sport, $date);
				$events = []; // Storing all teams linked to an event as an array
				while (mysqli_stmt_fetch($sqlTeamsGood)) {
					$events += [$eventId => [$team1, $team2, $sport, $date]];
				}
				$isSuccessful = TRUE;
			}
		}
		closeConnection($DB, $sqlTeamsGood);
	}
	if (!$isSuccessful) {
		$_SESSION["errorMessage"] = "We have technical issues. Please try again later or inform the administrator.";
		redirectScript("../Utils/404.php");
	}

	
	
	
