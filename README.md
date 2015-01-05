# Raspberry-Pi-Web-GPIO

PHP script to control Raspberry PI GPIO pins from the web.
Raspberry Pi Web GPIO _should_ work from any modern mobile
or desktop browser, but this hasn't been tested.

See http://linwiz.github.io/Raspberry-Pi-Web-GPIO page for screenshots.

## Requires
* [WiringPi](http://wiringpi.com)
* MySQL
 + Tested on 5.5.38
 + mysqli library
* PHP
 + Tested on 5.4.4
 + mcrypt library

## Installing
Copy all files into your web directory.

## Configuring
Import docs/gpio.sql into MySQL.

Create user for database `gpio`.

### Edit GPIOServer.sh
Set MySQL connection information in `GPIOServer.sh`

Verify the following directory is correct
```
revision=`python /var/www/gpio/revision.py`
```

### Edit config.php
Set MySQL connection information in `config.php`


### Run the setup script
Make sure the file has execute permissions.
```
chmod +x setup.py
```
Run the script, It detects the Raspberry Pi's board revision and makes changes to config.php
```
./setup.py
```

## Usage
### Execute `GPIOServer.sh`
Make sure the file has execute permissions.
```
chmod +x GPIOServer.sh
```
Run the script, It retrieves pin status from the database and turns pins on or off.
```
./GPIOServer.sh &
```
Load the script in your browser/mobile device.

#### Default login information
* username: `admin`
* password: `rpi`

## Enabling GPIOServer.sh on boot as a service
Edit the init.d/gpioserver file and make sure the TWO paths to GPIOserver.sh are correct.

Copy the init.d/gpioserver to your system's init.d directory.

chmod it to allow execution and enable it to run on startup.
```
sudo cp init.d/gpioserver /etc/init.d
sudo chmod +x /etc/init.d/gpioserver
sudo update-rc.d gpioserver defaults
```

## Credit
* Original idea and code
 + Credit goes to Daniel Curzon (http://www.instructables.com/id/Web-Control-of-Raspberry-Pi-GPIO).
 + GPIOServer.sh Script created by Daniel Curzon (https://code.google.com/p/raspberrypi-gpio).

	
* Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
 + Copyright (c) 2013, Taylor Hornby
 + All rights reserved.
