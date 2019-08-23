<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$is_msmtp_installed = exec("which msmtp") != "" ? 1 : 0;
$is_curl_installed = exec("which curl") != "" ? 1 : 0;

$msmtp_path = "/etc/msmtprc";

$notify_conf = parse_ini_file($directory."includes/infusion.conf");
$apptoken_conf = $notify_conf['apptoken'];
$userkey_conf = $notify_conf['userkey'];

$to_conf = $notify_conf['to'];
$from_conf = $notify_conf['from'];

$is_email_enabled = $notify_conf['notification_email'];
$is_push_enabled = $notify_conf['notification_push'];

if(!file_exists("/etc/msmtprc") && file_exists("/sd/etc/msmtprc"))
{
	exec("ln -s /sd/etc/msmtprc /etc/msmtprc");
}

?>