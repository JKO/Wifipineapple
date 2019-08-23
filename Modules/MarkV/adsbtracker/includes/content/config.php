<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>

<div id="adsbtracker_message"></div>

<fieldset>
  <legend>Startup Parameters</legend>
  <form method="POST" action="/components/infusions/adsbtracker/functions.php?action=startdump1090" id="startdump1090" onSubmit="$(this).AJAXifyForm(notify); return false;">
    <input type="checkbox" name="metric"> Use metric units.<br/>
    <input type="checkbox" name="enable-agc"> Enable the Automatic Gain Control.</br>
    <input type="checkbox" name="aggressive"> Aggressive: More CPU for more messages (two bits fixes, ...).<br/>
    <input type="text" name="gain" value=""> Gain: (default: max gain. Use -100 for auto-gain).<br/>
    <input type="text" name="freq" value="1090Mhz"> Frequency: Set frequency (default: 1090 Mhz).<br/><br/>
    <input type='submit' name='submit' value='Start dump1090'>
  </form>
</fieldset>

<br/><br/>
<form method="POST" action="/components/infusions/adsbtracker/functions.php?action=stopdump1090" id="stopdump1090" onSubmit="$(this).AJAXifyForm(notify); return false;">
  <input type='submit' name='submit' value='Stop dump1090'>
</form>


