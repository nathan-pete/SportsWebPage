<?php
	// Changing the style of the registration page
	
	// This has the purpose of disabling the animation if the user submitted the form
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		echo
		"
            <style>
                .loginMainLeft, .loginForm{
                    animation-name: none;
                }
            </style>
            ";
	}
	//============================================================================================================
	// Code which makes the connection to the database
	
	// This is for keeping the user details in the form if the registration failed
	$uEmail = "";
	$uFirstname = "";
	$uLastname = "";
	$isSuccessful = FALSE;
	
	$errorCode = 0;
	$errorArray = [
	  0 => "One or more inputs are incorrect",
	  1 => "The password does not match the requirements<br>
                -   It must contain at least <b>8 characters</b>!<br>
                -   It must include at least a <b>special symbol</b>, <b>uppercase letter</b>, and a <b>digit</b>!<br>
                Example:  <h3>Passw0rd!</h3>",
	  2 => "The passwords do <b>NOT</b> match!<br> If you continue to get this error, the special characters you are using might be invalid!",
	  3 => "An unexpected error occurred, try again later or contact an administrator!",
	  4 => "Such a email account is already registered in our system!"
	];
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Once the user tries to register, his inputs are validated/sanitized
		if (
		  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) and
		  $pass1 = filter_input(INPUT_POST, "password1", FILTER_UNSAFE_RAW) and
		  $pass2 = filter_input(INPUT_POST, "password2", FILTER_UNSAFE_RAW) and
		  $firstname = htmlentities(filter_input(INPUT_POST, "firstname", FILTER_UNSAFE_RAW)) and
		  $lastname = htmlentities(filter_input(INPUT_POST, "lastname", FILTER_UNSAFE_RAW))
		) {
			$errorCode = 1;
			// We check for password requirements: a special symbol, upper case letter, digit...
			if (
			  preg_match("/[a-z]+/", $pass1) and // Checking for small case letters
			  preg_match("/[A-Z]+/", $pass1) and // Checking for upper case letters
			  preg_match("/\d+/", $pass1) and // Checking for digits
			  ctype_alnum($pass1) == FALSE and // Checking for special symbols
			  strlen($pass1) > 8   // Checking for password length
			) {
				$errorCode = 2;
				// If both passwords the user entered match, and we check if special characters the user entered were not sanitized
				if ($pass1 === $pass2) {
					$errorCode = 3;
					// Connection to the database is made
					if (list($sqlChecked, $db) = prepareAndConnect("SELECT `email` FROM client WHERE `email`= ?")) {
						// Checking if there is not any other user with the same email as the one the user entered
						mysqli_stmt_bind_param($sqlChecked, "s", $email);
						if (mysqli_stmt_execute($sqlChecked)) {
							$errorCode = 4;
							mysqli_stmt_store_result($sqlChecked);
							// If there are no emails like the one the user did enter in the database, the account will be added
							if (mysqli_stmt_num_rows($sqlChecked) == 0) {
								$errorCode = 3;
								$sql = "INSERT INTO `client` (firstname, lastname, email, `password`) VALUES (?, ?, ?, ?)";
								
								if ($sqlChecked = mysqli_prepare($db, $sql)) {
									// The password is hashed using the BCRYPT algorithm, with the cost of 12 (it is harder to decrypt)
									$hash = password_hash($pass1, PASSWORD_DEFAULT, ["cost" => 12]);
									mysqli_stmt_bind_param($sqlChecked, "ssss", $firstname, $lastname, $email, $hash);
									if (mysqli_stmt_execute($sqlChecked)) {
										closeConnection($db, $sqlChecked);
										$isSuccessful = TRUE;
										// We redirect the user back to login page, and display a successfully registration message
										$_SESSION["success"] = "You successfully registered! Now try to log in c:";
										redirectScript("../Login/login.php");
									}
								}
							}
						}
						if (!$isSuccessful) {
							closeConnection($db, $sqlChecked);
						}
					}
				}
			}
		}
		if (!$isSuccessful) {
			$result = $errorArray[$errorCode];
			$uEmail = htmlentities($_POST["email"]);
			$uFirstname = htmlentities($_POST["firstname"]);
			$uLastname = htmlentities($_POST["lastname"]);
		}
	}
