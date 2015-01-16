#!/usr/bin/python
import RPi.GPIO as GPIO

# Retrieve revision information.
revision = GPIO.RPI_REVISION
print "Raspberry Pi Revision Found! Revision: " + str(revision)

# Configure db.php.
s = open("db.php", 'r').read()
f = open("db.php", 'w')
execfile("GPIOServer.conf.sh")
s = s.replace("$db_Type = '';", "$db_Type = '" + dbtype + "';")
s = s.replace("$db_Host = '';", "$db_Host = '" + dbhostname + "';")
s = s.replace("$db_User = '';", "$db_User = '" + dbusername + "';")
s = s.replace("$db_Password = '';", "$db_Password = '" + dbpassword + "';")
s = s.replace("$db_DataBase = '';", "$db_DataBase = '" + dbdatabase + "';")
f.write(s)
f.close()

# Database import magic.
if dbtype == "mysql":
	print "Importing docs/gpio.sql into database " + dbusername + "@" + dbhostname + "/" + dbdatabase
	import subprocess
	proc = subprocess.Popen(["mysql", "--host=%s" % dbhostname, "--user=%s" % dbusername, "--password=%s" % dbpassword, dbdatabase], stdin=subprocess.PIPE, stdout=subprocess.PIPE)
	out, err = proc.communicate(file("docs/gpio.sql").read())
else:
	print "Database type " + dbtype + " is invalid."
