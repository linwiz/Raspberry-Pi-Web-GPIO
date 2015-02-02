<?php
require_once('set_config_vars.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                print "Logged out. Please reload page.\r\n";
        }
        ?>
	</div>
</body>
</html>
