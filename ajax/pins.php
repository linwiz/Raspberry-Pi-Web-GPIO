<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Pins</title>
</head>
<body>

	<?php 
	$sort = $_GET['sort'];
	
	?>

	<!-- 
	<a href="#" onclick="showPins('pinNumberBCM%2B0')">Refresh</a>	
	 -->

	<div id='pins'>
		<?php
		include 'get_pins.php';
		?>
	</div>

</body>
</html>
