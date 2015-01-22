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

dbquery="mysql -B --host=$dbhostname --disable-column-names --user=$dbusername --password=$dbpassword $dbdatabase"

# Retrieve revision information.
revision=`echo "SELECT piRevision FROM config WHERE configVersion=1" | $dbquery`

addLogItem() {
    logdatas="$1 $2 $3"
    echo "INSERT INTO	 log (data) VALUES (\"$logdatas\");" | mysql --host=$dbhostname --user=$dbusername --password=$dbpassword $dbdatabase;
}

addLogItem "Starting GPIO Server"
trap "addLogItem Stopping GPIO Server" EXIT

# Retreive all GPIO pins.
pins=`echo "SELECT pinNumberBCM FROM pinRevision$revision WHERE concat('',pinNumberBCM * 1) = pinNumberBCM order by pinID" | $dbquery`

# Start Loop.
while true; do
	# Retrieve logging information.
	logging=`echo "SELECT enableLogging FROM config WHERE configVersion=1" | $dbquery`
	for PIN in $pins ;
		do

			# Select current PIN details.
			currPIN[$PIN]=`echo "SELECT pinID,pinEnabled,pinStatus,pinDirection FROM pinRevision$revision WHERE pinNumberBCM='$PIN'" | $dbquery`

			this_pin=${currPIN[$PIN]}
			currPIN=($this_pin)

			# Populate varbiables from query.
			pinID=${currPIN[0]}
			pinEnabled=${currPIN[1]}
			pinStatus=${currPIN[2]}
			pinDirection=${currPIN[3]}


			if [ "$pinEnabled" == "1" ]; then
				if [ ! -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/export
					if [ "$logging" == "1" ]; then addLogItem "Enabled Pin $PIN"; fi
				fi
			else
				if [ -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/unexport
					if [ "$logging" == "1" ]; then addLogItem "Disabled Pin $PIN"; fi
				fi
			fi

			# Skip disabled pins.
			if [ -d "/sys/class/gpio/gpio$PIN" ]; then

				# Read Pin Directions.
				direction2=`cat /sys/class/gpio/gpio$PIN/direction`

				# Read Pin Status'.
				status2=`cat /sys/class/gpio/gpio$PIN/value`

				# Change Pin Status'.
				if [ "$pinDirection" != "$direction2" ]; then
					if [ -n $PIN ]; then
						if [ -n $pinDirection ]; then
							echo $pinDirection > /sys/class/gpio/gpio$PIN/direction
							if [ "$logging" == "1" ]; then
								addLogItem "Pin $PIN direction to: $pinDirection"
							fi
						elif [ -z $pinDirection ]; then
							addLogItem "PIN direction zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "PIN value zero"
					fi
				fi

				if [ "$pinStatus" != "$status2" ]; then
					if [ -n $PIN ]; then
						if [ -n $pinStatus ]; then
							echo $pinStatus > /sys/class/gpio/gpio$PIN/value
							if [ "$logging" == "1" ]; then
								 addLogItem "Pin $PIN changed to: $pinStatus"
							fi
						elif [ -z $pinStatus ]; then
							addLogItem "PIN status zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "PIN value zero"
					fi
				fi
			fi
	done

	# Complete Loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
