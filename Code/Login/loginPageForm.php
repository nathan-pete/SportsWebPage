<?php
    // If the user registered just before, a successfully message will be displayed
    if (isset($_SESSION["success"])) {
        echo "<div style='text-align: center; color: green;'><b>" . $_SESSION["success"] . "</b></div>";
        unset($_SESSION["success"]);
    }
?>
<form action="<?= htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="loginFormFirstDiv">
        <label for="email">E-Mail Address</label>
        <input type="email" name="email" id="email" placeholder="Email" title="Your E-mail address"
               value="<?= $uEmail; ?>"
               required>
    </div>
    <div id="passwordDiv1">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="password" placeholder="Password" required>
        <img src="../assets/hidden.png" alt="Eye view" class="passView">
    </div>
    <div class="register">
        <input type="submit" value="Sign In" name="login">
    </div>
</form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<div class='phpResult'>";
        echo "<h2 style='color:red'>$result<h2>";
        echo "</div>";
    }
?>
<div class="loginFormRegisterText">
    Not a member,
    <a href="../Register/register.php">Sign up</a>
</div>
