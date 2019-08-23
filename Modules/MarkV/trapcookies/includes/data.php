<?php

require("/pineapple/components/infusions/trapcookies/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['history']))
{
	$log_list = array_reverse(glob($directory."includes/log/*"));

	if(count($log_list) == 0)
		echo "<em>No log history...</em>";
	
	for($i=0;$i<count($log_list);$i++)
	{
		if(basename($log_list[$i]) != "tmp")
		{
			$info = explode("_", basename($log_list[$i]));
			echo gmdate('Y-m-d H-i-s', $info[1])." [";
			echo "<a href=\"javascript:trapcookies_load_file('".basename($log_list[$i])."');\">view</a> | ";
			echo "<a href=\"/components/infusions/trapcookies/includes/actions.php?_csrfToken=".$_SESSION['_csrfToken']."&download&file=".basename($log_list[$i])."\">download</a> | ";
			echo "<a href=\"javascript:trapcookies_delete_file('log','".basename($log_list[$i])."');\">delete</a>]<br />";
		}
	}
}

if (isset($_GET['lastlog']))
{
	if ($is_ngrep_running)
	{
		$path = $directory."includes/log";

		$latest_ctime = 0;
		$latest_filename = '';    

		$d = dir($path);
		while (false !== ($entry = $d->read())) {
		  $filepath = "{$path}/{$entry}";
		  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
		      $latest_ctime = filectime($filepath);
		      $latest_filename = $entry;
		    }
		}

		if($latest_filename != "")
		{
			$log_date = gmdate("F d Y H:i:s", filemtime($directory."includes/log/".$latest_filename));
			echo "trapcookies ".$latest_filename." [".$log_date."]\n";

			$cmd = "cat ".$directory."includes/log/".$latest_filename." | grep -E 'GET|POST|User|Host|Cookie'";
				
			exec ($cmd, $output); foreach($output as $outputline) { echo (htmlentities("$outputline\n", ENT_QUOTES|ENT_SUBSTITUTE)); }
		}
	}
	else
	{
		echo "trapcookies is not running...";
	}
}

?>