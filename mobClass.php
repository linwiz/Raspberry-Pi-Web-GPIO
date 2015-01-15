<?php
session_start();
// Database connection & config
// looks strange when the Globals are displayed twice but it seems it's sent before headers so 'once' is not working ...
// So I disabled getting config here,  it should be checked out.
//require_once 'set_config_vars.php';
require_once 'db.php';

// Password hashing functions.
require_once('scrypt.php');

// Custom PHP Class "mobClass"
//  Nothing to edit here.

class mobClass {
	// Validate login information.
	public function checkLogin($username, $password) {
		global $db;
		$loginQuery = 'SELECT count(*) FROM users WHERE username = :username';
		$loginResult = $db->prepare($loginQuery);
		$loginResult->execute(array(':username'=>$username));

		if($loginResult->fetchColumn() < 1){
			return FALSE;
		}
		$loginData = $loginResult->fetch(PDO::FETCH_ASSOC);
		If (Password::check($password, $loginData['password']) === FALSE) {
			return FALSE;
		} else {
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['userID'] = $loginData['userID'];
			return TRUE;
		}
	}
}
?>
