#!/usr/bin/python
import RPi.GPIO as GPIO

# Retrieve revision information
revision = GPIO.RPI_REVISION
print "Raspberry Pi Revision Found! Revision: " + str(revision)

# Save revision information in the config.php file
s = open("mysqli.php", 'r').read()
f = open("mysqli.php", 'w')

execfile("GPIOServer.conf.sh")

s = s.replace("$MySQLi_Host = '';", "$MySQLi_Host = '" + mysqlhostname + "';")
s = s.replace("$MySQLi_User = '';", "$MySQLi_User = '" + mysqlusername + "';")
s = s.replace("$MySQLi_Password = '';", "$MySQLi_Password = '" + mysqlpassword + "';")
s = s.replace("$MySQLi_DataBase = '';", "$MySQLi_DataBase = '" + mysqldatabase + "';")
s = s.replace("$pi_rev = '';", "$pi_rev = '" + str(revision) + "';")

f.write(s)
f.close()
