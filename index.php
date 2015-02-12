<?php
require_once('set_config_vars.php');

if ($db_Host == '' || $db_User == '' || $db_Password == '' || $db_DataBase == '') {
	die("Please configure the values in the GPIOServer.conf.sh file and then run setup.py.");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="./styles/gpio.css" />
	<meta name="viewport" content="width=150, initial-scale=1, maximum-scale=5, user-scalable=1"/>
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="./apple-touch-icon.png" />
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/scripts.js"></script>
</head>
<body>
	<div id="header" class="page dark gradient"><h1>RPi Web GPIO</h1></div>
	<div id="nav">
		<a href="#" onclick="changeSection(1)" class="page dark gradient">PINs</a>&nbsp;
		<a href="#" onclick="changeSection(2)" class="page dark gradient">Log</a>&nbsp;
		<a href="#" onclick="changeSection(3)" class="page dark gradient">Config</a>&nbsp;
	</div>
	<div id="section">
<?php
	// Check if user logged in.
	if ((isset($_SESSION['username'])) || ($_SESSION['debugMode'])) {
		print "		<script type=\"text/javascript\">changeSection(1);</script>\r\n";
	}
?>
		<div id='login'>
			<div class="login_form">
				<h3>Login</h3>
				<fieldset>
					<input type="text" name="username" id="username" placeholder="username" class="page dark gradient" onkeydown="if (event.keyCode == 13) document.getElementById('submit_login').click()" size="10" /><br />
					<input type="password" name="pasword" id="password" placeholder="password" class="page dark gradient" onkeydown="if (event.keyCode == 13) document.getElementById('submit_login').click()" size="10" /><br />
					<input type="button" id="submit_login" name="submit" value="Login" class="page dark gradient" />
					<span class="login_loading"></span>
					<span class="errormess"></span>
				</fieldset>
			</div>
		</div>
	</div>
</body>
</html>
