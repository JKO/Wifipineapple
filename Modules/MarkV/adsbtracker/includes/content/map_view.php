<?php 
$adsbtracker_running = exec("pidof dump1090");
if($adsbtracker_running == "") {
  echo "The dump1090 daemon is not running. Please start the service from the Configuration tab.";
} else {
  $hosturl=explode(":",$_SERVER['HTTP_HOST'])[0]; 
  echo "<iframe width='100%' height='100%' src='http://" . $hosturl . ":9090/'></iframe>";
}
?>

