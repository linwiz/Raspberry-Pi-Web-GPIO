<?php
exec("pgrep gpioserverd", $pids);

print 'Status:';
if (empty($pids)) {
        print ' STOPPED';
}
else {
        print ' RUNNING';
}
print ".\r\n";
?>
