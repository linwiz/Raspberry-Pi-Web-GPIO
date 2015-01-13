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

addLogItem() {
    logdatas="$1 $2 $3"
    echo "INSERT INTO	 log (data) VALUES (\"$logdatas\");" | mysql --host=$mysqlhostname --user=$mysqlusername --password=$mysqlpassword $mysqldatabase;
}

addLogItem "Starting GPIO Server"
trap "addLogItem Stopping GPIO Server" EXIT

mysqlquery="mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase"

# Retreive all pins.
# paku - but only if the pinNumerBCM is the numerical value
pins=`echo "SELECT pinNumberBCM FROM pinRevision$revision WHERE concat('',pinNumberBCM * 1) = pinNumberBCM order by pinID" | $mysqlquery`

#echo $pins

# Start Loop.
while true; do
	for PIN in $pins ;
		do
			# Enable or Disable pins accordingly.
			enabled[$PIN]=`echo "SELECT pinID,pinEnabled,pinStatus,pinDirection FROM pinRevision$revision WHERE pinNumberBCM='$PIN'" | $mysqlquery`

			this_pin=${enabled[$PIN]}

			arr=($this_pin)

			#pinID
#			echo ${arr[0]}
			#pinEnabled
#			echo ${arr[1]}
			#pinStatus
#			echo ${arr[2]}
			#pinDirection
#			echo ${arr[3]}


			#from here we do not need more selects, all pin data are stored in the array

			# GPIO commands are disabled wirt comment as well as log output and sleep !!

			if [ "${arr[1]}" == "1" ]; then
				if [ ! -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/export
					if [ "$logging" ]; then addLogItem "Enabled Pin $PIN"; fi
				fi
			else
				if [ -d "/sys/class/gpio/gpio$PIN" ]
				then
					echo $PIN > /sys/class/gpio/unexport
					if [ "$logging" ]; then addLogItem "Disabled Pin $PIN"; fi
				fi
			fi

			# Skip disabled pins.
			if [ -d "/sys/class/gpio/gpio$PIN" ]; then

				# Read Pin Directions.
				direction2=`cat /sys/class/gpio/gpio$PIN/direction`

				# Read Pin Status'.
				status2=`gpio -g read $PIN`

				# Change Pin Status'.
				if [ "${arr[3]}" != "$direction2" ]; then
					addLogItem "Pin $PIN direction to: ${arr[3]} ($direction2)"
					if [ -n $PIN ]; then
						if [ -n ${arr[3]} ]; then
							gpio -g write $PIN ${arr[3]}
							if [ "$logging" ]; then
								addLogItem "Pin $PIN direction to: ${arr[3]}"
							fi
						elif [ -z ${arr[3]} ]; then
							addLogItem "PIN direction zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "PIN value zero"
					fi
				fi

				if [ "${arr[2]}" != "$status2" ]; then
					if [ -n $PIN ]; then
						if [ -n ${arr[2]} ]; then
							gpio -g write $PIN ${arr[2]}
							if [ "$logging" ]; then
								 addLogItem "Pin $PIN changed to: ${arr[2]}"
							fi
						elif [ -z ${arr[2]} ]; then
							addLogItem "PIN status zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "PIN value zero"
					fi
				fi
			fi
			#not needed any more
			#sleep 0.2
	done

	# Complete Loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
