<?php

exec("pgrep GPIOServer.sh", $pids);

print 'Status:';
if (empty($pids)) {
	print ' STOPPED';
}
else {
	print ' RUNNING';
}
print ".";

?>
