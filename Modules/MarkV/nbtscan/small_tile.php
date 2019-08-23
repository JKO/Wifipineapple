<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include $pineapple->directory . "/functions.php";

// Check if the firmware is recent enough
if (!$pineapple->requireVersion("2.0.4")) {
	$pineapple->sendNotification("Please update your pineapple!");
	die("Firmware version 2.0.4 is required by this infusion! Please update!");
}

?>

<!-- This is the javascript for NBT Scan -->
<script type="text/javascript" src="<?=$pineapple->rel_dir ?>/includes/nbtscan.js"></script>

<div style='text-align:right'><a href="#" class="refresh" onclick='refresh_small("nbtscan", "user")'></a></div>

<?php

if (!checkDepends()) {
	// Dependencies have not been installed so show the shit to get them installed

	$sdOption = "";
	if ($pineapple->sdAvailable())
		$sdOption = '<br /><a href="#" onclick="installNBTScan(\'small\', \'sd\')"><b>Install to SD Storage</b></a>';

	echo '<h2>Dependencies</h2>';
	echo '<hr />';

	echo '<a href="#" onclick="installNBTScan(\'small\', \'internal\')"><b>Install to Internal Storage</b></a><br />';
	echo $sdOption;
	$pineapple->sendNotification("NBT Scan has missing dependencies!");

} else {

?>

<select id="nbtscanCommands">
  <option value="0">Show Scan History</option>
  <option value="1">Show Routing Table</option>
  <option value="2">Forum Support</option>
</select>

<button type="button" onclick="handleNbtscanCommand();">Go</button>

<br />
<br />

<form id="startScan" method="POST" action="/components/infusions/nbtscan/includes/requests.php?scan">
  <table>
    <tr>
	  <td><label for="networkAddress">Network Address: </label></td>
	  <td><input type="text" value="172.16.42.0" id="networkAddress" name="networkAddress"></td>
	</tr>
	<tr>
	  <td><label for="cidrMask">CIDR Mask: </label></td>
	  <td><input type="text" value="24" id="cidrMask" name="cidrMask"></td>
    </tr>
    <tr>
	  <td><button type="button" onclick="preformNbtScan('small');">Scan Now</button></td>
	</tr>
  </table>
</form>

<?php

}

?>

<br />
<div id="spinny" style="display:none; margin-left:auto; margin-right:auto;">
  <center>
    <img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif">
  </center>
</div>
<br/>
