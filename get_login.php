<?php
require_once('mobClass.php');
$mobClass = new mobClass;

// define a username and password for test you can change this to a query from database or anything else that fetch a username and password
if (isset($_POST)) { // if ajax request submitted
	$post_username = $mysqli->real_escape_string($_POST['username']); // the ajax post username
	$post_password = $mysqli->real_escape_string($_POST['password']);; // the ajax post password

	$resultLogin = $mobClass->checkLogin($post_username, $post_password);
	if ($resultLogin === TRUE) {
		$_SESSION['username'] = $post_username; // define a session variable
		echo $post_username; // return a value for the ajax query
	}
}
?>
