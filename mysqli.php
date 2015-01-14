<?php
// Enter MySQLi connection details below, OR
// leave these lines default and run setup.py.
// eg; python setup.py OR ./setup.py
$MySQLi_Host = '';	// Enter your MySQLi Server address here.
$MySQLi_User = '';	// Enter your MySQLi Username here.
$MySQLi_Password = '';	// Enter your MySQLi Password here.
$MySQLi_DataBase = '';	// Enter your MySQLi Database here.

$mysqli = new mysqli($MySQLi_Host, $MySQLi_User, $MySQLi_Password, $MySQLi_DataBase) or
 die("Please run setup.py or configure the values in the GPIOServer.conf.sh file.");

// Raspberry Pi board revision.
// Enter your revision if you know it, OR
// leave this line default and run setup.py.
// eg; python setup.py OR ./setup.py
$pi_rev = '';	// Enter your Raspberry Pi revision number here.

//UI configuration
$logPaging=10; //lines per screen

?>
