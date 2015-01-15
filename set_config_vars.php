<?php
require_once('db.php');

// Get config setting
$queryConfig = 'SELECT * FROM config WHERE configVersion = 1';

$qry_resultConfig = $db->prepare($queryConfig);
$qry_resultConfig->execute();

if (!$qry_resultConfig) {
	$message = '<pre>Invalid query: ' . $db->error . '</pre>';
	$message .= '<pre>Whole query: ' . $queryConfig . '</pre>';
	die($message);
}

$rowConfig = $qry_resultConfig->fetch(PDO::FETCH_ASSOC);

//set app wide config variables

$debugMode = $rowConfig['debugMode'];
$showDisabledPins = $rowConfig['showDisabledPins'];

if ($debugMode) {
	print '<pre>System Wide Config Variables: </pre>';
	print '<pre>';
	print 'debugMode: ' . $debugMode . '<br />';
	print 'showDisabledPins: ' . $showDisabledPins . '<br />';
	print '</pre>';
}



