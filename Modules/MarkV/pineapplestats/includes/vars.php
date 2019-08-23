<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$installed = file_exists($directory."includes/installed") ? 1 : 0;
$install_error = file_exists($directory."includes/install_error") ? 1 : 0;

$pineNumbers = exec("pineapple serial | awk '{ print $4 }'");
//$pineMAC = exec("ifconfig | grep wlan0 | awk '{print $5}'");
$pineMAC = exec("uci get wireless.radio0.macaddr");
$pineDateTime = gmdate('Y-m-d H:i:s');

$is_watchdog_installed = exec("cat /etc/crontabs/root | grep pineapplestats_watchdog.sh") != "" ? 1 : 0;
$watchdog_update = exec("logread | grep pineapplestats_watchdog.sh | tail -1 | awk '{print $1\" \"$2\" \"$3;}'");

$is_daemon_running = exec("ps auxww | grep {pineapplestats_} | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_daemon_onboot = exec("cat /etc/rc.local | grep pineapplestats_report.sh") != "" ? 1 : 0;

$is_reboot_installed = exec("cat /etc/crontabs/root | grep pineapplestats_reboot.sh") != "" ? 1 : 0;

$pineapplestats_conf_path = $directory."includes/infusion.conf";

$pineapplestats_conf = parse_ini_file($pineapplestats_conf_path);
$server = $pineapplestats_conf['server'];
$pineName = $pineapplestats_conf['pineName'];
$watchdog_time = $pineapplestats_conf['watchdogFreq'];
$reboot_time = $pineapplestats_conf['rebootFreq'];
$pineLatitude = $pineapplestats_conf['pineLatitude'];
$pineLongitude = $pineapplestats_conf['pineLongitude'];
$token = $pineapplestats_conf['token'];
$hashMAC = $pineapplestats_conf['hashMAC'];
$connectivityCheck = $pineapplestats_conf['connectivityCheck'];

if($token == "")
{
	$token = md5(uniqid(rand(), true));
	
	$newdata = "server=".$server."\n"."pineName=".$pineName."\n"."watchdogFreq=".$watchdog_time."\n"."rebootFreq=".$reboot_time."\n"."pineLatitude=".$pineLatitude."\n"."pineLongitude=".$pineLongitude."\n"."token=".$token."\n"."hashMAC=".$hashMAC."\n"."connectivityCheck=".$connectivityCheck;
	$newdata = ereg_replace(13,  "", $newdata);
	$fw = fopen($pineapplestats_conf_path, 'w');
	$fb = fwrite($fw,stripslashes($newdata));
	fclose($fw);
}

$watchdog_task = $directory."includes/pineapplestats_watchdog.sh";   
$reboot_task = $directory."includes/pineapplestats_reboot.sh";   

?>