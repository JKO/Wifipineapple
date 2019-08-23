<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

// Include the pineapple API
include $pineapple->directory . "/functions.php";

// Check if the firmware is 2.0.3 or greater
if (!$pineapple->requireVersion("2.0.4")) {
  $pineapple->sendNotification("Please update your pineapple!");
  die("Firmware version 2.0.4 is required by this infusion! Please update!");
}

// Create the tabs to display
$pineapple->drawTabs(array("Library", "Page Builder", "Change Log"));

?>

<script type="text/javascript" src="<?=$pineapple->rel_dir ?>/includes/bobthebuilder.js"></script>