<?php
 
namespace pineapple;
$pineapple = new Pineapple(__FILE__);

// Include the pineapple API
include $pineapple->directory . "/functions.php";

// Check if the firmware is 2.0.4 or greater
if (!$pineapple->requireVersion("2.0.4")) {
  $pineapple->sendNotification("Please update your pineapple!");
  die("Firmware version 2.0.4 is required by this infusion! Please update!");
}

?>

<script type='text/javascript' src='/components/infusions/datalocker/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/datalocker/includes/css/infusion.css');</style>

<?php

//include "functions.php";

if (checkDepends()) {
  $pineapple->drawTabs(array("Data Locker", "Change Log"));
} else {
  echo '<font color="red"><center><br/>You have missing dependencies. Please use the small tile to install them.</center></font>';
}

?>
