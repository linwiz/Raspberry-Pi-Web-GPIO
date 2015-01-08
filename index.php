<?php
// Please run setup.py
// OR update the MySQLi host, username,
// password, database and Pi revision
// in GPIOServer.conf.sh

// Default login: admin
// Default password: rpi

// No need to edit anything in this file.
// Unless you really just want to.
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Raspberry Pi GPIO</title>
    <link href="styles/kendo.common.min.css" rel="stylesheet" />
    <link href="styles/kendo.default.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.default.min.css" rel="stylesheet" />
    <link href="styles/kendo.mobile.all.min.css" rel="stylesheet" />
    <link href="styles/styles.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/kendo.all.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.4, maximum-scale=1.4, user-scalable=0"/>
</head>
<body>
<?php
// Get the name of this file.
$break = Explode('/', $_SERVER["SCRIPT_NAME"]);
$thisScript = $break[count($break) - 1];

// MySQLi Connection.
require_once('mysqli.php');

// Mobile class functions.
require_once('mobClass.php');
$mobClass = new mobClass;

// Password hashing functions.
require_once('scrypt.php');

if ($pi_rev == '' || $MySQLi_Host == '' || $MySQLi_User == '' || $MySQLi_Password == '' || $MySQLi_DataBase == '') {
	die("Please run setup.py or configure the values in the GPIOServer.conf.sh file.");
}

if (isset($_GET['message'])) {
	$messageCode = $db->real_escape_string($_GET['message']);
}
else {
	$messageCode = '';
}

if (isset($_SESSION['username']) && isset($_SESSION['userID'])) {
	$username = $_SESSION['username'];
	$userID = $_SESSION['userID'];
}
else {
	$username = '';
	$userID = '';
}
// Check if user logged in.
If (!$mobClass->loggedIn($username, $userID)) {
	// No, lets log in. Makes login form the default page.
	$my_array = array(
		array("Username", "text", "username", ""),
		array("Password", "password", "password", "")
	);
	print $mobClass->newDrawer('login', 'Log In', 'Log in', TRUE, $my_array, $messageCode);

	// Process login form.
	If (isset($_POST['username'])) {
		$resultLogin = $mobClass->checkLogin($_POST['username'], $_POST['password']);
		if ($resultLogin === TRUE) {
			header('location: ' . $thisScript);
		}
		else {
			header('location: ' . $thisScript . '?message='.$resultLogin);
		}
	}
}
else { // Logged in.
	if (isset($_POST['action'])) {
		$action = $db->real_escape_string($_POST['action']);
		// Update pin description.
		if ($action == "update") {
			$array = $mobClass->arrayPins();
			foreach ($array as $pin) {
				$pinDescription = $db->real_escape_string($_POST['pinDescription' . $pin]);
				if (isset($_POST['pinEnabled' . $pin])) {
					$pinEnabled = 1;
				}
				else {
					$pinEnabled = 0;
				}
				$db->query("UPDATE pinRevision$pi_rev SET pinEnabled='$pinEnabled', pinDescription='$pinDescription' WHERE pinNumberBCM='$pin'") or die ($db->error);
			}
			header('Location: ' . $thisScript . '?message=pinDescriptionUpdated');
		}

		// Change Password.
		else if ($action == "setPassword") {
			$currentPassword = $db->real_escape_string($_POST['password0']);
			$newPassword1 = $db->real_escape_string($_POST['password1']);
			$newPassword2 = $db->real_escape_string($_POST['password2']);
			If ($newPassword1 != $newPassword2) {
				header('Location: ' . $thisScript . '?message=passwordsDoNotMatch#drawer-password');
				die();
			}
			If (strlen($newPassword1) < 1 || strlen($newPassword1) > 256) {
				header('location: ' . $thisScript . '?message=passwordLength#drawer-password');
				die();
			}

			$resetQuery = "SELECT username, password FROM users WHERE username = '$username';";
			$resetResult = $db->query($resetQuery) or die ($db->error);
			If ($resetResult->num_rows < 1) {
				header('location: ' . $thisScript . '?message=incorrectUser#drawer-password');
				die();
			}
			$resetData = $resetResult->fetch_assoc();
			$databasePassword = $resetData['password'];
			if (Password::check($currentPassword, $databasePassword) === FALSE) {
				header('Location: ' . $thisScript . '?message=incorrectPassword#drawer-password');
				die();
			}
			$resetResult->free();
			$newHash = Password::hash($newPassword1);
			$db->query("UPDATE users SET password='$newHash' WHERE username='$username'") or die ($db->error);
			header('location: ' . $thisScript . '?message=passwordChanged');
		}

		// Logout
		else if ($action == "logout") {
			$_SESSION = array();
			session_destroy();
			header('Location: ' . $thisScript);
		}

		// Update pin status.
		else if ($action == "turnOn" || $action == "turnOff") {
			$pin = $db->real_escape_string($_POST['pin']);
			if ($action == "turnOn") {
				$setting = "1";
				$db->query("UPDATE pinRevision$pi_rev SET pinStatus='$setting' WHERE pinNumberBCM='$pin';") or die ($db->error);
			} else If ($action == "turnOff") {
				$setting = "0";
				$db->query("UPDATE pinRevision$pi_rev SET pinStatus='$setting' WHERE pinNumberBCM='$pin';") or die ($db->error);
			}
			header('Location: ' . $thisScript . '?message=pinUpdated');
		}

		// Clear lgo.
		else if ($action == "Clear") {
			$db->query("TRUNCATE TABLE log;") or die ($db->error);
			header('Location: ' . $thisScript . '?message=logCleared');
		}

		else {
			header('Location: ' . $thisScript);
		}
	}
}
?>

	<div data-role="view" id="drawer-home" data-layout="drawer-layout" data-title="Raspberry Pi GPIO">
		<ul data-role="listview" class="inboxList">
<?php print $mobClass->newMessage($messageCode); ?>
<?php $mobClass->fillToggleForm(); ?>
		</ul>
	</div>

<?php
	// Generate Password page.
	$passwordArray = array(
		array("Current Password", "password", "password0", ""),
		array("New Password", "password", "password1", ""),
		array("New Password", "password", "password2", ""),
		array("", "hidden", "action", "setPassword")
	);
	print $mobClass->newDrawer('password', 'Password', 'Change Password', TRUE, $passwordArray, $messageCode);

	// Generate Logout page.
	$my_array = array(
		array("", "hidden", "action", "logout"),
		array("", "submit", "", "Log Out", "k-button")
	);
	print $mobClass->newDrawer('logout', 'Log Out', 'Log Out', FALSE, $my_array, $messageCode);
?>

	<div data-role="view" id="drawer-edit" data-layout="drawer-layout" data-title="Edit Pin Description">
		<ul data-role="listview" class="inboxList">
			<form id="formEdit" action="<?php print $thisScript; ?>" method="post">
				<ul data-role="listview" data-style="inset" data-type="group">
<?php							print $mobClass->newMessage($messageCode); ?>
					<li>Edit
						<ul>
							<?php $mobClass->fillEditPinForm(); ?>
						</ul>
					</li>
				</ul>
			</form>
		</ul>
	</div>

	<div data-role="view" id="drawer-log" data-layout="drawer-layout" data-title="Log">
		<ul data-role="listview" class="inboxList">
			<ul data-role="listview" data-style="inset" data-type="group">
				<li>
					<ul>
<?php						print $mobClass->newMessage($messageCode); ?>
						<li><form id="formLog" action="<?php print $thisScript; ?>#drawer-log" method="post"><input type="submit" name="action" value="Clear" /><input type="submit" name="action" value="Refresh" /></form></li>
						<?php $mobClass->fillLogForm(); ?>
					</ul>
				</li>
			</ul>
		</ul>
	</div>

	<div data-role="drawer" id="my-drawer" style="width: 270px" data-views="['drawer-home', 'drawer-login', 'drawer-edit', 'drawer-logout', 'drawer-password', 'drawer-log']">
		<ul data-role="listview" data-type="group">
<?php
 if ($mobClass->loggedIn($username, $userID)) {
print '			<li>menu
				<ul>
					<li data-icon="inbox"><a href="#drawer-home" data-transition="none">GPIO</a></li>
					<li data-icon="inbox"><a href="#drawer-log" data-transition="none">Log</a></li>
				</ul>
			</li>
			<li>Account
				<ul>
					<li data-icon="settings"><a href="#drawer-password" data-transition="none">Password</a></li>
					<li data-icon="off"><a href="#drawer-logout" data-transition="none">Log Out</a></li>' . "\r\n";
}
else {
print '
			<li>Account
				<ul>
					<li data-icon="off"><a href="#drawer-login" data-transition="none">Log In</a></li>' . "\r\n";
}
?>
				</ul>
			</li>
		</ul>
	</div>

	<div data-role="layout" data-id="drawer-layout">
		<header data-role="header">
			<div data-role="navbar">
				<a data-role="button" data-rel="drawer" href="#my-drawer" data-icon="drawer-button" data-align="left"></a>
				<span data-role="view-title"></span>
<?php
	if ($mobClass->loggedIn($username, $userID)) {
		print '				<a data-align="right" data-role="button" class="nav-button" href="#drawer-edit">Edit</a>' . "\r\n";
	}
?>
			</div>
		</header>
	</div>

	<script>
<?php
	$array = $mobClass->arrayPins();
	foreach ($array as $pin) {
		print "		function switchChange" . $pin . "(e) { $('#form" . $pin . "').submit(); }\r\n";
	}
?>
	</script>
	<script>
		var app = new kendo.mobile.Application(document.body);
	</script>
</body>
</html>
