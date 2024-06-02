<?php
	require "../../Utils/redirect.php";
	$isSuccessful = FALSE;
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (preg_match("~^ticket\d+\.pdf$~", filter_input(INPUT_GET, "file", FILTER_UNSAFE_RAW))) {
			$file = htmlentities($_GET["file"]);
			// It will be called downloaded.pdf
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $file . '"');
			readfile($file);
			$isSuccessful = TRUE;
		}
	}
	if (!$isSuccessful) {
		redirectError();
	}
?>
