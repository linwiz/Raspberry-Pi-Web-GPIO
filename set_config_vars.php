<?php
require_once('db.php');

try {
	// Get config setting
	$queryConfig = 'SELECT * FROM config WHERE configVersion = 1';

	$qry_resultConfig = $db->prepare($queryConfig);
	$qry_resultConfig->execute();

	$rowConfig = $qry_resultConfig->fetch(PDO::FETCH_ASSOC);

	// Set site wide config variables.
	// Check for missing revision.
	if (!$rowConfig['piRevision']) {
		exec("python revision.py", $apiRevision);
		$piRevision = $apiRevision[0];
		$queryRev = "UPDATE config SET piRevision=$piRevision WHERE configVersion='1'";
		$qry_resultRev = $db->prepare($queryRev);
		$qry_resultRev->execute();
	} else {
		$piRevision = $rowConfig['piRevision'];
	}
	$debugMode = $rowConfig['debugMode'];
	$showDisabledPins = $rowConfig['showDisabledPins'];
	$logPageSize = $rowConfig['logPageSize'];

	if ($debugMode) {
		print "<pre>System Wide Config Variables: </pre>";
		print "<pre>";
		print "piRevision: $piRevision<br />";
		print "debugMode: $debugMode<br />";
		print "showDisabledPins: $showDisabledPins<br />";
		print "logPageSize: $logPageSize<br />";
		print_r($_SESSION);
		print "</pre>";
	}
} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
