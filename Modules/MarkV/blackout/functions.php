<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php

$lights = array('red','blue','amber');

if (isset($_GET['off'])) {
  for ($i=0; $i<=sizeof($lights)-1; $i++) {
    exec("pineapple led " . $lights[$i] . " off");
  }
  echo "All LEDs are now off.";
}

if (isset($_GET['on'])) {
  for ($i=0; $i<=sizeof($lights)-1; $i++) {
    exec("pineapple led " . $lights[$i] . " on");
  }
  echo "All LEDs are now on.";
}

if (isset($_GET['single'])) {
  $led = $_POST['led'];
  $state = $_POST['state'];
  exec("pineapple led " . $led . " " . $state);
  echo ucfirst($led) . ' LED is now ' . $state . '.';
}

if (isset($_GET['reset'])) {
  exec("pineapple led reset");
  echo "Reset functionallity of all LEDs";
}

?>
