<?php 

require("/pineapple/components/infusions/get/handler.php");

global $directory;

require($directory."includes/vars.php");


if (isset($_GET['action'])) 
{
    $action = $_GET['action'];
    
     switch ($action) 
    {
        case 'erase_data':
            erase_data(0);
        break;
        case 'get_info':
            get_info(0);
        break;
        case 'get_all':
            get_all(0);
        break;
        case 'edit_comments':
            $mac = $_GET['mac'];
            edit_comments($mac, 0);
        break;
        case 'view_comments':
            $mac = $_GET['mac'];
            view_comments($mac, 0);
        break;
        case 'install':
            install(0);
        break;
        case 'uninstall':
            uninstall(0);
        break;
           case 'redirect':
            redirect(0);
        break;
        case 'unredirect':
            unredirect(0);
        break;
        case 'inSD':
            inSD(0);
        break;
        case 'outSD':
            outSD(0);
        break;
        default:
            # code...
            emptyMethod();
        break;
    }
}


if(isset($_POST['action']))
{
    $action = $_POST['action'];
    
    switch ($action) 
    {
        case 'save_comments':
            $content = $_POST['content'];
            $save_file = $_POST['save_file'];
            save_comments($save_file, $content, 0);
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

function install($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec('cp -r unprotected/ /www/get');

  echo "Info getter <font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_uninstall();'>uninstall</a></b>"; 
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function erase_data($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec('chmod +x erase_data.sh; ./erase_data.sh');

  echo "Infusion data cleared."; 
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function uninstall($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec('rm -r /www/get');
  
  echo "Info getter <font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_install();'>install</a></b>";
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function redirect($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec('echo \'<iframe style="display:none;" src="/get/get.php"></iframe>\' | tee -a /www/redirect.php');
  
  echo "Hidden Iframe <font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_unredirect()'>uninstall</a></b>";
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function unredirect($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec(' cat /www/redirect.php | sed \'s/<iframe style="display:none;" src="\/get\/get.php"><\/iframe>//\' -i /www/redirect.php');

  echo "Hidden Iframe <font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_redirect()'>install</a></b>";
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function inSD($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
  exec("mkdir /sd/get"); exec("cp get.database /sd/get"); 
  exec("ln -s -f -b /sd/get/get.database get.database"); 


  if ( !doesLocationFileExist('/etc/pineapple/get_database_location') )
  {
    exec("touch /etc/pineapple/get_database_location");
  } 

  // lets keep track of the get database location
  file_put_contents("/etc/pineapple/get_database_location", "/sd/get/");

  // read contents back
  // $variable = file(trim(file_get_contents("/etc/pineapple/get_database_location"))."get.database");


  echo "Database on SD <font style='color: green'><b> installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_outSD()'>uninstall</a></b>";
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function outSD($debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
   exec("cp /sd/get/get.database get.database.tmp");
  exec("rm /sd/get/get.database"); 
  exec("mv get.database~ get.database");
  exec("rm -rf /sd/get");
  exec("rm  get.database");
exec("mv get.database.tmp get.database");

  if ( !doesLocationFileExist('/etc/pineapple/get_database_location') )
  {
    exec("touch /etc/pineapple/get_database_location");
  } 
  
  // lets keep track of the get database location
  file_put_contents("/etc/pineapple/get_database_location", "/pineapple/components/infusions/get/includes/");

  
  echo "Database on SD <font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_inSD()'>install</a></b>"; 
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function save_comments($save_file, $content, $debug = 1)
{
  if ($debug) { echo "<b>debug:</b> debugging enabled<br>"; }
 
  // debug string below
  //$save_file = "./comments/00_c0_ca_52_5e_b9";
 
  $path = trim(file_get_contents("/etc/pineapple/get_database_location")) . $save_file;
  $content = trim($content); 
  $save_file = $path;
 
  if ($debug) { echo "<b>debug:</b> save file [" . $save_file . "] content[" . $content . "]<br>"; }
  
  if ($save_file != '') 
  {
      $comments_directory = trim(file_get_contents("/etc/pineapple/get_database_location"))."comments";
      if ( !doesLocationFileExist($comments_directory) )
      {
        exec ("mkdir $comments_directory");
      }
      $fh = fopen($save_file, 'w') or die("can't open file");
      $stringData = $content;
      $stringData=str_replace("\\'","'",$stringData);
      $stringData=str_replace('\\"','"',$stringData);
      $stringData=str_replace('\\\\','\\',$stringData);
      fwrite($fh, $stringData);
      fclose($fh);
  }
  
  $html = "<b>Comments Saved Successfully!!! Click on view comments to confirm</b>";

  if ($debug) { echo '<b>debug:</b> output returned by method: ' . $html . '<br>'; }
  echo $html;
}



// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function view_comments($mac, $debug = 1)
{
  if ($debug) { echo '<b>debug:</b> debugging enabled<br>'; }

  $macfile = str_replace(":","_",$mac);
 
  $open_file = trim(file_get_contents("/etc/pineapple/get_database_location"))."comments/";
  //$open_file = "./comments/";
  $open_file .= $macfile;
 
  $filenameForForm = "";
  if ($open_file == '') 
  { 
    $filenameForForm = $save_file; 
  }
  else
  {
    $filenameForForm = $open_file;    
  }
  
  $html  = "";
  //$html .= "[" . $mac . "]";
  $html .= "<div style=\"border: 1px white dashed; padding: 5px;\">";
  
  if (file_exists($open_file) && filesize($open_file)>0)
  {
    $fh=fopen($open_file, 'r');
    $theData=fread($fh,filesize($open_file));
    fclose($fh);
    $html .= $theData;
  } 
  else 
  {
    $html .= "<font style=\"font-family:monospace, prestige;\">[*] Comments empty ... </font>";
  }
  $html .= "</div>";
 
  if ($debug) { echo '<b>debug:</b> output returned by method: ' . $html . '<br>'; }
  
  echo $html;
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function edit_comments($mac, $debug = 1)
{
  if ($debug) { echo '<b>debug:</b> debugging enabled<br>'; }

  $macfile = str_replace(":","_",$mac);
  //$open_file = "./comments/";
  $open_file = "/comments/";
  $open_file .= $macfile;
 
  $filenameForForm = "";
  if ($open_file == '') 
  { 
    $filenameForForm = $save_file; 
  }
  else
  {
    $filenameForForm = $open_file;    
  }
  
  $html  = "";
  //$html .= "[" . $mac . "]";
  //$html .= "<form onsubmit='javascript:getInfusion_savecomments();' accept-charset='utf-8' >";
  $html .= "<form onsubmit='javascript:savecomments();' accept-charset='utf-8' >";
  //$html .= "  <b>Filename:</b><br>";
  //$html .= "  <input class=\"input_text\" type=\"text\" name=\"save_file\" id=\"save_file\" value=" . $filenameForForm . "><br>";

  $html .= "  <!--<b>Filename:</b><br> -->";
  $html .= "  <input class=\"input_text\" type=\"hidden\" name=\"save_file\" id=\"save_file\" value=" . $filenameForForm . "><br>";
  $html .= "  <b>Comments:</b><br>";
  $html .= "  <textarea id=\"content\" name=\"content\" style=\"width:90%; height:30%; color:#000000 background-color:#f7f7f7; border-radius:5px;\">";

 
          
  // need to get data for the text area
  if (!(is_file("$open_file"))) 
  {
    exec("touch $open_file");
    //$html .= "debug: in ! is file ()<br>";
  } 
        
  $file=file("$open_file");
         
  for ($i=0;$i<=count($file);$i++)
  {
    $html .= str_replace("<","&lt;",$file[$i]) ;
  } 

  // not sure what this does. Something about if the file is not present, then just echo the data back.
  // in the old version. We ended up to this code below b/c the view and save comments were together. Now
  // we don't need this below, because if the comments exist, then we display, else new ones are entered
  // and we save on the POST back.
  /*
  if ($open_file=='')
  {
    echo $content; 
    //$html .= "debug: openfile == ''<br>";  
  }
  else
  {
    //$html .= "debug: open file != ''<br>";
  }
  */

  $html .= "  </textarea><br>";
  $html .= "  <input type=\"submit\" name=\"Save\" value=\"Save Comments\"/>"; 
  $html .= "</form>";
 
  if ($debug) { echo '<b>debug:</b> output returned by method: ' . $html . '<br>'; }
  
  echo $html;
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

// 00:c0:ca:52:5e:b9

function get_info($debug = 1)
{
   if ($debug) { echo '<b>debug:</b> debugging enabled<br>'; }

  $mac=$_GET['mac'];
  
  if ($debug) { echo '<b>debug:</b> mac address passed: ' . $mac . '<br>'; }

  // Cat the database and then search for any data in the databae based on the MAC address
  $path = trim(file_get_contents("/etc/pineapple/get_database_location")) . "get.database";
  exec ("cat $path | grep $mac" , $output2);
  //exec("cat get.database | grep $mac" , $output2);
  $out="";
  
  if ($debug) { echo '<b>debug:</b> output from grepping get.database: ' . $output2 . '<br>'; }

  foreach($output2 as $outputline ) 
  {
    $out .= "<br />$outputline<br /><hr />";
  }  
  
  // if out is blank, means we didnt have data for this mac address or somehow we did not initially
  // save the mac address in the database
  if ($out == '') 
  {
    $out = "<font style='font-family:monospace, prestige;'>[*] No data ...</font>";
  }
  
  if ($debug) { echo '<b>debug:</b> output returned by method: ' . $out . '<br>'; }
  
  echo $out;
  //return $out;
}

// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function get_all($debug = 1)
{
  if ($debug) echo '<b>debug:</b> debugging enabled<br>';
  
  $path = trim(file_get_contents("/etc/pineapple/get_database_location")) . "get.database";
  exec ("cat $path | grep -oh '..:..:..:..:..:..' * |sort |grep -v '\.'|uniq", $output);
  //exec("cat get.database | grep -oh '..:..:..:..:..:..' * |sort |grep -v '\.'|uniq", $output);
  $state=0;
  $mac='';
  $out='';
  
  foreach($output as $outputline ) 
  { 
    $out .= "<tr><td>$outputline</td>";
    $mac=$outputline;
    $macfile=str_replace(":","_",$mac);
    // set the permissions incase it was not already set.
    exec("chmod +x /pineapple/components/infusions/get/includes/karmaclients.sh");
    $ip = exec("/pineapple/components/infusions/get/includes/karmaclients.sh |egrep 'address|name|Station' | sed 's/ */ /g' |sed 's/host name/hostname/g' |sed 's/ip address/ipaddress/g' | grep -A 1 $outputline | cut -d ' ' -f 3 |grep -oh '<.*>'") ;

    //echo 'ip: ['.$ip .'] [' .strlen($ip) .'] <br>';
    if ( strlen($ip) > 0 || $ip != '' )
    {
      $out .= "<td>" . $ip . "</td>";
    } 
    else 
    {
      $out .= "<td>[*] not connected ...</td>";
    }
    
    $path = trim(file_get_contents("/etc/pineapple/get_database_location")) . "get.database";
    $hostname= exec("cat $path | grep $outputline | grep -oh '<td>Host Name: </td><td><b>.*</b><!--end--></td></tr></table>' | grep -oh '<b>.*</b><!--end-->'");
    if ($hostname == '') 
    {
        $hostname = "[*] no data ...";
    }
    
    $out .= "<td>" . $hostname . "</td>" ;
    $out .= "<td>&nbsp;<a href='javascript:getInfusion_getinfo(\"$mac\")'>Info</a> ";
    $out .= "|&nbsp;<a href='javascript:getInfusion_viewcomments(\"$macfile\")'>View Comments</a> ";
    $out .= "|&nbsp;<a href='javascript:getInfusion_editcomments(\"$macfile\")'>Edit Comments</a> ";
    $out .= "</td>";    

    $state++;

    if ($state==3) 
    {
        $state=0;
    }
  }
  
  if ($debug) echo '<b>debug:</b> output returned by method: ' . $out . '<br>';

  // clean up for some space
  exec ('rm -rf /pineapple/components/infusions/get/includes/stadump');
  
  echo $out;
  //return $out;
}


// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================
// ===========================================================================================================

function doesLocationFileExist($path)
{
  $filename = $path;
  $found = false;
  if (file_exists($filename)) 
  {
    $found = true;
  }
  return $found;
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
