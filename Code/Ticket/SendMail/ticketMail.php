<?php
	// Function to create a pdf file based on the details of the ticket
	function createTicketPDF($data, $type = "S", $name = "")
	{
		$ticketPDF = new \Mpdf\Mpdf([
			// Format [width, height] of the pdf file
		  "format" => [230, 120],
			// It will not have any margins (so no white space on sides)
		  "margin_left" => 0,
		  "margin_right" => 0,
		  "margin_top" => 0,
		  "margin_bottom" => 0,
		  "margin_header" => 0,
		  "margin_footer" => 0,
			// Everything to be encoded in utf-8
		  "mode" => "utf-8",
		]);
		
		$ticketPDF->WriteHTML($data);
		// The ticket is returned in an STRING format by default
		return $ticketPDF->Output($name, $type);
	}
	
	function getMessage($success, $attempts, $isEmail): string
	{
		global $seatsArray;
		$message = "";
		$isRegistered = TRUE;
		// $success variable is used to count the number of successful introductions of tickets in the database
		// It is also used to display a corresponding message
		if ($success == $attempts and $attempts = count($seatsArray) and $attempts > 1) {
			$message .= "<div>Your tickets were successfully registered.";
		} elseif ($success === count($seatsArray) and $success === 1) {
			// If the user booked only ONE ticket and it was registered successfully
			$message .= "<div>Your ticket was successfully registered.";
		} elseif ($attempts === count($seatsArray) and $success != 0) {
			// If the user booked more than one ticket, but not all of them were registered successfully
			$message .= "<div style='color: #ff8800'>Only $success out of " . count($seatsArray) . " tickets were registered.";
		} else {
			$isRegistered = FALSE;
			$message .= "<div style='color: #ad1717'>There was an error registering your tickets!</div>";
		}
		
		if ($isRegistered) {
			if ($isEmail) {
				$message .= " You will receive a confirmation on your email</div>";
			} else {
				$message .= " If they have not downloaded please contact us on our email!</div>";
			}
		}
		
		$message .= "<a href='" . dirname(ROOT_FOLDER, 1) . '/index.php' . "'>You will be redirected back to the main page in 10 sec.</a>";
		
		return $message;
	}
	
	// Function to get email, firstname and lastname of the user who is booking the tickets
	function getUserDetail(): array
	{
		$isSuccessful = FALSE;
		
		if (list($sqlGood, $DB) = prepareAndConnect("SELECT email, firstname, lastname FROM client WHERE clientId = ?")) {
			mysqli_stmt_bind_param($sqlGood, "i", $_SESSION["clientID"]);
			if (mysqli_stmt_execute($sqlGood)) {
				mysqli_stmt_store_result($sqlGood);
				if (mysqli_stmt_num_rows($sqlGood) === 1) {
					mysqli_stmt_bind_result($sqlGood, $userEmail, $fname, $lname);
					mysqli_stmt_fetch($sqlGood);
					$isSuccessful = TRUE;
				}
			}
			closeConnection($DB, $sqlGood);
		}
		
		if (!$isSuccessful) {
			$userEmail = "info.nhlsports@gmail.com";
			$fname = $_SESSION["isLogged"];
			$lname = "";
		}
		return [$userEmail, $fname, $lname];
	}
	
	//==============================================================================================================
	//===========================Code executed first================================================================
	//==============================================================================================================
	
	//Getting users email, firstname and lastname from the database using a function
	list($userEmail, $fname, $lname) = getUserDetail();
	
	$eventName = $_SESSION["teams"][0] . " VS " . $_SESSION["teams"][1];
	$date = convertDate($_SESSION["eventDate"])[0] . " of " . convertDate($_SESSION["eventDate"])[1] . ", " . convertDate($_SESSION["eventDate"])[2];
	$root_folders = preg_replace("@\/NHL-Sports\/Code\/.*@", "", $_SERVER['REQUEST_URI']);
	$loginURL = $_SERVER["REMOTE_ADDR"] . $root_folders . "/NHL-Sports/Code/Login/login.php";
	
	$emailBody = "
			Hello $fname,<br><br>
			Thank you for registering for this event: <b><i> $eventName </i></b>. Your registration has been received.<br>
			If you would like to view your registration details, you can <a href='" . $loginURL . "'>Login</a> in your account!<br><br>
			You registered with this email: <b> $userEmail </b><br><br>
			If you have any questions leading up to the event, feel free to reply to this email.<br><br>
			We look forward to seeing you on $date !<br><br>
			Kind Regards,<br>
			<address>
			Event Staff<br>
			<a href='mailto:info.nhlsports@gmail.com'>info.nhlsports@gmail.com</a><br>
			Twitter: @twitter #hashtag<br>
			Facebook: www.facebook.com/companyname<br>
			(123) 456-7890
			</address>";
