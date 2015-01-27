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

checkMySQL() {
	if ! nc -z "$dbhostname" "$dbport"; then
		echo "MySQL is down.";
		sudo service mysql start
		sleep 5
		if ! nc -z "$dbhostname" "$dbport"; then
			echo "MySQL is down. Exiting";
			sudo service gpioserver stop
			exit;
		fi
	fi
}

checkMySQL

dbExec() {
	mysql -B --host="$dbhostname" --port="$dbport" --disable-column-names --user="$dbusername" --password="$dbpassword" "$dbdatabase" -e "$1"
}

addLogItem() {
    dbExec "INSERT INTO log (data) VALUES (\"$1\");"
}

dbQuery() {
	if ! dbExec "$1"; then
		checkMySQL
		addLogItem "$dbtype ERROR. Waiting 5 seconds to try again."
		sleep 5
		dbExec "$1"
	fi
}

# Retrieve revision information.
revision=`dbQuery "SELECT piRevision FROM config WHERE configVersion=1"`

addLogItem "Starting GPIO Server"
trap "addLogItem Stopping GPIO Server" EXIT

# Retreive all GPIO pins.
pins=`dbQuery "SELECT pinNumberBCM FROM pinRevision$revision WHERE concat('',pinNumberBCM * 1) = pinNumberBCM order by pinID"`

# Start loop.
while true; do
	# Retrieve logging information.
	logging=`dbQuery "SELECT enableLogging FROM config WHERE configVersion=1"`
	for PIN in $pins ;
		do
			# Select current pin details.
			currPIN[$PIN]=`dbQuery "SELECT pinID,pinEnabled,pinStatus,pinDirection FROM pinRevision$revision WHERE pinNumberBCM='$PIN'"`
			this_pin=${currPIN[$PIN]}
			currPIN=($this_pin)

			# Populate variables from query.
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

				# Read pin directions.
				direction2=`cat /sys/class/gpio/gpio$PIN/direction`

				# Read pin status'.
				status2=`cat /sys/class/gpio/gpio$PIN/value`

				# Change pin status'.
				if [ "$pinDirection" != "$direction2" ]; then
					if [ -n $PIN ]; then
						if [ -n $pinDirection ]; then
							echo $pinDirection > /sys/class/gpio/gpio$PIN/direction
							if [ "$logging" == "1" ]; then
								addLogItem "Pin $PIN direction to: $pinDirection"
							fi
						elif [ -z $pinDirection ]; then
							addLogItem "Pin $PIN direction zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "Pin $PIN value zero"
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
							addLogItem "Pin $PIN status zero"
						fi
					elif [ -z $PIN ]; then
						addLogItem "Pin $PIN value zero"
					fi
				fi
			fi
	done

	# Complete loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
