<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$interfaces = explode("\n", trim(shell_exec("cat /proc/net/dev | tail -n +3 | cut -f1 -d: | sed 's/ //g'")));

$is_vnstat_daemon = file_exists("/tmp/run/vnstat.pid") ? 1 : 0;
$is_vnstat_daemon_installed = exec("cat /etc/crontabs/root | grep vnstat") != "" ? 1 : 0;
$is_vnstat_installed = exec("which vnstat") != "" ? 1 : 0;
$is_vnstati_installed = exec("which vnstati") != "" ? 1 : 0;
$is_db_sd = file_exists("/sd/var/lib/vnstat/") ? 1 : 0;

$daemon_update = exec("logread | grep graphs-vnstat.sh | tail -1 | awk '{print $1\" \"$2\" \"$3;}'");

$cron_time = "*/5 * * * *";
$cron_task = $directory."includes/graphs-vnstat.sh";

$options = array('s','h','d','t','m');
$options_title['s'] = 'summary';
$options_title['h'] = 'hours';
$options_title['d'] = 'days';
$options_title['t'] = 'top 10';
$options_title['m'] = 'months';

if(!$is_vnstat_installed || !$is_vnstati_installed) exec("opkg update");
if(!$is_vnstat_installed) { exec("opkg install vnstat"); $is_vnstat_installed = 1; }
if(!$is_vnstati_installed) { exec("opkg install vnstati"); $is_vnstati_installed = 1; }

?>