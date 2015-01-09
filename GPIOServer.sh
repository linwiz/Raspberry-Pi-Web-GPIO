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
    echo "INSERT INTO log (data) VALUES (\"$logdatas\");" | mysql --host=$mysqlhostname --user=$mysqlusername --password=$mysqlpassword $mysqldatabase;
}

addLogItem "Starting GPIO Server"
trap "addLogItem Stopping GPIO Server" EXIT

mysqlquery="mysql -B --host=$mysqlhostname --disable-column-names --user=$mysqlusername --password=$mysqlpassword $mysqldatabase"

# Retreive all pins.
pins=`echo "SELECT pinNumberBCM FROM pinRevision$revision" | $mysqlquery`
mcp23017pins=`echo "SELECT pinNumber FROM mcp23017" | $mysqlquery`

# Start Loop.
while true; do
	for PIN in $pins; do
		# Enable or Disable pins accordingly.
		enabled[$PIN]=`echo "SELECT pinEnabled FROM pinRevision$revision WHERE pinNumberBCM='$PIN'" | $mysqlquery`
		if [ "${enabled[$PIN]}" == "1" ]; then
			if [ ! -d "/sys/class/gpio/gpio$PIN" ]; then
				gpio export $PIN out
				if [ "$logging" ]; then
					addLogItem "Enabled Pin $PIN"
				fi
			fi
		else
			if [ -d "/sys/class/gpio/gpio$PIN" ]; then
				gpio unexport $PIN
				if [ "$logging" ]; then
					addLogItem "Disabled Pin $PIN"
				fi
			fi
		fi

		# Skip disabled pins.
		if [ -d "/sys/class/gpio/gpio$PIN" ]; then
			# Read pin directions.
			direction[$PIN]=`echo "SELECT pinDirection FROM pinRevision$revision WHERE pinNumberBCM='$PIN'" | $mysqlquery`
			direction2=`cat /sys/class/gpio/gpio$PIN/direction`

			# Read pin status'.
			status[$PIN]=`echo "SELECT pinStatus FROM pinRevision$revision WHERE pinNumberBCM='$PIN'" | $mysqlquery`
			status2=`gpio -g read $PIN`

			# Change pin status'.
			if [ "${direction[$PIN]}" != "$direction2" ]; then
				gpio -g mode $PIN ${direction[$PIN]}
				if [ "$logging" ]; then
					addLogItem "Pin $PIN changed to: ${direction[$PIN]}"
				fi
			fi
			if [ "${status[$PIN]}" != "$status2" ]; then
				gpio -g write $PIN ${status[$PIN]}
				if [ "$logging" ]; then
					addLogItem "Pin $PIN changed to: ${status[$PIN]}"
				fi
			fi
		fi


		# Enable or Disable MCP23017 pins accordingly.
		#enabledmcp23017[$PIN]=`echo "SELECT pinEnabled FROM mcp23017 WHERE pinNumber='$PIN'" | $mysqlquery`
		#if [ "${enabledmcp23017[$PIN]}" == "1" ]; then
		#	if [ ! -d "/sys/class/gpio/gpio$PIN" ]; then
		#		#gpio export $PIN out
		#		if [ "$logging" ]; then
		#			addLogItem "Enabled mcp23017 pin $PIN"
		#		fi
		#	fi
		#else
		#	if [ -d "/sys/class/gpio/gpio$PIN" ]; then
		#		#gpio unexport $PIN
		#		if [ "$logging" ]; then
		#			addLogItem "Disabled mcp23017 pin $PIN"
		#		fi
		#	fi
		#fi

		# Skip disabled MCP23017 pins.
		# TODO: Need to read actual export status here.
		if [ -d "/sys/class/gpio/gpio$PIN" ]; then
			# Read pin base.
			basemcp23017[$PIN]=`echo "SELECT basePin FROM mcp23017 WHERE pinNumber='$PIN'" | $mysqlquery`

			# Read pin base address.
			addrmcp23017[$PIN]=`echo "SELECT address FROM mcp23017 WHERE pinNumber='$PIN'" | $mysqlquery`

			# Read pin direction.
			directionmcp23017[$PIN]=`echo "SELECT pinDirection FROM mcp23017 WHERE pinNumber='$PIN'" | $mysqlquery`
			# TODO: Need to read actual direction here.
			#directionmcp230172=`gpio -x mcp23017:${basemcp23017[$PIN]}:${addrmcp23017[$PIN}} ? $PIN`

			# Read pin status'.
			statusmcp23017[$PIN]=`echo "SELECT pinStatus FROM mcp23017 WHERE pinNumber='$PIN'" | $mysqlquery`
			statusmcp230172=`gpio -x mcp23017:${basemcp23017[$PIN]}:${addrmcp23017[$PIN}} read $PIN`

			# Change Pin Status'.
			if [ "${direction[$PIN]}" != "$directionmcp230172" ]; then
				gpio -x mcp23017:${basemcp23017[$PIN]}:${addrmcp23017[$PIN}} mode $PIN ${direction[$PIN]}
				if [ "$logging" ]; then
					addLogItem "mcp23017 pin $PIN changed to: ${direction[$PIN]}"
				fi
			fi
			if [ "${status[$PIN]}" != "$statusmcp230172" ]; then
				gpio -x mcp23017:${basemcp23017[$PIN]}:${addrmcp23017[$PIN}} write $PIN ${status[$PIN]}
				if [ "$logging" ]; then
					addLogItem "mcp23017 pin $PIN changed to: ${status[$PIN]}"
				fi
			fi
		fi
	done

	# Complete loop.
	sleep $waitTime
done
} >> /var/log/GPIOServer.log
