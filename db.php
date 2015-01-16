<?php
// Enter Database connection details below, OR
// leave these lines default and run setup.py.
// eg; python setup.py OR ./setup.py
$db_Host = '';	// Enter your db Server address here.
$db_User = '';	// Enter your db Username here.
$db_Password = '';	// Enter your db Password here.
$db_DataBase = '';	// Enter your db Database here.

try {
	$db = new PDO("mysql:host=$db_Host;dbname=$db_DataBase", $db_User, $db_Password);
} catch(PDOException $e){
	echo "ERROR: ". $e->getMessage();
}

// Raspberry Pi board revision.
// Enter your revision if you know it, OR
// leave this line default and run setup.py.
// eg; python setup.py OR ./setup.py
$pi_rev = '';	// Enter your Raspberry Pi revision number here.
?>
