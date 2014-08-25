Raspberry-Pi-Web-GPIO
=====================

PHP script to control Raspberry PI GPIO pins from the web.



Requires:

MySQL -- tested on 5.5.38
	mysqli

PHP -- tested on 5.4.4
	mcrypt library

Configuring:
Import docs/gpio.sql into MySQL
Create user for database `gpio`
Set MySQLi username and password in GPIOServer.sh
Set MySQLi connection information in config.php


Usage:

Execute GPIOServer.sh;
	Make sure the file has execute permissions
		chmod +x GPIOServer.sh
		
	run the script, retrieves pin status from the database and turns pins on or off
		./GPIOServer.sh &


Load the script in your browser/mobile device
	
		
Default login information;
	username: admin
	password: rpi

		
Credit goes to: Daniel Curzon
http://www.instructables.com/id/Web-Control-of-Raspberry-Pi-GPIO/1/?lang=en

GPIOServer.sh Script created by Daniel Curzon (http://www.instructables.com/member/drcurzon)
	
Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
Copyright (c) 2013, Taylor Hornby
All rights reserved.