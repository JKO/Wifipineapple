<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>

<div id="rtltcp_message"></div>

<fieldset>
  <legend>Description</legend>
  <p>Stream radio from your rtl-sdr via the wifi pineapple.</p>
</fieldset>

<fieldset>
  <legend>Startup Parameters</legend>
  <form method="POST" action="/components/infusions/rtlradiostreamer/functions.php?action=startrtltcp" id="startrtltcp" onSubmit="$(this).AJAXifyForm(notify); return false;">
  <input type="text" name="ListenAddress" value="0.0.0.0" /> Listen Address <br />
  <input type="text" name="ListenPort" value="1234" /> Listen Port <br />
  <input type="text" name="Frequency" value="1090000000" /> Frequency (Hz) <br />
  <input type="text" name="Gain" value="0" /> Gain (0 is auto) <br />
  <input type="text" name="SampleRate" value="48000" /> Sample Rate (Hz) <br />
  <input type="text" name="Device" value="0" /> Device <br />
  <input type="submit" name="Submit" value="Start rtl_tcp">
  </form>
</fieldset>

<br/><br/>
<form method="POST" action="/components/infusions/rtlradiostreamer/functions.php?action=stoprtltcp" id="stoprtltcp" onSubmit="$(this).AJAXifyForm(notify); return false;">
  <input type='submit' name='submit' value='Stop rtl_tcp'>
</form>

