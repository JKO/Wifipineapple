<?php

require("/pineapple/components/infusions/deauth/handler.php");

global $directory;

require($directory."includes/vars.php");

if(isset($_GET['log']))
{
	if($is_deauth_running)
	{
		if(file_exists($directory."includes/log")) echo file_get_contents($directory."includes/log");
	}
	else
	{
		echo "WiFi Deauth is not running...";
	}
}
?>