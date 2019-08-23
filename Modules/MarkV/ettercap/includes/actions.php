<?php

require("/pineapple/components/infusions/ettercap/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['launch']))
{
	if (isset($_GET['cmd']))
	{
		$time = time();
		$full_cmd = stripslashes($_GET['cmd']) . " -D -w ".$directory."includes/log/log_".$time.".pcap -m ".$directory."includes/log/log_".$time.".log";
		
		shell_exec("echo \"#!/bin/sh\n".$full_cmd." &\" > ".$directory."includes/ettercap.sh && chmod +x ".$directory."includes/ettercap.sh &");
		exec("echo ".$directory."includes/ettercap.sh | at now");
		
		if (isset($_GET['int'])) $new_int_run = $_GET['int'];
		$new_cmd_run = $_GET['cmd'];
		
		$filename = $directory."includes/infusion.run";

		$newdata = "int=".$new_int_run."\n"."cmd=".$new_cmd_run;
		$newdata = ereg_replace(13,  "", $newdata);
		$fw = fopen($filename, 'w');
		$fb = fwrite($fw,stripslashes($newdata));
		fclose($fw);
		
		exec("echo 1 > /proc/sys/net/ipv4/ip_forward");
	}
}

if (isset($_GET['cancel']))
{
	exec("echo -e \"int=\ncmd=\" > ".$directory."includes/infusion.run");
	exec("killall -9 ettercap &");
	
	exec("echo 1 > /proc/sys/net/ipv4/ip_forward");
}

if (isset($_GET['load']))
{
	if (isset($_GET['file']))
	{
		$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$_GET['file']));
		echo "<strong>ettercap log ".$_GET['file']." [".$log_date."]</strong><br/><br/>";
		
		echo '<textarea class="ettercap" cols="85" rows="29">';
		echo htmlentities(file_get_contents($directory."includes/log/".$_GET['file']), ENT_QUOTES|ENT_SUBSTITUTE);
		echo '</textarea>';
	}
}

if (isset($_GET['download']))
{
	if (isset($_GET['file']))
	{
		$file = $directory."includes/log/".basename($_GET['file']);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
		header('Content-Length: ' . filesize($file));
		readfile($file);
	}
}

if (isset($_GET['delete']))
{
	if (isset($_GET['file']))
	{
		exec("rm -rf ".$directory."includes/log/".$_GET['file']."*");
	}
}

if (isset($_GET['install_dep']))
{
	exec("echo \"<?php echo 'working'; ?>\" > ".$directory."includes/status.php");
	exec("echo \"sh ".$directory."includes/install.sh\" | at now");
}

?>