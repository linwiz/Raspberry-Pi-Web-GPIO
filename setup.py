#!/usr/bin/python
import subprocess
import os
import os.path
import RPi.GPIO as GPIO

# Retreive revision number.
piRevisioni=GPIO.RPI_REVISION
piRevision=str(piRevisioni)

print ("Do not leave any fields blank")
dbtype = "mysql"
#dbtype = raw_input("What is the database type? (mysql)")
dbhostname = raw_input("What is the database hostname? (localhost should be 127.0.0.1) ")
dbport = raw_input("What is the database port? (3306) ")
dbusername = raw_input("What is the database username? ")
dbpassword = raw_input("What is the database password? (not hidden) ")
dbdatabase = raw_input("What is the database name? ")

# Configure GPIOServer.conf.sh.
print ("Exporting database settings to GPIOServer.conf.sh.")
s = open("GPIOServer.conf.sh", 'r').read()
f = open("GPIOServer.conf.sh", 'w')
s = s.replace("dbtype=''", "dbtype='" + dbtype + "'")
s = s.replace("dbhostname=''", "dbhostname='" + dbhostname + "'")
s = s.replace("dbport=''", "dbport='" + dbport + "'")
s = s.replace("dbusername=''", "dbusername='" + dbusername + "'")
s = s.replace("dbpassword=''", "dbpassword='" + dbpassword + "'")
s = s.replace("dbdatabase=''", "dbdatabase='" + dbdatabase + "'")
f.write(s)
f.close()

# Configure db.php.
print ("Exporting database settings to db.php.")
s = open("db.php", 'r').read()
f = open("db.php", 'w')
s = s.replace("$db_Type = '';", "$db_Type = '" + dbtype + "';")
s = s.replace("$db_Host = '';", "$db_Host = '" + dbhostname + "';")
s = s.replace("$db_Port = '';", "$db_Port = '" + dbport + "';")
s = s.replace("$db_User = '';", "$db_User = '" + dbusername + "';")
s = s.replace("$db_Password = '';", "$db_Password = '" + dbpassword + "';")
s = s.replace("$db_DataBase = '';", "$db_DataBase = '" + dbdatabase + "';")
f.write(s)
f.close()

# Configure gpioserver.
workdir=os.path.dirname(os.path.realpath(__file__))
s = open("init.d/gpioserver", 'r').read()
f = open("init.d/gpioserver", 'w')
s = s.replace("workdir=''", "workdir='" + workdir + "'")
f.write(s)
f.close()

# Database import magic.
if dbtype == "mysql":
	MYSQL_FILE="docs/gpio.sql"
	import MySQLdb
	db = MySQLdb.connect(host=dbhostname, user=dbusername, passwd=dbpassword, db=dbdatabase)
	cur = db.cursor() 
	if not cur.execute("SHOW TABLES LIKE 'config'"):
		print ("Importing " + MYSQL_FILE + " into database: " + dbusername + "@" + dbhostname + "/" + dbdatabase)
		proc = subprocess.Popen(["mysql", "--host=%s" % dbhostname, "--user=%s" % dbusername, "--password=%s" % dbpassword, dbdatabase], stdin=subprocess.PIPE, stdout=subprocess.PIPE)
		out, err = proc.communicate(file(MYSQL_FILE).read())
	else:
		print ("Database already imported. Skipping.")

	if cur.execute("SHOW TABLES LIKE 'config'"):
		print ("Updating revision information in the config table")
		cur.execute("UPDATE config SET piRevision=" + piRevision + " WHERE configVersion=1")
		db.commit()
	else:
		print ("ERROR: config table was not found.")

else:
	print ("Database type " + dbtype + " is invalid.")

# Install service.
PATH='/etc/init.d/gpioserver'
if os.path.isfile(PATH) and os.access(PATH, os.R_OK):
	print ("gpioserver already installed at " + PATH)
else:
	print ("Installing gpioserver to " + PATH)
	subprocess.call(["sudo", "chmod", "+x", "init.d/gpioserver"])
	subprocess.call(["sudo", "ln", "-s", workdir + "init.d/gpioserver", PATH])
	subprocess.call(["sudo", "update-rc.d", "gpioserver", "defaults"])
	subprocess.call(["sudo", "service", "gpioserver", "start"])
