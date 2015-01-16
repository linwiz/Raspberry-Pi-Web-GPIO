#!/usr/bin/python
import RPi.GPIO as GPIO

# Retrieve revision information.
revision = GPIO.RPI_REVISION
print "Raspberry Pi Revision Found! Revision: " + str(revision)

# Configure db.php.
s = open("db.php", 'r').read()
f = open("db.php", 'w')
execfile("GPIOServer.conf.sh")
s = s.replace("$db_Host = '';", "$db_Host = '" + mysqlhostname + "';")
s = s.replace("$db_User = '';", "$db_User = '" + mysqlusername + "';")
s = s.replace("$db_Password = '';", "$db_Password = '" + mysqlpassword + "';")
s = s.replace("$db_DataBase = '';", "$db_DataBase = '" + mysqldatabase + "';")
s = s.replace("$pi_rev = '';", "$pi_rev = '" + str(revision) + "';")
f.write(s)
f.close()

# MySQL import magic.
print "Importing docs/gpio.sql into database " + mysqlusername + "@" + mysqlhostname + "/" + mysqldatabase
import subprocess
proc = subprocess.Popen(["mysql", "--host=%s" % mysqlhostname, "--user=%s" % mysqlusername, "--password=%s" % mysqlpassword, mysqldatabase], stdin=subprocess.PIPE, stdout=subprocess.PIPE)
out, err = proc.communicate(file("docs/gpio.sql").read())
