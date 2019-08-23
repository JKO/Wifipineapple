<?php

require("/pineapple/components/infusions/occupineapple/handler.php");

global $directory;

require($directory."includes/vars.php");

if(isset($_GET['interface']))
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
}

if(isset($_GET['monitor_l']))
{
	echo '<select class="occupineapple" id="monitorInterfaces_list" name="monitorInterfaces_list">';
	echo '<option value="">--</option>';
	foreach($monitor_interfaces as $value) { echo '<option value="'.$value.'">'.$value.'</option>'; }
	echo '</select>';
}

if(isset($_GET['interface_l']))
{
	echo '<select class="occupineapple" id="interfaces_list" name="interfaces_list">';
	foreach($wifi_interfaces as $value) { echo '<option value="'.$value.'">'.$value.'</option>'; }
	echo '</select>';
}

?>
