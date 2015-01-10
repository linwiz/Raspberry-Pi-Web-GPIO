<?php

$dbhost = "localhost";
$dbuser = "user";
$dbpass = "pass";
$dbname = "gpio";
//Connect to MySQL Server
mysql_connect($dbhost, $dbuser, $dbpass);
//Select Database
mysql_select_db($dbname) or die(mysql_error());
// Retrieve data from Query String

