<?php

if(isset($_GET['action'])){
  if($_GET['action'] == "startrtltcp"){
    echo start_rtltcp();
  }
  if($_GET['action'] == "stoprtltcp"){
    echo stop_rtltcp();
  }
}

function start_rtltcp(){
  //print_r($_POST);

  $startcommand = "rtl_tcp ";

  if(isset($_POST['ListenAddress'])){
    $startcommand .= " -a " . $_POST['ListenAddress'];
  } else {
    $startcommand .= " -a 0.0.0.0";
  }

  if(isset($_POST['ListenPort'])){
    $startcommand .= " -p " . $_POST['ListenPort'];
  } else {
    $startcommand .= " -p 1234";
  }

  if(isset($_POST['Device'])){
    $startcommand .= " -d ". $_POST['Device'];
  }

  if(isset($_POST['Gain'])){
    if($_POST['Gain'] != "") {
      $startcommand .= " -g " . $_POST['Gain'];
    }
  }

  if(isset($_POST['Frequency'])){
      $startcommand .= " -f " . $_POST['Frequency'];
  } else {
      $startcommand .= " -f 1090000000";
  }

  if(isset($_POST['SampleRate'])){
      $startcommand .= " -s " . $_POST['SampleRate'];
  } else {
      $startcommand .= " -s 48000";
  }

  exec("echo ".$startcommand." | at now");
  return "<font color='lime'>rtl_tcp Started</font>";
}



function stop_rtltcp(){
  exec("killall rtl_tcp");
  return "<font color='lime'>rtl_tcp Stopped.</font>";
}

 
?>
