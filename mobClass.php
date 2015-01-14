<?php
session_start();
// MySQLi connection & config
// looks strange when the Globals are displayed twice but it seems it's sent before headers so 'once' is not working ...
// So I disabled getting config here,  it should be checked out.
//require_once 'set_config_vars.php';
require_once 'mysqli.php';


// Password hashing functions.
require_once('scrypt.php');

// Custom PHP Class "mobClass"
//  Nothing to edit here.

class mobClass {
	// Validate login information.
	public function checkLogin($username, $password) {
		global $mysqli;
		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);
		$loginQuery = "SELECT userID, password FROM users WHERE username = '$username';";
		$loginResult = $mysqli->query($loginQuery) or die ($mysqli->error);
		if($loginResult->num_rows < 1){
			return 'invalidUsername';
		}
		$loginData = $loginResult->fetch_assoc();
		If (Password::check($password, $loginData['password']) === FALSE) {
			return 'invalidPassword';
		} else {
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['userID'] = $loginData['userID'];
			return TRUE;
		}
		$loginResult->free();
	}

}
?>
