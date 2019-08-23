<?php
namespace pineapple;
$pineapple = new Pineapple(__FILE__);

// Include the pineapple API
include $pineapple->directory . "/functions.php";

// Check if the firmware is 2.0.3 or greater
if (!$pineapple->requireVersion("2.1.0")) {
  $pineapple->sendNotification("Please update your pineapple!");
  die("Firmware version 2.1.0 is required by this infusion! Please update!");
}

// Check if the pineapple has an internet connection before installing depends
if (!$pineapple->online() && !checkDepends()) {
  $pineapple->sendNotification("Evil Portal needs an internet connection!");
  die("You need an internet connection to install dependencies!");
}

?>

<script type="text/javascript" src="<?=$pineapple->rel_dir ?>/includes/javascript/evilportal.js"></script>

<br />

<?php 

if (!checkDepends()) {
?>

    <center>
      <font color="red">You need to install dependencies before you can use Evil Portal</font><br />
      <form method="POST" id="install_depends_evilportal" action="<?=$rel_dir ?>/includes/requests.php?install_depends"></form>
      <a href="#" onclick="evilportalInstallDepends('#install_depends_evilportal', 'large')">Install Dependencies</a>
    </center>

<?php

} elseif (!checkConfig() && checkDepends()) {

  include $pineapple->directory . "/tabs/configuration.php";

} elseif (checkConfig() && checkDepends()) {

?>

    <form method="POST" id="start_evilportal" action="<?=$pineapple->rel_dir ?>/includes/requests.php?start=large"></form>
    <form method="POST" id="stop_evilportal" action="<?=$pineapple->rel_dir ?>/includes/requests.php?stop=large"></form>
    <form method="POST" id="enable_evilportal" action="<?=$pineapple->rel_dir ?>/includes/requests.php?enable=large"></form>
    <form method="POST" id="disable_evilportal" action="<?=$pineapple->rel_dir ?>/includes/requests.php?disable=large"></form>
    <form method="POST" id="refresh_ep_controls" action="<?=$pineapple->rel_dir ?>/includes/requests.php?refreshcontrols=large"></form>

    <div id="evilportalStatus" style="margin-left:10px;">

<?php

  showStatusControls("large");

?>
    </div>

    <center>
      <div id="spinny" style="display:none; margin-left:auto; margin-right:auto;">
        <img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif">
      </div>
    </center>

<?php

  $pineapple->drawTabs(array("Library", "Edit Portals", "Live Preview", "Dev Preview", "Configuration", "Change Log"));

}

?>
