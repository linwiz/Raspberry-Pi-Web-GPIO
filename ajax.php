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
		exit();
	}

	// Pins/Edit page query.
	if (($_SESSION['pageType'] == "pins") || ($_SESSION['debugMode']) || (($_SESSION['pageType'] == "edit") && (isset($_SESSION['username'])))) {
		$query_update = "";
		if ((isset($field)) && ($field != "none")) {
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
	if (($_SESSION['pageType'] == "pins") && ((isset($_SESSION['username'])) || ($_SESSION['debugMode']))) {
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
		print "<input type=\"button\" onclick=\"showPage(1,'" . urlencode($sort) . "')\" class=\"page dark gradient\" value=\"Refresh\" />\r\n";

		// Edit Pin description.
		print "		<input type=\"button\" onclick=\"changeSection(4)\" class=\"page dark gradient\" value=\"Edit Descriptions\" />\r\n";

		// Build Result String.
		// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
		$display_string = "		<table>\r\n";
		$display_string .= "			<tr>\r\n";

		if ($_SESSION['debugMode']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinID%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"pinID\" /></th>\r\n";
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinDirection',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"Direction\" /></th>\r\n";
		}

		if ($_SESSION['showBCMNumber']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinNumberBCM%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"BCM#\" /></th>\r\n";
		}

		if ($_SESSION['showWPiNumber']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinNumberWPi%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"WPi#\" /></th>\r\n";
		}

		$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinDescription',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"Description\" /></th>\r\n";

		$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinStatus%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"Status\" /></th>\r\n";

		if ($_SESSION['showDisableBox']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinEnabled%2B0',0,'none','" . ($_SESSION['sortDir'] == 'ASC' ? 'DESC':'ASC') . "')\" class=\"page dark gradient\" value=\"Enabled\" /></th>\r\n";
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
						$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
						$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</a></td>\r\n";
			} else {
				$display_string .= "				<td>";
				switch ($row['pinStatus']) {
					case 1 :
		       			        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
				                $display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</td>\r\n";
			}

 			if ($_SESSION['showDisableBox']) {
				// Enabled.
				$display_string .= "				<td><a href=\"#\" onclick=\"showPage(1,'" . urlencode($sort) . "'," . $row['pinID'] . ",'pinEnabled')\">";
				switch ($row['pinEnabled']) {
					case 1 :
		        		        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
        				        $display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
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
			print "		<pre>$query</pre>\r\n";
			print "		<pre>$query_update</pre>\r\n";
		}
	}

	// Edit page.
	elseif (($_SESSION['pageType'] == "edit") && ((isset($_SESSION['username'])) || ($_SESSION['debugMode']))) {
		// Update state and enabled fields as needed.
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		foreach ($_GET as $key => $editPinValue) {
			if (strpos($key,'editPin') !== false) {
				$editPinID = str_replace("editPin", "", $key);
				$query_update = "UPDATE pinRevision" . $_SESSION['piRevision'] . " SET pinDescription=:editPinValue WHERE pinID=:editPinID";
				$qry_result = $db->prepare($query_update);
				$qry_result->bindParam(':editPinID', $editPinID, PDO::PARAM_INT);
				$qry_result->bindParam(':editPinValue', $editPinValue);
				$qry_result->execute();
			}
		}

		// Show pins page if changes were saved.
		if (isset($editPinID)) {
			print "		<script type=\"text/javascript\">changeSection(1);</script>\r\n";
		}

		// Select rows
		$query = "SELECT * FROM pinRevision" . $_SESSION['piRevision'] . " WHERE pinID > 0";
		if ($_SESSION['showDisabledPins'] == 0) {
			$query .= " AND pinEnabled = 1";
		}
		$query .= " ORDER BY $sort " .  $_SESSION['sortDir'];
		$qry_result= $db->prepare($query);
		$qry_result->execute();

		$display_string = "<script type=\"text/javascript\">\r\n";
		$display_string .= "			var editPins = [!!REPLACE_ME!!];\r\n";
		$display_string .= "		</script>\r\n";

		// Edit Pin description.
		$display_string .= "		<input type=\"button\" onclick=\"showPage(4,editPins)\" class=\"page dark gradient\" value=\"Save\" />\r\n";

		// Build Result String.
		// Important %2B0 is url encoded "+0" string passed to mySQL to force numerical varchars to be sorted as true numbers.
		$display_string .= "		<table>\r\n";
		$display_string .= "			<tr>\r\n";

		if ($_SESSION['debugMode']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinID%2B0',0,'none')\" class=\"page dark gradient\" value=\"pinID\" /></th>\r\n";
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinDirection',0,'none')\" class=\"page dark gradient\" value=\"Direction\" /></th>\r\n";
		}

		if ($_SESSION['showBCMNumber']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinNumberBCM%2B0',0,'none')\" class=\"page dark gradient\" value=\"BCM#\" /></th>\r\n";
		}

		if ($_SESSION['showWPiNumber']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinNumberWPi%2B0',0,'none')\" class=\"page dark gradient\" value=\"WPi#\" /></th>\r\n";
		}

		$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinDescription',0,'none')\" class=\"page dark gradient\" value=\"Description\" /></th>\r\n";

		$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinStatus%2B0',0,'none')\" class=\"page dark gradient\" value=\"Status\" /></th>\r\n";

		if ($_SESSION['showDisableBox']) {
			$display_string .= "				<th><input type=\"button\" onclick=\"showPage(1,'pinEnabled%2B0',0,'none')\" class=\"page dark gradient\" value=\"Enabled\" /></th>\r\n";
		}
		$display_string .= "			</tr>\r\n";

		$editPins = '';
		$editPinString = '';
		while ($row = $qry_result->fetch(PDO::FETCH_ASSOC)) {
			$display_string .= "			<tr>\r\n";
			$editPins .= "\"" . $row['pinID'] . "\",";

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
	       			        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
					break;
				case 0 :
			                $display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
			}
			$display_string .= "</td>\r\n";

 			if ($_SESSION['showDisableBox']) {
				// Enabled.
				$display_string .= "				<td>";
				switch ($row['pinEnabled']) {
					case 1 :
		        		        $display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
						break;
					case 0 :
        				        $display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
				}
				$display_string .= "</td>\r\n";
			}
			$display_string .= "			</tr>\r\n";
		}
		$display_string .= "		</table>\r\n";

		$editPins = rtrim($editPins, ",");
		$display_string = str_replace("!!REPLACE_ME!!", $editPins, $display_string);

		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
			print "		<pre>$query</pre>\r\n";
			print "		<pre>$query_update</pre>\r\n";
		}
	}

	// Log page.
	elseif (($_SESSION['pageType'] == "log") && ((isset($_SESSION['username'])) || ($_SESSION['debugMode']))) {
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
		if (((int)$id1 != $id1) || ((int)$id1 < 0)) {
			$id1 = 0;
		}
		if (((int)$id2 != $id2) || ((int)$id2 < 0)) {
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
		if (((int)$pn != $pn) || ((int)$pn < 0)) {
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
		$logPrev = ($pn - 1);
		$logNext = ($pn + 1);
		$logLastPage = ceil($logCount / $_SESSION['logPageSize']);
		$logNextToLastPage = ($logLastPage - 1);
		if ((int)$pn > (int)$logLastPage) {
			$pn = $logLastPage;
		}

		print "<input type=\"button\" onclick=\"showPage(2,$pn,'false')\" class=\"page dark gradient\" value=\"Refresh\" /> \r\n";
		print "		<input type=\"button\" onclick=\"showPage(2,$pn,'true')\" class=\"page dark gradient\" value=\"Clear Log\" /><br />\r\n";

		print "		<label for=\"id1\">ID Range:</label>\r\n";
		print "		<input type=\"text\" id=\"id1\" value=\"$id1\" onchange=\"showPage(2,$pn,'false')\" size=\"5\" class=\"page dark gradient\" />\r\n";
		print "		<input type=\"text\" id=\"id2\" value=\"$id2\" onchange=\"showPage(2,$pn,'false')\" size=\"5\" class=\"page dark gradient\" /><br />\r\n";

		print "		\r\n";

		$logPagination = '';
		$page_adjacents = '1';
		if ($logLastPage > 1) {
			$logPagination .= "		<div class=\"pagination dark\">";
			//previous button
			if ($pn > 1) {
				$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logPrev)\" class=\"page dark gradient\" value=\"prev\" /> ";
			} else {
				$logPagination .= "<span class=\"page dark gradient\">prev</span>";
			}

			//pages
			if ($logLastPage < (7 + ($page_adjacents * 2))) {
				for ($counter = 1; $counter <= $logLastPage; $counter++) {
					if ($counter == $pn) {
						$logPagination .= "<span class=\"page dark active\">$counter</span>";
					} else {
						$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\" value=\"$counter\" /> ";
					}
				}
			}
			elseif ($logLastPage > (5 + ($page_adjacents * 2))) {
				//close to beginning; only hide later pages
				if ($pn < (1 + ($page_adjacents * 2))) {
					for ($counter = 1; $counter < (4 + ($page_adjacents * 2)); $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark active\">$counter</span>";
						} else {
							$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\" value=\"$counter\" /> ";
						}
					}
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logNextToLastPage)\" class=\"page dark gradient\" value=\"$logNextToLastPage\" /> ";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logLastPage)\" class=\"page dark gradient\" value=\"$logLastPage\" /> ";
				}
				//in middle; hide some front and some back
				elseif (($logLastPage - ($page_adjacents * 2) > $pn) && ($pn > ($page_adjacents * 2))) {
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,1)\" class=\"page dark gradient\" value=\"1\" /> ";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,2)\" class=\"page dark gradient\" value=\"2\" /> ";
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					for ($counter = ($pn - $page_adjacents); $counter <= ($pn + $page_adjacents); $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark active\">$counter</span>";
						} else {
							$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\" value=\"$counter\" /> ";
						}
					}
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logNextToLastPage)\" class=\"page dark gradient\" value=\"$logNextToLastPage\" /> ";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logLastPage)\" class=\"page dark gradient\" value=\"$logLastPage\" /> ";
				}
				//close to end; only hide early pages
				else {
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,1)\" value=\"1\" /> ";
					$logPagination .= "<input type=\"button\" onclick=\"showPage(2,2)\" value=\"2\" /> ";
					$logPagination .= "<span class=\"page dark gradient\">...</span>";
					for ($counter = ($logLastPage - (2 + ($page_adjacents * 2))); $counter <= $logLastPage; $counter++) {
						if ($counter == $pn) {
							$logPagination .= "<span class=\"page dark gradient\">$counter</span>";
						} else {
							$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$counter)\" class=\"page dark gradient\" value=\"$counter\" /> ";
						}
					}
				}
			}

			//next button
			if ($pn < ($counter - 1)) {
				$logPagination .= "<input type=\"button\" onclick=\"showPage(2,$logNext)\" class=\"page dark gradient\" value=\"next\" /> ";
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
			print "		<pre>Select: " . htmlentities($query) . "</pre>";
		}
	}

	// Config page.
	elseif (($_SESSION['pageType'] == "config") && ((isset($_SESSION['username'])) || ($_SESSION['debugMode']))) {
		// Get params for update.
		if ((isset($_GET['logPageSize'])) && ($_GET['logPageSize'] != 'undefined')) {
			$pageSizeTemp = $_GET['logPageSize'];
			if (((int)$pageSizeTemp != $pageSizeTemp) || ((int)$pageSizeTemp <= 0)) {
				$pageSizeTemp = 10;
			}
		}

		if ((isset($_GET['updateConfig'])) && ($_GET['updateConfig'] != 'undefined')) {
			$updateConfig = $_GET['updateConfig'];
			if (((int)$updateConfig != $updateConfig) || ((int)$updateConfig < 0) || ((int)$updateConfig > 1)) {
				$updateConfig = 0;
			}
 		} else {
			$updateConfig = 0;
		}

		if ((isset($_GET['debugMode'])) && ($_GET['debugMode'] != 'undefined')) {
			$debugModeTemp = $_GET['debugMode'];
			if (((int)$debugModeTemp != $debugModeTemp) || ((int)$debugModeTemp < 0) || ((int)$debugModeTemp > 1)) {
				$debugModeTemp = 0;
			}
		}

		if ((isset($_GET['showDisabledPins'])) && ($_GET['showDisabledPins'] != 'undefined')) {
			$showDisabledPinsTemp = $_GET['showDisabledPins'];
			if (((int)$showDisabledPinsTemp != $showDisabledPinsTemp) || ((int)$showDisabledPinsTemp < 0) || ((int)$showDisabledPinsTemp > 1)) {
				$showDisabledPinsTemp = 0;
			}
		}

		if ((isset($_GET['enableLogging'])) && ($_GET['enableLogging'] != 'undefined')) {
			$enableLoggingTemp = $_GET['enableLogging'];
			if (((int)$enableLoggingTemp != $enableLoggingTemp) || ((int)$enableLoggingTemp < 0) || ((int)$enableLoggingTemp > 1)) {
				$enableLoggingTemp = 1;
			}
		}

		if ((isset($_GET['showBCMNumber'])) && ($_GET['showBCMNumber'] != 'undefined')) {
			$showBCMNumberTemp = $_GET['showBCMNumber'];
			if (((int)$showBCMNumberTemp != $showBCMNumberTemp) || ((int)$showBCMNumberTemp < 0) || ((int)$showBCMNumberTemp > 1)) {
					$showBCMNumberTemp = 0;
			}
		}

		if ((isset($_GET['showWPiNumber'])) && ($_GET['showWPiNumber'] != 'undefined')) {
			$showWPiNumberTemp = $_GET['showWPiNumber'];
			if (((int)$showWPiNumberTemp != $showWPiNumberTemp) || ((int)$showWPiNumberTemp < 0) || ((int)$showWPiNumberTemp > 1)) {
				$showWPiNumberTemp = 0;
			}
		}

		if ((isset($_GET['showDisableBox'])) && ($_GET['showDisableBox'] != 'undefined')) {
			$showDisableBoxTemp = $_GET['showDisableBox'];
			if (((int)$showDisableBoxTemp != $showDisableBoxTemp) || ((int)$showDisableBoxTemp < 0) || ((int)$showDisableBoxTemp > 1)) {
				$showDisableBoxTemp = 0;
			}
		}

		if ((isset($_GET['pinDelay'])) && ($_GET['pinDelay'] != 'undefined')) {
			$pinDelayTemp = $_GET['pinDelay'];
			if (((int)$pinDelayTemp != $pinDelayTemp) || ((int)$pinDelayTemp < 0)) {
				$pinDelayTemp = 5;
			}
		}

		if ((isset($_GET['chPassword1'])) && ($_GET['chPassword1'] != 'undefined')) {
			if ((isset($_GET['chPassword2'])) && ($_GET['chPassword2'] != 'undefined')) {
				if (($_GET['chPassword2'] != "") && ($_GET['chPassword2'] != "")) {
					$chPassword1Temp = $_GET['chPassword1'];
					$chPassword2Temp = $_GET['chPassword2'];
				}
			}
		}

		// Update config fields as (if) needed.
		$query_update = "";
		$pdo_array = array();
		if ($updateConfig > 0) {
/*
			if ((isset($_GET['serverStatus'])) && ($_GET['serverStatus'] != 'undefined')) {
				$serverStatusTemp = $_GET['serverStatus'];
				if (((int)$serverStatusTemp == $serverStatusTemp) && ((int)$serverStatusTemp >= 0) && ((int)$serverStatusTemp <= 1)) {
					if ($serverStatusTemp == 0) {
						//Possible to stop service? sudo service gpioserver stop
						$_SESSION['gpioserverdStatus'] = $serverStatusTemp;
					} else {
						//Possible to start service? sudo service gpioserver start
						$_SESSION['gpioserverdStatus'] = $serverStatusTemp;
					}
				}
			}
*/
			$query_update = 'UPDATE config SET ';

			if (isset($debugModeTemp)) {
				$query_update .= 'debugMode = :debugMode';
				$_SESSION['debugMode'] = $debugModeTemp;
				$pdo_array[':debugMode'] = $debugModeTemp;
			}
			if (isset($showDisabledPinsTemp)) {
				$query_update .= 'showDisabledPins = :showDisabledPins';
				$_SESSION['showDisabledPins'] = $showDisabledPinsTemp;
				$pdo_array[':showDisabledPins'] = $showDisabledPinsTemp;
			}
			if (isset($pageSizeTemp)) {
				$query_update .= 'logPageSize = :logPageSize';
				$_SESSION['logPageSize'] = $pageSizeTemp;
				$pdo_array[':logPageSize'] = $pageSizeTemp;
			}
			if (isset($enableLoggingTemp)) {
				$query_update .= 'enableLogging = :enableLogging';
				$_SESSION['enableLogging'] = $enableLoggingTemp;
				$pdo_array[':enableLogging'] = $enableLoggingTemp;
			}
			if (isset($showBCMNumberTemp)) {
				$query_update .= 'showBCMNumber = :showBCMNumber';
				$_SESSION['showBCMNumber'] = $showBCMNumberTemp;
				$pdo_array[':showBCMNumber'] = $showBCMNumberTemp;
			}
			if (isset($showWPiNumberTemp)) {
				$query_update .= 'showWPiNumber = :showWPiNumber';
				$_SESSION['showWPiNumber'] = $showWPiNumberTemp;
				$pdo_array[':showWPiNumber'] = $showWPiNumberTemp;
			}
			if (isset($showDisableBoxTemp)) {
				$query_update .= 'showDisableBox = :showDisableBox';
				$_SESSION['showDisableBox'] = $showDisableBoxTemp;
				$pdo_array[':showDisableBox'] = $showDisableBoxTemp;
			}
			if (isset($pinDelayTemp)) {
				$query_update .= 'pinDelay = :pinDelay';
				$_SESSION['pinDelay'] = $pinDelayTemp;
				$pdo_array[':pinDelay'] = $pinDelayTemp;
			}
			$query_update .= ' WHERE configVersion = 1';

			if (isset($chPassword1Temp)) {
				if (isset($chPassword2Temp)) {
					if ($chPassword1Temp == $chPassword2Temp) {
						$pdo_array = array();
						$query_update = 'UPDATE users SET password = :chPasswordTemp WHERE username = :username AND userID = :userID LIMIT 1';
						$pdo_array[':chPasswordTemp'] = Password::hash($chPassword1Temp);
						$pdo_array[':username'] = $_SESSION['username'];
						$pdo_array[':userID'] = $_SESSION['userID'];
					}
				}
			}

			$qry_result = $db->prepare($query_update);
			$qry_result->execute($pdo_array);
		}

		// Build Result String.
		$display_string = "	<table>\r\n";

		// gpioserverd status..
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Server status</td>\r\n";
		$display_string .= "				<td>";
		//$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,10," . ($_SESSION['gpioserverdStatus'] == 1 ? '0':'1') . ")\">";

		switch ($_SESSION['gpioserverdStatus']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</td>\r\n";
		//$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Debug Mode.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Enable Debug Mode</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,1," . ($_SESSION['debugMode'] == 1 ? '0':'1') . ")\">";

		switch ($_SESSION['debugMode']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show Disabled Pins.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show Disabled Pins</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,2," . ($_SESSION['showDisabledPins'] == 1 ? '0':'1') . ")\">";

		switch ($_SESSION['showDisabledPins']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show BCM number.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show BCM pin number</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,5," . ($_SESSION['showBCMNumber'] == 1 ? '0':'1') . ")\">";

		switch ($_SESSION['showBCMNumber']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show WPi number.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show WPi number</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,6," . ($_SESSION['showWPiNumber'] == 1 ? '0':'1')  . ")\">";

		switch ($_SESSION['showWPiNumber']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Show Disable box.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Show Disable box</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,7," . ($_SESSION['showDisableBox'] == 1 ? '0':'1') . ")\">";

		switch ($_SESSION['showDisableBox']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

		// Enable logging.
		$display_string .= "			<tr>\r\n";
		$display_string .= "				<td>Enable Logging</td>\r\n";
		$display_string .= "				<td><a href=\"#\" onclick=\"showPage(3,4," . ($_SESSION['enableLogging'] == 1 ? '0':'1') . ")\">";
		switch ($_SESSION['enableLogging']) {
			case 1 :
				$display_string .= "<img src=\"" . $stateIcon['on'] . "\" alt=\"" . $stateIcon['on'] . "\" />";
				break;
			case 0 :
				$display_string .= "<img src=\"" . $stateIcon['off'] . "\" alt=\"" . $stateIcon['off'] . "\" />";
		}
		$display_string .= "</a></td>\r\n";
		$display_string .= "			</tr>\r\n";

	        // Log page size.
		$display_string .= "                    <tr>\r\n";
		$display_string .= "                            <td>Log entries/page</td>\r\n";
		$display_string .= "                            <td><input type=\"text\" id=\"logPageSize\" value=\"" . $_SESSION['logPageSize'] . "\" size=\"2\" class=\"page dark gradient\" onkeydown=\"if (event.keyCode == 13) document.getElementById('submit_logPageSize').click()\" /><input type=\"button\" value=\"save\" id=\"submit_logPageSize\" onclick=\"showPage(3,3)\" class=\"page dark gradient\" /></td>\r\n";
		$display_string .= "                    </tr>\r\n";

	        // Pin delay.
		$display_string .= "                    <tr>\r\n";
		$display_string .= "                            <td>Pin delay in seconds<br /><i><small>The shorter the time<br />the more cpu will be used</i></small></td>\r\n";
		$display_string .= "                            <td><input type=\"text\" id=\"pinDelay\" value=\"" . $_SESSION['pinDelay'] . "\" size=\"2\" class=\"page dark gradient\" onkeydown=\"if (event.keyCode == 13) document.getElementById('submit_pinDelay').click()\" /><input type=\"button\" value=\"save\" id=\"submit_pinDelay\" onclick=\"showPage(3,8)\" class=\"page dark gradient\" /></td>\r\n";
		$display_string .= "                    </tr>\r\n";

	        // Update Password.
		$display_string .= "                    <tr>\r\n";
		$display_string .= "                            <td><label for=\"chPassword1\">Change password</label></td>\r\n";
		$display_string .= "                            <td><input type=\"password\" id=\"chPassword1\" class=\"page dark gradient\" onkeydown=\"if (event.keyCode == 13) document.getElementById('submit_chPassword').click()\" size=\"10\" /><br />\r\n";
                $display_string .= "                            <input type=\"password\" id=\"chPassword2\" class=\"page dark gradient\" onkeydown=\"if (event.keyCode == 13) document.getElementById('submit_chPassword').click()\" size=\"10\" /><br />\r\n";
                $display_string .= "                            <input type=\"button\" value=\"save\" id=\"submit_chPassword\" onclick=\"showPage(3,9)\" class=\"page dark gradient\" /></td>\r\n";
		$display_string .= "                    </tr>\r\n";

		// Close table.
		$display_string .= "		</table>\r\n";

		// Display it.
		print $display_string;

		if ($_SESSION['debugMode']) {
			// Debug output.
			print $configVariables . "\r\n";
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
