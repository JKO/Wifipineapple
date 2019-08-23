<?php

require("/pineapple/components/infusions/notify/handler.php");
require("/pineapple/components/infusions/notify/functions.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_POST['set_conf']))
{
	if($_POST['set_conf'] == "email")
	{
		$notify_conf['to_email'] = $_POST['to'];
		$notify_conf['from_email'] = $_POST['from'];		
		put_ini_file($directory."includes/infusion.conf", $notify_conf);
	}
	
	if($_POST['set_conf'] == "pushover")
	{
		$notify_conf['apptoken'] = $_POST['apptoken'];
		$notify_conf['userkey'] = $_POST['userkey'];
		put_ini_file($directory."includes/infusion.conf", $notify_conf);
	}
	
	if($_POST['set_conf'] == "msmtp")
	{
		$filename = $msmtp_path;
		$msmtp = $_POST['msmtp'];

		$newdata = ereg_replace(13,  "", $msmtp);
		$fw = fopen($filename, 'w');
		$fb = fwrite($fw,stripslashes($msmtp));
		fclose($fw);
	}
	
	echo '<font color="lime"><strong>updated</strong></font>';
}

?>