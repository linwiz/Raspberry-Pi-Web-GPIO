import RPi.GPIO as GPIO
a = GPIO.RPI_REVISION
print "Raspberry Pi Revision Found! Revision: " + str(a)

s = open("config.php").read()
s = s.replace("$pi_rev = '';", "$pi_rev = '" + str(a) + "';")
f = open("config.php", 'w')
f.write(s)
f.close()