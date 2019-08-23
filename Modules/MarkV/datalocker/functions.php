<?php

// Vars

$database = "/pineapple/components/infusions/datalocker/includes/database/tracker.db";


// Requests

/**
 * This starts installing dependencies
 */
if (isset($_GET['deps'])) {
  exec("opkg update && opkg install python-crypto");
  echo '<font color="lime">Dependencies have been installed!</font>';
}

/**
 * This decrypts a file
 */
if (isset($_GET['decrypt'])) {
  $file = $_POST['file'];
  $algo = $_POST['algo'];
  $key = $_POST['key'];

  if ($file != "" && $algo != "" && $key != "") {
    if (file_exists($file)) {
      $keyCheck = exec("/pineapple/components/infusions/datalocker/includes/fuckphp.py " . $algo . " " . $file . " " . $key);
      if ($keyCheck == "good") {
        exec("pineapple infusion datalocker decryptfile " . $algo . " " . $key . " " . $file);
        echo '<font color="lime">File decrypted successfully!</font>';
      } else {
        echo '<font color="red">The given key is not the key used to encrypt this file!</font>';
      }
    } else {
      echo '<font color="red">File: ' . $file . ' does not exist!</font>';
    }
  } else {
    echo '<font color="red">Please fill in all of the fields!</font>';
  }
}

/**
 * This encrypts a file
 */
if (isset($_GET['encrypt'])) {
  $file = $_POST['file'];
  $algo = $_POST['algo'];
  $key = $_POST['key'];

  $blocksize = 0;

  if ($algo == "aes128")
    $blocksize = 16;
  elseif ($algo == "aes256")
    $blocksize = 32;

  if ($file != "" && $algo != "" && $key != "") {
    if (file_exists($file)) {
      if (strlen($key) > $blocksize) {
        echo '<font color="red">Key length is to long! It should be between 1 and ' . $blocksize . ' characters</font>';
      } else {
        exec("pineapple infusion datalocker encryptfile " . $algo . " " . $key . " " . $file);
        echo '<font color="lime">File encrypted successfully!</font>';
      }
    } else {
      echo '<font color="red">File: ' . $file . ' does not exist!</font>';
    }
  } else {
    echo '<font color="red">Please fill in all of the fields!</font>';
  }
}

if (isset($_GET['filetracker'])) {
  echo showFileTracker();
}

// Functions

/**
 * This function checks if the dependencies are installed or not
 */
function checkDepends() {
  $output = exec("opkg list-installed | grep python-crypto");
  if ($output == "")
    return false;
  else
    return true;
}

/**
 * This function gets files from the tracker database
 */
function getFiles() {
  global $database;
  $db = new SQLite3($database);
  $db->exec("SELECT file FROM tracking");
  $rows = array();
  $result = $db->query("SELECT file FROM tracking");
  while ($row = $result->fetchArray()) {
    array_push($rows, $row['file']);
  }
  $db->close();
  return $rows;
}

/**
 * This function gets the algorithms used to encrypt files from database
 */
function getAlgos() {
  global $database;
  $db = new SQLite3($database);
  $db->exec("SELECT algorithm FROM tracking");
  $rows = array();
  $result = $db->query("SELECT algorithm FROM tracking");
  while ($row = $result->fetchArray()) {
    array_push($rows, $row['algorithm']);
  }
  $db->close();
  return $rows;
}

/**
 * This function gets the data the file was encrypted from database
 */
function getDates() {
  global $database;
  $db = new SQLite3($database);
  //$db->exec("SELECT date FROM tracking");
  $result = $db->query("SELECT date FROM tracking");
  $rows = array();
  while ($row = $result->fetchArray()) {
    array_push($rows, $row['date']);
  }
  $db->close();
  return $rows;
}

/**
 * This function shows the files in the file tracker
 */
function showFileTracker() {

  $files = getFiles();
  $algos = getAlgos();
  $dates = getDates();

  ?>

  <center>
    <table cellspacing="20px">
      <tr><th><u>File</u></th> <th><u>Encryption</u></th> <th><u>Date</u></th></tr>

<?php
      for ($i=0; $i <= sizeof(files); $i++) {
        echo "<tr><td>" . $files[$i] . "</td><td>" . $algos[$i] . "</td><td>" . $dates[$i] . "</td></tr>";
      }
?>
    </table>
  </center>

<?php
}

?>
