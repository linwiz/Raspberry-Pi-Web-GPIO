<?php
require_once ('set_config_vars.php');

// Set up calling params.

// Get params for update.
$updateConfig		= isset($_GET['updateConfig']) && ($_GET['updateConfig']!= 'undefined') 	? $_GET['updateConfig'] 	: 0;
$debugModeTemp			= isset($_GET['debugMode']) && ($_GET['debugMode']!= 'undefined') 	? $_GET['debugMode'] 	: 0;
$showDisabledPinsTemp 	= isset($_GET['showDisabledPins'])  	&& ($_GET['showDisabledPins']!= 'undefined') 		? $_GET['showDisabledPins'] 		: 0;

// Set up state icons.
$on =  'images/checkbox_checked_icon.png';
$off = 'images/checkbox_unchecked_icon.png';

// Escape params.
$updateConfig = $mysqli->real_escape_string($updateConfig);
$debugModeTemp = $mysqli->real_escape_string($debugModeTemp);
$showDisabledPinsTemp = $mysqli->real_escape_string($showDisabledPinsTemp);

// Update config fields as (if) needed.
$query_update = "";

if ($updateConfig>0) {
	$query_update = "UPDATE config SET debugMode=".$debugModeTemp.", showDisabledPins = ".$showDisabledPinsTemp."  WHERE configVersion = 1;";
	$qry_result = $mysqli->query($query_update);
	if (!$qry_result) {
		$message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
		$message .= '<pre>Whole query: ' . $query_update . "</pre>";
		die($message);
	}
}

// Select the only row.
$query = "SELECT * FROM config WHERE configVersion = 1";

$qry_result = $mysqli->query($query);

if (!$qry_result) {
	$message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
	$message .= '<pre>Whole query: ' . $query . "</pre>";
	die($message);
}

// Config table has only ONE row to return.
$row = mysqli_fetch_array($qry_result);

$debugMode=$row['debugMode'];
$showDisabledPins=$row['showDisabledPins'];

// Build Result String.
$display_string = "<table>";

// Debug Mode.
$display_string .= "<tr>";
$display_string .= "<td><a href=\"#\" onclick=\"showConfig(1,".($debugMode == 1 ? '0':'1').",".$showDisabledPins.")\">Enable Debug Mode</a></td>";
$display_string .= "<td>";

switch ($debugMode){
	case 1 :
		$display_string .= "<img src=\"$on\" />";
		break;
	case 0 :
		$display_string .= "<img src=\"$off\" />";
		break;
}
$display_string .= "</a></td>";
$display_string .= "</tr>";

// Show Disabled Pins.
$display_string .= "<tr>";
$display_string .= "<td><a href=\"#\" onclick=\"showConfig(1,".$debugMode.",".($showDisabledPins == 1 ? '0':'1').")\">Show Disabled Pins</a></td>";
$display_string .= "<td>";

switch ($showDisabledPins){
	case 1 :
		$display_string .= "<img src=\"$on\" />";
		break;
	case 0 :
		$display_string .= "<img src=\"$off\" />";
		break;
}
$display_string .= "</a></td>";
$display_string .= "</tr>";

// Close table.
$display_string .= "</table>";

// Display it.
print $display_string;

if ($debugMode) {

	//debug output
	print '<pre>Query params: ' . $updateConfig . ' ' . $debugModeTemp . ' ' . $showDisabledPinsTemp . '</pre>';
	print '<pre>DB    params: ' . $debugMode . ' ' . $showDisabledPins. '</pre>';	
	print '<pre>' . $query_update . '</pre>';
	print '<pre>' . $query . '</pre>';	
}

?>
