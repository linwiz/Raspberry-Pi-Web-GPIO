<h3>Raspberry-Pi-Web-GPIO</h3>
=====================
PHP script to control Raspberry PI GPIO pins from the web.

Raspberry Pi Web GPIO _should_ work from any modern mobile or desktop browser, but this hasn't been tested.

See http://linwiz.github.io/Raspberry-Pi-Web-GPIO page for screenshots.

<h4>Requires:</h4>
<ul>
  <li>MySQL
    <ul>
    <li>Tested on 5.5.38</li>
    <li>mysqli library</li>
    </ul>
  </li>
  <li>PHP
    <ul>
    <li>Tested on 5.4.4</li>
    <li>mcrypt library</li>
    </ul>
  </li>
</ul>


Configuring:

Import docs/gpio.sql into MySQL.

Create user for database `gpio`.

Edit GPIOServer.sh:

Set MySQL connection information in `GPIOServer.sh`

Verify the following directory is correct

revision=`python /var/www/gpio/revision.py`


Edit config.php

Set MySQL connection information in `config.php`


Usage:

Execute `GPIOServer.sh`:

Make sure the file has execute permissions.

```
chmod +x GPIOServer.sh
```
		
Run the script, It retrieves pin status from the database and turns pins on or off.

```
./GPIOServer.sh &
```

Load the script in your browser/mobile device.

Default login information:

username: `admin`

password: `rpi`



Enabling GPIOServer.sh on boot:

Edit the init.d/gpioserver file and make sure the TWO paths to GPIOserver.sh are correct.

Copy the init.d/gpioserver to your system's init.d directory.

chmod it to allow execution and enable it to run on startup:

```
sudo cp init.d/gpioserver /etc/init.d
sudo chmod +x /etc/init.d/gpioserver
sudo update-rc.d gpioserver defaults
```

-----------

Credit goes to: Daniel Curzon (http://www.instructables.com/id/Web-Control-of-Raspberry-Pi-GPIO).

GPIOServer.sh Script created by Daniel Curzon (https://code.google.com/p/raspberrypi-gpio).

-----------
	
Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).

Copyright (c) 2013, Taylor Hornby

All rights reserved.