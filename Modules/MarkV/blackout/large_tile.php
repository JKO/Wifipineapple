<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
global $directory, $rel_dir;
?>

<script type="text/javascript">
function lights(led) {
  $(led).AJAXifyForm(notify);
  return false;
}

</script>

<center>
<?php
  echo '
  <br />
  <h3>CONTROL YOUR LEDS</h3>
  <br />
  <div id="all" style="color:white; border:1px; border-style:dotted; border-color:#FFFFFF; width:300px; text-align:center;">
    <b>All LEDs</b>
    <form method="POST" id="on" action="/components/infusions/blackout/functions.php?on">
      <button type="button" onclick="lights(\'#on\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">ALL ON</button>
    </form>
    <form method="POST" id="off" action="/components/infusions/blackout/functions.php?off">
      <button type="button" onclick="lights(\'#off\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">ALL OFF</button>
    </form>
    <form method="POST" id="reset" action="/components/infusions/blackout/functions.php?reset">
      <button type="button" onclick="lights(\'#reset\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">RESET</button>
    </form>
  </div>
  ';

  $lights = array('red','blue','amber');
  for ($i=0; $i<=sizeof($lights)-1; $i++) {
    echo '
    <br />
    <div id="'. $lights[$i] . '" style="color:white; border:1px; border-style:dotted; border-color:#FFFFFF; width:300px; text-align:center;">
      <b>' . strtoupper($lights[$i]) . ' LED</b>
      <form method="POST" id="' . $lights[$i] . 'On" action="/components/infusions/blackout/functions.php?single">
        <input type="hidden" name="led" value="' . $lights[$i] . '">
        <input type="hidden" name="state" value="on">
        <button type="button" onclick="lights(\'#' . $lights[$i] . 'On\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">' . strtoupper($lights[$i]) . ' ON</button>
      </form>
      <form method="POST" id="' . $lights[$i] . 'Off" action="/components/infusions/blackout/functions.php?single">
        <input type="hidden" name="led" value="' . $lights[$i] . '">
        <input type="hidden" name="state" value="off">
        <button type="button" onclick="lights(\'#' . $lights[$i] . 'Off\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">' .  strtoupper($lights[$i]) . ' OFF</button>
      </form>
    </div>
    ';
  }

?>

</center>
