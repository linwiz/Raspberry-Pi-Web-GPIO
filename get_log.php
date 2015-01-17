<?php
include 'set_config_vars.php';

$id1 = $_GET['id1'];
$id2 = $_GET['id2'];

try {
	// Build query.
	$query = 'SELECT * FROM log WHERE id > 0 ';
	if(is_numeric($id1)) {
		$query .= ' AND id >= :id1';
	}
	if(is_numeric($id2)) {
		$query .= ' AND id <= :id2';
	}
	$query .= ' ORDER BY date DESC';
	$query .= " LIMIT $logPageSize";

	// Execute query.
	$qry_result = $db->prepare($query);
	$qry_result->execute(array(':id1'=>$id1, ':id2'=>$id2));

	print "	<a href=\"#\" onclick=\"showLog()\">Refresh</a>\r\n";

	print "		<form name=\"myForm\">ID Range: \r\n";
	print "			<input type=\"text\" id=\"id1\" value=\"$id1\"onchange=\"showLog()\" size=\"5\" />\r\n";
	print "			<input type=\"text\" id=\"id2\" value=\"$id2\"onchange=\"showLog()\" size=\"5\" /><br />\r\n";

	print "		</form>\r\n";

	// Build Result String.
	$display_string = "		<table>\r\n";
	$display_string .= "			<tr>\r\n";
	$display_string .= "				<th>ID</th>\r\n";
	$display_string .= "				<th>Time</th>\r\n";
	$display_string .= "				<th>Entry</th>\r\n";
	$display_string .= "			</tr>\r\n";

	// Insert a new row in the table for each result returned.
	while($row = $qry_result->fetch(PDO::FETCH_ASSOC)) {
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>" . $row['id'] . "</td>\r\n";
		$display_string .= "				<td>" . $row['date'] . "</td>\r\n";
		$display_string .= "				<td>" . $row['data'] . "</td>\r\n";
		$display_string .= "			</tr>";
	}

	$display_string .= "		</table>\r\n";

	print $display_string;

	if ($_SESSION['debugMode']) {
		// Debug output.
		print "<pre>Range Set: $id1 <-> $id2</pre>\r\n";
		print "<pre>Select: $query</pre>\r\n";
	}
} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
