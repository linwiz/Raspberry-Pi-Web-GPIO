<?php
session_start();
// Database connection & config
require_once 'db.php';
// Password hashing functions.
require_once('scrypt.php');

if ($db_Host == '' || $db_User == '' || $db_Password == '' || $db_DataBase == '') {
	die("Please configure the values in the GPIOServer.conf.sh file and then run setup.py.");
}
?>
<html>
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="./styles/gpio.css">
	<meta name="viewport" content="width=150, initial-scale=1, maximum-scale=5, user-scalable=1"/>
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="./images/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="./images/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="./images/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="./images/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="./images/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="./images/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="./images/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="./images/apple-touch-icon-152x152.png" />
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/scripts.js"></script>
</head>
<body>
	<div id="header">RPi Web GPIO</div>
	<div id="nav">
	</div>
	<div id="section">
<?php
	include 'set_config_vars.php';
	// Check if user logged in.
	if (isset($_SESSION['username'])) {
		print "		<script type=\"text/javascript\">showNavigation(1);changeSection(1);</script>\r\n";
	} else {
		print "		<script type=\"text/javascript\">showNavigation(0);</script>\r\n";
	}
?>
		<div id='login'>
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
	</div>
</body>
</html>
