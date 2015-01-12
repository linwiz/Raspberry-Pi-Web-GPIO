<html>
<head>
	<title>RPi Web GPIO</title>
	<link rel="stylesheet" type="text/css" href="gpio.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1"/>
</head>
<body>
	<script type="text/javascript" src="./js/scripts.js"></script>
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
		<h1>Welcome</h1>
	</div>
<!--	<div id="footer">
	</div>-->
</body>
</html>
