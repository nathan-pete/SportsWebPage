<?php
	require dirname(__DIR__, 2) . "/Utils/session.php";
	// Checking if javascript is enabled
	if ($_SERVER["REQUEST_METHOD"] == "POST" and $js = filter_input(INPUT_POST, "js", FILTER_VALIDATE_BOOL)) {
		$_SESSION["JavaScript"] = TRUE;
	}
