<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php include_once("{$directory}/functions.php"); ?>

<div style='text-align: right'><a href='#' class="refresh" onclick='refresh_network()'> </a></div>




<?php
$adsbtracker_running = exec("pidof dump1090");
if($adsbtracker_running == "") { 
  echo "dump1090 daemon <font color='red'>disabled</font>";
} else {
  echo "dump1090 daemon <font color='lime'>enabled</font>";
}
?>
<br/><br/>
<form method="POST" action="/components/infusions/adsbtracker/functions.php?action=startdump1090" id="startdump1090" onSubmit="$(this).AJAXifyForm(notify); return false;">
  <input type='submit' name='submit' value='Start dump1090'>
</form>

<form method="POST" action="/components/infusions/adsbtracker/functions.php?action=stopdump1090" id="stopdump1090" onSubmit="$(this).AJAXifyForm(notify); return false;">
  <input type='submit' name='submit' value='Stop dump1090'>
</form>

