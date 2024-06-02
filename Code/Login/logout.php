<?php
	require dirname(__DIR__, 1) . "/Utils/session.php";
	require dirname(__DIR__, 1) . "/Utils/redirect.php";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (
		  $user = htmlentities(filter_input(INPUT_GET, "user", FILTER_UNSAFE_RAW)) and
		  isset($_SESSION["isLogged"]) and
		  $user == $_SESSION["isLogged"]
		) {
			unset($_SESSION["isLogged"]);
			$_SESSION["success"] = "You logged out successfully!";
			redirectScript("./login.php");
			echo "<a href='./login.php'>Login</a>";
		} else {
			redirectError();
		}
	}
