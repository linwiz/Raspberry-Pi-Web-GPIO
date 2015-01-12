<?php

exec("pgrep GPIOServer.sh", $pids);

print '<p>Rasberry PI GPIOService';
if(empty($pids)) {
	print ' ** NOT **';
}
print " runnig</p>";

?>
