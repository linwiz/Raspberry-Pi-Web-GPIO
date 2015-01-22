<?php
require 'set_config_vars.php';

if (isset($_POST['username'])) { // if ajax request submitted
	// Password hashing functions.
	require_once('scrypt.php');

	$post_username = $_POST['username']; // the ajax post username
	$post_password = $_POST['password']; // the ajax post password

	try {
		$loginQuery = 'SELECT * FROM users WHERE username = :username';
		$loginResult = $db->prepare($loginQuery);
		$loginResult->execute(array(':username'=>$post_username));

		if($loginResult->rowCount() > 0){
			$loginData = $loginResult->fetch(PDO::FETCH_ASSOC);
			If (Password::check($post_password, $loginData['password'])) {
				session_regenerate_id();
				$_SESSION['username'] = $post_username;
				$_SESSION['userID'] = $loginData['userID'];
				echo $post_username;
			}
		}
	} catch(Exception $e) {
		echo 'Exception -> ';
		var_dump($e->getMessage());
	}
}

// Pins page.
if ($_SESSION['pageType'] == "pins" && isset($_SESSION['username'])) {
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

	$query_update = "";
	try {
		// Get value of $field.
		$query_fieldvalue = "SELECT $field FROM pinRevision" . $_SESSION['piRevision'] . " WHERE pinID=:id";
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
			$query_update = "UPDATE pinRevision" . $_SESSION['piRevision'] . " SET $field=:field_value WHERE pinID=:id";
			$qry_result = $db->prepare($query_update);
			$qry_result->bindParam(':id', $id, PDO::PARAM_INT);
			$qry_result->bindParam(':field_value', $field_value, PDO::PARAM_INT);
			$qry_result->execute();
		}

		// Select rows
		$query = "SELECT * FROM pinRevision" . $_SESSION['piRevision'] . " WHERE pinID > 0";
		if ($_SESSION['showDisabledPins'] == 0) {
			$query .= " AND pinEnabled = 1";
		}
		$query .= " ORDER BY $sort ASC";
		$qry_result= $db->prepare($query);
		$qry_result->execute();

		// Refresh using current sort order.
		print "	<a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "')\">Refresh</a>\r\n";

		// Build Result String.
		// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
		$display_string = "		<table>\r\n";
		$display_string .= "			<tr>\r\n";

		if ($_SESSION['debugMode']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinID%2B0',0,'none')\">pinID</a></th>\r\n";
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDirection',0,'none')\">Direction</a></th>\r\n";
		}

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberBCM%2B0',0,'none')\">BCM#</a></th>\r\n";
		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberWPi%2B0',0,'none')\">WPi#</a></th>\r\n";
		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDescription',0,'none')\">Description</a></th>\r\n";

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinStatus%2B0',0,'none')\">Status</a></th>\r\n";
		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinEnabled%2B0',0,'none')\">Enabled</a></th>\r\n";
		$display_string .= "			</tr>\r\n";

		while($row = $qry_result->fetch(PDO::FETCH_ASSOC)){
			$display_string .= "			<tr>\r\n";

			if ($_SESSION['debugMode']) {
				$display_string .= "				<td>" . $row['pinID'] . "</td>\r\n";
				$display_string .= "				<td>" . $row['pinDirection'] . "</td>\r\n";
			}

			$display_string .= "				<td>" . $row['pinNumberBCM'] . "</td>\r\n";
			$display_string .= "				<td>" . $row['pinNumberWPi'] . "</td>\r\n";
			$display_string .= "				<td>" . $row['pinDescription'] . "</td>\r\n";

			// On/Off.
			if ($row['pinEnabled'] == 1) {
				$display_string .= "				<td><a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "'," . $row['pinID'] . ",'pinStatus')\">";
				switch ($row['pinStatus']){
					case 1 :
						$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
						$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</a></td>\r\n";
			} else {
				$display_string .= "				<td>";
				switch ($row['pinStatus']){
					case 1 :
		       			        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
				                $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</td>\r\n";
			}

			// Enabled.
			$display_string .= "				<td><a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "'," . $row['pinID'] . ",'pinEnabled')\">";
			switch ($row['pinEnabled']){
				case 1 :
		        	        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
					break;
				case 0 :
        			        $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
			}
			$display_string .= "</a></td>\r\n";
			$display_string .= "			</tr>\r\n";
		}
		$display_string .= "		</table>\r\n";
		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
			print "		<pre>$sort $id $field</pre>\r\n";
			print "		<pre>$query</pre>\r\n";
			print "		<pre>$query_update</pre>\r\n";
			print "		<pre>:field=$field</pre>\r\n";
			print "		<pre>:id=$id</pre>";
		}

	} catch(Exception $e) {
		echo 'Exception -> ';
		var_dump($e->getMessage());
	}
}

// Log page.
elseif ($_SESSION['pageType'] == "log" && isset($_SESSION['username'])) {
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
		$query .= " LIMIT " . $_SESSION['logPageSize'];

		// Execute query.
		$qry_result = $db->prepare($query);
		$qry_result->execute(array(':id1'=>$id1, ':id2'=>$id2));

		print "	<a href=\"#\" onclick=\"showPage(2)\">Refresh</a>\r\n";

		print "		<form name=\"myForm\">ID Range: \r\n";
		print "			<input type=\"text\" id=\"id1\" value=\"$id1\"onchange=\"showPage(2)\" size=\"5\" />\r\n";
		print "			<input type=\"text\" id=\"id2\" value=\"$id2\"onchange=\"showPage(2)\" size=\"5\" /><br />\r\n";

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
			$display_string .= "			</tr>\r\n";
		}

		$display_string .= "		</table>\r\n";

		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
			print "		<pre>Range Set: $id1 <-> $id2</pre>\r\n";
			print "		<pre>Select: $query</pre>";
		}
	} catch(Exception $e) {
		echo 'Exception -> ';
		var_dump($e->getMessage());
	}
}

// Config page.
elseif ($_SESSION['pageType'] == "config" && isset($_SESSION['username'])) {
	// Get params for update.
	$pageSize		= isset($_GET['logPageSize']) && ($_GET['logPageSize']!= 'undefined') 	? $_GET['logPageSize'] 	: 10;
	$updateConfig		= isset($_GET['updateConfig']) && ($_GET['updateConfig']!= 'undefined') 	? $_GET['updateConfig'] 	: 0;
	$debugModeTemp			= isset($_GET['debugMode']) && ($_GET['debugMode']!= 'undefined') 	? $_GET['debugMode'] 	: 0;
	$showDisabledPinsTemp 	= isset($_GET['showDisabledPins'])  	&& ($_GET['showDisabledPins']!= 'undefined') 		? $_GET['showDisabledPins'] 		: 0;

	// Update config fields as (if) needed.
	$query_update = "";

	try {
		if ($updateConfig > 0) {
			$query_update = 'UPDATE config SET debugMode = :debugMode, showDisabledPins = :disabledPins, logPageSize = :logPageSize WHERE configVersion = 1';
			$qry_result = $db->prepare($query_update);
			$qry_result->execute(array(':debugMode'=>$debugModeTemp, ':disabledPins'=>$showDisabledPinsTemp, ':logPageSize'=>$pageSize));
			$_SESSION['debugMode'] = $debugModeTemp;
			$_SESSION['showDisabledPins'] = $showDisabledPinsTemp;
			$_SESSION['logPageSize'] = $pageSize;
		}

		// Build Result String.
		$display_string = "		<script type=\"text/javascript\">logPageSize=document.getElementById('logPageSize').value);</script>\r\n";
		$display_string .= "		<table>\r\n";

		// Debug Mode.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Enable Debug Mode</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . ($_SESSION['debugMode'] == 1 ? '0':'1') . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . ")\" />";

		switch ($_SESSION['debugMode']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show Disabled Pins.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show Disabled Pins</a></td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . ($_SESSION['showDisabledPins'] == 1 ? '0':'1') . "," . $_SESSION['logPageSize'] . ")\" />";

		switch ($_SESSION['showDisabledPins']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

	        // Log page size.
		$display_string .= "                    <tr>\r\n";
		$display_string .= "                            <td>Log pagination</a></td>\r\n";
		$display_string .= "                            <td><input type=\"text\" id=\"logPageSize\" value=\"" . $_SESSION['logPageSize'] . "\" size=\"3\" /><input type=\"submit\" value=\"save\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . ",logPageSize.value)\" /></td>\r\n";

		$display_string .= "</a></td>\r\n";
		$display_string .= "                    </tr>\r\n";

		// Close table.
		$display_string .= "		</table>\r\n";

		// Display it.
		print $display_string;

		if ($_SESSION['debugMode']) {
			//debug output
			print $configVariables . "\r\n";
			print '		<pre>Query params: ' . $updateConfig . ' ' . $debugModeTemp . ' ' . $showDisabledPinsTemp . ' ' . $pageSize . '</pre>';
			print '		<pre>' . $query_update . '</pre>';
		}
	} catch(Exception $e) {
		echo 'Exception -> ';
		var_dump($e->getMessage());
	}
}

else {
	print "Logged out. Please reload page.\r\n";
}
?>
