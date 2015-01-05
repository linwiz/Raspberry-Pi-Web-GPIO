<?php
// Custom PHP Class "mobClass"
//  Nothing to edit here.

class mobClass {
	// Check if user is logged in.
	public function loggedIn($username, $userID) {
		if (!isset($username) || trim($username) === '') {
			return FALSE;
		}
		if (!isset($userID) || trim($userID) === '') {
			return FALSE;
		}
		return TRUE;
	}

	// Validate login information.
	public function checkLogin($username, $password) {
		global $db;
		$username = $db->real_escape_string($username);
		$password = $db->real_escape_string($password);
		$loginQuery = "SELECT userID, password FROM users WHERE username = '$username';";
		$loginResult = $db->query($loginQuery) or die ($db->error);
		if($loginResult->num_rows < 1){
			return 'invalidUsername';
		}
		$loginData = $loginResult->fetch_assoc();
		If (Password::check($password, $loginData['password']) === FALSE) {
			return $password." ! ".$loginData['password']." ! ".Password::check($password, $loginData['password'])." ! ".Password::hash($password);
//			return 'invalidPassword';
		} else {
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['userID'] = $loginData['userID'];
			return TRUE;
		}
		$loginResult->free();
	}

	// Generate pages.
	public function newDrawer($id, $title, $label, $submit = false, &$my_array, $messageCode) {
		global $thisScript;
		$render = '	<div data-role="view" id="drawer-' . $id . '" data-layout="drawer-layout" data-title="' . $title . '">
		<ul data-role="listview" class="inboxList">' . "\r\n";
		$render .= $this->newMessage($messageCode);
		$render .= '			<form action="' . $thisScript . '" method="post">
				<ul data-role="listview" data-style="inset" data-type="group">
					<li>' . $label . '
						<ul>' . "\r\n";
							$arrayLength = count($my_array);
							for ($row = 0; $row < $arrayLength; $row++) {
								if (isset($my_array[$row][4]) && $my_array[$row][4] != "") {
									$class = 'class="' . $my_array[$row][4] . '" ';
								}
								else {
									$class = "";
								}
								$render .= '							<li>' . "\r\n";
								$render .= '								<label>' . "\r\n";
								$render .= '									' . $my_array[$row][0] . "\r\n";
								$render .= '									<input type="' . $my_array[$row][1] . '" name="' . $my_array[$row][2] . '" value="' . $my_array[$row][3] . '" ' . $class . '/>' . "\r\n";
								$render .= '								</label>' . "\r\n";
								$render .= '							</li>' . "\r\n";
							}
							$render .= '						</ul>
					</li>
				</ul>';
				if ($submit) {
					$render .= '
				<input type="submit" style="margin-left: -1000px" />';
				}
			$render .= '
			</form>
		</ul>
	</div>' . "\r\n";
		return $render;
	}

	// Generate page to edit pin descriptions.
	public function fillEditPinForm() {
		global $thisScript, $db, $pi_rev;
		$fillQuery = "SELECT pinNumber, pinDescription, pinEnabled FROM pinRevision$pi_rev";
		$fillResult = $db->query($fillQuery) or die ($db->error);
		$totalGPIOCount = $fillResult->num_rows;
		$currentGPIOCount = 0;
		while ($currentGPIOCount < $totalGPIOCount) {
			$pinRow = $fillResult->fetch_assoc();
			$pinEnabled = $pinRow['pinEnabled'];
			$pinNumber = $pinRow['pinNumber'];
			$pinDescription = $pinRow['pinDescription'];
			if ($pinEnabled != 2) {
				if ($pinEnabled == 1) {
					$pinChecked = 'checked="checked" ';
				}
				else {
					$pinChecked = "";
				}
				print '
								<li>
									<label>
										Pin ' . $pinNumber . '
										<input type="text" name="pinDescription' . $pinNumber . '" value="' . $pinDescription . '" />
									</label>
								</li>
								<li>
									<label>
										 Enable Pin ' . $pinNumber . '
										<input type="checkbox" name="pinEnabled' . $pinNumber . '" ' . $pinChecked . ' />
									</label>
								</li>' . "\r\n";
			}
			$currentGPIOCount ++;
		}
		print '							<input type="hidden" name="action" value="update" />
							<input type="submit" style="margin-left: -1000px" />' . "\r\n";
		$fillResult->free();
	}

	// Generate main form to toggle pin status.
	public function fillToggleForm() {
		global $thisScript, $db, $pi_rev;
		$fillQuery = "SELECT pinNumber, pinDescription, pinStatus, pinEnabled FROM pinRevision$pi_rev";
		$fillResult = $db->query($fillQuery) or die ($db->error);
		$totalGPIOCount = $fillResult->num_rows;
		$currentGPIOCount = 0;
		while ($currentGPIOCount < $totalGPIOCount) {
			$pinRow = $fillResult->fetch_assoc();
			$pinEnabled = $pinRow['pinEnabled'];
			$pinNumber = $pinRow['pinNumber'];
			$pinStatus = $pinRow['pinStatus'];
			$pinDescription = $pinRow['pinDescription'];
			If ($pinStatus == "0") {
				$action = "turnOn";
				$checked = '';
			} else {
				$action = "turnOff";
				$checked = ' checked="checked"';
			}

			if ($pinEnabled == 1) {
				print '			<li>
					<label>
						' . $pinDescription . '
						<form id="form' . $pinNumber . '" action="' . $thisScript . '" method="post">
							<input id="pin' . $pinNumber . '" data-role="switch" data-change="switchChange' . $pinNumber . '"' . $checked . ' />
							<input type="hidden" name="pin" value="' . $pinNumber . '" />
							<input type="hidden" name="action" value="' . $action . '" />
						</form>
					</label>
				</li>' . "\r\n";
			}
			$currentGPIOCount ++;
		}
		$fillResult->free();
	}

	// Generate array with pin numbers.
	public function arrayPins() {
		$newArray = array();
		global $thisScript, $db, $pi_rev;
		$fillQuery = "SELECT pinNumber FROM pinRevision$pi_rev ORDER BY pinID ASC";
		$fillResult = $db->query($fillQuery) or die ($db->error);
		while (($pinRow =  $fillResult->fetch_assoc())) {
			$newArray[] = $pinRow['pinNumber'];
		}
		$fillResult->free();
		return $newArray;
	}

	// Print messages.
	public function newMessage($code = '') {
		global $thisScript;
		if ($code == '') {
			return '';
		}
		if ($code == "passwordChanged") {
			$message = "Password Changed Successfullly.";
			$type = "success";
		}
		else if ($code == "pinUpdated") {
			$message = "Pin Updated Successfullly.";
			$type = "success";
		}
		else if ($code == "pinDescriptionUpdated") {
			$message = "Pin Description Updated Successfullly.";
			$type = "success";
		}
		else if ($code == "passwordsDoNotMatch") {
			$message = "New passwords do not match.";
			$type = "error";
		}
		else if ($code == "passwordLength") {
			$message = "Password must be 1 to 256 characters long.";
			$type = "error";
		}
		else if ($code == "incorrectUsername") {
			$message = "Invalid Username.";
			$type = "error";
		}
		else if ($code == "incorrectPassword") {
			$message = "Invalid Password.";
			$type = "error";
		}
		else if ($code == "invalidUsername") {
			$message = "Invalid Username.";
			$type = "error";
		}
		else if ($code == "invalidPassword") {
			$message = "Invalid Password.";
			$type = "error";
		}
		else {
			return $code;
		}
return '			<li>
				<div class="k-block k-' . $type . '-colored" data-role="listview"><a href="' . $thisScript . '" data-icon="closemessage">' . $message . '</a></div>
			</li>' . "\r\n";
	}
}
?>
