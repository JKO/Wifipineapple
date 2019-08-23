<?php

require("/pineapple/components/infusions/strip-n-inject/handler.php");

global $directory, $rel_dir;

require($directory."includes/vars.php");

if (isset($_GET['codeinject']))
{

  if (isset($_GET['start']))
  {
    shell_exec("chmod +x ".$directory."includes/start.sh");
    exec("bash ".$directory."includes/start.sh | at now");
  }

  if (isset($_GET['stop']))
  {
    shell_exec("chmod +x ".$directory."includes/stop.sh");
    exec("bash ".$directory."includes/stop.sh | at now");
  }

  if (isset($_GET['install']))
  {
     exec("chmod +x ".$directory."includes/install.sh");
     exec("bash ".$directory."includes/install.sh | at now");
  }

}

