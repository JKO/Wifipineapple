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

<div style='text-align:right'><a href="#" class="refresh" onclick='refresh_small("datalocker", "user")'></a></div>
<script type="text/javascript">
function postToBar(id) {
  $(id).AJAXifyForm(notify);
  return false;
}
</script>

<form method="POST" id="deps" action="/components/infusions/datalocker/functions.php?deps">

<?php

if (checkDepends()) {
  echo "<b><i>Enter Large Tile To Encrypt All The Things</i></b><br /><br />";
  echo "<a href='https://forums.hak5.org/index.php?/topic/32118-support-data-locker/#entry240215' target='blank'><b>Infusion Support</b></a>";
} else {
  echo "<center><b><font color='red'>You have missing dependencies!</b></font>";
  echo '<button type="button" onclick="postToBar(\'#deps\');">Install</button></center>';
}

?>
