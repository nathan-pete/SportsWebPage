<?php
	require_once "../Utils/session.php";
	require "../Utils/Database.php";
	require "../Utils/redirect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<link rel="icon" type="image/png" href="../assets/NHLsports.png"/>
	<title>NHL Sports - All Sports</title>
</head>

<body class="image">
<?php
	//Getting Header Code
	include_once "../header.php";
	
	if (isset($_SESSION["isLogged"])) {
		echo '
      <div class="welcomemessage">
        <h2>Welcome ' . $_SESSION["isLogged"] . '!</h2>
      </div>
		';
	} else {
		echo '
      <div class="welcomemessage">
        <h2>Welcome User, Please <a href="../Login/login.php">Login</a>!</h2>
      </div>
		';
	}
?>

<div class="content-wrap">
	<!--Form-->
	<div class="form">
		<form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<h3>
				Fill out the options below!<br>
			</h3>
			<h3>
				<label>
					<select name="month">
						<option value="">Select Month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
				</label>
				<label>
					<select name="sport">
						<option value="">Select Sport</option>
						<option value="Football">Football</option>
						<option value="Hockey">Hockey</option>
						<option value="Tennis">Tennis</option>
						<option value="Basketball">Basketball</option>
					</select>
				</label>
				<input type="submit" value="&#10004;">
			</h3>
		</form>
	</div>
	
	<?php
		require "../Utils/convertDate.php";
		//Getting code from SportsDB
		require_once "./sportsdb.php";
		
		//Filtering Form Input
		$acceptedMonth = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
		$acceptedSport = ["Football", "Hockey", "Tennis", "Basketball"];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$month = filter_input(INPUT_POST, "month", FILTER_SANITIZE_NUMBER_INT);
			$sport = htmlspecialchars($_POST["sport"]); //Instead of FILTER_SANITIZE_STRING
			if (in_array($month, $acceptedMonth) and in_array($sport, $acceptedSport)) {
				$monthStr = convertDate("2022-" . $month . "01")[1];
				
				//Creating boxes
				echo "<div class='top-left'><h3 class='Month'>$monthStr - $sport</h3></div>";
				echo "<div class='boxcontainer'>";
				echo "<div class='boxes'>";
				foreach ($events as $event => $eventdetails) {
					if ($month == substr($eventdetails[3], 5, 2) and $sport == $eventdetails[2]) {
						list($day, $monthStr, $year) = convertDate($eventdetails[3]);
						echo '
			                <a href = "../Ticket/event.php?eventID=' . $event . '">
			                    <div class="box">
			                        <div class="front">
			                            <img src = "../assets/TeamLogo/fcemmenlogo.png" alt = "Logo 1" width = "85" height = "100">
			                            <img src = "../assets/TeamLogo/ajaxamsterdamlogo.png" alt = "Logo 2" width = "85" height = "85">
			                        </div>
			                        <div class="back">
			                            <p class="data"> ' . $eventdetails[0] . ' VS ' . $eventdetails[1] . ' </p>
			                            <p class="data"> ' . $day . ' / ' . $monthStr . ' / ' . $year . '</p>
			                        </div>
			                    </div>
			                </a>';
					}
				}
				echo "</div>";
				echo "</div>";
			} else {
				echo '
			        <div class="errormessage">
			            <h5> Error: Inputs are Invalid. Please try again.</h5>
			        </div>';
			}
			
		}
	?>
</div>

<?php
	//Getting Footer Code
	include_once "../footer.html";
?>

</body>
</html>
