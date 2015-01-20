<?php
include 'set_config_vars.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php print $_SESSION['pageType']; ?></title>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/scripts.js"></script>
</head>
<body>
	<div id='<?php print $_SESSION['pageType']; ?>'>
        <?php
        // Check if user logged in.
        if (isset($_SESSION['username'])) {
                include "ajax.php";
        } else {
                print "         <script type=\"text/javascript\">showNavigation(0);</script>\r\n";
                print "Logged out. Please reload page.\r\n";
        }
        ?>
	</div>
</body>
</html>
