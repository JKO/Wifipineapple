<?php
namespace pineapple;
$pineapple = new Pineapple(__FILE__);

global $directory;

$wifi_interfaces = array_reverse(explode("\n", trim(shell_exec("iwconfig 2> /dev/null | grep \"wlan*\" | grep -v \"mon*\" | awk '{print $1}' | sort -r"))));
$monitor_interfaces = array_reverse(explode("\n", trim(shell_exec("iwconfig 2> /dev/null | grep \"mon*\" | awk '{print $1}'"))));

$interfaces = explode("\n", trim(shell_exec("cat /proc/net/dev | tail -n +3 | cut -f1 -d: | sed 's/ //g'")));
$nbr_radio_devices = exec("uci -P /var/state -q show wireless | grep wifi-device | wc -l");

$wifimanager_conf = parse_ini_file($directory."includes/infusion.conf");
$first_backup_done = $wifimanager_conf['first_backup'];

if(!$first_backup_done) 
{
	exec("cp /etc/config/wireless ".$directory."includes/backup/wireless_".(time()).".bck");
	
	$filename = $directory."includes/infusion.conf";
	$newdata = "first_backup=1";
	file_put_contents($filename, str_replace("\r", "", $newdata));
}

$modes = array(
		"Access Point" => "ap",  
		"Client" => "sta",
		"Ad-Hoc" => "adhoc"
		 );

$security_modes = array(
				"Disabled" => "none",  
				"WEP" => "wep", 
				"WPA Personal" => "psk",  
				//"WPA Enterprise" => "wpa",  
				"WPA2 Personal" => "psk2",  
				//"WPA2 Enterprise" => "wpa2",
				"WPA/WPA2 Personal mixed mode" => "mixed-psk",
				//"WPA/WPA2 Enterprise mixed mode" => "mixed-wpa"
				 );

$wep_modes = array(
			"Shared key" => "shared",
			"Open System" => "open"
			);
			
$eap_types = array(
			"TLS" => "tls",
			"PEAP" => "ttls"
			);

$network_types = array(
			"LAN" => "lan",
			"WAN" => "wan"
			);

$ciphers = array(
		"TKIP" => "tkip",  
		"CCMP" => "ccmp",
		"TKIP, CCMP" => "tkip+ccmp"
		);

$ssid_broadcast = array(
				"Enable" => "0",
				"Disable" => "1"
				);
?>