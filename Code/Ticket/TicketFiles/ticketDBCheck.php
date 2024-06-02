<?php
	//Import PHPMailer classes into the global namespace
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	
	// Function that inserts the tickets ( ticketInsert() )
	require_once ROOT_FOLDER . "/TicketFiles/ticketDBInsert.php";
	require_once dirname(ROOT_FOLDER, 1) . '/vendor/autoload.php';
	
	$errorCode = 0;
	$possibleErrors = [
	  0 => "Invalid path",
	  1 => "Incorrect seats where submitted!",
	  2 => "We have technical issued . Please try again later or inform the administrator!"
	];
	$isSuccessful = FALSE;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$errorCode = 1;
		$seatsArray = filter_input(INPUT_POST, "seat", FILTER_UNSAFE_RAW, FILTER_REQUIRE_ARRAY);
		if (
		  preg_match("/^Zone\d(a|b|s|vip)\d{1,3}$/", filter_input(INPUT_GET, "zoneID", FILTER_UNSAFE_RAW)) and
		  !empty($seatsArray)
		) {
			$errorCode = 2;
			// Checking the zone (preg_match returns only 1 or 0, therefore we have to define $zoneID in another line)
			$zoneID = filter_input(INPUT_GET, "zoneID", FILTER_UNSAFE_RAW);
			if (list($sqlGood, $DB) = prepareAndConnect("SELECT row, `column` FROM ticket WHERE eventId=? AND stadiumSeatingZoneId=? AND row=? AND `column`=?")) {
				$isSuccessful = TRUE;
				$success = 0;
				$attempts = 0;
				$errorMessage = "";
				$open = "";
				$toDownload = [];
				$mailSender = TRUE;
				
				//=====================================================================================================
				//Create a new PHPMailer instance
				$mail = new PHPMailer(TRUE);
				// Initially config of the mail
				try {
					//Server settings
					$mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Enable verbose debug output
					$mail->isSMTP();                                            //Send using SMTP
					$mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
					$mail->SMTPAuth = TRUE;
					$mail->Username = 'info.nhlsports@gmail.com';
					$mail->Password = 'StrongPassw0rd!';
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
					$mail->Port = 465;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
					$mail->setFrom('info.nhlsports@gmail.com', 'NHLSports');
					// Recipient from the database
					$mail->addAddress($userEmail, $fname . " " . $lname);
					// Test recipient
					//$mail->addAddress("jatof59235@douwx.com", "Joe Mama");    // Don't uncomment this unless you want to send an email to a specific address
					//Content
					$mail->isHTML(TRUE);   //Set email format to HTML
					// Email subject
					$mail->Subject = "Get Your Tickets Now for " . $eventName;
					// Email message send in html format
					$mail->Body = $emailBody;
					// Email message send if html is not supported
					$mail->AltBody = strip_tags($emailBody);
				} catch (Exception $e) {
					$errorMessage .= "<br>Could not connect to the mailer. Mailer Error: {$mail->ErrorInfo}<br>";
					$mailSender = FALSE;
				}
				//=====================================================================================================
				
				foreach ($seatsArray as $seat) {
					// In case more than 1 ticket is booked we introduce them in the database one after another
					// $attempts variable is used to display another message in case one or more tickets (NOT ALL) failed to be introduced
					$attempts += 1;
					// Checking if the $seat value has the structure {begins with a number, the "+" symbol, ends with a letter from "a" TO "j"}
					// Then we check if the number at the beginning  is less than 20
					if (preg_match("/^\d{1,2}\+[a-j]$/", $seat) and substr($seat, 0, -2) < 20) {
						$isRegistered = FALSE;
						// Getting the row the user wants to book
						$uRow = substr($seat, 0, -2);
						// Getting the column the user wants to book
						$uColumn = substr($seat, -1);
						if ($sqlGood = prepareStatement($DB, "SELECT row, `column` FROM ticket WHERE eventId=? AND stadiumSeatingZoneId=? AND row=? AND `column`=?")) {
							mysqli_stmt_bind_param($sqlGood, "isis", $_SESSION["eventID"], $zoneID, $uRow, $uColumn);
							if (mysqli_stmt_execute($sqlGood)) {
								mysqli_stmt_store_result($sqlGood);
								if (mysqli_stmt_num_rows($sqlGood) == 0) {
									if ($ticketID = ticketInsert($zoneID, $uRow, $uColumn)) {
										$isRegistered = TRUE;
										require ROOT_FOLDER . "/SendMail/mailContents.php";
										$fileName = "ticket" . $ticketID . ".pdf";
										// Creating the pdf version of the ticket and saving it to the server
										createTicketPDF($dataPDF, "F", "SavedTickets/" . $fileName);
										$toDownload[] = $fileName;
										if ($mailSender) {
											try {
												$mail->addStringAttachment(createTicketPDF($dataPDF), $fileName);
											} catch (Exception $e) {
												$errorMessage .= "<br>Could not attach the attachment. Ticket id: " . $ticketID . "<br>";
											}
										}
									}
								}
							}
						}
						if (!$isRegistered) {
							$errorMessage .= "<br>The ticket on row $uRow and column $uColumn could not be registered!<br>";
						}
					} else {
						$errorMessage .= "<br>One of the seats is invalid!<br>";
					}
				}
				// END OF foreach LOOP =================================================================================
				
				if ($mailSender) {
					try {
						$mail->send();
					} catch (Exception $e) {
						$errorMessage .= "<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
						$mailSender = FALSE;
					}
				}
				closeConnection($DB, $sqlGood);
				$message = getMessage($success, $attempts, $mailSender);
				if (!$mailSender) {
					// If the mailer has failed tickets will be downloaded to the users machine
					foreach ($toDownload as $ticket) {
						$url = "./SavedTickets/download.php?file=" . $ticket;
						//$open .= 'window.open(' . $url . ', "_blank"); ';
						// Iframes are used to download all the tickets the user has bought
						echo "<iframe style='display: none;' src='" . $url . "' height='0' width='0'></iframe>";
					}
					//echo "If your tickets have not downloaded <a href='' onclick=$open>click here!</a>";
				}
				
				echo $message;
				echo $errorMessage;
				redirectScript("../index.php", 10000);
			}
		}
	}
	if (!$isSuccessful) {
		$_SESSION["errorMessage"] = $possibleErrors[$errorCode];
		redirectError();
	}
