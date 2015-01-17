<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Log</title>
<script type="text/javascript" src="./js/scripts.js"></script>
</head>
<body>
	<div id='log'>
        <?php
        // Check if user logged in.
        if (isset($_SESSION['username'])) {
                include 'get_log.php';
        }
        ?>
	</div>
</body>
</html>
