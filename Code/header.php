<?php
	// Checking if the url on the machine has other root folders in front of `/NHL-Sports/Code/`
	$root_folders = preg_replace("@\/NHL-Sports\/Code\/.*@", "", $_SERVER['REQUEST_URI']);
?>
<header>
	<nav>
		<div class="container">
			<div class="logo">
				<img height="120" src="<?= $root_folders; ?>/NHL-Sports/Code/assets/NHLSports.png" width="240">
			</div>
			<div class="menu">
				<div class="item"><a href="<?= $root_folders; ?>/NHL-Sports/Code/index.php"><span>Home</span></a></div>
				<div class="item"><a href="<?= $root_folders; ?>/NHL-Sports/Code/AllSports/Allsports.php"><span>All Sports</span></a>
				</div>
				<?php
					if (isset($_SESSION["isLogged"])) {
						echo '
                              <div class="item"><a href="' . $root_folders . '/NHL-Sports/Code/Login/login.php"><span>' . $_SESSION["isLogged"] . '</span></a></div>
				    ';
					} else {
						echo '
                              <div class="item"><a href="' . $root_folders . '/NHL-Sports/Code/Login/login.php"><span>Login</span></a></div>
				    ';
					}
				?>
				<!--USER PANEL AND PHP SWITCH-->
				<div class="spacer"></div>
				<div class="label">Menu</div>
			</div>
		</div>
	</nav>
</header>
