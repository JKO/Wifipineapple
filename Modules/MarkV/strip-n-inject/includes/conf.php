<?php

require("/pineapple/components/infusions/strip-n-inject/handler.php");

global $directory, $rel_dir;

require($directory."includes/vars.php");

if (isset($_POST['set_code']))
{  
  $filename = $code_path;

  $newdata = $_POST['newdata'];
  //$newdata = ereg_replace(13,  "", $newdata);
  
  $fw = fopen($filename, 'w');
  $fb = fwrite($fw,stripslashes($newdata));
  fclose($fw);
    
  echo '<font color="lime"><strong>saved</strong></font>';
}

if (isset($_POST['set_ip']))
{  
  $filename = $ip_path;

  $newdata = $_POST['newdata'];
  //$newdata = ereg_replace(13,  "", $newdata);
  
  $fw = fopen($filename, 'w');
  $fb = fwrite($fw,stripslashes($newdata));
  fclose($fw);
    
  echo '<font color="lime"><strong>saved</strong></font>';
}


?>
