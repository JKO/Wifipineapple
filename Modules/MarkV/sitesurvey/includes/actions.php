<?php

require("/pineapple/components/infusions/sitesurvey/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['int'])) $interface = $_GET['int'];
if (isset($_GET['mon'])) $monitorInterface = $_GET['mon'];

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

if (isset($_GET['delete']))
{
	if (isset($_GET['file']))
	{
		if (isset($_GET['log']))
			exec("rm -rf ".$directory."includes/log/".$_GET['file']."*");
		if (isset($_GET['cap']))
			exec("rm -rf ".$directory."includes/captures/".$_GET['file']."*");
	}
}

if (isset($_GET['execute']))
{
	if (isset($_GET['cmd']))
	{	
		$time = time(); $cmd = stripslashes(base64_decode($_GET['cmd']));
		$full_cmd = "(".$cmd.") &> ".$directory."includes/log/output_".$time.".log";
		
		shell_exec("echo \"#!/bin/sh\n".$full_cmd." &\" > ".$directory."includes/custom.sh && chmod +x ".$directory."includes/custom.sh &");
		exec("echo ".$directory."includes/custom.sh | at now");
	}
}

if (isset($_GET['cancel']))
{
	exec("killall custom.sh &");	
}

if (isset($_GET['background_refresh']))
{
	if ($_GET['background_refresh'] == "start")
	{
		$full_cmd = "airodump-ng --write $dumpPath $monitorInterface &> /dev/null &";
		
		shell_exec("rm -rf ".$dumpPath."-01*");
		shell_exec("killall airodump-ng 2> /dev/null");

		shell_exec("echo \"#!/bin/sh\n".$full_cmd."\" > ".$directory."includes/refresh.sh && chmod +x ".$directory."includes/refresh.sh &");
		exec("echo ".$directory."includes/refresh.sh | at now");
	}
	else if ($_GET['background_refresh'] == "stop")
	{
		exec("killall airodump-ng 2> /dev/null");
		shell_exec("rm -rf ".$dumpPath."-01*");
		shell_exec("killall airodump-ng 2> /dev/null");
	}
}

if (isset($_GET['load']))
{
	if (isset($_GET['file']))
	{
		$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$_GET['file']));
		echo "<strong>sitesurvey log ".$_GET['file']." [".$log_date."]</strong><br/><br/>";
		
		echo '<textarea class="sitesurvey" cols="85" rows="29">';
		echo htmlentities(file_get_contents($directory."includes/log/".$_GET['file']), ENT_QUOTES|ENT_SUBSTITUTE);
		echo '</textarea>';
	}
}

if (isset($_GET['download']))
{
	if (isset($_GET['file']))
	{
		if (isset($_GET['log']))
		{
			$file = $directory."includes/log/".basename($_GET['file']);
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
		else if (isset($_GET['capture']))
		{
			$file = $directory."includes/captures/".$_GET['file'];
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
	}
}

?>