<?php

require("/pineapple/components/infusions/wifimanager/handler.php");
require("/pineapple/components/infusions/wifimanager/functions.php");

global $directory;

require($directory."includes/vars.php");
require($directory."includes/iwlist_parser.php");

if(isset($_GET['interface']))
{
	echo '<fieldset class="wifimanager">';
	echo '<legend class="wifimanager">Physical Interfaces</legend>';
	
	echo '<table class="interfaces">';
	
	for($i=0;$i<$nbr_radio_devices;$i++)
	{
		$mac_address = exec("uci get wireless.radio".$i.".macaddr");
		$disabled = exec("uci get wireless.radio".$i.".disabled");
	
		echo '<tr>';
		
		echo '<td>radio'.$i.'</td>';
		echo '<td>';
		if(!$disabled)
		{	
			echo '<font color="lime"><strong>&#10004;</strong></font>'; 
		}
		else
		{
			echo '<font color="red"><strong>&#10008;</strong></font>';
		}
		echo '</td>';
	
		echo '<td>';
		echo $mac_address; 
		echo '</td>';
	
		echo '</tr>';
	}
	
	echo "</table>";
	echo '</fieldset>';
	echo '<br />';
	echo '<fieldset class="wifimanager">';
	echo '<legend class="wifimanager">Logical Interfaces</legend>';
	
	echo '<table class="interfaces">';
	
    for ($i=0;$i<count($wifi_interfaces);$i++)
    {
		$disabled = exec("ifconfig | grep ".$wifi_interfaces[$i]." | awk '{ print $1}'") == "" ? 1 : 0;
		
	    $uci_iface = my_getWifiIfaceUCIid($wifi_interfaces[$i]);
		$mode = exec("uci get wireless.@wifi-iface[".$uci_iface."].mode");
		
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
			echo '<a id="disable" href="javascript:wifimanager_interface_toggle(\''.$wifi_interfaces[$i].'\',\'stop\');">[Disable]</a>';
		else
			echo '<a id="enable" href="javascript:wifimanager_interface_toggle(\''.$wifi_interfaces[$i].'\',\'start\');">[Enable]</a>';
		echo '</td>';
		
		echo '<td>';
			echo '<a id="enable" href="javascript:wifimanager_monitor_toggle(\''.$wifi_interfaces[$i].'\',\'\',\'start\');">[Start Monitor]</a>';
		echo '</td>';
		
		echo '<td>&nbsp;</td>';
		
		echo '</tr>';
	}
	
	echo "</table>";
	echo '</fieldset>';
	echo '<br />';
	echo '<fieldset class="wifimanager">';
	echo '<legend class="wifimanager">Monitor Interfaces</legend>';
	
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
				echo '<a id="disable" href="javascript:wifimanager_interface_toggle(\''.$monitor_interfaces[$i].'\',\'stop\');">[Disable]</a>';
			else
				echo '<a id="enable" href="javascript:wifimanager_interface_toggle(\''.$monitor_interfaces[$i].'\',\'start\');">[Enable]</a>';
			echo '</td>';
		
			echo '<td>';
				echo '<a id="disable" href="javascript:wifimanager_monitor_toggle(\'\',\''.$monitor_interfaces[$i].'\',\'stop\');">[Stop Monitor]</a>';
			echo '</td>';
		
			echo '<td></td>';
		
			echo '</tr>';
		}
	}
	
	echo "</table>";
	echo '</fieldset>';
	echo '<br />';
	echo '<fieldset class="wifimanager">';
	echo '<legend class="wifimanager">Interfaces IP</legend>';
	
	echo '<table class="interfaces">';
	
    for ($i=0;$i<count($wifi_interfaces);$i++)
    {
		$uci_iface = my_getWifiIfaceUCIid($wifi_interfaces[$i]);
		
		$disabled = exec("ifconfig | grep ".$wifi_interfaces[$i]." | awk '{ print $1}'") == "" ? 1 : 0;
		$mode = exec("uci get wireless.@wifi-iface[".$uci_iface."].mode");
		$ip_address = exec("ifconfig ".$wifi_interfaces[$i]." | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'"); $ip_address = $ip_address != "" ? $ip_address : "";
		
		if($mode == "sta" && !$disabled)
		{
			echo '<tr>';
		
			echo '<td>'.$wifi_interfaces[$i].'</td>';
		
			echo '<td>';
			if(!$disabled)
				echo '<font color="lime"><strong>&#10004;</strong></font>';
			else
				echo '<font color="red"><strong>&#10008;</strong></font>';
			echo '</td>';
		
			if($mode == "sta" && !$disabled)
			{
				if($ip_address != "")
					echo '<td><a id="wifimanager_release" href="javascript:wifimanager_release(\''.$wifi_interfaces[$i].'\');">[Release]</a></td>';
				else
					echo '<td><a id="wifimanager_connect" href="javascript:wifimanager_connect(\''.$wifi_interfaces[$i].'\');">[Request]</a></td>';
			}
			else
			{
				echo '<td>&nbsp;</td>';
			}
		
			if($mode == "sta" && !$disabled && $interface != "-")
			{
				if($ip_address != "")
					echo '<td>'.$ip_address.'</td>';
				else
					echo '<td>&nbsp;</td>';
			}
			else
			{
				echo '<td>&nbsp;</td>';
			}
		
			echo '</tr>';
		}	
	}
	
	echo "</table>";
	echo '</fieldset>';
}

if(isset($_GET['available_ap']))
{
	if (isset($_GET['int'])) $interface = $_GET['int'];
	
	// List APs
	$iwlistparse = new iwlist_parser();
	$p = $iwlistparse->parseScanDev($interface);

	if(!empty($p))
	{
		echo '<table id="wifimanager-survey-grid" class="grid" cellspacing="0">';
		echo '<tr class="header">';
		echo '<td>SSID</td>';
		echo '<td>BSSID</td>';
		echo '<td>Signal level</td>';
		echo '<td colspan="2">Quality level</td>';
		echo '<td>Ch</td>';
		echo '<td>Encryption</td>';
		echo '<td>Cipher</td>';
		echo '<td>Auth</td>';
		echo '</tr>';
	}
	else
	{
		echo "<em>No data...</em>";
	}

	for($i=1;$i<=count($p[$interface]);$i++)
	{
		$quality = $p[$interface][$i]["Quality"];

		if($quality <= 25) $graph = "red";
		else if($quality <= 50) $graph = "yellow";
		else if($quality <= 100) $graph = "green";

		echo '<tr class="odd" name="'.$p[$interface][$i]["ESSID"].'">';

		echo '<td>'.$p[$interface][$i]["ESSID"].'</td>';

		$MAC_address = explode(":", $p[$interface][$i]["Address"]);
		echo '<td>'.$p[$interface][$i]["Address"].'</td>';
		echo '<td>'.$p[$interface][$i]["Signal level"].'</td>';
		echo "<td>".$quality."%</td>";
		echo "<td width='150'>";
		echo '<div class="graph-border">';
		echo '<div class="graph-bar" style="width: '.$quality.'%; background: '.$graph.';"></div>';
		echo '</div>';
		echo "</td>";
		echo '<td>'.$p[$interface][$i]["Channel"].'</td>';

		if($p[$interface][$i]["Encryption key"] == "on")
		{
			$WPA = strstr($p[$interface][$i]["IE"], "WPA Version 1");
			$WPA2 = strstr($p[$interface][$i]["IE"], "802.11i/WPA2 Version 1");

			$auth_type = str_replace("\n"," ",$p[$interface][$i]["Authentication Suites (1)"]);
			$auth_type = implode(' ',array_unique(explode(' ', $auth_type)));

			$cipher = $p[$interface][$i]["Pairwise Ciphers (2)"] ? $p[$interface][$i]["Pairwise Ciphers (2)"] : $p[$interface][$i]["Pairwise Ciphers (1)"];
			$cipher = str_replace("\n"," ",$cipher);
			$cipher = implode(',',array_unique(explode(' ', $cipher)));

			if($WPA2 != "" && $WPA != "")
				echo '<td>WPA,WPA2</td>';
			else if($WPA2 != "")
				echo '<td>WPA2</td>';
			else if($WPA != "")
				echo '<td>WPA</td>';
			else
				echo '<td>WEP</td>';

			echo '<td>'.$cipher.'</td>';
			echo '<td>'.$auth_type.'</td>';
		}
		else
		{
			echo '<td>None</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
		}

		echo '</tr>';
	}
}

?>