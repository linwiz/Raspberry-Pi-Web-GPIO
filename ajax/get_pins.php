<?php

include 'dbi.php';

$sort = $_GET['sort'];

//default sort
if (empty($sort)) {
	$sort = " pinNumberBCM+0 ";
}

$sort = mysql_real_escape_string($sort);

$query = "SELECT * FROM pinRevision3 WHERE pinID > 0 ";
$query .= "ORDER BY ".$sort." ASC";    

$qry_result = mysql_query($query);

if (!qry_result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $query;
	die($message);
}

//Build Result String
//Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers !!!
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinID%2B0')\">pinID</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberBCM%2B0')\">NumberBCM</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberWPi%2B0')\">NumberWPi</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDescription')\">Description</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDirection')\">Direction</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinStatus%2B0')\">Status</a></th>";
$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinEnabled%2B0')\">Enabled</a></th>";		
$display_string .= "</tr>";


    // Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){
    $display_string .= "<tr>";
    $display_string .= "<td>$row[pinID]</td>";
    $display_string .= "<td>$row[pinNumberBCM]</td>";
    $display_string .= "<td>$row[pinNumberWPi]</td>";
    $display_string .= "<td>$row[pinDescription]</td>";
    $display_string .= "<td>$row[pinDirection]</td>";
    $display_string .= "<td>$row[pinStatus]</td>";
    $display_string .= "<td>$row[pinEnabled]</td>";                
    $display_string .= "</tr>";
    
}

$display_string .= "</table>";
echo $display_string;

echo "<p>Query: " . $query . "</p>";

?>
