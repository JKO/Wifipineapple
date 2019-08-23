<?php

require("/pineapple/components/infusions/occupineapple/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['int'])) $interface = $_GET['int'];
if (isset($_GET['mon'])) $monitorInterface = $_GET['mon'];
if (isset($_GET['list'])) $list = $_GET['list'];

if (isset($_GET['mdk3']))
{
	if (isset($_GET['start']))
	{
		exec("echo \"".$list."\" > ".$directory."includes/infusion.run");
		
		$filename = $directory."includes/infusion.conf";

		$newdata = "speed=".$speed_conf."\n"."channel=".$channel_conf."\n"."interface=".$interface."\n"."monitor=".$monitorInterface."\n"."list=".$list."\n"."options=".$options_conf;
		$newdata = ereg_replace(13,  "", $newdata);
		$fw = fopen($filename, 'w');
		$fb = fwrite($fw,stripslashes($newdata));
		fclose($fw);
		
		exec("echo ".$directory."includes/start_mdk3.sh | at now");
	}
	if (isset($_GET['stop']))
	{
		exec("echo \"\" > ".$directory."includes/infusion.run");
		exec("echo ".$directory."includes/stop_mdk3.sh | at now");
	}
}

if (isset($_POST['interface']) && isset($_POST['action']) && isset($_POST['int']))
{
	if ($_POST['action'] == 'start') 
		exec("ifconfig ".$_POST['int']." up &");
	else
		exec("ifconfig ".$_POST['int']." down &");
}

if (isset($_POST['monitor']) && isset($_POST['action']) && isset($_POST['int']) && isset($_POST['mon']))
{
	if ($_POST['action'] == 'start') 
		exec("airmon-ng start ".$_POST['int']." &");
	else
		exec("airmon-ng stop ".$_POST['mon']." &");
}

if (isset($_GET['boot']))
{
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
		
		switch($action)
		{
			case 'enable':
				exec("sed -i '/exit 0/d' /etc/rc.local"); 
				exec("echo ".$directory."includes/start_mdk3.sh >> /etc/rc.local");
				exec("echo exit 0 >> /etc/rc.local");
			break;
			
			case 'disable': 
				exec("sed -i '/start_mdk3.sh/d' /etc/rc.local");
			break;
		}
	}	
}

if (isset($_GET['install'])) 
{
	if (isset($_GET['where']))
	{
		$where = $_GET['where'];
		
		switch($where)
		{
			case 'sd': 
				exec("opkg update && opkg install mdk3 --dest sd"); 
			break;
			
			case 'internal': 
				exec("opkg update && opkg install mdk3"); 
			break;
		}
	}
}

?>