<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center>
<h3>CONTROL YOUR LEDS</h3>

<?php
global $directory, $rel_dir;
?>

<script type="text/javascript">
function lights(led) {
  $(led).AJAXifyForm(notify);
  return false;
}

</script>

<?php

echo '
  <form method="POST" id="on" action="/components/infusions/blackout/functions.php?on">
    <button type="button" onclick="lights(\'#on\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">ALL ON</button>
  </form>
  <form method="POST" id="off" action="/components/infusions/blackout/functions.php?off">
    <button type="button" onclick="lights(\'#off\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">ALL OFF</button>
  </form>
  <form method="POST" id="reset" action="/components/infusions/blackout/functions.php?reset">
    <button type="button" onclick="lights(\'#reset\')" style="background-color:black; color:lime; border: 1px; border-style:dotted; border-color:#FFFFFF; width:110px;">RESET</button>
  </form>
';

?>
</center>
