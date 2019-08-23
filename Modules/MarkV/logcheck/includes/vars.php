<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$match_path = $directory."includes/rules/match";
$ignore_path = $directory."includes/rules/ignore";
$smtp_path = "/etc/ssmtp/ssmtp.conf";
$custom_path = $directory."includes/custom.sh";

$is_ssmtp_installed = exec("which ssmtp") != "" ? 1 : 0;
$is_daemon_installed = exec("cat /etc/crontabs/root | grep logcheck") != "" ? 1 : 0;
$daemon_update = exec("logread | grep logcheck_report.sh | tail -1 | awk '{print $1\" \"$2\" \"$3;}'");

$is_logcheck_running = exec("ps auxww | grep logread | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_logcheck_onboot = exec("cat /etc/rc.local | grep logcheck") != "" ? 1 : 0;

$logcheck_conf = parse_ini_file($directory."includes/infusion.conf");
$To = $logcheck_conf['to'];
$From = $logcheck_conf['from'];
$Subject = $logcheck_conf['subject'];

$cron_time = "*/30 * * * *";
$cron_task = $directory."includes/logcheck_report.sh";

if(!file_exists("/etc/ssmtp/") && file_exists("/sd/etc/ssmtp/"))
{
	exec("ln -s /sd/etc/ssmtp/ /etc/ssmtp");
}

?>