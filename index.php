<?php
require_once('set_config_vars.php');

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
	<div id="header" class="page dark gradient"><h1>RPi Web GPIO</h1></div>
	<div id="nav">
		<a href="#" onclick="changeSection(1)" class="page dark gradient">PINs</a>&nbsp;
		<a href="#" onclick="changeSection(2)" class="page dark gradient">Log</a>&nbsp;
		<a href="#" onclick="changeSection(3)" class="page dark gradient">Config</a>&nbsp;
	</div>
	<div id="section">
<?php
	// Check if user logged in.
	if (isset($_SESSION['username'])) {
		print "		<script type=\"text/javascript\">changeSection(1);</script>\r\n";
	}
?>
		<div id='login'>
			<div class="login_form">
				<h3>Login</h3>
				<form method="POST">
					<label>Username</label>
					<input type="text" name="username" id="username" placeholder="your username" class="page dark gradient" /><br />
					<label>Password</label>
					<input type="password" name="pasword" id="password" placeholder="your password" class="page dark gradient" /><br />
					<input type="submit" id="submit_login" name="submit" value="Login" class="page dark gradient" />
					<span class="login_loading"></span>
					<span class="errormess"></span>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
