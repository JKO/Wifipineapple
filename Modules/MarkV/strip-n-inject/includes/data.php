<?php

require("/pineapple/components/infusions/strip-n-inject/handler.php");

global $directory, $rel_dir;

require($directory."includes/vars.php");

if (isset($_GET['proxylog']))
{
  if ($is_codeinject_running)
  {
    // get some info
    $log_cmd = "touch /sd/tmp/proxy_inject.log ; tail -n 50 /sd/tmp/proxy_inject.log";
    exec ($log_cmd, $output1);
    foreach($output1 as $outputline1) { echo ("$outputline1\n"); }

  }

  else
  {
    echo "Strip-N-Inject is not running...";
  }
}

?>
