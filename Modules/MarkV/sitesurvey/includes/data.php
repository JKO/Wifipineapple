<?php

require("/pineapple/components/infusions/sitesurvey/handler.php");
require("/pineapple/components/infusions/sitesurvey/functions.php");

global $directory;

require($directory."includes/vars.php");
require($directory."includes/iwlist_parser.php");

if (isset($_POST['int'])) $interface = $_POST['int'];
if (isset($_POST['mon'])) $monitorInterface = $_POST['mon'];

$clients = array();

if(!$is_airodump_running)
{
	// Remove old data
	shell_exec("rm -rf ".$dumpPath."-01*");
	shell_exec("killall airodump-ng 2> /dev/null");
}

if (isset($_POST['clients']) && $_POST['clients'] == 1)
{ 
	shell_exec("airodump-ng --write $dumpPath $monitorInterface &> /dev/null &");
	sleep(1);
	
	// Give time to discover clients
	for($i=0;$i<$timeAP;$i++) sleep(1);

	shell_exec("killall airodump-ng 2> /dev/null");
}

// List Clients
shell_exec("cat ".$dumpPath."-01.csv | tail -n +$(($(cat ".$dumpPath."-01.csv | grep -n \"Station MAC\" | cut -f1 -d:)+1)) | tr '\r' '\n' > ".$dumpPath."-01.tmp");
shell_exec("sed '/^$/d' < ".$dumpPath."-01.tmp > ".$dumpPath."-01.clients");

$file_handle = fopen($dumpPath."-01.clients", "r");
while (!feof($file_handle))
{
	$line = fgets($file_handle); $line = str_replace(" ", "", $line);
   	$clients[] = explode(",", $line);
}
fclose($file_handle);

// List APs
$iwlistparse = new iwlist_parser();
$p = $iwlistparse->parseScanDev($interface);

if(!empty($p))
{
	echo '<table id="sitesurvey-survey-grid" class="grid" cellspacing="0">';
	echo '<tr class="header">';
	echo '<td>SSID</td>';
	echo '<td>BSSID</td>';
	echo '<td>Signal level</td>';
	echo '<td colspan="2">Quality level</td>';
	echo '<td>Ch</td>';
	echo '<td>Encryption</td>';
	echo '<td>Cipher</td>';
	echo '<td>Auth</td>';
	echo '<td>Deauth</td>';
	echo '<td>Capture</td>';
	echo '<td>Custom</td>';
	echo '</tr>';
}
else
{
	echo "<em>No data...</em>";
}

$odd=0; $clientN=1;
for($i=1;$i<=count($p[$interface]);$i++)
{
	$quality = $p[$interface][$i]["Quality"];
	
	if($quality <= 25) $graph = "red";
	else if($quality <= 50) $graph = "yellow";
	else if($quality <= 100) $graph = "green";
	
	echo '<tr class="odd">';
	
	echo '<td>'.$p[$interface][$i]["ESSID"].'</td>';
	
	echo '<td><a title="OUI search" href="javascript:sitesurvey_getOUIFromMAC(\''.$p[$interface][$i]["Address"].'\')">'.$p[$interface][$i]["Address"].'</a></td>';
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
	
	echo '<td align="center">';
	echo '<input class="sitesurvey" type="text" id="sitesurvey_deauthtimes'.$i.'" size="3" value="5" onFocus="if(this.value == \'5\') {this.value = \'\';}" onBlur="if (this.value == \'\') {this.value = \'5\';}">';
	echo '&nbsp;<a href="javascript:sitesurvey_deauth(\''.$p[$interface][$i]["Address"].'\', \'\', $(\'#sitesurvey_deauthtimes'.$i.'\').val());">Run</a>';
	echo '</td>';
	
	echo '<td align="center">';
	if($is_capture_running)
	{
		if(exec("cat ".$directory."includes/captures/lock") == $p[$interface][$i]["Address"])
			echo '<a class="cap_link" href="javascript:sitesurvey_cancel_capture();">Stop</a>';
		else
			echo '<a class="cap_link" href="javascript:void(0);">-</a>';
	}
	else
	{
		echo '<a class="cap_link" href="javascript:sitesurvey_capture(\''.$p[$interface][$i]["Address"].'\', \''.$p[$interface][$i]["Channel"].'\');">Capture</a>';
	}
	echo '</td>';
	
	$tags = array("SSID" => $p[$interface][$i]["ESSID"], "BSSID" => $p[$interface][$i]["Address"], "CHANNEL" => $p[$interface][$i]["Channel"]);
	$custom_command = replace_tags($tags, $custom_commands[0]);
	
	echo '<td align="center">';
	if($is_custom_running)
	{
		echo '<a href="javascript:sitesurvey_cancel_custom_script();">Cancel</a>';
	}
	else
	{
		echo '<a href="javascript:sitesurvey_execute_custom_script(\''.base64_encode($custom_command).'\');">Execute</a>';
	}
	echo '</td>';

	echo '</tr>';
	
	for($j=0;$j<count($clients);$j++)
	{
		echo '<tr class="even">';
		
		if($clients[$j][5] == $p[$interface][$i]["Address"])
		{
			echo '<td class="clients" align="center">Client '.$clientN.'</td>';
			
			echo '<td class="clients"><a title="OUI search" href="javascript:sitesurvey_getOUIFromMAC(\''.$clients[$j][0].'\')">'.$clients[$j][0].'</a></td>';
			
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';

			echo '<td align="center">';
			echo '<input class="sitesurvey" type="text" class="even" id="sitesurvey_deauthtimes'.$i.'-'.$j.'" size="3" value="5" onFocus="if(this.value == \'5\') {this.value = \'\';}" onBlur="if (this.value == \'\') {this.value = \'5\';}">';
			echo '&nbsp;<a href="javascript:sitesurvey_deauth(\''.$p[$interface][$i]["Address"].'\', \''.$clients[$j][0].'\', $(\'#sitesurvey_deauthtimes'.$i.'-'.$j.'\').val());">Run</a>';
			echo '</td>';
			echo '<td>&nbsp;</td>';
			
			$clientN +=1;
		}
		
		echo '</tr>';
	}	
	
	$odd += 1;
}

?>

</table>