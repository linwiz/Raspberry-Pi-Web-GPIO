<?php
require_once ('set_config_vars.php');

// Set up calling params.
$sort_whitelist = array('pinID+0', 'pinDirection', 'pinNumberBCM+0', 'pinNumberWPi+0', 'pinDescription', 'pinStatus+0', 'pinEnabled+0');
if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_whitelist)) {
	$sort = $_GET['sort'];
} else {
	$sort = "pinNumberBCM+0";
}

$field_whitelist = array('pinID', 'pinDirection', 'pinNumberBCM', 'pinNumberWPi', 'pinDescription', 'pinStatus', 'pinEnabled');
if (isset($_GET['id']) && in_array($_GET['field'], $field_whitelist)) {
	$field = $_GET['field'];
} else {
	$field = "none";
}

$id = isset($_GET['id']) && ($_GET['id']!= 'undefined')	? $_GET['id'] : 0;

// Set up state icons.
$on =  'images/checkbox_checked_icon.png';
$off = 'images/checkbox_unchecked_icon.png';

$query_update = "";
try {
	// Get value of $field.
	$query_fieldvalue = "SELECT $field FROM pinRevision$piRevision WHERE pinID=:id";
	$qry_fieldvalue_result = $db->prepare($query_fieldvalue);
	$qry_fieldvalue_result->bindParam(':id', $id, PDO::PARAM_INT);
	$qry_fieldvalue_result->execute();
	$row_fieldvalue = $qry_fieldvalue_result->fetch(PDO::FETCH_ASSOC);
	$field_value = $row_fieldvalue[$field];
	if ($field_value == 1) {
		$field_value = 0;
	} else {
		$field_value = 1;
	}

	// Update state and enabled fields as needed.
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	if ($id > 0) {
		$query_update = "UPDATE pinRevision$piRevision SET $field=:field_value WHERE pinID=:id";
		$qry_result = $db->prepare($query_update);
		$qry_result->bindParam(':id', $id, PDO::PARAM_INT);
		$qry_result->bindParam(':field_value', $field_value, PDO::PARAM_INT);
		$qry_result->execute();
	}


	// Select rows
	$query = "SELECT * FROM pinRevision$piRevision WHERE pinID > 0";
	if ($showDisabledPins == 0) {
		$query .= " AND pinEnabled = 1";
	}
	$query .= " ORDER BY $sort ASC";
	$qry_result= $db->prepare($query);
	$qry_result->execute();

	// Refresh using current sort order.
	print "<a href=\"#\" onclick=\"showPins('" . urlencode($sort) . "')\">Refresh</a>";

	// Build Result String.
	// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
	$display_string = "<table>";
	$display_string .= "<tr>";

	if ($debugMode) {
		$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinID%2B0',0,'none')\">pinID</a></th>";
		$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDirection',0,'none')\">Direction</a></th>";
	}

	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberBCM%2B0',0,'none')\">BCM#</a></th>";
	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinNumberWPi%2B0',0,'none')\">WPi#</a></th>";
	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinDescription',0,'none')\">Description</a></th>";

	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinStatus%2B0',0,'none')\">Status</a></th>";
	$display_string .= "<th><a href=\"#\" onclick=\"showPins('pinEnabled%2B0',0,'none')\">Enabled</a></th>";
	$display_string .= "</tr>";

	while($row = $qry_result->fetch(PDO::FETCH_ASSOC)){
		$display_string .= "<tr>";

		if ($debugMode) {
			$display_string .= "<td>" . $row['pinID'] . "</td>";
			$display_string .= "<td>" . $row['pinDirection'] . "</td>";
		}

		$display_string .= "<td>" . $row['pinNumberBCM'] . "</td>";
		$display_string .= "<td>" . $row['pinNumberWPi'] . "</td>";
		$display_string .= "<td>" . $row['pinDescription'] . "</td>";

		// On/Off.
		if ($row['pinEnabled'] == 1) {
			$display_string .= "<td><a href=\"#\" onclick=\"showPins('" . urlencode($sort) . "'," . $row['pinID'] . ",'pinStatus')\">";
			switch ($row['pinStatus']){
				case 1 :
					$display_string .= "<img src=\"$on\" />";
					break;
				case 0 :
					$display_string .= "<img src=\"$off\" />";
			}
			$display_string .= "</a></td>";
		} else {
			$display_string .= "<td>";
			switch ($row['pinStatus']){
				case 1 :
	       			        $display_string .= "<img src=\"$on\" />";
					break;
				case 0 :
			                $display_string .= "<img src=\"$off\" />";
			}
			$display_string .= "</td>";
		}

		// Enabled.
		$display_string .= "<td><a href=\"#\" onclick=\"showPins('" . urlencode($sort) . "'," . $row['pinID'] . ",'pinEnabled')\">";
		switch ($row['pinEnabled']){
			case 1 :
	        	        $display_string .= "<img src=\"$on\" />";
				break;
			case 0 :
        		        $display_string .= "<img src=\"$off\" />";
		}
		$display_string .= "</a></td>";
		$display_string .= "</tr>";
	}
	$display_string .= "</table>";
	print $display_string;

	if ($debugMode) {
		// Debug output.
		print "<pre>$sort $id $field</pre>";
		print "<pre>$query</pre>";
		print "<pre>$query_update</pre>";
		print "<pre>:field=$field</pre>";
		print "<pre>:id=$id</pre>";
	}

}
	catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
