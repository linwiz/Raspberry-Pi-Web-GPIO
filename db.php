<?php
// Leave these values blank. Run setup.py instead.
// eg; python setup.py OR ./setup.py

$db_Type = '';
$db_Host = '';
$db_Port = '';
$db_User = '';
$db_Password = '';
$db_DataBase = '';

// Database connection
try {
	if ($db_Type == 'mysql') {
		$db = new PDO("mysql:host=$db_Host;port=$db_Port;dbname=$db_DataBase", $db_User, $db_Password);
	}
	else {
		echo "Database type $db_Type is invalid.";
	}
} catch (PDOException $e) {
	echo "ERROR: ". $e->getMessage();
}
?>
