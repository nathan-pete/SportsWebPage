<?php
	require dirname(__DIR__, 2) . "/Utils/session.php";
	require dirname(__DIR__, 2) . "/Utils/Database.php";
	
	$isSuccessful = FALSE;
	$errorCode = 0;
	$errorArray = [
	  0 => "This zone is invalid!",
	  1 => "We have technical issued. Please try again later or inform the administrator!"
	];
	// Selecting all the seats from the DB based on the zone selected
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// A ZONE has the structure: ~ Zone[1 digit here](the strings: a OR b OR s OR vip)[1 TO 3 digits here] ~
		// ^ - means it has to begin with Zone
		// \d - means a digit from 0 to 9 must occur
		// {} - inside this is specified the number of times the item before can occur || {1,3} means it can occur 1 to 3 times
		// () - inside this are written patterns that can occur; '|' symbol is a delimiter which means `OR`
		// $ - means it has to end with a digit
		if (
		  preg_match("/^Zone\d(a|b|s|vip)\d{1,3}$/", filter_input(INPUT_POST, "zoneID", FILTER_UNSAFE_RAW)) and
		  $eventID = $_SESSION["eventID"]
		) {
			$errorCode = 1;
			$zoneID = filter_input(INPUT_POST, "zoneID", FILTER_UNSAFE_RAW);
			if (list($sqlGood, $DB) = prepareAndConnect("SELECT seat.row, seat.column, ticket.row, ticket.column FROM seat
						LEFT JOIN ticket ON seat.stadiumSeatingZoneId = ticket.stadiumSeatingZoneId AND seat.row = ticket.row AND seat.column = ticket.column AND ticket.eventId = ?
						WHERE seat.stadiumSeatingZoneId = ?
						ORDER BY seat.row, seat.`column`;")) {
				mysqli_stmt_bind_param($sqlGood, "is", $eventID, $zoneID);
				if (mysqli_stmt_execute($sqlGood)) {
					mysqli_stmt_store_result($sqlGood);
					$errorCode = 0;
					if (mysqli_stmt_num_rows($sqlGood) >= 1) {
						mysqli_stmt_bind_result($sqlGood, $row, $column, $rowBooked, $columnBooked);
						echo "<form action='tickets.php?zoneID=$zoneID' method='POST' class='seats'>";
						echo "
								<div class='seatSubmit'>
										<div>
											<h1>$zoneID</h1>
										</div>
										<div class='seatAmount'></div>
										<div>
											<input type='submit' value='Checkout'>
										</div>
								</div>";
						$rowCheck = "";
						while (mysqli_stmt_fetch($sqlGood)) {
							// Putting each row in a new ul tag
							if ($row != $rowCheck) {
								// We avoid to add a close ul tag at the beginning
								if ($rowCheck != "") {
									echo "</ul>";
								}
								echo "<ul>";
								echo "<h1>Row " . $row + 1 . "</h1>";
								$rowCheck = $row;
							}
							if ($row == $rowBooked and $column == $columnBooked) {
								// If the seat is already booked
								echo "
										<li class='seatDisabled' title='This seat is already booked'>
											<input type='checkbox' name='seat[]' id='$row+$column'  disabled>
											<label for='$row+$column'><img src='../assets/seat.png' alt='Seat'></label>
										</li>";
							} else {
								// If the seat is not booked
								echo "
										<li class='seatAvailable' title='Available!'>
											<input type='checkbox' name='seat[]' id='$row+$column' value='$row+$column'>
											<label for='$row+$column'><img src='../assets/seat.png' alt='Seat'></label>
										</li>";
							}
							/* The form for the seats must look like this
							 * <form class="seats">
							 *      <ul>
							 *          <li class="seatDisabled">
							 *              <input>
							 *              <label> <img /> </label>
							 *          </li>
							 *      </ul>
							 *      <ul>
							 *          <li class="seatAvailable">
							 *              <input>
							 *              <label> <img /> </label>
							 *          </li>
							 *      </ul>
							 *  ...
							 * </form>
							 * */
						}
						echo "</form>";
						$isSuccessful = TRUE;
					}
				}
				closeConnection($DB, $sqlGood);
			}
		}
		if (!$isSuccessful) {
			echo $errorArray[$errorCode];
		}
	}
