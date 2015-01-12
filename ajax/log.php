<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Log</title>
<body>
	<a href="#" onclick="showLog()">Refresh</a>
	<form name='myForm'>
		ID Range: <input type='text' id='id1' onchange='showLog()' /> <input
			type='text' id='id2' onchange='showLog()' /> <br />
	</form>

	<div id='log'>
		<?php
		include 'get_log.php';
		?>

	</div>
</body>
</html>
