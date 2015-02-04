<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once('db.php');
require_once('scrypt.php');

try {
	if (!isset($_SESSION['piRevision'])) {
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
		$_SESSION['showBCMNumber'] = $rowConfig['showBCMNumber'];
		$_SESSION['showWPiNumber'] = $rowConfig['showWPiNumber'];
		$_SESSION['showDisableBox'] = $rowConfig['showDisableBox'];
		$_SESSION['pinDelay'] = $rowConfig['pinDelay'];
		$_SESSION['sortDir'] = 'ASC';
	}

	// Configure whitelists.
	$page_whitelist = array('pins', 'log', 'config', 'edit');
	$sort_whitelist = array('pinID+0', 'pinDirection', 'pinNumberBCM+0', 'pinNumberWPi+0', 'pinDescription', 'pinStatus+0', 'pinEnabled+0');
	$field_whitelist = array('pinID', 'pinDirection', 'pinNumberBCM', 'pinNumberWPi', 'pinDescription', 'pinStatus', 'pinEnabled');
	$sortDir_whitelist = array('ASC', 'DESC');

	// Set up calling params.
	if (isset($_GET['pageType']) && in_array($_GET['pageType'], $page_whitelist)) {
		$_SESSION['pageType'] = $_GET['pageType'];
	} else {
		$_SESSION['pageType'] = "pins";
	}

	if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_whitelist)) {
		$sort = $_GET['sort'];
	} else {
		$sort = "pinNumberBCM+0";
	}

	if (isset($_GET['field']) && in_array($_GET['field'], $field_whitelist)) {
		$field = $_GET['field'];
	} else {
		$field = "none";
	}

	if (isset($_GET['id']) && ($_GET['id']!= 'undefined')) {
		$id = $_GET['id'];
		if ((int)$id != $id || (int)$id >= 0) {
			$id = $_GET['id'];
		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}

	if (isset($_GET['sortDir']) && in_array($_GET['sortDir'], $sortDir_whitelist)) {
		$_SESSION['sortDir'] = $_GET['sortDir'];
	} else {
		$_SESSION['sortDir'] = "ASC";
	}

	// Set up state icons.
	$stateIcon = array();
	$stateIcon['on'] =  'images/checkbox_checked_icon.png';
	$stateIcon['off'] = 'images/checkbox_unchecked_icon.png';

	// Daemon status.
	exec("pgrep GPIOServer.sh", $pids);
	if (empty($pids)) {
		$_SESSION['gpioserverdStatus'] = 0;
	} else {
		$_SESSION['gpioserverdStatus'] = 1;
	}

	// Debug output.
	$configVariables = "		<pre>System Wide Config Variables:</pre>\r\n";
	foreach ($_SESSION as $key => $value) {
		$configVariables .= "		<pre> " . $key . "=>" . $value . "</pre>\r\n";
	}

	$configVariables .= "		<pre>GET Variables:</pre>\r\n";
	foreach ($_GET as $key => $value) {
		$configVariables .= "		<pre> " . $key . "=>" . $value . "</pre>\r\n";
	}
} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
