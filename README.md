# Raspberry-Pi-Web-GPIO

PHP script to control Raspberry PI GPIO pins from the web.
Raspberry Pi Web GPIO _should_ work from any modern mobile
or desktop browser, but this hasn't been tested.

See http://linwiz.github.io/Raspberry-Pi-Web-GPIO page for screenshots.

## Requires
* [WiringPi](http://wiringpi.com)
* [scrypt](https://github.com/DomBlack/php-scrypt)
* MySQL
 + Tested on 5.5.38
* PHP
 + Tested on 5.4.4
 + mcrypt library

## Installing
Copy all files into your web directory.

## Configuring
Create MySQL database `gpio`.

Create user for MySQL database `gpio`.

### Edit GPIOServer.conf.sh
Set MySQL connection information in `GPIOServer.conf.sh`

### Run the setup script
Make sure the file has execute permissions.
```
chmod +x setup.py
```
Run the script, It detects the Raspberry Pi's board revision, imports the tables into the database,
installs the gpioserver into /etc/init.d and makes changes to db.php
```
./setup.py
```

## Usage
### Start gpioserver
Start gpioserver
```
sudo service gpioserver start
```

Load the script in your browser/mobile device.

http://127.0.0.1/

#### Default login information
* username: `admin`
* password: `rpi`

## Credit
### Original idea and code
 + Credit goes to Daniel Curzon (http://www.instructables.com/id/Web-Control-of-Raspberry-Pi-GPIO).
 + GPIOServer.sh Script created by Daniel Curzon (https://code.google.com/p/raspberrypi-gpio).

---

### Password Hashing with scrypt
(https://github.com/DomBlack/php-scrypt).
 * This works is licensed under the BSD 2-Clause license.
 * Original Scrypt Implementation; Copyright (c) 2009 Colin Percival
 * PHP Module; Copyright (c) 2012, Dominic Black
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

> Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution. THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
