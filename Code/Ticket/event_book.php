<?php
	require "../Utils/session.php";
	require "../Utils/Database.php";
	require "../Utils/redirect.php";
	// If the user is not logged in it is not possible to book a ticket
	if (!isset($_SESSION["isLogged"])) {
		$_SESSION["success"] = "<span style='color: red'>You have to log in first!</span>";
		// If the user logs in it will be redirected back here
		if (isset($_SESSION["eventID"])) {
			$_SESSION["redURL"] = "../Ticket/event.php?eventID=" . $_SESSION["eventID"];
		}
		redirectScript("../Login/login.php");
		die();
	}
	require_once "./SeatBookFiles/stadiumZones.php";
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="../JS/seatDisplay.js" type="text/javascript"></script>
	<title>Booking</title>
	<style>
		nav {
			background-color: black;
		}
	</style>
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			echo "
                 <style>
                    .stadium, .stadiumZones {
                        animation-name: none;
                    }
                 </style>
                 ";
		}
	?>
</head>
<body>

<?php
	include_once "../header.php";
?>

<div class="content-wrap">
	<div class="mainStadium">
		<div class="stadium">
			<div class="stadiumUp">
				<?php
					if (!isset($_SESSION["JavaScript"])) {
						foreach ($seatDisplayZones1 as $zoneName => $zoneDetails) {
							foreach ($zoneDetails as $Type => $capacity) {
								echo "
                            <form action='" . htmlentities($_SERVER["PHP_SELF"]) . "?eventID=$eventID' method='POST' class='zone' title='This zone has $capacity seats'>
                                <input type='submit' value='$zoneName' class='input$Type' name='zoneID'>
                            </form>";
							}
						}
					} else {
						foreach ($seatDisplayZones1 as $zoneName => $zoneDetails) {
							foreach ($zoneDetails as $Type => $capacity) {
								echo "
                            <div class='zoneDiv input$Type' event='$eventID' zone='$zoneName' title='This zone has $capacity seats'>
                                $zoneName
                            </div>";
							}
						}
					}
				?>
			</div>
			
			<div class="stadiumMiddle">
				<div class="stadiumMiddleLeft"></div>
				<div class="stadiumImage"><img src="../assets/pitchScheme.jpg" alt="Stadium"></div>
				<div class="stadiumMiddleRight"></div>
			</div>
			
			<div class="stadiumDown">
				<?php
					if (!isset($_SESSION["JavaScript"])) {
						foreach ($seatDisplayZones2 as $zoneName => $zoneDetails) {
							foreach ($zoneDetails as $Type => $capacity) {
								echo "
                            <form action='" . htmlentities($_SERVER["PHP_SELF"]) . "?eventID=$eventID' method='POST' class='zone' title='This zone has $capacity seats'>
                                <input type='submit' value='$zoneName' class='input$Type' name='zoneID'>
                            </form>";
							}
						}
					} else {
						foreach ($seatDisplayZones2 as $zoneName => $zoneDetails) {
							foreach ($zoneDetails as $Type => $capacity) {
								echo "
                            <div class='zoneDiv input$Type' event='$eventID' zone='$zoneName' title='This zone has $capacity seats'>
                                $zoneName
                            </div>";
							}
						}
					}
				?>
			</div>
		</div>
		
		<div class="stadiumZones">
			<?php
				foreach ($seats as $seat => $seatPrice) {
					echo "<div class='zoneTicket JQ$seat'>
                        <div class='zone$seat'>$seat</div>
                        <div class='zoneTicketline'></div>
                        <div>\$ $seatPrice</div>
                      </div>";
				}
			?>
		</div>
	</div>
	
	<span class="seatDisplay">
    <?php
	    if (!isset($_SESSION["JavaScript"])) {
		    require_once "./SeatBookFiles/seatDisplay.php";
	    }
    ?>
	</span>
</div>

<?php
	include_once "../footer.html";
?>

</body>
</html>
