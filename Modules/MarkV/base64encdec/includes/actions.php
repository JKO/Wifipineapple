<?php 

require("/pineapple/components/infusions/base64encdec/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['action'])) 
{
    $action = $_GET['action'];
    
    switch ($action) 
    {
        case 'process':
            $content = $_GET['content'];
            $operation= $_GET['operation'];
            process($content, $operation, 0);
        break;
        default:
            # code...
            emptyMethod();
        break;
    }
}


/*

function log($msg)
{
  $file = 'log.txt';
  exec ('touch log.txt');
  $fh = fopen($file, 'w') or die("can't open file");
  $stringData = $msg;
  //$stringData=str_replace("\\'","'",$stringData);
  //$stringData=str_replace('\\"','"',$stringData);
  //$stringData=str_replace('\\\\','\\',$stringData);
  fwrite($fh, $stringData);
  fclose($fh);
}
*/


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function process($content, $operation, $debug = 1)
{
  
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  $output = "";
   
  switch ($operation) 
  {
      case 'encode':
          $output = base64_encode($content);
          break;
      case 'decode':
           $output = base64_decode($content);
      break;
      default:
          # code...
          emptyMethod();
      break;
  }
  echo "</br>".$output; 
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function emptyMethod()
{
    $output = "<h1>No method selected</h1>";
    echo $output;
    return $output;
}
?>
