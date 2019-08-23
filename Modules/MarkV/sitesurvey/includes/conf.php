<?php

require("/pineapple/components/infusions/sitesurvey/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['get_conf']))
{
	$configArray = explode("\n", trim(file_get_contents($directory."includes/infusion.conf")));
	
	echo "<form id='sitesurvey_form_conf'>";
	echo "Command executed on selected AP [Variables: %%SSID%%, %%BSSID%%, %%CHANNEL%%]<br />";
	echo '<input class="sitesurvey" type="text" id="command_AP" name="command_AP" value="'.htmlentities($configArray[0]).'" size="115"><br /><br />';
	echo "Command executed on selected capture [Variables: %%FILENAME%%]<br />";
	echo '<input class="sitesurvey" type="text" id="command_File" name="command_File" value="'.htmlentities($configArray[1]).'" size="115">';
	echo "</form>";
}

if (isset($_POST['set_conf']))
{
	if (isset($_POST['command_AP']) && isset($_POST['command_File']))
	{
		$command_AP = base64_decode($_POST['command_AP']);
		$command_File = base64_decode($_POST['command_File']);
		
		$filename = $directory."includes/infusion.conf";
		
		$newdata = $command_AP."\n".$command_File;
		$newdata = ereg_replace(13,  "", $newdata);
		$fw = fopen($filename, 'w+');
		$fb = fwrite($fw,$newdata);
		fclose($fw);
		
		echo '<font color="lime"><strong>saved</strong></font>';
	}
}

?>