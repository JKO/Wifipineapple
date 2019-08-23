<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

// Dependencies were requested to be installed
if (isset($_GET['install'])) {
	echo installNbtScan($_GET['install']);
}

// A scan was requested
if (isset($_GET['scan'])) {
	$netAddr = $_POST['networkAddress']; // Get the network address from POST
	$cidrMask = $_POST['cidrMask']; // Get the cidr mask from POST

	// Block evil cmd injections with regex! #pinepwn #loves #cmdinject
	if (preg_match("/^\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b$/", $netAddr) && is_numeric($cidrMask)) {
		// Everything looks good preform the scan
		echo preformNbtScan($netAddr, $cidrMask);
	} else {
		// Something wasn't right tell the user
		if (strpos($netAddr, ";") || strpos($netAddr, "&") || strpos($netAddr, "|")) {
			$data = "i R s0 l33t!";
		} else {
			$data = "You may have a malformed network address or Cidr Mask.";
		}

		$htmlToEcho = '<center><textarea id="resultArea" style="width:100%; height:250px" Placeholder="Scan results will be shown here" disabled>' . $data . '</textarea></center>';
		echo $htmlToEcho;
	}
}

// Scan history was requested
if (isset($_GET['history'])) {
	showNbtScanHistory($_GET['history']);
}

// The results of a single scan were requested
if (isset($_GET['result'])) {
	echo showNbtScanResult($_GET['result']);
}

// A request to delete a scan was made
if (isset($_GET['delete'])) {
	deleteNbtScanResult($_GET['delete']);
	showNbtScanHistory($_GET['tile']);
}

// A request to view the routing table was made
if (isset($_GET['routing'])) {
	$data = shell_exec("route");
	
	$htmlToEcho = '<center><textarea id="resultArea" style="width:100%; height:250px" Placeholder="Scan results will be shown here" disabled>' . $data . '</textarea></center>';

	echo $htmlToEcho;

}

?>
