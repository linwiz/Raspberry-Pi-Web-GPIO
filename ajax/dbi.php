<?php

$dbhost = "localhost";
$dbuser = "user";
$dbpass = "pass";
$dbname = "gpio";

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if ($mysqli->connect_error) {
	die('Database Error: ' . $mysqli->connect_error);
}
