<?php
require_once('mysqli.php');

// Set up calling params.

// Get params for update.
$updateConfig		= isset($_GET['updateConfig']) && ($_GET['updateConfig']!= 'undefined') 	? $_GET['updateConfig'] 	: 0;
$debugMode			= isset($_GET['debugMode']) && ($_GET['debugMode']!= 'undefined') 	? $_GET['debugMode'] 	: 0;
$showDisabledPins 	= isset($_GET['showDisabledPins'])  	&& ($_GET['showDisabledPins']!= 'undefined') 		? $_GET['showDisabledPins'] 		: 0;

// Set up state "icons".
$on =  '[X]';
$off = '[_]';
$unknown = '[?]';

// Escape params.
$updateConfig = $mysqli->real_escape_string($updateConfig);
$debugMode = $mysqli->real_escape_string($debugMode);
$showDisabledPins = $mysqli->real_escape_string($showDisabledPins);

// Update config fields as (if) needed.
$query_update = "";

if ($updateConfig>0) {
	$query_update = "UPDATE config SET debugMode=".$debugMode.", showDisabledPins = ".$showDisabledPins."  WHERE configVersion = 1;";
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

// Build Result String.
$display_string = "<table>";

// Debug Mode.
$display_string .= "<tr>";
$display_string .= "<td>Enable Debug Mode</td>";
$display_string .= "<td><a href=\"#\" onclick=\"showConfig(1,".($row['debugMode'] == 1 ? '0':'1').",".$row['showDisabledPins'].")\">";

switch ($row['debugMode']){
	case 1 :
		$display_string .= "$on";
		break;
	case 0 :
		$display_string .= "$off";
		break;
	default:
		$display_string .= "$unknown";
}
$display_string .= "</a></td>";
$display_string .= "</tr>";

// Show Disabled Pins.
$display_string .= "<tr>";
$display_string .= "<td>Show Disabled Pins</td>";
$display_string .= "<td><a href=\"#\" onclick=\"showConfig(1,".$row['debugMode'].",".($row['showDisabledPins'] == 1 ? '0':'1').")\">";

switch ($row['showDisabledPins']){
	case 1 :
		$display_string .= "$on";
		break;
	case 0 :
		$display_string .= "$off";
		break;
	default:
		$display_string .= "$unknown";
}
$display_string .= "</a></td>";
$display_string .= "</tr>";

// Close table.
$display_string .= "</table>";

// Display it.
print $display_string;

// Debug output.
if ($row['debugMode'] == 1) {
	print '<pre>Query params: ' . $updateConfig . ' ' . $debugMode . ' ' . $showDisabledPins . '</pre>';
	print '<pre>DB    params: ' . $row['debugMode'] . ' ' . $row['showDisabledPins'] . '</pre>';
	print '<pre>' . $query_update . '</pre>';
	print '<pre>' . $query . '</pre>';
}

?>
