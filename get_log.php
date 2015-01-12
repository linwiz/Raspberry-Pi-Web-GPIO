<?php

require_once 'mysqli.php';

$id1 = $_GET['id1'];
$id2 = $_GET['id2'];
// Escape User Input to help prevent SQL Injection
$id1 = $mysqli->real_escape_string($id1);
$id2 = $mysqli->real_escape_string($id2);
//build query
$query = "SELECT * FROM log WHERE id > 0 ";
if(is_numeric($id1))
	$query .= " AND id >= $id1";
if(is_numeric($id2))
	$query .= " AND id <= $id2";
//Execute query
$query .= " ORDER BY time DESC";

$qry_result= $mysqli->query($query);

if (!$qry_result) {
	$message  = '<pre>Invalid query: ' . $mysqli->error . "</pre>";
	$message .= '<pre>Whole query: ' . $query ."</pre>";
	die($message);
}


print "<a href=\"#\" onclick=\"showLog()\">Refresh</a>";

print "<form name=\"myForm\">ID Range: ";
print "<input type=\"text\" id=\"id1\" value=\"".$id1."\"onchange=\"showLog()\" size=\"5\" />";
print "<input type=\"text\" id=\"id2\" value=\"".$id2."\"onchange=\"showLog()\" size=\"5\" /> <br />";

print "</form>";


//Build Result String
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th>ID</th>";
$display_string .= "<th>Time</th>";
$display_string .= "<th>Entry</th>";
$display_string .= "</tr>";

// Insert a new row in the table for each person returned
while($row = mysqli_fetch_array($qry_result)){
	$display_string .= "<tr>";
	$display_string .= "<td>".$row['id']."</td>";
	$display_string .= "<td>".$row['time']."</td>";
	$display_string .= "<td>".$row['data']."</td>";
	$display_string .= "</tr>";

}

$display_string .= "</table>";

print $display_string;

if ($debugMode) {	
	//debug output	
	print '<pre>'.$id1.'<->'.$id2.'</pre>';
	
	print '<pre>' . $query .'</pre>';	

}
?>
