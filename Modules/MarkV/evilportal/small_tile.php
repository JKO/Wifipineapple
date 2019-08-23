<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include $pineapple->directory . "/functions.php";

// Check if the firmware is 2.0.3 or greater
if (!$pineapple->requireVersion("2.1.0")) {
  $pineapple->sendNotification("Evil Portal: Please update your pineapple!");
  die("Firmware version 2.1.0 is required by this infusion! Please update!");
}

// Check if the pineapple has an internet connection before installing depends
if (!$pineapple->online() && !checkDepends()) {
  $pineapple->sendNotification("Evil Portal needs an internet connection!");
  die("You need an internet connection to install dependencies!");
}

?>

<div style='text-align:right'><a href="#" class="refresh" onclick='refresh_small("evilportal", "user")'></a></div>

<form method="POST" id="configure_evilportal" action="<?=$rel_dir; ?>/includes/requests.php?configure=small"></form>
<form method="POST" id="start_evilportal" action="<?=$rel_dir; ?>/includes/requests.php?start=small"></form>
<form method="POST" id="stop_evilportal" action="<?=$rel_dir; ?>/includes/requests.php?stop=small"></form>
<form method="POST" id="enable_evilportal" action="<?=$rel_dir; ?>/includes/requests.php?enable=small"></form>
<form method="POST" id="disable_evilportal" action="<?=$rel_dir; ?>/includes/requests.php?disable=small"></form>
<form method="POST" id="live_preview" action="<?=$rel_dir; ?>/includes/requests.php?live_preview"></form>
<form method="POST" id="dev_preview" action="<?=$rel_dir ?>/includes/requests.php?dev_preview"></form>
<form method="POST" id="install_depends_evilportal" action="<?=$rel_dir ?>/includes/requests.php?install_depends"></form>

<script type="text/javascript" src="<?=$pineapple->rel_dir ?>/includes/javascript/evilportal.js"></script>

<?php

if (!checkDepends()) { // Display stuff to install dependencies

?>

  Dependencies <font color="red"><b>Missing.</b></font>&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalInstallDepends('#install_depends_evilportal', 'small');">Install</a></b>
  <br /><br />
  <center>
    <font color="red">Dependencies must be installed.</font><script type="text/javascript">notify("Evil Portal has missing dependencies", "evilportal", "red");</script>
    <br />
  </center>

<?php

} elseif (!checkConfig() && checkDepends()) { // Display stuff to configure EP

?>

  Configuration <font color="red"><b>Needed.</b></font>&nbsp|<b><a href="#" onclick="evilportalConfigure('#configure_evilportal', 'small');">Configure</a></b>
  <br />
  <br />
  <center>
    <font color="yellow">Configuration is needed.</font><script type="text/javascript">notify("Evil Portal must be configured", "evilportal", "yellow");</script><br />
    <font color="yellow"><i>Open for manual config.</i></font>
  </center>

<?php

} elseif (checkConfig() && checkDepends()) { // Display evilportal controlls
  showStatusControls();


?>

  Live Portal Preview&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalAjaxPopup('#live_preview');">Show</a></b><br />
  Dev Portal Preview&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalAjaxPopup('#dev_preview');">Show</a></b><br />
  Forum Support Topic&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="https://forums.hak5.org/index.php?/topic/33554-support-evil-portal/" target="blank">Open</a></b><br />

<?php

}

?>

<!-- YAY SPINNY PINEAPPLES! -->
<br />
<div id="spinny" style="display:none; margin-left:auto; margin-right:auto;">
  <img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif">
</div>

