</br></br><div class="my_large_tile_content">

<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/sitesurvey/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/sitesurvey/includes/js/jquery.base64.min.js'></script>
<script type='text/javascript' src='/components/infusions/sitesurvey/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/sitesurvey/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ sitesurvey_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="sitesurvey" class="refresh_text"></span></div>
<div class=sidePanelContent>
<div id=sidePanelContent_int>
<?php

echo '<fieldset class="sitesurvey">';
echo '<legend class="sitesurvey">Logical Interfaces</legend>';

echo '<table class="interfaces">';

for ($i=0;$i<count($wifi_interfaces);$i++)
{
	$disabled = exec("ifconfig | grep ".$wifi_interfaces[$i]." | awk '{ print $1}'") == "" ? 1 : 0;
	$mode = exec("uci get wireless.@wifi-iface[".$i."].mode");
	
	echo '<tr>';
	
	echo '<td>'.$wifi_interfaces[$i].'</td>';
	
	echo '<td>';
	if(!$disabled)
		echo '<font color="lime"><strong>&#10004;</strong></font>';
	else
		echo '<font color="red"><strong>&#10008;</strong></font>';
	echo '</td>';
	
	echo '<td>';
	if(!$disabled)
		echo '<a id="disable" href="javascript:sitesurvey_interface_toggle(\''.$wifi_interfaces[$i].'\',\'stop\');">[Disable]</a>';
	else
		echo '<a id="enable" href="javascript:sitesurvey_interface_toggle(\''.$wifi_interfaces[$i].'\',\'start\');">[Enable]</a>';
	echo '</td>';
	
	echo '<td>';
		echo '<a id="enable" href="javascript:sitesurvey_monitor_toggle(\''.$wifi_interfaces[$i].'\',\'\',\'start\');">[Start Monitor]</a>';
	echo '</td>';
	
	echo '<td>&nbsp;</td>';
	
	echo '</tr>';
}

echo "</table>";
echo '</fieldset>';
echo '<br />';
echo '<fieldset class="sitesurvey">';
echo '<legend class="sitesurvey">Monitor Interfaces</legend>';

echo '<table class="interfaces">';

for ($i=0;$i<count($monitor_interfaces);$i++)
{
	if($monitor_interfaces[$i] != "")
	{
		$disabled = exec("ifconfig | grep ".$monitor_interfaces[$i]." | awk '{ print $1}'") == "" ? 1 : 0;
	
		echo '<tr>';
	
		echo '<td>'.$monitor_interfaces[$i].'</td>';
	
		echo '<td>';
		if(!$disabled)
			echo '<font color="lime"><strong>&#10004;</strong></font>';
		else
			echo '<font color="red"><strong>&#10008;</strong></font>';
		echo '</td>';
	
		echo '<td>';
		if(!$disabled)
			echo '<a id="disable" href="javascript:sitesurvey_interface_toggle(\''.$monitor_interfaces[$i].'\',\'stop\');">[Disable]</a>';
		else
			echo '<a id="enable" href="javascript:sitesurvey_interface_toggle(\''.$monitor_interfaces[$i].'\',\'start\');">[Enable]</a>';
		echo '</td>';
	
		echo '<td>';
			echo '<a id="disable" href="javascript:sitesurvey_monitor_toggle(\'\',\''.$monitor_interfaces[$i].'\',\'stop\');">[Stop Monitor]</a>';
		echo '</td>';
	
		echo '<td></td>';
	
		echo '</tr>';
	}
}

echo "</table>";
echo '</fieldset>';
echo "</div>";
?>
</div>
</div>

[<a id="refresh" href="javascript:sitesurvey_refresh(0);">Refresh APs</a>] [<a id="clients" href="javascript:sitesurvey_refresh(1);">Refresh Clients</a>]
<?
	echo '<select class="sitesurvey" id="sitesurvey_interfaces" name="sitesurvey_interfaces">';
	echo '<option disabled>Interface</option>';
	foreach($wifi_interfaces as $value) { echo '<option value="'.$value.'">'.$value.'</option>'; }
	echo '</select>';
	
	echo '<select class="sitesurvey" id="sitesurvey_monitorInterface" name="sitesurvey_monitorInterface">';
	echo '<option value="--">--</option>';
	foreach($monitor_interfaces as $value)
	{
		if($value != "")
		{
			if($int_run != "" && $int_run == $value)
				echo '<option selected value="'.$value.'">'.$value.'</option>';
			else
				echo '<option value="'.$value.'">'.$value.'</option>';
		}
	}
	echo '</select>';
?>
<br /><br />
<div id="content"></div><br />
Auto-refresh <select class="sitesurvey" id="sitesurvey_auto_time">
	<option value="1000">1 sec</option>
	<option value="5000">5 sec</option>
	<option value="10000">10 sec</option>
	<option value="15000">15 sec</option>
	<option value="20000">20 sec</option>
	<option value="25000">25 sec</option>
	<option value="30000">30 sec</option>
</select> <select class="sitesurvey" id="sitesurvey_auto_what">
	<option value="0">APs</option>
	<option value="1">All</option>
</select> <a id="sitesurvey_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a> 

<div id="sitesurvey" class="tab">
	<ul>
		<li><a id="Output_link" class="selected" href="#Output">Output</a></li>
		<li><a id="Captures_link" href="#Captures">Captures</a></li>
		<li><a id="History_link" href="#History">History</a></li>
		<li><a id="Configuration_link" href="#Conf">Configuration</a></li>
	</ul>
	
<div id="Output">
	<textarea readonly class="sitesurvey" id='sitesurvey_output' name='sitesurvey_output' cols='85' rows='29'></textarea>
</div>

<div id="Captures">
	[<a id="refresh" href="javascript:sitesurvey_refresh_history();">Refresh</a>]<br />
	<div id="content_captures"></div>
</div>

<div id="History">
	[<a id="refresh" href="javascript:sitesurvey_refresh_history();">Refresh</a>]<br />
	<div id="content_history"></div>
</div>

<div id="Conf">
	[<a id="config" href="javascript:sitesurvey_set_config();">Save</a>]<br />
	<div id="content_conf"></div>
</div>

</div>

</div>