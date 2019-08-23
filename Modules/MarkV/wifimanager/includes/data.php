<script type="text/javascript">
	$(document).ready(function(){
		$("#wifimanager ul").idTabs();
		$("#wifimanager2 ul").idTabs();
		
		$('.confirmation').on('click', function () {
		        return confirm('Are you sure?');
		});
	});
</script>
<?php

require("/pineapple/components/infusions/wifimanager/handler.php");
require("/pineapple/components/infusions/wifimanager/functions.php");

global $directory;

require($directory."includes/vars.php");

echo '<div id="wifimanager" class="tab">';
echo '<ul>';
echo '<li><a id="Wireless_link" class="selected" href="#Wireless">Wireless</a></li>';
echo '<li><a id="BCK_link" href="#BCK">Backup</a></li>';
echo '</ul>';

////////////////////////////
// Wireless Tab
////////////////////////////

echo '<div id="Wireless">';
echo '[<a id="wifimanager_detect" href="javascript:wifimanager_detect();">Auto-Detect</a>] [<a id="wifimanager_save" href="javascript:wifimanager_save(\'wireless_conf\');">Save</a>] [<a id="commit" href="javascript:wifimanager_commit();">Commit</a>] [<a id="revert" href="javascript:wifimanager_revert();">Revert</a>]<br/>';

echo '<div id="wifimanager2" class="tab2"><ul>';
for($i=0;$i<count($wifi_interfaces);$i++)
{
    $iface = $wifi_interfaces[$i];
    $uci_dev = my_getWifiDevUCIid($iface);

	if($uci_dev != "")
	{
		if($i == 0) $class = "selected"; else $class = "";
		echo '<li><a class="'.$class.'" href="#iface'.$i.'">'.$wifi_interfaces[$i].'</a></li>';
	}
}
echo '</ul>';

echo "<form id='wireless_conf'>";
echo "<input class='wifimanager' type='hidden' name='conf' value='wireless'/>";

for($i=0;$i<count($wifi_interfaces);$i++)
{	
    $uci_iface = my_getWifiIfaceUCIid($wifi_interfaces[$i]);
    $uci_dev = my_getWifiDevUCIid($wifi_interfaces[$i]);

	if($uci_dev != "")
	{
		$radio = exec("uci get wireless.@wifi-iface[".$uci_iface."].device");
	
		//$disabled = exec("ifconfig | grep ".$wifi_interfaces[$i]." | awk '{ print $1}'") == "" ? 1 : 0;
		$disabled = trim(exec("uci get wireless.@wifi-iface[".$uci_iface."].disabled 2>&1")) == "uci: Entry not found" ? "0" : exec("uci get wireless.@wifi-iface[".$uci_iface."].disabled");

		$mac_address = exec("cat /sys/class/net/".$wifi_interfaces[$i]."/address");

		// Section - Wifi Network
		$ssid = exec("uci get wireless.@wifi-iface[".$uci_iface."].ssid");
		$mode = exec("uci get wireless.@wifi-iface[".$uci_iface."].mode");
		$network = exec("uci get wireless.@wifi-iface[".$uci_iface."].network");
		$hidden = exec("uci get wireless.@wifi-iface[".$uci_iface."].hidden");
		$encryption = explode("+", exec("uci get wireless.@wifi-iface[".$uci_iface."].encryption"));

		$cipher = isset($encryption[2]) ? $encryption[1]."+".$encryption[2] : $encryption[1];

		$key = exec("uci get wireless.@wifi-iface[".$uci_iface."].key");

		///////////// WPA/WPA2 Enterprise (Client)
		$eap_type = exec("uci get wireless.@wifi-iface[".$uci_iface."].eap_type");
		$identity = exec("uci get wireless.@wifi-iface[".$uci_iface."].identity");
		$password = exec("uci get wireless.@wifi-iface[".$uci_iface."].password");

		///////////// WPA/WPA2 Enterprise (AP)
		$server = exec("uci get wireless.@wifi-iface[".$uci_iface."].server");
		$port = exec("uci get wireless.@wifi-iface[".$uci_iface."].port");

		// Section - Wifi Device
		$type = exec("uci get wireless.@wifi-device[".$uci_dev."].type");
		$channel = exec("uci get wireless.@wifi-device[".$uci_dev."].channel");

		////////////////////////////// Tab Content
		echo '<div id="iface'.$i.'">';

		// Display
		echo '<fieldset class="wifimanager">';
		echo '<legend class="wifimanager">Physical Interface '.$radio.' ['.$wifi_interfaces[$i].'] - HWAddr ['.$mac_address.'] [<a id="remove" class="confirmation" href="javascript:wifimanager_remove(\''.$i.'\');">Remove config</a>]</legend>';

		//// Enabled

		echo '<div class="setting">';
		echo '<span class="label">Enable</span>';
		echo '<span>';
		if($disabled == 1)
			echo '<input class="wifimanager" type="checkbox" name="parameters['.$i.'][disabled]" value="1" />';
		else
			echo '<input class="wifimanager" type="checkbox" name="parameters['.$i.'][disabled]" value="0" / checked>';
		echo '</span>';
		echo '</div>';

		//// Type

		echo '<div class="setting">';
		echo '<span class="label">Type</span>';
		echo '<span>'.$type.'</span>';
		echo '</div>';

		//// Network

		echo '<div class="setting">';
		echo '<span class="label">Network</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][network]" id="radio'.$i.'_mode">';
		foreach($network_types as $k => $v)
		{
			if($network == $v) echo '<option selected value="'.$v.'">'.$k.'</option>';
			else echo '<option value="'.$v.'">'.$k.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';

		//// Mode

		echo '<div class="setting">';
		echo '<span class="label">Mode</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][mode]" id="radio'.$i.'_mode" onchange="javascript:wifimanager_toggle_options(\'radio'.$i.'\')">';
		foreach($modes as $k => $v)
		{
			if($mode == $v) echo '<option selected value="'.$v.'">'.$k.'</option>';
			else echo '<option value="'.$v.'">'.$k.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';
	
		//// SSID

		echo '<div class="setting">';
		echo '<span class="label">Wireless Network Name (SSID)</span>';
		echo '<span><input class="wifimanager" id="radio'.$i.'_ssid" name="parameters['.$i.'][ssid]" size="20" maxlength="32" value="'.$ssid.'"> [<a id="show_ap" href="javascript:wifimanager_show_ap(\'radio'.$i.'_ssid\');">Available AP</a>]</span>';
		echo '</div>';

		//// Channel

		echo '<div class="setting">';
		echo '<span class="label">Channel</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][channel]" id="radio'.$i.'_channel">';
		if($mode == "ap")
		{
			echo '<option value="auto" disabled>auto</option>';
		}
		else
		{
			if($channel == "auto") echo '<option selected value="auto">auto</option>';
			else echo '<option value="auto">auto</option>';
		}
		for($c=1;$c<=13;$c++)
		{
			if($channel == $c) echo '<option selected value="'.$c.'">'.$c.'</option>';
			else echo '<option value="'.$c.'">'.$c.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';

		//// Broadcast

		echo '<div class="setting">';
		echo '<span class="label">Broadcast SSID</span>';
		echo '<span>';
		foreach($ssid_broadcast as $k => $v)
		{
			if($hidden == 1 && $v == 1) echo '<input class="wifimanager" type="radio" name="parameters['.$i.'][broadcast]" value="'.$v.'" checked>'.$k.'&nbsp;';
			else if($hidden == 0 && $v == 0) echo '<input class="wifimanager" type="radio" name="parameters['.$i.'][broadcast]" value="'.$v.'" checked>'.$k.'&nbsp;';
			else echo '<input class="wifimanager" type="radio" name="parameters['.$i.'][broadcast]" value="'.$v.'">'.$k.'&nbsp;';
		}
		echo '</span>';
		echo '</div>';

		//// Security Mode

		echo '<div class="setting">';
		echo '<span class="label">Security Mode</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][security_mode]" id="radio'.$i.'_security_mode" onchange="javascript:wifimanager_toggle_options(\'radio'.$i.'\')">';
		foreach($security_modes as $k => $v)
		{
			if($encryption[0] == $v) echo '<option selected value="'.$v.'">'.$k.'</option>';
			else echo '<option value="'.$v.'">'.$k.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';

		///////////// WPA/WPA2 Enterprise (Client)

		//// Eap Type

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "sta")) echo '<div id="radio'.$i.'_eap_type_div" class="setting">';
		else echo '<div id="radio'.$i.'_eap_type_div" class="setting" style="display: none;">';
		echo '<span class="label">EAP Type</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][eap_type]" id="radio'.$i.'_eap_type">';
		foreach($eap_types as $k => $v)
		{
			if($eap_type == $v) echo '<option selected value="'.$v.'">'.$k.'</option>';
			else echo '<option value="'.$v.'">'.$k.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';

		//// Identity

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "sta")) echo '<div id="radio'.$i.'_identity_div" class="setting">';
		else echo '<div id="radio'.$i.'_identity_div" class="setting" style="display: none;">';
		echo '<span class="label">Identity</span>';
		echo '<span><input class="wifimanager" name="parameters['.$i.'][identity]" size="20" maxlength="32" value="'.$identity.'"></span>';
		echo '</div>';

		//// Password

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "sta")) echo '<div id="radio'.$i.'_password_div" class="setting">';
		else echo '<div id="radio'.$i.'_password_div" class="setting" style="display: none;">';
		echo '<span class="label">Password</span>';
		echo '<span><input class="wifimanager" type="password" name="parameters['.$i.'][password]" size="20" maxlength="32" value="'.$password.'"></span>';
		echo '</div>';

		///////////// WPA/WPA2 Enterprise (AP)

		//// Server

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "ap")) echo '<div id="radio'.$i.'_server_div" class="setting">';
		else echo '<div id="radio'.$i.'_server_div" class="setting" style="display: none;">';
		echo '<span class="label">RADIUS Server</span>';
		echo '<span><input class="wifimanager" name="parameters['.$i.'][server]" size="20" maxlength="32" value="'.$server.'"></span>';
		echo '</div>';

		//// Port

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "ap")) echo '<div id="radio'.$i.'_port_div" class="setting">';
		else echo '<div id="radio'.$i.'_port_div" class="setting" style="display: none;">';
		echo '<span class="label">RADIUS Port</span>';
		echo '<span><input class="wifimanager" name="parameters['.$i.'][port]" size="20" maxlength="32" value="'.$port.'"></span>';
		echo '</div>';

		//// Secret

		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "ap")) echo '<div id="radio'.$i.'_shared_div" class="setting">';
		else echo '<div id="radio'.$i.'_shared_div" class="setting" style="display: none;">';
		echo '<span class="label">Shared RADIUS secret</span>';
		if(($encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-wpa") && ($mode == "ap")) echo '<span><input class="wifimanager" type="password" name="parameters['.$i.'][shared]" size="20" maxlength="32" value="'.$key.'"></span>';
		else echo '<span><input class="wifimanager" type="password" name="parameters['.$i.'][shared]" size="20" maxlength="32" value=""></span>';
		echo '</div>';

		///////////// WPA/WPA2 Personal + Enterprise (Client & AP)

		// Cipher

		if($encryption[0] == "psk" || $encryption[0] == "psk2" || $encryption[0] == "wpa" || $encryption[0] == "wpa2" || $encryption[0] == "mixed-psk" || $encryption[0] == "mixed-wpa") echo '<div id="radio'.$i.'_encryption_div" class="setting">';
		else echo '<div id="radio'.$i.'_encryption_div" class="setting" style="display: none;">';
		echo '<span class="label">Encryption</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][encryption]" id="radio'.$i.'_encryption">';
		if($cipher == "tkip+ccmp" || $cipher == "tkip+aes" || $cipher == "ccmp+tkip" || $cipher == "aes+tkip") echo '<option value="tkip">TKIP</option><option value="ccmp">CCMP</option><option selected value="tkip+ccmp">TKIP, CCMP</option>';
		else if($cipher == "ccmp" || $cipher == "aes") echo '<option value="tkip">TKIP</option><option selected value="ccmp">CCMP</option><option value="tkip+ccmp">TKIP, CCMP</option>';
		else if($cipher == "tkip") echo '<option selected value="tkip">TKIP</option><option value="ccmp">CCMP</option><option value="tkip+ccmp">TKIP, CCMP</option>';
		else echo '<option value="tkip">TKIP</option><option value="ccmp">CCMP</option><option value="tkip+ccmp">TKIP, CCMP</option>';
		echo '</select>';
		echo '</span>';
		echo '</div>';

		///////////// WPA/WPA2 Personal (Client & AP)

		//// WPA Shared Key

		if($encryption[0] == "psk" || $encryption[0] == "psk2" || $encryption[0] == "mixed-psk") echo '<div id="radio'.$i.'_shared_key_div" class="setting">';
		else echo '<div id="radio'.$i.'_shared_key_div" class="setting" style="display: none;">';
		echo '<span class="label">Shared Key</span>';
		if($encryption[0] == "psk" || $encryption[0] == "psk2" || $encryption[0] == "mixed-psk")
			echo '<span><input class="wifimanager" name="parameters['.$i.'][shared_key]" size="32" maxlength="80" value="'.$key.'"></span>';
		else
			echo '<span><input class="wifimanager" name="parameters['.$i.'][shared_key]" size="32" maxlength="80" value=""></span>';
		echo '</div>';

		///////////// WEP (Client & AP)

		//// Wep Key

		if($encryption[0] == "wep") echo '<div id="radio'.$i.'_key_div" class="setting">';
		else echo '<div id="radio'.$i.'_key_div" class="setting" style="display: none;">';
		echo '<span class="label">Key</span>';
		if($encryption[0] == "wep")
			echo '<span><input class="wifimanager" name="parameters['.$i.'][key]" size="32" maxlength="80" value="'.$key.'"></span>';
		else 
			echo '<span><input class="wifimanager" name="parameters['.$i.'][key]" size="32" maxlength="80" value=""></span>';
		echo '</div>';

		//// Wep Mode

		if($encryption[0] == "wep") echo '<div id="radio'.$i.'_wep_mode_div" class="setting">';
		else echo '<div id="radio'.$i.'_wep_mode_div" class="setting" style="display: none;">';
		echo '<span class="label">Wep Mode</span>';
		echo '<span>';
		echo '<select class="wifimanager" name="parameters['.$i.'][wep_mode]" id="radio'.$i.'_wep_mode">';
		foreach($wep_modes as $k => $v)
		{
			if($encryption[1] == $v) echo '<option selected value="'.$v.'">'.$k.'</option>';
			else echo '<option value="'.$v.'">'.$k.'</option>';
		}
		echo '</select>';
		echo '</span>';
		echo '</div>';

		echo '</fieldset>';

		////////////////////////////// End Tab Content
		echo '</div>';
	}
}

echo "</form>";

echo '</div>'; // End of interfaces Tabs

echo '</div>'; // End of Wireless Tab

////////////////////////////
// Backup Tab
////////////////////////////

echo '<div id="BCK">';
echo '[<a id="refresh" href="javascript:wifimanager_refresh_bck();">Refresh</a>] [<a id="backup" href="javascript:wifimanager_new_bck();">New Backup</a>]<br />';
echo '<div id="content_bck"></div>';
echo '</div>'; // End of Backup Tab



echo '</div>'; // End of Tabs

?>