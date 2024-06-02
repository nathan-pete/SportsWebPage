<?php
	require __DIR__ . "/session.php";
	require __DIR__ . "/redirect.php";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../style/style.css" type="text/css">
	<title>Error</title>
</head>
<body>

<div style="background-color: black; margin-bottom: 1em">
	<?php
		include_once "../header.php";
	?>
</div>

<h1>OOPS...</h1>

<h1>This is a 404 :(</h1>
<br><br><br>
<h2>Reason: </h2>
<?php
	if (isset($_SESSION["errorMessage"])) {
		echo "<div style='color: red;'>" . $_SESSION["errorMessage"] . "</div>";
		unset($_SESSION["errorMessage"]);
	} else {
		redirectScript("../index.php");
	}
?>

<br><br><br>
<h3>Return to the <a href="../index.php">Main page</a>!</h3>

<?php
	include_once "../footer.html";
?>

</body>
</html>

