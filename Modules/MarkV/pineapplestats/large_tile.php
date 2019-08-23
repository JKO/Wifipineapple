<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/pineapplestats/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/pineapplestats/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/pineapplestats/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ pineapplestats_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="pineapplestats" class="refresh_text"></span></div>
<div class=sidePanelContent>
<?php
if($installed)
{
	echo "Pineapple Date and Time <font color=\"lime\"><strong>".$pineDateTime."</strong></font><br/>";
	echo "Pineapple ID <font color=\"lime\"><strong>".$pineNumbers."</strong></font><br/>";
	if($pineName != "")
		echo "Pineapple Name <font color=\"lime\"><strong>".$pineName."</strong></font><br/>";
	else
		echo "Pineapple Name <font color=\"orange\"><strong><em>not defined</em></strong></font> [<a href=\"javascript:pineapplestats_showTab()\">Configuration</a>]<br/>";
	echo "Pineapple MAC <font color=\"lime\"><strong>".$pineMAC."</strong></font><br/>";
	if($pineLatitude != "" && $pineLatitude != "")
		echo "Pineapple Position <font color=\"lime\"><strong>".$pineLatitude." / ".$pineLatitude."</strong></font><br/><br/>";
	else
		echo "Pineapple Position <font color=\"orange\"><strong><em>not defined</em></strong></font> [<a href=\"javascript:pineapplestats_showTab()\">Configuration</a>]<br/><br/>";

	if ($is_daemon_running)
	{
		echo "Daemon <span id=\"daemon_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"daemon_link\" href=\"javascript:pineapplestats_daemon_toggle('stop');\"><strong>Stop</strong></a><br />";
	}
	else
	{ 
		echo "Daemon <span id=\"daemon_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"daemon_link\" href=\"javascript:pineapplestats_daemon_toggle('start');\"><strong>Start</strong></a><br />"; 
	}
	
	if ($is_daemon_onboot) 
	{
		echo "Autostart <span id=\"boot_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:pineapplestats_boot_toggle('disable');\"><strong>Disable</strong></a><br /><br />";
	}
	else 
	{ 
		echo "Autostart <span id=\"boot_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:pineapplestats_boot_toggle('enable');\"><strong>Enable</strong></a><br /><br />"; 
	}

	if($is_watchdog_installed)
	{
		echo "Watchdog <span id=\"watchdog_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"watchdog_link\" href=\"javascript:pineapplestats_watchdog_toggle('disable');\"><strong>Uninstall</strong></a>";
		echo " | <a href=\"javascript:hide_large_tile(); draw_large_tile('configuration', 'system'); selectTabContent('cron');\"><b>Edit</b></a><br />";
	}
	else
	{
		echo "Watchdog <span id=\"watchdog_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"watchdog_link\" href=\"javascript:pineapplestats_watchdog_toggle('enable');\"><strong>Install</strong></a>";
		echo " | <a href=\"javascript:hide_large_tile(); draw_large_tile('configuration', 'system'); selectTabContent('cron');\"><b>Edit</b></a><br />";
	}
	if($watchdog_update != "")
		echo "Last watchdog update: <font color=\"lime\"><strong>".$watchdog_update."</strong></font><br/><br />";
	else
		echo "Last watchdog update: <font color=\"red\"><strong>N/A</strong></font><br/><br />";
	
	if($is_reboot_installed)
	{
		echo "AutoReboot <span id=\"reboot_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"reboot_link\" href=\"javascript:pineapplestats_reboot_toggle('disable');\"><strong>Uninstall</strong></a>";
		echo " | <a href=\"javascript:hide_large_tile(); draw_large_tile('configuration', 'system'); selectTabContent('cron');\"><b>Edit</b></a><br />";
	}
	else
	{
		echo "AutoReboot <span id=\"reboot_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"reboot_link\" href=\"javascript:pineapplestats_reboot_toggle('enable');\"><strong>Install</strong></a>";
		echo " | <a href=\"javascript:hide_large_tile(); draw_large_tile('configuration', 'system'); selectTabContent('cron');\"><b>Edit</b></a><br />";
	}
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
				
	exit();
}
?>
</div>
</div>

<div id="pineapplestats" class="tab">
	<ul>
		<li><a id="Output_link" class="selected" href="#Output">Output</a></li>
		<li><a id="Configuration_link" href="#Conf">Configuration</a></li>
		<li><a id="Help_link" href="#Help">Help</a></li>
	</ul>

<div id="Output">
	[<a id="refresh" href="javascript:pineapplestats_refresh();">Refresh</a>] [<a id="clean" href="javascript:pineapplestats_clean();">Clean log</a>]<br /><br />
	<textarea class="pineapplestats" id='pineapplestats_output' name='pineapplestats_output' cols='85' rows='29'></textarea>
</div>

<div id="Conf">
	[<a id="config" href="javascript:pineapplestats_set_config();">Save</a>]<br />
	<div id="pineapplestats_content_conf"></div>
</div>

<div id="Help">
	<div>
		<strong>Web UI:</strong>	<br><br>
		1. Upload server-side files from <a href="/components/infusions/pineapplestats/includes/pineapplestats.tar.gz" download>pineapplestats.tar.gz</a> on remote server.<br><br>
		2. Create DB Structure by using pineapplestats.sql.<br><br>
		3. Go to your remote server and follow the instructions for the installation.
	</div>
</div>

</div>
<br />
Auto-refresh <select class="pineapplestats" id="pineapplestats_auto_time">
	<option value="1000">1 sec</option>
	<option value="5000">5 sec</option>
	<option value="10000">10 sec</option>
	<option value="15000">15 sec</option>
	<option value="20000">20 sec</option>
	<option value="25000">25 sec</option>
	<option value="30000">30 sec</option>
</select> <a id="pineapplestats_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a>
