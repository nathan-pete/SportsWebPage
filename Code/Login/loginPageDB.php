<?php
	// Changing the style of the login page
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// This has the purpose of disabling the animation if the user submitted the form
		echo
		"
            <style>
                .loginMainLeft, .loginForm{
                    animation-name: none;
                }
            </style>
            ";
	} else {
		// Revert the animation if the login page is accessed
		echo
		"
            <style>
                .loginMainLeft {
                    animation-name: loginStartDown;
                }
                .loginForm {
                    animation-name: loginStartUp;
                }
            </style>
            ";
	}
	//=================================================================================================================
	// Code used for connection to the database
	
	// This is for keeping the user email in the form if the login failed
	$uEmail = "";
	$isSuccessful = FALSE;
	$errorCode = 0;
	$errorArray = [
	  0 => "The email and/or password are incorrect",
	  1 => "An unexpected error occurred, try again later or contact an administrator!",
	  2 => "The email/password are incorrect"
	];
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Once the user tries to login, the email and password a filtered/validated
		if (
		  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) and
		  $passwd = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW)
		) {
			$errorCode = 1;
			// Connection to the database is made, and it searches for the email which matches with the mail the users entered
			if (list($sqlChecked, $db) = prepareAndConnect("SELECT `password`, `firstname`, `clientId` FROM client WHERE `email`= ?")) {
				mysqli_stmt_bind_param($sqlChecked, "s", $email);
				if (mysqli_stmt_execute($sqlChecked)) {
					mysqli_stmt_store_result($sqlChecked);
					$errorCode = 2;
					if (mysqli_stmt_num_rows($sqlChecked) == 1) {
						mysqli_stmt_bind_result($sqlChecked, $hash, $firstName, $clientID);
						mysqli_stmt_fetch($sqlChecked);
						
						// Here we verify if the password (the function hashes the password the user enters) matches with the hash in the database
						if (password_verify($passwd, $hash)) {
							closeConnection($db, $sqlChecked);
							$isSuccessful = TRUE;
							$_SESSION["isLogged"] = $firstName;
							$_SESSION["clientID"] = $clientID;
							if (isset($_SESSION["redURL"])) {
								$redURL = $_SESSION["redURL"];
								unset($_SESSION["redURL"]);
								redirectScript($redURL);
							} else {
								redirectScript("../index.php");
							}
						}
					}
				}
				if (!$isSuccessful) {
					closeConnection($db, $sqlChecked);
				}
			}
		}
		if (!$isSuccessful) {
			if (!empty($email)) {
				$uEmail = $email;
			}
			$result = $errorArray[$errorCode];
		}
	}
	
