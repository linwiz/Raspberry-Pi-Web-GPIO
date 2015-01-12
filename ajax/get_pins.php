<?php

require_once 'dbi.php';

$sort = $_GET['sort'];
//default sort
if (empty($sort)) {
	$sort = " pinNumberBCM+0 ";
}

$on =  '[X]';
$off = '[_]';
$unknown = '[?]';

$sort = $mysqli->real_escape_string($sort);

$query = "SELECT * FROM pinRevision3 WHERE pinID > 0 ";
$query .= "ORDER BY ".$sort." ASC";

$qry_result= $mysqli->query($query);

if (!$qry_result) {
	$message  = '<p>Invalid query: ' . $mysqli->error . "</p>";
	$message .= '<p>Whole query: ' . $query ."</p>";
	die($message);
}

// refresh using current sort order
print "<a href=\"#\" onclick=\"showPins('".urlencode($sort)."')\">Refresh</a>";


//Build Result String
//Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers !!!
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinID%2B0')\">pinID</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberBCM%2B0')\">BCM#</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberWPi%2B0')\">WPi#</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDescription')\">Description</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDirection')\">Direction</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinStatus%2B0')\">Status</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinEnabled%2B0')\">Enabled</a></th>";
$display_string .= "</tr>";

// Insert a new row in the table for each person returned
while($row = mysqli_fetch_array($qry_result)){
	$display_string .= "<tr>";
	$display_string .= "<td>".$row['pinID']."</td>";
	$display_string .= "<td>".$row['pinNumberBCM']."</td>";
	$display_string .= "<td>".$row['pinNumberWPi']."</td>";
	$display_string .= "<td>".$row['pinDescription']."</td>";
	$display_string .= "<td>".$row['pinDirection']."</td>";

	
	// On/Off
	$display_string .= "<td><a href=\"#\" onclick=\"showPins('".urlencode($sort)."')\">";
	//$display_string .= "<td><a href=\"#\" onclick=\"showPins('".$sort."')\">";
	
	switch ($row['pinStatus']){
	case 1 :	$display_string .= $on;
		break;
	case 0 :	$display_string .= $off;
		break;
	default:	$display_string .= $unknown;				

	}
	
	$display_string .= "</a></td>";
		
	
	// Enabled
	switch ($row['pinEnabled']){
	case 1 :	$display_string .= "<td>$on</td>";
		break;
	case 0 :	$display_string .= "<td>$off</td>";
		break;
	default:	$display_string .= "<td>$unknown</td>";				

	}
	

	$display_string .= "</tr>";

}

$display_string .= "</table>";

print $display_string;

print "<p>Query: " . $query . "</p>";

?>
