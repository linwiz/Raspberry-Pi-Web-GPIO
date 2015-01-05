# Raspberry-Pi-Web-GPIO

PHP script to control Raspberry PI GPIO pins from the web.
Raspberry Pi Web GPIO _should_ work from any modern mobile
or desktop browser, but this hasn't been tested.

See http://linwiz.github.io/Raspberry-Pi-Web-GPIO page for screenshots.

## Requires
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

	
* Password Hashing With scrypt (http://crackstation.net/hashing-security.htm).
 + This works is licensed under the BSD 2-Clause license.
 + Original Scrypt Implementation; Copyright (c) 2009 Colin Percival
 + PHP Module; Copyright (c) 2012, Dominic Black
 + All rights reserved.
 + Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

> Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
