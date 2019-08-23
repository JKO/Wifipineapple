<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

$rel_dir = $pineapple->rel_dir;
$directory = $pineapple->directory;

function stringEndsWith($whole, $end) {
    return (strpos($whole, $end, strlen($whole) - strlen($end)) !== false);
}

function checkRunning() {
  if (exec("ps -aux | grep -v grep | grep -o nodogsplash") == '')
    return false;
  else
    return true;
}

function checkAutoStart() {
  if (exec("ls /etc/rc.d/ | grep nodogsplash") == '')
    return false;
  else
    return true;
}

function checkDepends() {
  $splash = true;
  
  if (exec("opkg list-installed | grep nodogsplash") == '')
    $splash = false;

  return $splash;
}

function checkConfig() {
  $nodogsplashFile = "/etc/nodogsplash/nodogsplash.conf";
  $nodogsplash = false;

  if (file_exists($nodogsplashFile)) {
    $f = fopen($nodogsplashFile, "r");
    $line = fgets($f);
    if (strstr($line, "#configured"))
      $nodogsplash = true;
    fclose($f);
  }

  return $nodogsplash;

}

function showStatusControls($tile="small") {
  if (checkRunning())
    echo 'NoDogSplash <font color="lime"><b>Running.</b></font>&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalSubmitControl(\'#stop_evilportal\', \'' . $tile . '\');">Stop</a></b><br />';
  else
    echo 'NoDogSplash <font color="red"><b>Disabled.</b></font>&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalSubmitControl(\'#start_evilportal\', \'' . $tile . '\');">Start</a></b><br />';

  if (checkAutoStart())
    echo 'Autostart <font color="lime"><b>Enabled.</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalSubmitControl(\'#disable_evilportal\', \'' . $tile . '\');">Disable</a></b><br />';
  else
    echo 'Autostart <font color="red"><b>Disabled.</b></font>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp<b><a href="#" onclick="evilportalSubmitControl(\'#enable_evilportal\', \'' . $tile . '\');">Enable</a></b><br />';
}

function showDevPreview($file) {
  if ($file == "")
    $file = "/etc/nodogsplash/htdocs/splash.html";
  
  if (file_exists($file)) {
    $f=fopen($file, "r");
    $data=fread($f, filesize($file));
    fclose($f);
    echo '<br />' . $data;
  } else {
    echo '<center><b><font color="red">Please make sure you have installed all the dependencies!</b></font></center>';
  }
}

function showLivePreview($url) {
  if ($url == "")
    $url = "http://172.16.42.1:2050";

  if (exec('ps -aux | grep "nodogsplash" | grep -v "grep"') != "")
    echo '<br /><iframe src="' .  $url . '" height="80%" width="100%"/>';
  else
    echo '<center><b><font color="red">Please start NoDogSplash first!</b></font></center>';
}

function showConfigFile($file, $pineapple) {

  if (file_exists($file)) {
    $f=fopen($file, "r");
    $data=fread($f, filesize($file));
    fclose($f);

    if ($pineapple->sdAvailable())
      $options = array('<option value="/sd/portals/">SD Card</option>', '<option value="/root/portals/">Internal Storage</option>');
    else
      $options = array('<option value="/root/portals/">Internal Storage</option>');

    $storagebox = '<select id="storage" name="storage">';
    foreach($options as $option) { 
      $storagebox .= $option; 
    }
    $storagebox .= '</select>';

    if ($file != "/etc/nodogsplash/htdocs/splash.html") {
      $buttons = '<button type="button" onclick="save(\'exit\', false); close_popup();">Save & Close</button><button type="button" onclick="save(\'continue\', false)">Save & Continue</button>';
    } else {
      $buttons = '<button type="button" onclick="save(\'continue\', false)">Save Portal</button>';
      $backup = '<div id="backupTable" style="float:left; text-align:left">' . $storagebox . '<input type="text" id="backname" placeholder="Backup Portal Name"> <button type="button" onclick="save(\'continue\', true)">Backup Portal</button></div>';
    }
    
?>
    <script type="text/javascript">
    function save(post_save_action, backup) {
      if (post_save_action == "exit") {
        document.getElementById("post_save_action").value = "exit";
      } else {
        document.getElementById("post_save_action").value = "continue";
      }

      if (backup) {
        document.getElementById("backup_name").value = document.getElementById("backname").value;
        document.getElementById("preform_backup").value = "true";
      }

      $('#save').AJAXifyForm(notify);
      return false;
    }
    </script>

    <center>
      <b>Editing <?=$file ?></b><br /><br />
     
      <form id="save" method="POST" action="/components/infusions/evilportal/includes/requests.php?save">
        <?=$buttons ?>
        <br />
        <?=$backup ?>
        <textarea name="data" style="width:100%; height:500px;"><?=$data ?></textarea>
        <input type="hidden" id="file_name" name="file" value="<?=$file ?>">
        <input type="hidden" id="backup_name" name="backup_name" value="">
        <input type="hidden" id="preform_backup" name="preform_backup" value="false">
        <input type="hidden" name="save_action" id="post_save_action" value="exit">
        <?=$buttons ?>
      </form>
    </center>
<?php
  } else
    echo 'Error finding file: ' . $file . ' . Make sure all dependencies are installed.';
}

function showSavedPortals() {
  if (!file_exists("/sd/portals"))
    mkdir("/sd/portals");
  
  if (!file_exists("/root/portals"))
    mkdir("/root/portals");

  $sd_portals = scandir('/sd/portals');
  $internal_portals = scandir('/root/portals');
          
  echo '<table style="width:75%; text-align:center; margin-left:auto; margin-right:auto;" cellpadding="0" cellspacing="0">';

  foreach ($sd_portals as $file) {
    if ($file != "." && $file != "..")
      echo '<tr><td>' . $file . '</td><td><a href="#" onclick="evilportalAjaxPopup(\'#view_sd_' . str_replace(".html", "", $file) . '\');">Dev Preview</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#code_sd_' . str_replace(".html", "", $file) . '\');">View Code</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#active_sd_' . str_replace(".html", "", $file) . '\');">Activate</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#delete_sd_' . str_replace(".html", "", $file) . '\');">Delete</a></td></tr>';
  }
          
  foreach ($internal_portals as $file) {
    if ($file != "." && $file != "..")
      echo '<tr><td>' . $file . '</td><td><a href="#" onclick="evilportalAjaxPopup(\'#view_int_' . str_replace(".html", "", $file) . '\');">Dev Preview</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#code_int_' . str_replace(".html", "", $file) . '\');">View Code</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#active_int_' . str_replace(".html", "", $file) . '\');">Activate</a></td><td><a href="#" onclick="evilportalAjaxPopup(\'#delete_int_' . str_replace(".html", "", $file) . '\');">Delete</a></td></tr>';
  }
  echo '</table></center>';

  foreach ($sd_portals as $file) {
    $dir = "/sd/portals";
    echo '<form method="POST" id="code_sd_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?configfile=' . $dir . '/' . $file . '"></form>';
    echo '<form method="POST" id="active_sd_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?request_active=' . $dir . '/' . $file .'"></form>';
    echo '<form method="POST" id="delete_sd_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?request_delete=' . $dir . '/' . $file .'"></form>';
    echo '<form method="POST" id="view_sd_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?dev_preview='. $dir . '/' . $file .'"></form>';
  }
          
  foreach ($internal_portals as $file) {
    $dir = "/root/portals";
    echo '<form method="POST" id="code_int_' .str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?configfile=' . $dir . '/' . $file . '"></form>';
    echo '<form method="POST" id="active_int_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?request_active=' . $dir . '/' . $file .'"></form>';
    echo '<form method="POST" id="delete_int_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?request_delete=' . $dir . '/' . $file .'"></form>';
    echo '<form method="POST" id="view_int_' . str_replace(".html", "", $file) . '" action="/components/infusions/evilportal/includes/requests.php?dev_preview=' . $dir . '/' . $file .'"></form>';
  }

  if ((count($sd_portals)-2) <= 0 && (count($internal_portals)-2) <= 0)
    echo '<center><i>You have no saved portals to view</i></center>';

}

?>
