<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

if (isset($_GET['refreshcontrols'])) {
	showStatusControls($_GET['refreshcontrols']);
}

if (isset($_GET['refreshLibrary'])) {
  showSavedPortals();
}

if (isset($_GET['fixconfig'])) {
  $pineapple->execute('pineapple infusion evilportal fixconfig');
  echo '<center><font color="lime"><br />The configuration has been fixed!<br />You should restart NoDogSplash if it is running.</font></center>';
}

if (isset($_GET['backup'])) {
  $fileName = $_POST['filename'];
}

if (isset($_GET['configfile'])) {
  $file = $_GET['configfile'];
  showConfigFile($file, $pineapple);
}

if (isset($_GET['request_active'])) {
  $file = $_GET['request_active'];
  $message = '<br /><center>';
  $message .= '<b>You are about to set <i>' . $file . ' as your active portal</b><br />';
  $message .= 'This will overwrite your current portal!<br /><br />';
  $message .= 'Are you sure you want to continue?<br /><br />';
  $message .= '<a href="#" onclick="$(\'#active_portal\').AJAXifyForm(notify); close_popup();">Yes</a>&nbsp&nbsp&nbsp<a href="#" onclick="close_popup();">No</a>';
  $message .= '<form method="POST" id="active_portal" action="/components/infusions/evilportal/includes/requests.php?set_active=' . $file .'"></form></center>';
  echo $message;
}
    
if (isset($_GET['set_active'])) {
  $file = $_GET['set_active'];
  $pineapple->execute('cp ' . $file . ' /etc/nodogsplash/htdocs/splash.html');
  echo $file . ' is now your active portal!';
}
    
if (isset($_GET['request_delete'])) {
  $file = $_GET['request_delete'];
  $message = '<br/><center>';
  $message .= '<b>You are about to delete <i>' . $file . '</i></b><br/>';
  $message .= 'Are you sure you want to delete this portal?<br /><br />';
  $message .= '<a href="#" onclick="$(\'#delete_portal\').AJAXifyForm( evilportalRefreshLibrary); close_popup();">Yes</a>&nbsp&nbsp&nbsp<a href="#" onclick="close_popup();">No</a>';
  $message .= '<form method="POST" id="delete_portal" action="/components/infusions/evilportal/includes/requests.php?delete=' . $file .'"></form></center>';
  echo $message;
}

if (isset($_GET['delete'])) {
  $file = $_GET['delete'];
  if (unlink($file))
    showSavedPortals();
  else {
    $pineapple->sendNotification('Evil Portal: There was an issue deleting this file');
    showSavedPortals();
  }
}

if (isset($_GET['save'])) {

  $file = $_POST['file'];
  $backupName = str_replace("/", "", $_POST['backup_name']);
  $backupPath = $_POST['storage'];

  if ($file != "/etc/nodogsplash/htdocs/splash.html" && $backupName == "" && !strstr($file, "/sd/portals") && !strstr($file, "/root/portals"))
    $headText = "#configured\n";
  else
    $headText = "";

  $f = fopen($file, 'w');
  fwrite($f, $headText . $_POST['data']);
  fclose($f);

  $message = 'Saved file: ' . $_POST['file'] . ' ' . $javascript;

  if ($backupName != "") {

    if (!stringEndsWith($backup, ".html"))
      $backupName = $backupName . ".html";

    if ($backupPath == "/sd/portals/" && !$pineapple->sdAvailable()) 
      $message = "You can't save to an SD card if it is not there!";
    else {
      if (!file_exists($backupPath))
        mkdir($backupPath, 0777, true);

      $backup = fopen($backupPath . $backupName, 'w');
      fwrite($backup, $_POST['data']);
      fclose($backup);
      $message = 'Your portal has been saved to a backup!';
    }
  }

  echo $message;
}

if (isset($_GET['live_preview'])) {
  $url = $_GET['live_preview'];
  showLivePreview($url);
}

if (isset($_GET['dev_preview'])) {
  $file = $_GET['dev_preview'];
  showDevPreview($file);
}

if (isset($_GET['check_depends'])) {
  echo checkDepends();
}

if (isset($_GET['install_depends'])) {
  exec('pineapple infusion evilportal deps');

  $fromTile = $_GET['install_depends'];

  echo 'Evil Portal has finished installing dependencies!';
}

if (isset($_GET['configure'])) {
  $pineapple->execute('pineapple infusion evilportal config');
  echo 'Evil Portal has been configured! ';
}

if (isset($_GET['start'])) {
  if (checkDepends() && checkConfig()) {
    $pineapple->execute('echo "/etc/init.d/nodogsplash start" | at now && sleep 1s');
    
    $fromTile = $_GET['start'];
    
    echo 'Nodogsplash has been started!';

  } else
    echo 'You have actions that must be preformed first!';
}

if (isset($_GET['stop'])) {
  exec('killall nodogsplash && sleep 2s');

  $fromTile = $_GET['stop'];

  echo 'Nodogsplash has been stoped!';
}

if (isset($_GET['enable'])) {
  if (checkDepends() && checkConfig()) {
    $pineapple->execute('echo "/etc/init.d/nodogsplash enable" | at now && sleep 1s');

    $fromTile = $_GET['enable'];

    echo 'Nodogsplash will now run on startup!';

  } else
    echo 'You have actions that must be preformed first!';
}

if (isset($_GET['disable'])) {
  $pineapple->execute('echo "/etc/init.d/nodogsplash disable" | at now && sleep 1s');

  $fromTile = $_GET['disable'];

  echo 'Nodogsplash will no longer run on startup!';

}

?>