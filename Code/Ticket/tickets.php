<?php
	require_once "../Utils/session.php";
	require "../Utils/Database.php";
	require "../Utils/redirect.php";
	require "../Utils/convertDate.php";
	define("ROOT_FOLDER", __DIR__);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../style/style.css" type="text/css">
	<title>Ticket</title>
	<style>
		nav {
			background-color: black;
		}
	</style>
</head>
<body>

<?php
	include_once "../header.php";
?>

<div class="ticketMain">
	<?php
		// Functions used  for sending tickets through mail
		require_once "./SendMail/ticketMail.php";
		
		// Checking, inserting and sending the ticket in the database
		require_once "./TicketFiles/ticketDBCheck.php";
	?>
</div>

<?php
	include_once "../footer.html";
?>

</body>
</html>
