<?php
	require dirname(__DIR__, 1) . "/Utils/Database.php";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
			if (list($sqlChecked, $db) = prepareAndConnect("SELECT `email` FROM client WHERE `email`= ?")) {
				mysqli_stmt_bind_param($sqlChecked, "s", $email);
				if (mysqli_stmt_execute($sqlChecked)) {
					mysqli_stmt_store_result($sqlChecked);
					// If a mail is found in the database, the user will be notified about this before submitting the form
					if (mysqli_stmt_num_rows($sqlChecked) != 0) {
						echo "This email already exists!";
					}
				}
				closeConnection($db, $sqlChecked);
			}
		} else {
			echo "This email is invalid!";
		}
	}
