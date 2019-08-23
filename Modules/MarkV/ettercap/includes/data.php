<?php

require("/pineapple/components/infusions/ettercap/handler.php");
require("/pineapple/components/infusions/ettercap/functions.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['history']))
{
	$log_list = array_reverse(glob($directory."includes/log/*.pcap"));

	if(count($log_list) == 0)
		echo "<em>No log history...</em>";
	
	for($i=0;$i<count($log_list);$i++)
	{
		$file = basename($log_list[$i],".pcap");
		$info = explode("_", basename($log_list[$i]));
		echo gmdate('Y-m-d H-i-s', $info[1])." - ";
		echo dataSize($directory."includes/log/".basename($log_list[$i]))." [";
		echo "<a href=\"javascript:ettercap_load_file('".$file.".log');\">view</a> | ";
		echo "<a href=\"/components/infusions/ettercap/includes/actions.php?_csrfToken=".$_SESSION['_csrfToken']."&download&file=".$file.".log\">download</a> | ";
		echo "<a href=\"/components/infusions/ettercap/includes/actions.php?_csrfToken=".$_SESSION['_csrfToken']."&download&file=".$file.".pcap\">pcap</a> | ";
		echo "<a href=\"javascript:ettercap_delete_file('".$file."');\">delete</a>]<br />";
	}
}

if (isset($_GET['lastlog']))
{
	if ($is_ettercap_running)
	{
		$path = $directory."includes/log";

		$latest_ctime = 0;
		$latest_filename = '';  

		$d = dir($path);
		while (false !== ($entry = $d->read())) {
		  $filepath = "{$path}/{$entry}";
		  if (is_file($filepath) && filectime($filepath) > $latest_ctime && substr_compare($filepath, ".log", -4, 4) == 0) {
		      $latest_ctime = filectime($filepath);
		      $latest_filename = $entry;
		    }
		}

		if($latest_filename != "")
		{
			$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$latest_filename));
			echo "ettercap ".$latest_filename." [".$log_date."]\n";
			echo file_get_contents($directory."includes/log/".$latest_filename);
		}
	}
	else
	{
		echo "ettercap is not running...";
	}
}

?>