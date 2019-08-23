<?php 

if(isset($_GET['action'])){
  if($_GET['action'] == "startdump1090"){
    echo start_dump1090();
  }
  if($_GET['action'] == "stopdump1090"){
    echo stop_dump1090();
  }
}

function start_dump1090(){
  //print_r($_POST);

  $startcommand = "dump1090 --net --net-http-port 9090";

  if(isset($_POST['metric'])){
    $startcommand .= " --metric ";
  }

  if(isset($_POST['enable-agc'])){
    $startcommand .= " --enable-agc ";
  }

  if(isset($_POST['aggressive'])){
    $startcommand .= " --aggressive ";
  }

  if(isset($_POST['gain'])){
    if($_POST['gain'] != "") {
      $startcommand .= " --gain " . $_POST['gain'];
    }
  }

  if(isset($_POST['freq'])){
    if($_POST['freq'] != "1090Mhz") {
      $startcommand .= " --freq " . $_POST['freq'];
    }
  }

  exec("echo ".$startcommand." | at now");
  return "<font color='lime'>dump1090 Started</font>";
}

function stop_dump1090(){
  exec("killall dump1090");
  return "<font color='lime'>dump1090 Stopped.</font>";
}

?>
