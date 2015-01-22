<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('db.php');

try {
	if (!$_SESSION['piRevision']) {
		// Get config setting
		$queryConfig = 'SELECT * FROM config WHERE configVersion = 1';

		$qry_resultConfig = $db->prepare($queryConfig);
		$qry_resultConfig->execute();

		$rowConfig = $qry_resultConfig->fetch(PDO::FETCH_ASSOC);

		// Set site wide config variables.
		$_SESSION['piRevision'] = $rowConfig['piRevision'];
		$_SESSION['debugMode'] = $rowConfig['debugMode'];
		$_SESSION['showDisabledPins'] = $rowConfig['showDisabledPins'];
		$_SESSION['logPageSize'] = $rowConfig['logPageSize'];
		$_SESSION['enableLogging'] = $rowConfig['enableLogging'];
	}

	// Page whitelist.
	$page_whitelist = array('pins', 'log', 'config');
	if (isset($_GET['pageType']) && in_array($_GET['pageType'], $page_whitelist)) {
	        $_SESSION['pageType'] = $_GET['pageType'];
	} else {
	        $_SESSION['pageType'] = "pins";
	}

	// Debug output.
	if ($_SESSION['debugMode']) {
		$configVariables = "            <pre>System Wide Config Variables: </pre>\r\n";
		$configVariables .= "           <pre>\r\n";
		$configVariables .= "           [piRevision] => " . $_SESSION['piRevision'] . "\r\n";
		$configVariables .= "           [debugMode] => " . $_SESSION['debugMode'] . "\r\n";
		$configVariables .= "           [showDisabledPins] => " . $_SESSION['showDisabledPins'] . "\r\n";
		$configVariables .= "           [enableLogging] => " . $_SESSION['enableLogging'] . "\r\n";
		$configVariables .= "           [logPageSize] => " . $_SESSION['logPageSize'] . "\r\n";
		if (isset($_SESSION['username'])) {
			$configVariables .= "           [username] => " . $_SESSION['username'] . "\r\n";
		}
		if (isset($_SESSION['userID'])) {
			$configVariables .= "           [userID] => " . $_SESSION['userID'] . "\r\n";
		}
		$configVariables .= "           [pageType] => " . $_SESSION['pageType'] . "\r\n";
		$configVariables .= "           </pre>\r\n";
	}

	// Set up state icons.
	$stateIcon = array();
	$stateIcon['on'] =  'images/checkbox_checked_icon.png';
	$stateIcon['off'] = 'images/checkbox_unchecked_icon.png';

} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
