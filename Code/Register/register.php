<?php
	require_once "../Utils/session.php";
	require_once "../Utils/redirect.php";
	require "../Utils/Database.php";
	// We redirect the user to the login page if he is logged in
	// In the login page the user will have the opportunity to logout
	if (isset($_SESSION["isLogged"])) {
		redirectScript("../Login/login.php");
		die();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="../JS/checkInput.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../style/style.css" type="text/css">
	<link rel="icon" type="image/ico" href="../assets/favicon.ico"/>
	<title>Register</title>
</head>

<?php
	// The php code needed for registration
	require_once "./registerPageDB.php";
?>
<body class="backGround">
<div class="loginMain">
	<div class="loginMainTitle"><h1>Register</h1></div>
	<a href="../AllSports/Allsports.php" class="loginMainLeft">
		<div class="leftLogin">
			<div class="leftLoginUp"><h1>Bringing People Together.</h1></div>
			<div class="leftLoginLine"></div>
			<div class="leftLoginDown">Discover events create meaningful experiences through ticketmaster</div>
		</div>
	</a>
	
	<div class="loginForm">
		<form action="<?= htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
			<div>
				<label for="firstname">Firstname</label>
				<input type="text" name="firstname" id="firstname" placeholder="Firstname"
				       value="<?= $uFirstname; ?>" required>
			</div>
			<div>
				<label for="lastname">Lastname</label>
				<input type="text" name="lastname" id="lastname" placeholder="Lastname"
				       value="<?= $uLastname; ?>" required>
			</div>
			<div>
				<label for="email">Email</label><span id="emailCheck"></span>
				<input type="email" name="email" id="email" placeholder="Email"
				       value="<?= $uEmail; ?>" title="Your Email"
				       required>
			</div>
			<div id="passwordDiv1">
				<label for="password1">Password</label><span id="passCheck"></span>
				<input type="password" name="password1" id="password1" class="password" placeholder="Password"
				       title="8 characters, 1 upper-case letter, 1 digit, 1 special symbol" required>
				<img src="../assets/hidden.png" alt="Eye view" class="passView">
				<div class="passRequirements">
					<p>
						The password must be 8 characters in length, and must contain <b>at least</b>:<br>
						- 1 uppercase letter;<br>
						- 1 digit (0-9);<br>
						- 1 special symbol (!, $, #).
					</p>
				</div>
			</div>
			<div>
				<label for="password2">Retype Password</label><span id="passCheck"></span>
				<input type="password" name="password2" id="password2" class="password" placeholder="Repeat Password"
				       title="8 characters, 1 upper-case letter, 1 digit, 1 special symbol" required>
			</div>
			<div class="register">
				<input type="submit" value="Register" name="register" id="register">
			</div>
		</form>
		
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST" and !$isSuccessful) {
				echo "<div class='phpResult'>";
				echo "<p style='color: red;'>$result</p>";
				echo "</div>";
			}
		?>
		
		<div class="loginFormRegisterText">
			Already have an account,
			<a href="../Login/login.php">Sign In</a>
		</div>
	</div>
</div>

</body>
</html>
