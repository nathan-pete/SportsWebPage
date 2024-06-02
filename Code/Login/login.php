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
	<link rel="stylesheet" href="../style/style.css" type="text/css">
	<link rel="icon" type="image/png" href="../assets/favicon.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		$(function () {
			// When the "eye" is pressed, the input changes to type=text and the icon changes to a "hidden eye"
			$(".passView").on("click", function () {
				let inputType = $("#password").prop("type");
				if (inputType === "password") {
					$(this).prop("src", "../assets/view.png");
					$(".password").prop("type", "text");
				} else {
					$(this).prop("src", "../assets/hidden.png");
					$(".password").prop("type", "password");
				}
			});
		})
	</script>
	<title>Login</title>
</head>

<?php
	// PHP code needed for the login page
	require_once "./loginPageDB.php";
?>

<body class="backGround">
<div class="loginMain">
	<div class="loginMainTitle"><h1>Login</h1></div>
	<a href="../AllSports/Allsports.php" class="loginMainLeft">
		<div class="leftLogin">
			<div class="leftLoginUp"><h1>Bringing People Together.</h1></div>
			<div class="leftLoginLine"></div>
			<div class="leftLoginDown">Discover events create meaningful experiences through ticketmaster</div>
		</div>
	</a>
	
	<div class="loginForm">
		<?php
			if (!isset($_SESSION["isLogged"])) {
				require_once "./loginPageForm.php";
			} else {
				echo "
                    <style>
                        .loginForm {
                            align-content: center;
                            text-align: center;
                            line-height: 2;
                        }
                    </style>";
				echo
						"
                    <h2>You are logged in as " . $_SESSION["isLogged"] . "!</h2>
                    <i>Do you want to log out now?</i>
                    <form action='./logout.php?user=" . $_SESSION["isLogged"] . "' method='POST'>
                        <input type='submit' value='Logout'>
                    </form>
                ";
			}
		?>
	</div>
</div>

</body>
</html>
