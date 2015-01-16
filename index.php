<?php
session_start();
// Database connection & config
// looks strange when the Globals are displayed twice but it seems it's sent before headers so 'once' is not working ...
// So I disabled getting config here,  it should be checked out.
//require_once 'set_config_vars.php';
require_once 'db.php';

// Password hashing functions.
require_once('scrypt.php');

// not sure it's important here now
//require_once ('set_config_vars.php');
if ($pi_rev == '' || $db_Host == '' || $db_User == '' || $db_Password == '' || $db_DataBase == '') {
	die("Please configure the values in the GPIOServer.conf.sh file and then run setup.py.");
}
?>
<html>
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="./styles/gpio.css">
	<meta name="viewport" content="width=150, initial-scale=1, maximum-scale=15, user-scalable=1"/>
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png" /></head>
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
