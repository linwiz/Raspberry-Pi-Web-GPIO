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
	}

	if ($_SESSION['debugMode']) {
		print "<pre>System Wide Config Variables: </pre>";
		print "<pre>";
		print_r($_SESSION);
		print "</pre>";
	}
} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
