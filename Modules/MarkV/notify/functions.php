<?php

function put_ini_file($file, $array, $i = 0){
  $str="";
  foreach ($array as $k => $v){
    if (is_array($v)){
      $str.=str_repeat(" ",$i*2)."[$k]".PHP_EOL; 
      $str.=put_ini_file("",$v, $i+1);
    }else
      $str.=str_repeat(" ",$i*2)."$k=$v".PHP_EOL; 
  }
 if($file)
    return file_put_contents($file,$str);
  else
    return $str;
}

?>