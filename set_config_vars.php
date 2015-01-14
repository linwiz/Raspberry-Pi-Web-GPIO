<?php

require_once('mysqli.php');

// Get config setting
$queryConfig = "SELECT * FROM config WHERE configVersion = 1";

$qry_resultConfig = $mysqli->query($queryConfig);

if (!$qry_resultConfig) {
	$message = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
	$message .= '<pre>Whole query: ' . $queryConfig . "</pre>";
	die($message);
}

$rowConfig = mysqli_fetch_array($qry_resultConfig);

//set app wide config variables

$debugMode=$rowConfig['debugMode'];
$showDisabledPins=$rowConfig['showDisabledPins'];

if ($debugMode) {
	print '<pre>System Wide Config Variables: </pre>';
	print '<pre>';
	print 'debugMode: '.$debugMode.'<br>';
	print 'showDisabledPins: '.$showDisabledPins.'<br>';
	print '</pre>';
}



