<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/p0f/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/p0f/includes/js/jquery.base64.min.js'></script>
<script type='text/javascript' src='/components/infusions/p0f/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/p0f/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ p0f_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="p0f" class="refresh_text"></span></div>
<div class=sidePanelContent>
<?php
if($is_p0f_installed)
{
	echo '<fieldset class="p0f">';
	echo '<legend class="p0f">Dependencies</legend>';

	if($is_p0f_installed)
	{
		echo "p0f";
		echo "&nbsp;<font color=\"lime\"><strong>&#10004;</strong></font>";
	}
	else
	{
		echo "p0f";
		echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font>";
	}

	echo '</fieldset><br/>';

	echo '<fieldset class="p0f">';
	echo '<legend class="p0f">Controls</legend>';

	if ($is_p0f_running) 
	{
		echo "p0f <span id=\"p0f_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"p0f_link\" href=\"javascript:p0f_toggle('stop');\"><strong>Stop</strong></a> ";
	}
	else
	{ 
		echo "p0f <span id=\"p0f_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"p0f_link\" href=\"javascript:p0f_toggle('start');\"><strong>Start</strong></a> "; 
	}

	if($is_p0f_running)
		echo '<select class="p0f" disabled="disabled" id="interface" name="interface">';
	else
		echo '<select class="p0f" id="interface" name="interface">';

	for($i=0;$i<count($interfaces);$i++)
	{
		if($current_interface == $interfaces[$i])
			echo '<option selected value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
		else
			echo '<option value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
	}
	echo '</select>';

	echo '</fieldset><br/>';

	echo '<fieldset class="p0f">';
	echo '<legend class="p0f">Configuration</legend>';

	if ($is_p0f_onboot) 
	{
		echo "Autostart <span id=\"boot_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:p0f_boot_toggle('disable');\"><strong>Disable</strong></a><br />";
	}
	else 
	{ 
		echo "Autostart <span id=\"boot_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:p0f_boot_toggle('enable');\"><strong>Enable</strong></a><br />"; 
	}
	echo '</fieldset>';
}
else
{
	echo "p0f";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:p0f_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:p0f_install('sd');\">SD Storage</a>";
		
	exit();	
}

?>
</div>
</div>

<div id="p0f" class="tab">
	<ul>
		<li><a id="Output_link" class="selected" href="#Output">Output</a></li>
		<li><a id="History_link" href="#History">History</a></li>
		<li><a id="Custom_link" href="#Custom">Custom</a></li>
		<li><a id="Configuration_link" href="#Conf">Configuration</a></li>
	</ul>

<div id="Output">
	[<a id="refresh" href="javascript:p0f_refresh();">Refresh</a>] Filter <input class="p0f" type="text" id="filter" name="filter" value="" size="90"> <em>Piped commands used to filter output (e.g. grep, awk)</em><br /><br />
	<textarea class="p0f" id='p0f_output' name='p0f_output' cols='85' rows='29'></textarea>
</div>

<div id="History">
	[<a id="refresh" href="javascript:p0f_refresh_history();">Refresh</a>]<br />
	<div id="content_history"></div>
</div>

<div id="Custom">
	[<a id="refresh" href="javascript:p0f_refresh_custom();">Refresh</a>]<br />
	<div id="content_custom"></div>
</div>

<div id="Conf">
	[<a id="config" href="javascript:p0f_set_config();">Save</a>]<br />
	<div id="content_conf"></div>
</div>

</div>
<br />
Auto-refresh <select class="p0f" id="auto_time">
	<option value="1000">1 sec</option>
	<option value="5000">5 sec</option>
	<option value="10000">10 sec</option>
	<option value="15000">15 sec</option>
	<option value="20000">20 sec</option>
	<option value="25000">25 sec</option>
	<option value="30000">30 sec</option>
</select> <a id="p0f_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a>