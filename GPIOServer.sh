#!/bin/bash
{
# Initial Script created by Daniel Curzon (http://www.instructables.com/member/drcurzon).
# Initial version created 10th June 2012.
# Initial Version: 1.0.

# Heavily modified script by linwiz.
# January 7th 2015

# Set working directory.
dir="$(dirname "$0")"

# Read config file (relative).
source "$dir/GPIOServer.conf.sh"

# Retrieve revision information.
rev_cmd="python $dir/revision.py"
revision=`$rev_cmd`

echo "$(date +"%Y-%m-%d %T") Starting GPIO Server"
trap "echo Stopping GPIO Server" EXIT

# Retreive all pins.
pins=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinNumberBCM FROM pinRevision$revision"`

# Start Loop.
while true; do
	for PIN in $pins ;
		do
			NOW=$(date +"%Y-%m-%d %T")

			# Enable or Disable pins accordingly.
			enabled[$PIN]=`mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase -e"SELECT pinEnabled FROM pinRevision$revision WHERE pinNumberBCM='$PIN'"`
			if [ "${enabled[$PIN]}" == "1" ]; then
				if [ ! -d "/sys/class/gpio/gpio$PIN" ]
				then
					gpio export $PIN out
					if [ "$logging" ]; then echo "$NOW Enabled $PIN"; fi
				fi
			else
				if [ -d "/sys/class/gpio/gpio$PIN" ]
				then
					gpio unexport $PIN
					if [ "$logging" ]; then echo "$NOW Disabled $PIN"; fi
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
					if [ "$logging" ]; then echo "$NOW $PIN changed: ${direction[$PIN]}"; fi
				fi

				if [ "${status[$PIN]}" != "$status2" ]; then
					gpio -g write $PIN ${status[$PIN]}
					if [ "$logging" ]; then echo "$NOW $PIN changed: ${status[$PIN]}"; fi
				fi
			fi
	done

	# Complete Loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
