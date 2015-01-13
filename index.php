<?php
require_once('mobClass.php');
$mobClass = new mobClass;
?>
<html>
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="./styles/gpio.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1"/>
</head>
<body>
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/scripts.js"></script>
	<script type="text/javascript">
<?php
// Check if user logged in.
if (isset($_SESSION['username'])) {
	echo "changeSection(1);\r\n";
}
?>
	</script>
	<div id="header">
		<h1>RPi Web GPIO</h1>
	</div>
	<div id="nav">
		<a href="#" onclick="changeSection(1)">PINs</a>
		<a href="#" onclick="changeSection(2)">Log</a>
		<a href="#" onclick="changeSection(3)">Config</a>
		<?php include 'status.php'; ?>
	</div>
	<div id="section">
        <div class="login_form">
        <h3>Login</h3>
        <form method="POST">
        <label>Username</label>
        <input type="text" name="username" id="username" placeholder="your username" /><br />
        <label>Password</label>
        <input type="password" name="pasword" id="password" placeholder="your password" /><br />
        <input type="submit" id="submit_login" name="submit" class="inputbutton grey" value="Login" />
        <span class="login_loading"></span>
        <span class="errormess"></span>
        </form>
        </div>
	</div>
</body>
</html>
