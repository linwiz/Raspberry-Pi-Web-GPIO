<?php
require 'set_config_vars.php';
require_once('scrypt.php');

try {
	// Login.
	if (isset($_POST['username'])) {
		$post_username = $_POST['username'];
		$post_password = $_POST['password'];
		$loginQuery = 'SELECT * FROM users WHERE username = :username';
		$loginResult = $db->prepare($loginQuery);
		$loginResult->execute(array(':username'=>$post_username));

		if ($loginResult->rowCount() > 0) {
			$loginData = $loginResult->fetch(PDO::FETCH_ASSOC);
			If (Password::check($post_password, $loginData['password'])) {
				session_regenerate_id();
				$_SESSION['username'] = $post_username;
				$_SESSION['userID'] = $loginData['userID'];
				echo $post_username;
			}
		}
		unset($loginResult);
		unset($loginData);
	}

	// Pins/Edit page query.
	if (($_SESSION['pageType'] == "pins") || ($_SESSION['pageType'] == "edit") && (isset($_SESSION['username']))) {
		$query_update = "";
		if (isset($field) && $field != "none") {
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
		}
	}

	// Pins page.
	if ($_SESSION['pageType'] == "pins" && isset($_SESSION['username'])) {
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
		$query .= " ORDER BY $sort " . $_SESSION['sortDir'];
		$qry_result= $db->prepare($query);
		$qry_result->execute();

		// Refresh using current sort order.
		print "	<a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "')\" class=\"page dark gradient\">Refresh</a>\r\n";

		// Edit Pin description.
		print "	<a href=\"#\" onclick=\"changeSection(4)\" class=\"page dark gradient\">Edit Descriptions</a>\r\n";

		// Build Result String.
		// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
		$display_string = "		<table>\r\n";
		$display_string .= "			<tr>\r\n";

		if ($_SESSION['debugMode']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinID%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">pinID</a></th>\r\n";
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDirection',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">Direction</a></th>\r\n";
		}

		if ($_SESSION['showBCMNumber']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberBCM%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">BCM#</a></th>\r\n";
		}

		if ($_SESSION['showWPiNumber']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberWPi%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">WPi#</a></th>\r\n";
		}

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDescription',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">Description</a></th>\r\n";

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinStatus%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">Status</a></th>\r\n";

		if ($_SESSION['showDisableBox']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinEnabled%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\">Enabled</a></th>\r\n";
		}
		$display_string .= "			</tr>\r\n";

		while ($row = $qry_result->fetch(PDO::FETCH_ASSOC)) {
			$display_string .= "			<tr>\r\n";

			if ($_SESSION['debugMode']) {
				$display_string .= "				<td>" . $row['pinID'] . "</td>\r\n";
				$display_string .= "				<td>" . $row['pinDirection'] . "</td>\r\n";
			}

			if ($_SESSION['showBCMNumber']) {
				$display_string .= "				<td>" . $row['pinNumberBCM'] . "</td>\r\n";
			}

			if ($_SESSION['showWPiNumber']) {
				$display_string .= "				<td>" . $row['pinNumberWPi'] . "</td>\r\n";
			}

			$display_string .= "				<td>" . $row['pinDescription'] . "</td>\r\n";

			// On/Off.
			if ($row['pinEnabled'] == 1) {
				$display_string .= "				<td><a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "'," . $row['pinID'] . ",'pinStatus')\">";
				switch ($row['pinStatus']) {
					case 1 :
						$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
						$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</a></td>\r\n";
			} else {
				$display_string .= "				<td>";
				switch ($row['pinStatus']) {
					case 1 :
		       			        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
				                $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</td>\r\n";
			}

 			if ($_SESSION['showDisableBox']) {
				// Enabled.
				$display_string .= "				<td><a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "'," . $row['pinID'] . ",'pinEnabled')\">";
				switch ($row['pinEnabled']) {
					case 1 :
		        		        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
        				        $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</a></td>\r\n";
			}
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
	}

	// Edit page.
	elseif ($_SESSION['pageType'] == "edit" && isset($_SESSION['username'])) {
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
		$query .= " ORDER BY $sort " .  $_SESSION['sortDir'];
		$qry_result= $db->prepare($query);
		$qry_result->execute();

		// Edit Pin description.
		print "	<a href=\"#\" onclick=\"showPage(4,editPins)\" class=\"page dark gradient\">Save</a>\r\n";

		// Build Result String.
		// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
		$display_string = "		<table>\r\n";
		$display_string .= "			<tr>\r\n";

		if ($_SESSION['debugMode']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinID%2B0',0,'none')\" class=\"page dark gradient\">pinID</a></th>\r\n";
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDirection',0,'none')\" class=\"page dark gradient\">Direction</a></th>\r\n";
		}

		if ($_SESSION['showBCMNumber']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberBCM%2B0',0,'none')\" class=\"page dark gradient\">BCM#</a></th>\r\n";
		}

		if ($_SESSION['showWPiNumber']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinNumberWPi%2B0',0,'none')\" class=\"page dark gradient\">WPi#</a></th>\r\n";
		}

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinDescription',0,'none')\" class=\"page dark gradient\">Description</a></th>\r\n";

		$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinStatus%2B0',0,'none')\" class=\"page dark gradient\">Status</a></th>\r\n";

		if ($_SESSION['showDisableBox']) {
			$display_string .= "				<th><a href=\"#\" onclick=\"showPage(1,'pinEnabled%2B0',0,'none')\" class=\"page dark gradient\">Enabled</a></th>\r\n";
		}
		$display_string .= "			</tr>\r\n";

		$editPins = '';
		$editPinString = '';
		while ($row = $qry_result->fetch(PDO::FETCH_ASSOC)) {
			$display_string .= "			<tr>\r\n";
			$editPinString .= "			var editPin" . $row['pinID'] . "=document.getElementById('editPin" . $row['pinID'] . "').value);\r\n";
			$editPins .= $row['pinID'] . ",";

			if ($_SESSION['debugMode']){
				$display_string .= "				<td>" . $row['pinID'] . "</td>\r\n";
				$display_string .= "				<td>" . $row['pinDirection'] . "</td>\r\n";
			}

			if ($_SESSION['showBCMNumber']) {
				$display_string .= "				<td>" . $row['pinNumberBCM'] . "</td>\r\n";
			}

			if ($_SESSION['showWPiNumber']) {
				$display_string .= "				<td>" . $row['pinNumberWPi'] . "</td>\r\n";
			}

			$display_string .= "				<td><input type=\"text\" id=\"editPin" . $row['pinID'] . "\" value=\"" . $row['pinDescription'] . "\" class=\"page dark gradient\" /></td>\r\n";

			// On/Off.
			$display_string .= "				<td>";
			switch ($row['pinStatus']) {
				case 1 :
	       			        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
					break;
				case 0 :
			                $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
			}
			$display_string .= "</td>\r\n";

 			if ($_SESSION['showDisableBox']) {
				// Enabled.
				$display_string .= "				<td>";
				switch ($row['pinEnabled']) {
					case 1 :
		        		        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
        				        $display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</td>\r\n";
			}
			$display_string .= "			</tr>\r\n";
		}
		$display_string .= "		</table>\r\n";
		$display_string .= "		<script type=\"text/javascript\">\r\n";
		$display_string .= $editPinString;
		$display_string .= "			var editPins=\"" . $editPins . "\";\r\n";
		$display_string .="		</script>\r\n";

		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
			print "		<pre>$sort $id $field</pre>\r\n";
			print "		<pre>$query</pre>\r\n";
			print "		<pre>$query_update</pre>\r\n";
			print "		<pre>:field=$field</pre>\r\n";
			print "		<pre>:id=$id</pre>\r\n";
		}
	}

	// Log page.
	elseif ($_SESSION['pageType'] == "log" && isset($_SESSION['username'])) {
		if (isset($_GET['id1'])) {
			$id1 = $_GET['id1'];
		} else {
			$id1 = 0;
		}
		if (isset($_GET['id2'])) {
			$id2 = $_GET['id2'];
		} else {
			$id2 = 99999;
			}
		if (isset($_GET['pn'])) {
			$pn = $_GET['pn'];
		} else {
			$pn = 1;
		}
		if (isset($_GET['truncate'])) {
			$truncate = $_GET['truncate'];
		} else {
			$truncate = 'false';
		}

		// Check for positive integers.
		if ((int)$id1 != $id1 || (int)$id1 < 0) {
			$id1 = 0;
		}
		if ((int)$id2 != $id2 || (int)$id2 < 0) {
			$id2 = 99999;
		}

		// id1 must be <= id2.
		if ((int)$id1 > (int)$id2) {
			$id1 = 0;
			}
		// id2 must be >= id1.
		if ((int)$id2 < (int)$id1) {
			$id2 = 99999;
			}
		if ((int)$pn != $pn || (int)$pn < 0) {
			$pn = 1;
		}

		if ($truncate == "true") {
			$qry_result = $db->prepare("TRUNCATE TABLE log;");
			$qry_result->execute();
		}

		// Build query.
		$query = 'SELECT * FROM log WHERE id > 0 ';
		$query .= ' AND id >= :id1';
		$query .= ' AND id <= :id2';
		$query .= ' ORDER BY id DESC';

		// Execute query.
		$qry_resultpn = $db->prepare($query);
		$qry_resultpn->execute(array(':id1'=>$id1, ':id2'=>$id2));
		$logCount = $qry_resultpn->rowCount();
		$logStart = (($pn - 1) * $_SESSION['logPageSize']);

		// Determine number of pages needed.
		$logPrev = $pn - 1;
		$logNext = $pn + 1;
		$logLastPage = ceil($logCount / $_SESSION['logPageSize']);
		$logNextToLastPage = $logLastPage - 1;
		if ((int)$pn > (int)$logLastPage) {
			$pn = $logLastPage;
		}

		print "	<a href=\"#\" onclick=\"showPage(2,$pn,'false')\" class=\"page dark gradient\">Refresh</a> \r\n";
		print "	<a href=\"#\" onclick=\"showPage(2,$pn,'true')\" class=\"page dark gradient\">Clear Log</a> \r\n";

		print "		<form name=\"myForm\">ID Range: \r\n";
		print "			<input type=\"text\" id=\"id1\" value=\"$id1\"onchange=\"showPage(2,$pn,'false')\" size=\"5\" class=\"page dark gradient\" />\r\n";
		print "			<input type=\"text\" id=\"id2\" value=\"$id2\"onchange=\"showPage(2,$pn,'false')\" size=\"5\" class=\"page dark gradient\" /><br />\r\n";

		print "		</form>\r\n";

		$logPagination = '';
		if($logLastPage > 1) {
			$logPagination .= "<div class=\"pagination dark\">";
			//previous button
			if ($pn > 1) {
				$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logPrev)\" class=\"page dark gradient\">prev</a> ";
			} else {
				$logPagination .= "<span class=\"page dark gradient\">prev</span>";
			}

			//pages
			if ($logLastPage < 7 + (3 * 2)) {
				for ($counter = 1; $counter <= $logLastPage; $counter++) {
					if ($counter == $pn) {
						$logPagination .= "<span class=\"page dark active\">$counter</span>";
					} else {
						$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\">$counter</a> ";
					}
				}
			}
			elseif($logLastPage > 5 + (3 * 2)) {
				//close to beginning; only hide later pages
				if($pn < 1 + (3 * 2)) {
					for ($counter = 1; $counter < 4 + (3 * 2); $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark active\">$counter</span>";
						} else {
							$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\">$counter</a> ";
						}
					}
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logNextToLastPage)\" class=\"page dark gradient\">$logNextToLastPage</a> ";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logLastPage)\" class=\"page dark gradient\">$logLastPage</a> ";
				}
				//in middle; hide some front and some back
				elseif($logLastPage - (3 * 2) > $pn && $pn > (3 * 2)) {
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,1)\" class=\"page dark gradient\">1</a> ";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,2)\" class=\"page dark gradient\">2</a> ";
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					for ($counter = $pn - 3; $counter <= $pn + 3; $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark active\">$counter</span>";
						} else {
							$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\">$counter</a> ";
						}
					}
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logNextToLastPage)\" class=\"page dark gradient\">$logNextToLastPage</a> ";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logLastPage)\" class=\"page dark gradient\">$logLastPage</a> ";
				}
				//close to end; only hide early pages
				else {
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,1)\">1</a> ";
					$logPagination .= "<a href=\"#\" onclick=\"showPage(2,2)\">2</a> ";
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					for ($counter = $logLastPage - (2 + (3 * 2)); $counter <= $logLastPage; $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark gradient\">$counter</span>";
						} else {
							$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\">$counter</a> ";
						}
					}
				}
			}

			//next button
			if ($pn < $counter - 1) {
				$logPagination .= "<a href=\"#\" onclick=\"showPage(2,$logNext)\" class=\"page dark gradient\">next</a> ";
			} else {
				$logPagination .= "<span class=\"page dark gradient\">next</span>";
			}
			$logPagination .= "</div>";
		}
		if (isset($logPagination)) {
			print $logPagination . "<br />\r\n";
		}

		// Build Result String.
		$display_string = "		<table>\r\n";
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<th>ID</th>\r\n";
		$display_string .= "				<th>Time</th>\r\n";
		$display_string .= "				<th>Entry</th>\r\n";
		$display_string .= "			</tr>\r\n";

		// Insert a new row in the table for each result returned.
		$x = 0;
		$i = 1;
		while (($row = $qry_resultpn->fetch(PDO::FETCH_ASSOC)) && ($i <= $_SESSION['logPageSize'])) {
			if ($x >= $logStart) {
				$display_string .= "			<tr>\r\n";
				$display_string .= "				<td>" . $row['id'] . "</td>\r\n";
				$display_string .= "				<td>" . $row['date'] . "</td>\r\n";
				$display_string .= "				<td>" . $row['data'] . "</td>\r\n";
				$display_string .= "			</tr>\r\n";
				$i++;
			}
			$x++;
		}

		$display_string .= "		</table>\r\n";

		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
			print "		<pre>Range Set: $id1 <-> $id2</pre>\r\n";
			print "		<pre>Select: $query</pre>";
		}
	}

	// Config page.
	elseif ($_SESSION['pageType'] == "config" && isset($_SESSION['username'])) {
		// Get params for update.
		if (isset($_GET['logPageSize']) && ($_GET['logPageSize']!= 'undefined')) {
			$pageSizeTemp = $_GET['logPageSize'];
			if ((int)$pageSizeTemp != $pageSizeTemp || (int)$pageSizeTemp <= 0) {
				$pageSizeTemp = 10;
			}
		} else {
			$pageSizeTemp = 10;
		}

		if (isset($_GET['updateConfig']) && ($_GET['updateConfig']!= 'undefined')) {
			$updateConfig = $_GET['updateConfig'];
			if ((int)$updateConfig != $updateConfig || (int)$updateConfig < 0 || (int)$updateConfig > 1) {
				$updateConfig = 0;
			}
 		} else {
			$updateConfig = 0;
		}

		if (isset($_GET['debugMode']) && ($_GET['debugMode']!= 'undefined')) {
			$debugModeTemp = $_GET['debugMode'];
			if ((int)$debugModeTemp != $debugModeTemp || (int)$debugModeTemp < 0 || (int)$debugModeTemp > 1) {
				$debugModeTemp = 0;
			}
		} else {
			$debugModeTemp = 0;
		}

		if (isset($_GET['showDisabledPins']) && ($_GET['showDisabledPins']!= 'undefined')) {
			$showDisabledPinsTemp = $_GET['showDisabledPins'];
			if ((int)$showDisabledPinsTemp != $showDisabledPinsTemp || (int)$showDisabledPinsTemp < 0 || (int)$showDisabledPinsTemp > 1) {
				$showDisabledPinsTemp = 0;
			}
		} else {
			$showDisabledPinsTemp = 0;
		}

		if (isset($_GET['enableLogging']) && ($_GET['enableLogging']!= 'undefined')) {
			$enableLoggingTemp = $_GET['enableLogging'];
			if ((int)$enableLoggingTemp != $enableLoggingTemp || (int)$enableLoggingTemp < 0 || (int)$enableLoggingTemp > 1) {
				$enableLoggingTemp = 1;
			}
		} else {
			$enableLoggingTemp = 1;
		}

		if (isset($_GET['showBCMNumber']) && ($_GET['showBCMNumber']!= 'undefined')) {
			$showBCMNumberTemp = $_GET['showBCMNumber'];
			if ((int)$showBCMNumberTemp != $showBCMNumberTemp || (int)$showBCMNumberTemp < 0 || (int)$showBCMNumberTemp > 1) {
					$showBCMNumberTemp = 0;
			}
		} else 	{
			$showBCMNumberTemp = 0;
		}

		if (isset($_GET['showWPiNumber']) && ($_GET['showWPiNumber']!= 'undefined')) {
			$showWPiNumberTemp = $_GET['showWPiNumber'];
			if ((int)$showWPiNumberTemp != $showWPiNumberTemp || (int)$showWPiNumberTemp < 0 || (int)$showWPiNumberTemp > 1) {
				$showWPiNumberTemp = 0;
			}
		} else {
			$showWPiNumberTemp = 0;
		}

		if (isset($_GET['showDisableBox']) && ($_GET['showDisableBox']!= 'undefined')) {
			$showDisableBoxTemp = $_GET['showDisableBox'];
			if ((int)$showDisableBoxTemp != $showDisableBoxTemp || (int)$showDisableBoxTemp < 0 || (int)$showDisableBoxTemp > 1) {
				$showDisableBoxTemp = 0;
			}
		} else {
			$showDisableBoxTemp = 0;
		}

		if (isset($_GET['pinDelay']) && ($_GET['pinDelay']!= 'undefined')) {
			$pinDelayTemp = $_GET['pinDelay'];
			if ((int)$pinDelayTemp != $pinDelayTemp || (int)$pinDelayTemp < 0) {
				$pinDelayTemp = 5;
		}
			} else {
			$pinDelayTemp = 5;
		}

		// Update config fields as (if) needed.
		$query_update = "";

		if ($updateConfig > 0) {
			$query_update = 'UPDATE config SET debugMode = :debugMode, showDisabledPins = :disabledPins, logPageSize = :logPageSize, enableLogging = :enableLogging, showBCMNumber = :showBCMNumber, showWPiNumber = :showWPiNumber, showDisableBox = :showDisableBox, pinDelay = :pinDelay WHERE configVersion = 1';
			$qry_result = $db->prepare($query_update);
			$qry_result->execute(array(':debugMode'=>$debugModeTemp, ':disabledPins'=>$showDisabledPinsTemp, ':logPageSize'=>$pageSizeTemp, ':enableLogging'=>$enableLoggingTemp, ':showBCMNumber'=>$showBCMNumberTemp, ':showWPiNumber'=>$showWPiNumberTemp, ':showDisableBox'=>$showDisableBoxTemp, ':pinDelay'=>$pinDelayTemp));
			$_SESSION['debugMode'] = $debugModeTemp;
			$_SESSION['showDisabledPins'] = $showDisabledPinsTemp;
			$_SESSION['logPageSize'] = $pageSizeTemp;
			$_SESSION['enableLogging'] = $enableLoggingTemp;
			$_SESSION['showBCMNumber'] = $showBCMNumberTemp;
			$_SESSION['showWPiNumber'] = $showWPiNumberTemp;
			$_SESSION['showDisableBox'] = $showDisableBoxTemp;
			$_SESSION['pinDelay'] = $pinDelayTemp;
		}

		// Build Result String.
		$display_string = "		<script type=\"text/javascript\">var logPageSize=document.getElementById('logPageSize').value); var pinDelay=document.getElementById('pinDelay').value);</script>\r\n";
		$display_string .= "		<table>\r\n";

		// gpioserverd status..
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>gpioserverd status</td>\r\n";
		$display_string .= "				<td>";
		$display_string .= $_SESSION['gpioserverdStatus'];
		$display_string .= "				</td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Debug Mode.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Enable Debug Mode</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . ($_SESSION['debugMode'] == 1 ? '0':'1') . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . "," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" />";

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
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . ($_SESSION['showDisabledPins'] == 1 ? '0':'1') . "," . $_SESSION['logPageSize'] . "," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" />";

		switch ($_SESSION['showDisabledPins']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show BCM number.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show BCM pin number</a></td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . "," . $_SESSION['enableLogging'] . "," . ($_SESSION['showBCMNumber'] == 1 ? '0':'1') . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" />";

		switch ($_SESSION['showBCMNumber']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show WPi number.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show WPi number</a></td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . "," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . ($_SESSION['showWPiNumber'] == 1 ? '0':'1')  . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" />";

		switch ($_SESSION['showWPiNumber']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show Disable box.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show Disable box</a></td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . "," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . ($_SESSION['showDisableBox'] == 1 ? '0':'1') . ",pinDelay.value)\" />";

		switch ($_SESSION['showDisableBox']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Enable logging.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Enable Logging</a></td>\r\n";
		$display_string .= " <td><a href=\"#\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . "," . ($_SESSION['enableLogging'] == 1 ? '0':'1') . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" />";
		switch ($_SESSION['enableLogging']) {
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
		$display_string .= "                            <td><input type=\"text\" id=\"logPageSize\" value=\"" . $_SESSION['logPageSize'] . "\" size=\"3\" class=\"page dark gradient\" /><input type=\"submit\" value=\"save\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . ",logPageSize.value," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" class=\"page dark gradient\" /></td>\r\n";
		$display_string .= "                    </tr>\r\n";

	        // Pin delay.
		$display_string .= "                    <tr>\r\n";
		$display_string .= "                            <td>Pin delay</a></td>\r\n";
		$display_string .= "                            <td><input type=\"text\" id=\"pinDelay\" value=\"" . $_SESSION['pinDelay'] . "\" size=\"3\" class=\"page dark gradient\" /><input type=\"submit\" value=\"save\" onclick=\"showPage(3,1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . ",logPageSize.value," . $_SESSION['enableLogging'] . "," . $_SESSION['showBCMNumber'] . "," . $_SESSION['showWPiNumber'] . "," . $_SESSION['showDisableBox'] . ",pinDelay.value)\" class=\"page dark gradient\" /></td>\r\n";
		$display_string .= "                    </tr>\r\n";

		// Close table.
		$display_string .= "		</table>\r\n";

		// Display it.
		print $display_string;

		if ($_SESSION['debugMode']) {
			//debug output
			print $configVariables . "\r\n";
			print '		<pre>Query params: ' . $updateConfig . ' ' . $debugModeTemp . ' ' . $showDisabledPinsTemp . ' ' . $pageSizeTemp . ' ' . $enableLoggingTemp . "</pre>\r\n";
			print '		<pre>' . $query_update . "</pre>\r\n";
		}
	}

	else {
		print "Logged out. Please reload page.\r\n";
	}

	// Cleanup.
	unset($row);
	unset($qry_result);
	unset($qry_resultpn);
	unset($row_fieldvalue);
	unset($qry_fieldvalue_result);
	$db = null;

} catch (Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
