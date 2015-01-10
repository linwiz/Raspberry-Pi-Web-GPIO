<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="gpio.css">
</head>

<body>
	<script language="javascript" type="text/javascript"
		src="./js/scripts.js"></script>

	<div id="header">
		<h1>GPIO by Web & SMS</h1>
	</div>

	<div id="nav">
		<table>
			<tr>
				<td><a href="#" onclick="changeSection(1)">PINs</a>
				</td>
			</tr>
			<tr>
				<td><a href="#" onclick="changeSection(2)">Log</a>
				</td>
			</tr>
			<tr>
				<td><a href="#" onclick="changeSection(3)">Config</a>
				</td>
			</tr>
		</table>
	</div>

	<div id="section">
		<h1>Welcome ...</h1>
	</div>


	<div id="footer">
		<?php
		include 'footer.php';
		?>
	</div>

</body>
</html>
