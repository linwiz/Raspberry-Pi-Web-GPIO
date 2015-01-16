<?php
// Enter Database connection details below, OR
// leave these values blank and run setup.py.
// eg; python setup.py OR ./setup.py

$db_Type = ''; // Enter your db Type here.
$db_Host = ''; // Enter your db Server address here.
$db_User = ''; // Enter your db Username here.
$db_Password = ''; // Enter your db Password here.
$db_DataBase = ''; // Enter your db Database here.

// Database connection
try {
	if ($db_Type == 'mysql') {
		$db = new PDO("mysql:host=$db_Host;dbname=$db_DataBase", $db_User, $db_Password);
	}
	else {
		echo "Database type $db_Type is invalid.";
	}
} catch(PDOException $e){
	echo "ERROR: ". $e->getMessage();
}
?>
