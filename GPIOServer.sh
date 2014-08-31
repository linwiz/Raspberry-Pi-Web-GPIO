#!/bin/bash
{
# Initial Script created by Daniel Curzon (http://www.instructables.com/member/drcurzon).
# Initial version created 10th June 2012.
# Initial Version: 1.0.

# Heavily modified script by MTec007.
# August 27th 2014.


###################################
#####  EDIT THESE BEFORE USE  #####
###################################
mysqlhostname="localhost"
mysqlusername="user"
mysqlpassword="pass"
mysqldatabase="gpio"

# Enable logging in /var/log/GPIOServer.log
# TODO : Doesn't log errors
logging=TRUE

# Set  Refresh.
waitTime=1

# Script directory
dir='/var/www/gpio'

#############################################################################################################################
################################################### DO NOT EDIT BELOW THIS LINE ##############################################
##############################################################################################################################

# Retrieve revision information.
rev_cmd="python $dir/revision.py"
revision=`$rev_cmd`

echo "Starting GPIOServer.sh"
trap "echo Stopping GPIOServer.sh" EXIT

# Retreive all pins.
pins=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinNumber FROM pinRevision$revision"`

# Start Loop.
while true; do
	for PIN in $pins ;
		do
			# Enable or Disable pins accordingly.
			enabled[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinEnabled FROM pinRevision$revision WHERE pinNumber='$PIN'"`
			if [ "${enabled[$PIN]}" == "1" ]; then
				if [ ! -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/export
					if [ "$logging" ]; then echo "Enabled $PIN"; fi
				fi
			else
				if [ -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/unexport
					if [ "$logging" ]; then echo "Disabled $PIN"; fi
				fi
			fi

			# Skip disabled pins.
			if [ -d "/sys/class/gpio/gpio$PIN" ]; then

				# Read Pin Directions.
				direction[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinDirection FROM pinRevision$revision WHERE pinNumber='$PIN'"`
				direction2=`cat /sys/class/gpio/gpio$PIN/direction`

				# Read Pin Status'.
				status[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e "SELECT pinStatus FROM pinRevision$revision WHERE pinNumber='$PIN'"`
				status2=`cat /sys/class/gpio/gpio$PIN/value`

				# Change Pin Status'.
				if [ "${direction[$PIN]}" != "$direction2" ]; then
					echo ${direction[$PIN]} > /sys/class/gpio/gpio$PIN/direction
					if [ "$logging" ]; then echo "$PIN changed: ${direction[$PIN]}"; fi
				fi

				if [ "${status[$PIN]}" != "$status2" ]; then
					echo ${status[$PIN]} > /sys/class/gpio/gpio$PIN/value
					if [ "$logging" ]; then echo "$PIN changed: ${status[$PIN]}"; fi
				fi
			fi
	done


	# Complete Loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log