<?php
require_once('mysqli.php');

// Set up calling params.
$sort 	= isset($_GET['sort']) 	&& ($_GET['sort']!= 'undefined') 	? $_GET['sort'] 	: "pinNumberBCM+0";
$id 	= isset($_GET['id'])  	&& ($_GET['id']!= 'undefined') 		? $_GET['id'] 		: 0;
$field 	= isset($_GET['field']) && ($_GET['field']!= 'undefined')  	? $_GET['field'] 	: 'none';

// Set up state "icons".
$on =  '[X]';
$off = '[_]';
$unknown = '[?]';

// Escape params.
$sort = $mysqli->real_escape_string($sort);
$id = $mysqli->real_escape_string($id);
$field = $mysqli->real_escape_string($field);

// Update state and enabled fields as needed.
$query_update ="";
if ($id>0) {
	$query_update = "UPDATE pinRevision" . $pi_rev . " SET " . $field . "= NOT " . $field . " WHERE pinID =" . $id . ";";
	$qry_result = $mysqli->query($query_update);
	if (!$qry_result) {
		$message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
		$message .= '<pre>Whole query: ' . $query_update . "</pre>";
		die($message);
	}
}

// Get config setting for disabled pins.
$queryConfig = "SELECT * FROM config WHERE configVersion = 1";
$qry_resultConfig = $mysqli->query($queryConfig);
if (!$qry_resultConfig) {
        $message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
        $message .= '<pre>Whole query: ' . $queryConfig . "</pre>";
        die($message);
}
$rowConfig = mysqli_fetch_array($qry_resultConfig);

// Select rows.
$query = "SELECT * FROM pinRevision$pi_rev WHERE pinID > 0";
if ($rowConfig['showDisabledPins'] == 0) {
	$query .= " AND pinEnabled='1'";
}
$query .= " ORDER BY " . $sort . " ASC";

$qry_result = $mysqli->query($query);

if (!$qry_result) {
	$message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
	$message .= '<pre>Whole query: ' . $query ."</pre>";
	die($message);
}

// Refresh using current sort order.
print "<a href=\"#\" onclick=\"showPins('".urlencode($sort)."')\">Refresh</a>";

// Build Result String.
// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
$display_string = "<table>";
$display_string .= "<tr>";

if ($rowConfig['debugMode'] == 1) {
	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinID%2B0',0,'none')\">pinID</a></th>";
	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDirection',0,'none')\">Direction</a></th>";
}

$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberBCM%2B0',0,'none')\">BCM#</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberWPi%2B0',0,'none')\">WPi#</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDescription',0,'none')\">Description</a></th>";

$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinStatus%2B0',0,'none')\">Status</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinEnabled%2B0',0,'none')\">Enabled</a></th>";
$display_string .= "</tr>";


while($row = mysqli_fetch_array($qry_result)){
	$display_string .= "<tr>";

	if ($rowConfig['debugMode'] == 1) {
		$display_string .= "<td>" . $row['pinID'] . "</td>";
		$display_string .= "<td>" . $row['pinDirection'] . "</td>";
	}

	$display_string .= "<td>" . $row['pinNumberBCM'] . "</td>";
	$display_string .= "<td>" . $row['pinNumberWPi'] . "</td>";
	$display_string .= "<td>" . $row['pinDescription'] . "</td>";

	// On/Off.
	if ($row['pinEnabled'] == 1) {
		$display_string .= "<td><a href=\"#\" onclick=\"showPins('" . urlencode($sort) . "'," . $row['pinID'] . ",'pinStatus'" . ")\">";
		switch ($row['pinStatus']){
			case 1 :
			$display_string .= $on;
			break;
			case 0 :
			$display_string .= $off;
			break;
			default:
			$display_string .= $unknown;
		}
		$display_string .= "</a></td>";
	} else {
		$display_string .= "<td>";
		switch ($row['pinStatus']){
			case 1 :
			$display_string .= $on;
			break;
			case 0 :
			$display_string .= $off;
			break;
			default:
			$display_string .= $unknown;
		}
		$display_string .= "</td>";
	}

	// Enabled.
	$display_string .= "<td><a href=\"#\" onclick=\"showPins('" . urlencode($sort) . "'," . $row['pinID'] . ",'pinEnabled'" . ")\">";
	switch ($row['pinEnabled']){
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
}
$display_string .= "</table>";
print $display_string;

if ($rowConfig['debugMode'] == 1) {
	// Debug output.
	print '<pre>' . $sort . ' ' . $id . ' ' . $field . '</pre>';
	print '<pre>' . $query . '</pre>';
	print '<pre>' . $query_update . '</pre>';
}

?>
