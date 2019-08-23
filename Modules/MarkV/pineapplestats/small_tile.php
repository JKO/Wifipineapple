<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/pineapplestats/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/pineapplestats/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ pineapplestats_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="pineapplestats_loading" class="refresh" onclick="javascript:pineapplestats_refresh_tile();"></a></div>

<?php
if($installed)
{
	echo "Pineapple Date and Time <font color=\"lime\"><strong>".$pineDateTime."</strong></font><br/>";
	echo "Pineapple ID <font color=\"lime\"><strong>".$pineNumbers."</strong></font><br/>";
	if($pineName != "")
		echo "Pineapple Name <font color=\"lime\"><strong>".$pineName."</strong></font><br/>";
	else
		echo "Pineapple Name <font color=\"orange\"><strong><em>not defined</em></strong></font><br/>";
	echo "Pineapple MAC <font color=\"lime\"><strong>".$pineMAC."</strong></font><br/>";
	if($pineLatitude != "" && $pineLatitude != "")
		echo "Pineapple Position <font color=\"lime\"><strong>".$pineLatitude." / ".$pineLatitude."</strong></font><br/><br/>";
	else
		echo "Pineapple Position <font color=\"orange\"><strong><em>not defined</em></strong></font><br/><br/>";

	if($watchdog_update != "")
		echo "Last watchdog update: <font color=\"lime\"><strong>".$watchdog_update."</strong></font><br/><br />";
	else
		echo "Last watchdog update: <font color=\"red\"><strong>N/A</strong></font><br/><br />";
}
else if($install_error)
{
	echo "No internet connection...<br /><br />";
		
	echo "Please check your network connectivity...<br /><br />";
		
	echo '[<a href="javascript:pineapplestats_reload();">Reload</a>]';
	
	exec("rm -rf ".$directory."includes/install_error");
				
	exit();
}
else
{
	echo "All required dependencies have to be installed first. This may take a few minutes.<br /><br />";
		
	echo "Please wait, do not leave or refresh this page. Once the install is complete, this page will refresh automatically.<br /><br />";
		
	echo '[<a id="Install" href="javascript:pineapplestats_install();">Install</a>]';
	
	echo '<script type="text/javascript">notify("pineapplestats dependencies are not installed", "pineapplestats", "red");</script>';
				
	exit();
}
?>