<?php

require("/pineapple/components/infusions/notify/handler.php");
require("/pineapple/components/infusions/notify/functions.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['test_email']))
{
	exec("pineapple infusion notify -n=email -m='Test Notification' -t='[Notify] Test'");
	echo '<font color="lime"><strong>test mail sent</strong></font>';
}

if (isset($_GET['test_push']))
{
	exec("pineapple infusion notify -n=push -m='Test Notification' -t='[Notify] Test'");
	echo '<font color="lime"><strong>test push sent</strong></font>';
}

if (isset($_POST['notification']) && isset($_POST['action']) && isset($_POST['notificationtype']))
{
	$notificationtype = $_POST['notificationtype'];
	
	if ($_POST['action'] == 'enable')
	{
		$notify_conf[$notificationtype] = "1";
		put_ini_file($directory."includes/infusion.conf", $notify_conf);	
	}
	else
	{
		$notify_conf[$notificationtype] = "0";
		put_ini_file($directory."includes/infusion.conf", $notify_conf);
	}
	
	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_GET['install']))
{
	if (isset($_GET['where']))
	{
		$where = $_GET['where'];
		
		if (isset($_GET['what']))
		{
			$what = $_GET['what'];
	
			switch($where)
			{
				case 'sd': 
					exec("opkg update && opkg install ".$what." --dest sd"); 
				break;

				case 'internal': 
					exec("opkg update && opkg install ".$what.""); 
				break;
			}
		}
	}
}

?>