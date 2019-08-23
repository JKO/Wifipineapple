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

<?php

if (!checkDepends()) {
	// Dependencies have not been installed so show the shit to get them installed
?>

	<h2>Dependencies</h2>
	<hr/>

<?php

	$sdOption = "";
	if ($pineapple->sdAvailable())
		$sdOption = '<br /><a href="#" onclick="installNBTScan(\'large\', \'sd\')"><b>Install to SD Storage</b></a>';

	if ($pineapple->online()) {
		echo '<p>Nbt Scan is required to be installed by this infusion. Please select an option below.</p>';
		echo '<a href="#" onclick="installNBTScan(\'large\', \'internal\')"><b>Install to Internal Storage</b></a><br />';
		echo $sdOption;
	}
	else
	{
		echo '<b><font color="red">An internet connection is required.</b>';
	}

}
else
{
	// Create the tabs
	$pineapple->drawTabs(array("Scan", "History", "Change Log"));	
}

?>
