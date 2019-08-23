<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

/**
 * checkDepends()
 * Check for the required dependencies
 */
function checkDepends() {
	if (exec("opkg list-installed | grep nbtscan") == '')
		return false; // Dependencies have not been installed
	else
		return true; // Dependencies have been installed
}

/**
 * installNbtScan()
 * Install nbtscan to $storage (sd or internal)
 */
function installNbtScan($storage) {
	global $pineapple;

	$toReturn = "Nbt Scan was installed sucessfully!";

	if (!$pineapple->online())
		return "An internet connection is required!";

	switch($storage) {
		case "sd":
			if ($pineapple->sdAvailable()) {
				exec("opkg update && opkg install -d sd nbtscan && ln -s /sd/usr/sbin/nbtscan /usr/sbin/nbtscan");
			} else
				$toReturn = "You don't have an SD card in your pineapple.";
			break;

		case "internal":
			exec("opkg update && opkg install nbtscan");
			break;
	}

	return $toReturn;
}

/**
 * preformNbtScan()
 * Nbt Scan the work
 */
function preformNbtScan($networkAddr, $cidrMask) {
	global $pineapple;

	// Create the command to run
	$command = "nbtscan " . $networkAddr . "/" . $cidrMask . " | tee " . $pineapple->directory . "/includes/scans/nbtscan-" . time();

	// Run the command and store the results
	$scanResults = shell_exec($command);

	// Put the results into some html
	$htmlToReturn = '<center><textarea id="resultArea" style="width:100%; height:250px" Placeholder="Scan results will be shown here" disabled>' . $scanResults . '</textarea></center>';

	// Return the html code
	return $htmlToReturn;
}

/**
 * showScanHistory
 * Display all of the previous nbt scans preformed
 */
function showNbtScanHistory($tile="large") {
	global $pineapple;

	// Get a list of files in the scans dir
	$files = scandir($pineapple->directory . "/includes/scans");
	
	// There are files in the dir other than "." and ".."
	if (sizeof($files) > 2) {

		// Put the table on the page
		echo '<table id="historyTable" cellspacing="20px" style="margin-left:auto; margin-right:auto;">';

		// Loop through the files and put them in the table
		foreach ($files as $file) {
			if ($file != "." && $file != "..") {
				echo "<tr>";
				echo "<td><b>" . $file . "</b></td>";
				echo "<td><a href='#' onclick='viewSingleNbtScanResult(\"" . $file . "\")'>View Results</a></td>";
				echo "<td><a href='" . $pineapple->rel_dir . "/includes/scans/" . $file . "' target='blank'>Download Results</a></td>";
				echo "<td><a href='#' onclick='deleteSingleNbtScanResult(\"" . $tile . "\", \"" . $file . "\")'>Delete Results</a></td>";
				echo "</tr>";
			}
		}

		// End the table tag
		echo '</table>';

	} else {
		// There are no files to display
		echo "<b><i>You have no scan history</i></b>";
	}
}

/**
 * showNbtScanResult()
 * Show the results of a single scan
 */
function showNbtScanResult($fileName) {
	global $pineapple;

	$file = $pineapple->directory . "/includes/scans/" . $fileName;

	if (file_exists($file)) {
		$f = fopen($file, "r");
		$data = fread($f, filesize($file));
		fclose($f);
		$htmlToReturn = '<center><textarea id="resultArea" style="width:100%; height:250px" Placeholder="Scan results will be shown here" disabled>' . $data . '</textarea></center>';
	} else {
		$htmlToReturn = '<b>Could not find results for the requested scan</b>';
	}

	return $htmlToReturn;

}

/**
 * deleteNbtScanResult
 * Delete a nbtscan result
 */
function deleteNbtScanResult($fileName) {
	global $pineapple;

	$file = $pineapple->directory . "/includes/scans/" . $fileName;

	if (file_exists($file)) {
		unlink($file);
	}
}

?>
