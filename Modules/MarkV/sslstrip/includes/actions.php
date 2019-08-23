<?php

require("/pineapple/components/infusions/sslstrip/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['sslstrip']))
{
	if($is_sslstrip_installed)
	{
		if (isset($_GET['start']))
		{
			if (isset($_GET['verbose'])) $verbose = 1; else $verbose = 0;
		
			exec("iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-ports 10000");
			//exec("iptables -t nat -A PREROUTING -p tcp --destination-port 443 -j REDIRECT --to-ports 10000");
		
			$time = time();
		
			if($verbose)
				$full_cmd = "sslstrip -a -k -f -w ".$directory."includes/log/output_".$time.".log 2>&1";
			else
				$full_cmd = "sslstrip -k -f -w ".$directory."includes/log/output_".$time.".log 2>&1";

			shell_exec("echo \"#!/bin/sh\n".$full_cmd." &\" > ".$directory."includes/sslstrip.sh && chmod +x ".$directory."includes/sslstrip.sh &");
			exec("echo ".$directory."includes/sslstrip.sh | at now");
		}
	
		if (isset($_GET['stop']))
		{
			exec("kill `ps -ax | grep sslstrip | grep -v -e grep | grep -v -e php | awk {'print $1'}`");

			exec("iptables -t nat -D PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-ports 10000");
			//exec("iptables -t nat -D PREROUTING -p tcp --destination-port 443 -j REDIRECT --to-ports 10000");
		}
	}
	else
	{
		echo "sslstrip is not installed...";
	}
}

if (isset($_GET['load']))
{
	if (isset($_GET['file']))
	{
		if (isset($_GET['what']) && $_GET['what'] == "log")
		{
			$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$_GET['file']));
			echo "<strong>sslstrip log ".$_GET['file']." [".$log_date."]</strong><br/><br/>";
		
			echo '<textarea class="sslstrip" cols="85" rows="29">';
			echo htmlentities(file_get_contents($directory."includes/log/".$_GET['file']), ENT_QUOTES|ENT_SUBSTITUTE);
			echo '</textarea>';
		}
		if (isset($_GET['what']) && $_GET['what'] == "custom")
		{
			$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/custom/".$_GET['file']));
			echo "<strong>sslstrip custom log ".$_GET['file']." [".$log_date."]</strong><br/><br/>";
		
			echo '<textarea class="sslstrip" cols="85" rows="29">';
			echo file_get_contents($directory."includes/custom/".$_GET['file']);
			echo '</textarea>';
		}
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
		else if (isset($_GET['custom']))
		{
			$file = $directory."includes/custom/".$_GET['file'];
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
	}
}

if (isset($_GET['delete']))
{
	if (isset($_GET['file']))
	{
		if (isset($_GET['log']))
			exec("rm -rf ".$directory."includes/log/".$_GET['file']."*");
		else if (isset($_GET['custom']))
			exec("rm -rf ".$directory."includes/custom/".$_GET['file']."*");
	}
}

if (isset($_GET['install'])) 
{
	if (isset($_GET['where']))
	{
		$where = $_GET['where'];
		
		exec("opkg remove twisted --force-depends && opkg remove twisted-web --force-depends");
		exec("opkg remove pyopenssl --force-depends");
		exec("opkg update && opkg install twisted-web && opkg install pyopenssl");
		
		switch($where)
		{
			case 'sd': 
				exec("opkg update && opkg install sslstrip --dest sd"); 
			break;
			
			case 'internal': 
				exec("opkg update && opkg install sslstrip"); 
			break;
		}
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
				exec("sed -i '/sslstrip\/includes\/autostart.sh/d' /etc/rc.local");
			break;
		}
	}	
}

if (isset($_GET['execute']))
{
	if (isset($_GET['cmd']))
	{	
		$time = time(); $cmd = stripslashes(base64_decode($_GET['cmd']));
		$full_cmd = "(".$cmd.") &> ".$directory."includes/custom/output_".$time.".log &";
		
		$filename = $directory."includes/custom.sh";
		
		$newdata = "#!/bin/sh\n".$full_cmd;
		$newdata = ereg_replace(13,  "", $newdata);
		$fw = fopen($filename, 'w+');
		$fb = fwrite($fw,$newdata);
		fclose($fw);
		
		shell_exec("chmod +x ".$directory."includes/custom.sh &");
		exec("echo ".$directory."includes/custom.sh | at now");
	}
}

?>