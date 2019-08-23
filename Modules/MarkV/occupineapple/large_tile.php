</br></br><div class="my_large_tile_content">

<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/occupineapple/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/occupineapple/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/occupineapple/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ occupineapple_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="occupineapple" class="refresh_text"></span></div>
<div class=sidePanelContent>
<div id=sidePanelContent_int>
<?php
if($is_mdk3_installed)
{
	echo '<fieldset class="occupineapple">';
	echo '<legend class="occupineapple">Logical Interfaces</legend>';

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
			echo '<a id="disable" href="javascript:occupineapple_interface_toggle(\''.$wifi_interfaces[$i].'\',\'stop\');">[Disable]</a>';
		else
			echo '<a id="enable" href="javascript:occupineapple_interface_toggle(\''.$wifi_interfaces[$i].'\',\'start\');">[Enable]</a>';
		echo '</td>';
	
		echo '<td>';
			echo '<a id="enable" href="javascript:occupineapple_monitor_toggle(\''.$wifi_interfaces[$i].'\',\'\',\'start\');">[Start Monitor]</a>';
		echo '</td>';
	
		echo '<td>&nbsp;</td>';
	
		echo '</tr>';
	}

	echo "</table>";
	echo '</fieldset>';
	echo '<br />';
	echo '<fieldset class="occupineapple">';
	echo '<legend class="occupineapple">Monitor Interfaces</legend>';

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
				echo '<a id="disable" href="javascript:occupineapple_interface_toggle(\''.$monitor_interfaces[$i].'\',\'stop\');">[Disable]</a>';
			else
				echo '<a id="enable" href="javascript:occupineapple_interface_toggle(\''.$monitor_interfaces[$i].'\',\'start\');">[Enable]</a>';
			echo '</td>';
	
			echo '<td>';
				echo '<a id="disable" href="javascript:occupineapple_monitor_toggle(\'\',\''.$monitor_interfaces[$i].'\',\'stop\');">[Stop Monitor]</a>';
			echo '</td>';
	
			echo '<td></td>';
	
			echo '</tr>';
		}
	}

	echo "</table>";
	echo '</fieldset>';
	echo "</div><br/>";
	
	echo '<fieldset class="occupineapple">';
	echo '<legend class="occupineapple">Dependencies</legend>';
	
	echo "mdk3";
	echo "&nbsp;<font color=\"lime\"><strong>&#10004;</strong></font><br />";
	
	echo '</fieldset>';
	echo "<br/>";
	
	echo '<fieldset class="occupineapple">';
	echo '<legend class="occupineapple">Controls</legend>';

	if ($is_mdk3_running)
	{
		echo "Occupineapple <span id=\"mdk3_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"mdk3_link\" href=\"javascript:occupineapple_mdk3_toggle('stop');\"><strong>Stop</strong></a> ";
	}
	else
	{ 
		echo "Occupineapple <span id=\"mdk3_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"mdk3_link\" href=\"javascript:occupineapple_mdk3_toggle('start');\"><strong>Start</strong></a> "; 
	}
	
	echo "<span id=\"interfaces_l\">";
	echo '<select class="occupineapple" id="interfaces_list" name="interfaces_list">';
	for ($i=0;$i<count($wifi_interfaces);$i++)
	{ 
		if($interface_conf == $wifi_interfaces[$i])
			echo '<option selected value="'.$wifi_interfaces[$i].'">'.$wifi_interfaces[$i].'</option>'; 
		else
			echo '<option value="'.$wifi_interfaces[$i].'">'.$wifi_interfaces[$i].'</option>'; 
	}
	echo '</select>';
	echo "</span>";
	echo "<span id=\"monitorInterface_l\">";
	echo '<option value="">--</option>';
	echo '<select class="occupineapple" id="monitorInterfaces_list" name="monitorInterfaces_list">';
	for ($i=0;$i<count($monitor_interfaces);$i++)
	{ 
		if($monitor_conf == $monitor_interfaces[$i])
			echo '<option selected value="'.$monitor_interfaces[$i].'">'.$monitor_interfaces[$i].'</option>'; 
		else
			echo '<option value="'.$monitor_interfaces[$i].'">'.$monitor_interfaces[$i].'</option>'; 
	}
	echo '</select>';
	echo "</span>";
	
	if($is_mdk3_running)
		echo '<select class="occupineapple" disabled="disabled" id="list" name="list">';
	else
		echo '<select class="occupineapple" id="list" name="list">';
	
	echo '<option>--</option>';
	$lists_list = array_reverse(glob($directory."includes/lists/*"));

	for($i=0;$i<count($lists_list);$i++)
	{
		if($occupineapple_run == basename($lists_list[$i]))
			echo '<option selected value="'.basename($lists_list[$i]).'">'.basename($lists_list[$i]).'</option>';
		else
			echo '<option value="'.basename($lists_list[$i]).'">'.basename($lists_list[$i]).'</option>';
	}
	echo '</select><br /><br />';

	if ($is_mdk3_onboot) 
	{
		echo "Autostart <span id=\"boot_status\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:occupineapple_boot_toggle('disable');\"><strong>Disable</strong></a><br />";
	}
	else 
	{ 
		echo "Autostart <span id=\"boot_status\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"boot_link\" href=\"javascript:occupineapple_boot_toggle('enable');\"><strong>Enable</strong></a><br />"; 
	}
	
	echo '</fieldset>';
}
else
{
	echo "mdk3";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:occupineapple_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:occupineapple_install('sd');\">SD Storage</a>";
		
	exit();	
}

?>
</div>
</div>

<div id="occupineapple" class="tab">
	<ul>
		<li><a id="Output_link" class="selected" href="#Output">Output</a></li>
		<li><a id="Editor_link" href="#Editor">Editor</a></li>
		<li><a id="Configuration_link" href="#Conf">Configuration</a></li>
	</ul>
	
<div id="Output">
	[<a id="refresh" href="javascript:occupineapple_refresh();">Refresh</a>]<br /><br />
	<textarea readonly class="occupineapple" id='occupineapple_output' name='occupineapple_output' cols='85' rows='29'></textarea>
</div>

<div id="Editor">
	<table id="occupineapple" class="grid" cellspacing="0">
		<tr>
			<td>List: </td>
			<td>
				<select class="occupineapple" id="list_editor" name="list_editor">
				<option>--</option>
				<?php
					$lists_list = array_reverse(glob($directory."includes/lists/*"));

					for($i=0;$i<count($lists_list);$i++)
					{
						echo '<option value="'.basename($lists_list[$i]).'">'.basename($lists_list[$i]).'</option>';
					}
				?>
				</select> [<a id="delete_list" href="javascript:occupineapple_delete_list();">Delete List</a>]
			</td>
		</tr>
		<tr>
			<td>Name: </td>
			<td>
				<input class="occupineapple" type="text" id="list_name" name="list_name" value="" size="50"> [<a id="new_list" href="javascript:occupineapple_new_list();">New List</a>] <span id="error_text"></span>
			</td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>
				<textarea class="occupineapple" id='list_content' name='list_content' cols='114' rows='29'></textarea><br/><br/>
				[<a id="save_list" href="javascript:occupineapple_save_list();">Save List</a>]	
			</td>
		</tr>
	</table>
</div>

<div id="Conf">
	[<a id="config" href="javascript:occupineapple_set_config();">Save</a>]<br />
	<div id="occupineapple_content_conf"></div>
</div>

</div>
<br />
Auto-refresh <select class="occupineapple" id="occupineapple_auto_time">
	<option value="1000">1 sec</option>
	<option value="5000">5 sec</option>
	<option value="10000">10 sec</option>
	<option value="15000">15 sec</option>
	<option value="20000">20 sec</option>
	<option value="25000">25 sec</option>
	<option value="30000">30 sec</option>
</select> <a id="occupineapple_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a>

</div>
