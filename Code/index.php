<?php
	require "./Utils/session.php";
	require "./Utils/credentials.php";
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./style/style.css" type="text/css">
	<title>Home</title>
</head>
<?php
	include_once "header.php";
	//=================================================================================================================
	$connection = mysqli_connect($host, $user, $pass, $database);
	if (!$connection) {
		die("Failed to connect: " . mysqli_connect_error());
	}
	$query = $connection->prepare("SELECT event.eventId,
										       event.date,
										       event.time,
										       team.name AS teamName,
										       sport.name AS sportName,
										       stadium.name AS stadiumName,
										       stadium.location
										FROM event
										         JOIN eventmatch ON event.eventId = eventmatch.eventId
										         JOIN team ON eventmatch.teamId = team.teamId
										         JOIN sport ON team.sportId = sport.sportId
										         JOIN stadium ON event.stadiumId = stadium.stadiumId
										WHERE
										    date BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY )
										ORDER BY
										    date, time;");
	$query->execute();
	$result = $query->get_result();
	$datas = array();
	if (mysqli_num_rows($result) > 0) {
		while ($datas[] = $result->fetch_assoc()) {
			//print_r($datas);
		}
	}
	if ($query === 'false') {
		die('Query Failed' . mysqli_error($connection));
	} else {
		//header('location:index.php?insert_msg=Your data has been added successfully!');
	}
	$query->close();
	$connection->close();
	//=================================================================================================================
	function MaincountFunction($MainNumberOne, $MainNumberTwo, $datas)
	{
		echo "<b><p>" . $datas[$MainNumberOne]['teamName'] . "</p>" . "<p>VS </p><p>" .
				$datas[$MainNumberTwo]['teamName'] . "</p><p>" .
				$datas[$MainNumberOne]['date'] . "<br><p>" .
				$datas[$MainNumberOne]['time'] . "<br></b><p>" .
				$datas[$MainNumberOne]['stadiumName'] . "</p>";
	}

?>
<body class="MainBg">
<div id="MainContent">
	<div class="MainGrid">
		<button id="MainButton" onclick="location.href='https://www.google.com'" type="button"><h1>Book Now</h1>
		</button>
		<div class="MainLeftTitleOne"><h1 class="TeamOneAndTwo"><?php echo $datas[0]['teamName']; ?>
				vs <?php echo $datas[1]['teamName']; ?></h1></div>
		<div class="MainLeftParaOne"><p class="TeamOneAndTwo">Descriptions of the event in great detail about the event
				and all the......</p></div>
		<div class="MainLeftTitleTwo"><h1 class="NowTrending">Now Trending</h1></div>
		<div class="MainLeftTitleThree"><h1 class="ThisWeek">This week</h1></div>
		<div class="MainClassFlexOne">
			<div class="MainA">
				<div class="MainA_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports">
				</div>
				
				<div class="MainA_words">
					<?php
						MaincountFunction(0, 1, $datas)
					?>
				</div>
			</div>
			<div class="MainB">
				<div class="MainB_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports">
				</div>
				<div class="MainB_words">
					<?php
						MaincountFunction(2, 3, $datas)
					?>
				</div>
			</div>
			<div class="MainC">
				<div class="MainC_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports">
				</div>
				<div class="MainC_words">
					<?php
						MaincountFunction(4, 5, $datas)
					?>
				</div>
			</div>
		</div>
		<div class="MainClassFlexTwo">
			<div class="MainD">
				<div class="MainD_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports"></div>
				<div class="MainD_words">
					<?php
						MaincountFunction(6, 7, $datas)
					?>
				</div>
			</div>
			<div class="MainE">
				<div class="MainE_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports">
				</div>
				<div class="MainE_words">
					<?php
						MaincountFunction(8, 9, $datas)
					?>
				</div>
			</div>
			<div class="MainF">
				<div class="MainF_image">
					<img src="./assets/mainPageAssets/fcemmenlogo.png" alt="Sports">
				</div>
				<div class="MainF_words">
					<?php
						MaincountFunction(10, 11, $datas)
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include("footer.html");
?>
</body>
</html>

