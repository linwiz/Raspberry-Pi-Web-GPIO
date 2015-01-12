<?php

require_once 'dbi.php';

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
	$message  = '<p>Invalid query: ' . $mysqli->error . "</p>";
	$message .= '<p>Whole query: ' . $query ."</p>";
	die($message);
}

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

print  '<p>Query: ' . $query . '</p>';

?>