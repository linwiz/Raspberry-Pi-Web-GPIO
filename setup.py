#!/usr/bin/python
import subprocess
import os
import os.path

# Configure db.php.
print "Importing settings from GPIOServer.conf.sh to db.php."
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
	print "Importing docs/gpio.sql into database: " + dbusername + "@" + dbhostname + "/" + dbdatabase
#	proc = subprocess.Popen(["mysql", "--host=%s" % dbhostname, "--user=%s" % dbusername, "--password=%s" % dbpassword, dbdatabase], stdin=subprocess.PIPE, stdout=subprocess.PIPE)
#	out, err = proc.communicate(file("docs/gpio.sql").read())
else:
	print "Database type " + dbtype + " is invalid."

# Install service.
PATH='/etc/init.d/gpioserver'
if os.path.isfile(PATH) and os.access(PATH, os.R_OK):
	print "gpioserver already installed to " + PATH
else:
	print "Installing gpioserver to " + PATH
	subprocess.call(["sudo", "chmod", "+x", "init.d/gpioserver"])
	subprocess.call(["sudo", "cp", "init.d/gpioserver", "/etc/init.d"])
	subprocess.call(["sudo", "update-rc.d", "gpioserver", "defaults"])
