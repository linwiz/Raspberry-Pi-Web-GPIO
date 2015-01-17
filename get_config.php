<?php
include 'set_config_vars.php';

// Get params for update.
$pageSize		= isset($_GET['logPageSize']) && ($_GET['logPageSize']!= 'undefined') 	? $_GET['logPageSize'] 	: 10;
$updateConfig		= isset($_GET['updateConfig']) && ($_GET['updateConfig']!= 'undefined') 	? $_GET['updateConfig'] 	: 0;
$debugModeTemp			= isset($_GET['debugMode']) && ($_GET['debugMode']!= 'undefined') 	? $_GET['debugMode'] 	: 0;
$showDisabledPinsTemp 	= isset($_GET['showDisabledPins'])  	&& ($_GET['showDisabledPins']!= 'undefined') 		? $_GET['showDisabledPins'] 		: 0;

// Set up state icons.
$on =  'images/checkbox_checked_icon.png';
$off = 'images/checkbox_unchecked_icon.png';

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
	$display_string .= "				<td><a href=\"#\" onclick=\"showConfig(1," . ($_SESSION['debugMode'] == 1 ? '0':'1') . "," . $_SESSION['showDisabledPins'] . "," . $_SESSION['logPageSize'] . ")\" />";

	switch ($_SESSION['debugMode']) {
		case 1 :
			$display_string .= "<img src=\"$on\" />";
			break;
		case 0 :
			$display_string .= "<img src=\"$off\" />";
	}
	$display_string .= "</a></td>\r\n";
	$display_string .= "			</tr>\r\n";

	// Show Disabled Pins.
	$display_string .= "			<tr>\r\n";
	$display_string .= "				<td>Show Disabled Pins</a></td>\r\n";
	$display_string .= "				<td><a href=\"#\" onclick=\"showConfig(1," . $_SESSION['debugMode'] . "," . ($_SESSION['showDisabledPins'] == 1 ? '0':'1') . "," . $_SESSION['logPageSize'] . ")\" />";

	switch ($_SESSION['showDisabledPins']) {
		case 1 :
			$display_string .= "<img src=\"$on\" />";
			break;
		case 0 :
			$display_string .= "<img src=\"$off\" />";
	}
	$display_string .= "</a></td>\r\n";
	$display_string .= "			</tr>\r\n";

        // Log page size.
        $display_string .= "                    <tr>\r\n";
        $display_string .= "                            <td>Log pagination</a></td>\r\n";
        $display_string .= "                            <td><input type=\"text\" id=\"logPageSize\" value=\"" . $_SESSION['logPageSize'] . " \" size=\"3\" /><input type=\"submit\" value=\"save\" onclick=\"alert(logPageSize.value);showConfig(1," . $_SESSION['debugMode'] . "," . $_SESSION['showDisabledPins'] . ",logPageSize.value)\" /></td>\r\n";

        $display_string .= "</a></td>\r\n";
        $display_string .= "                    </tr>\r\n";

	// Close table.
	$display_string .= "		</table>\r\n";

	// Display it.
	print $display_string;

	if ($_SESSION['debugMode']) {
		//debug output
		print '<pre>Query params: ' . $updateConfig . ' ' . $debugModeTemp . ' ' . $showDisabledPinsTemp . ' ' . $pageSize . '</pre>';
		print '<pre>' . $query_update . '</pre>';
	}
} catch(Exception $e) {
	echo 'Exception -> ';
	var_dump($e->getMessage());
}
?>
