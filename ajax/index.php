<html>
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="gpio.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1"/>
</head>
<body>
	<script type="text/javascript" src="./js/scripts.js"></script>
	<script type="text/javascript">
	<?php
require_once('mobClass.php');
$mobClass = new mobClass;

// Check if user logged in.
If (!$mobClass->loggedIn($username, $userID)) {
	// No, lets log in. Makes login form the default page.
	echo "changeSection(0);\r\n";
}
else { // Logged in.
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
	</div>
</body>
</html>
