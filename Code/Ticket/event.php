<?php
	require "../Utils/session.php";
	require "../Utils/Database.php";
	require "../Utils/redirect.php";
	require "../Utils/convertDate.php";
	// PHP code needed for this page
	require_once "./EventFiles/eventDB.php";
	
	$playing = $_SESSION["teams"][0] . " VS " . $_SESSION["teams"][1];
	$date = convertDate($_SESSION["eventDate"])[0] . " of " . convertDate($_SESSION["eventDate"])[1] . ", " . convertDate($_SESSION["eventDate"])[2];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		// If javascript is enabled a session variable will be created to make PHP know that client has JS enabled
		$.ajax({
			type: "POST",
			url: "./EventFiles/checkJS.php",
			data: {"js": true}
		})
	</script>
	<title><?= $playing; ?></title>
</head>
<body class="image">

<?php
	include_once "../header.php";
?>

<div class="content-wrap">
	<div class="eventMiddle">
		<div class="eventDetails">
			<div class="eventTitle">
				<h1><?= $playing; ?></h1>
			</div>
			<div class="eventDate"> <?= $date; ?> </div>
			<div class="eventTime"> <?= substr($_SESSION["eventTime"], 0, -3); ?> </div>
			<div class="eventLocation"> <?= $_SESSION["eventLocation"]; ?> </div>
		</div>
		<div class="eventBook">
			<a href="./event_book.php"><input type="submit" value="Book Now"></a>
		</div>
	</div>
</div>

<?php
	include_once "../footer.html";
?>

</body>
</html>
