<?php
session_start();
// Database connection & config
// looks strange when the Globals are displayed twice but it seems it's sent before headers so 'once' is not working ...
// So I disabled getting config here,  it should be checked out.
//require_once 'set_config_vars.php';
require_once('db.php');

// Password hashing functions.
require_once('scrypt.php');

if (isset($_POST)) { // if ajax request submitted
	$post_username = $_POST['username']; // the ajax post username
	$post_password = $_POST['password']; // the ajax post password

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
}
?>
