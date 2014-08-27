#!/usr/bin/python
import RPi.GPIO as GPIO

# Retrieve revision information
revision = GPIO.RPI_REVISION
print "Raspberry Pi Revision Found! Revision: " + str(revision)

# Save revision information in the config.php file
s = open("config.php").read()
s = s.replace("$pi_rev = '';", "$pi_rev = '" + str(revision) + "';")
f = open("config.php", 'w')
f.write(s)
f.close()