#!/bin/bash
{
# Initial Script created by Daniel Curzon (http://www.instructables.com/member/drcurzon).
# Initial version created 10th June 2012.
# Initial Version: 1.0.

# Heavily modified script by MTec007.
# August 31st 2014.

#set working directory
dir="$(dirname "$0")"

#read config file (relative)
. "$dir/GPIOServer.conf.sh"

# Retrieve revision information.
rev_cmd="python $dir/revision.py"
revision=`$rev_cmd`

echo "Starting GPIOServer.sh"
trap "echo Stopping GPIOServer.sh" EXIT

# Retreive all pins.
pins=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinNumberBCM FROM pinRevision$revision"`

# Start Loop.
while true; do
	for PIN in $pins ;
		do
			# Enable or Disable pins accordingly.
			enabled[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinEnabled FROM pinRevision$revision WHERE pinNumberBCM='$PIN'"`
			if [ "${enabled[$PIN]}" == "1" ]; then
				if [ ! -d "/sys/class/gpio/gpio$PIN" ]
				then
					gpio export $PIN out
					if [ "$logging" ]; then echo "Enabled $PIN"; fi
				fi
			else
				if [ -d "/sys/class/gpio/gpio$PIN" ]
				then
					gpio unexport $PIN
					if [ "$logging" ]; then echo "Disabled $PIN"; fi
				fi
			fi

			# Skip disabled pins.
			if [ -d "/sys/class/gpio/gpio$PIN" ]; then

				# Read Pin Directions.
				direction[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinDirection FROM pinRevision$revision WHERE pinNumberBCM='$PIN'"`
				direction2=`cat /sys/class/gpio/gpio$PIN/direction`

				# Read Pin Status'.
				status[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e "SELECT pinStatus FROM pinRevision$revision WHERE pinNumberBCM='$PIN'"`
				status2=`gpio -g read $PIN`

				# Change Pin Status'.
				if [ "${direction[$PIN]}" != "$direction2" ]; then
					gpio -g mode $PIN ${direction[$PIN]}
					if [ "$logging" ]; then echo "$PIN changed: ${direction[$PIN]}"; fi
				fi

				if [ "${status[$PIN]}" != "$status2" ]; then
					gpio -g write $PIN ${status[$PIN]}
					if [ "$logging" ]; then echo "$PIN changed: ${status[$PIN]}"; fi
				fi
			fi
	done


	# Complete Loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
