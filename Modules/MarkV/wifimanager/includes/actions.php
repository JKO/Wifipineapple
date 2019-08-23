<?php

require("/pineapple/components/infusions/wifimanager/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_POST['detect']))
{	
	if(shell_exec("wifi detect") != "")
	{
		exec("wifi detect >> /etc/config/wireless");
		exec("uci delete wireless.@wifi-iface[-1].network");
		
		echo '<font color="lime"><strong>done</strong></font>';
	}
	else
	{
		echo '<font color="orange"><strong>nothing detected</strong></font>';
	}
}

if (isset($_POST['interface']) && isset($_POST['action']) && isset($_POST['int']))
{
	if ($_POST['action'] == 'start') 
		exec("ifconfig ".$_POST['int']." up &");
	else
		exec("ifconfig ".$_POST['int']." down &");
}

if (isset($_POST['monitor']) && isset($_POST['action']) && isset($_POST['int']) && isset($_POST['mon']))
{
	if ($_POST['action'] == 'start') 
		exec("airmon-ng start ".$_POST['int']." &");
	else
		exec("airmon-ng stop ".$_POST['mon']." &");
}

if (isset($_POST['connect']) && isset($_POST['int']))
{
	$interface = $_POST['int'];
	exec("udhcpc -R -n -i ".$interface."");
	
	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_POST['release']) && isset($_POST['int']))
{
	$interface = $_POST['int'];
	exec("kill `ps -ax | grep udhcp | grep ".$interface." | awk {'print $1'}`");
	
	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_POST['remove']) && isset($_POST['phy']))
{
	$phy = $_POST['phy'];
	exec("uci delete wireless.radio".$phy);
	exec("uci delete wireless.@wifi-iface[".$phy."]");
	
	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_POST['commit']))
{
	exec("uci commit wireless");
	exec("wifi");

	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_POST['revert']))
{
	exec("uci revert wireless");
	exec("wifi");

	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_POST['conf']))
{
	if($_POST['conf'] == "wireless")
	{	
		if ( isset( $_POST['parameters'] ) )
		{
			for($i=0;$i<count($wifi_interfaces);$i++)
			{		
				// Section - Wifi Network
				exec("uci set wireless.@wifi-iface[".$i."].ssid=\"".$_POST['parameters'][$i]['ssid']."\"");
				exec("uci set wireless.@wifi-iface[".$i."].mode=".$_POST['parameters'][$i]['mode']);
				exec("uci set wireless.@wifi-iface[".$i."].network=".$_POST['parameters'][$i]['network']);
				exec("uci set wireless.@wifi-iface[".$i."].hidden=".$_POST['parameters'][$i]['broadcast']);
				
				exec("uci set wireless.@wifi-iface[".$i."].disabled=".(isset($_POST['parameters'][$i]['disabled']) ? 0 : 1));
				//if(!isset($_POST['parameters'][$i]['disabled']))
				//	exec("ifconfig ".$wifi_interfaces[$i]." down");
				//else
				//	exec("ifconfig ".$wifi_interfaces[$i]." up");
				
				// Section - Wifi Device
				$radio = exec("uci get wireless.@wifi-iface[".$i."].device");
				exec("uci set wireless.".$radio.".channel=".$_POST['parameters'][$i]['channel']);
				
				if($_POST['parameters'][$i]['security_mode'] == "psk" || $_POST['parameters'][$i]['security_mode'] == "psk2" || $_POST['parameters'][$i]['security_mode'] == "mixed-psk")
				{
					exec("uci set wireless.@wifi-iface[".$i."].key=".$_POST['parameters'][$i]['shared_key']);
					
					$encryption = $_POST['parameters'][$i]['security_mode']."+".$_POST['parameters'][$i]['encryption'];
					exec("uci set wireless.@wifi-iface[".$i."].encryption=".$encryption);
					
					// Delete unecessary value
					exec("uci delete wireless.@wifi-iface[".$i."].server");
					exec("uci delete wireless.@wifi-iface[".$i."].port");
					exec("uci delete wireless.@wifi-iface[".$i."].eap_type");
					exec("uci delete wireless.@wifi-iface[".$i."].identity");
					exec("uci delete wireless.@wifi-iface[".$i."].password");
				}
				else if($_POST['parameters'][$i]['security_mode'] == "wpa" || $_POST['parameters'][$i]['security_mode'] == "wpa2" || $_POST['parameters'][$i]['security_mode'] == "mixed-wpa")
				{					
					$encryption = $_POST['parameters'][$i]['security_mode']."+".$_POST['parameters'][$i]['encryption'];
					exec("uci set wireless.@wifi-iface[".$i."].encryption=".$encryption);
					
					if($_POST['parameters'][$i]['mode'] == "ap")
					{
						exec("uci set wireless.@wifi-iface[".$i."].server=".$_POST['parameters'][$i]['server']);
						exec("uci set wireless.@wifi-iface[".$i."].port=".$_POST['parameters'][$i]['port']);
						exec("uci set wireless.@wifi-iface[".$i."].key=".$_POST['parameters'][$i]['shared']);
						
						// Delete unecessary value
						exec("uci delete wireless.@wifi-iface[".$i."].eap_type");
						exec("uci delete wireless.@wifi-iface[".$i."].identity");
						exec("uci delete wireless.@wifi-iface[".$i."].password");
					}
					else if($_POST['parameters'][$i]['mode'] == "sta")
					{
						exec("uci set wireless.@wifi-iface[".$i."].eap_type=".$_POST['parameters'][$i]['eap_type']);
						exec("uci set wireless.@wifi-iface[".$i."].identity=".$_POST['parameters'][$i]['identity']);
						exec("uci set wireless.@wifi-iface[".$i."].password=".$_POST['parameters'][$i]['password']);
						
						// Delete unecessary value
						exec("uci delete wireless.@wifi-iface[".$i."].server");
						exec("uci delete wireless.@wifi-iface[".$i."].port");
						exec("uci delete wireless.@wifi-iface[".$i."].key");
					}
				}
				else if($_POST['parameters'][$i]['security_mode'] == "wep")
				{
					exec("uci set wireless.@wifi-iface[".$i."].key=".$_POST['parameters'][$i]['key']);
					
					$encryption = $_POST['parameters'][$i]['security_mode']."+".$_POST['parameters'][$i]['wep_mode'];
					
					exec("uci set wireless.@wifi-iface[".$i."].encryption=".$encryption);
				}
				else if($_POST['parameters'][$i]['security_mode'] == "none")
				{
					// Delete unecessary value
					exec("uci delete wireless.@wifi-iface[".$i."].encryption");
					exec("uci delete wireless.@wifi-iface[".$i."].key");
					exec("uci delete wireless.@wifi-iface[".$i."].server");
					exec("uci delete wireless.@wifi-iface[".$i."].port");
					exec("uci delete wireless.@wifi-iface[".$i."].eap_type");
					exec("uci delete wireless.@wifi-iface[".$i."].identity");
					exec("uci delete wireless.@wifi-iface[".$i."].password");
				}
			}
			echo '<font color="lime"><strong>saved</strong></font>';
		}
	}
}

?>