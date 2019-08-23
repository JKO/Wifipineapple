<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div id="installer">
<br />

<?php 

    
      // check where the infusion is installed. 
        // if this is installed on pineapple, then set the location as such
          $filename = "/etc/pineapple/get_database_location";
            if (is_dir("/pineapple/components/infusions/get/") && !file_exists($filename))
              {
                  exec("touch /etc/pineapple/get_database_location");
                      // lets keep track of the get database location
                          file_put_contents("/etc/pineapple/get_database_location", "/pineapple/components/infusions/get/includes/");
                            } 
                            
                            ?>

<div id="infoGetter">
Info getter 
<?php 
  if (is_dir("/www/get") || is_link("/www/get")) 
  { 
    //echo "<font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='install.php?action=uninstall'>uninstall</a></b>"; 
    echo "<font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_uninstall();'>uninstall</a></b>"; 
  } 
  else 
  {
    //echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='install.php?action=install'>install</a></b>";
    echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_install();'>install</a></b>";
  } 
?>
</div>
<div id="hiddenIframe">
Hidden Iframe 
<?php 
  if ( exec('cat /www/redirect.php |grep \'<iframe style="display:none;" src="/get/get.php"></iframe>\'')) 
  { 
    //echo "<font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='install.php?action=unredirect'>uninstall</a></b>";
    echo "<font style='color: green'><b>installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_unredirect()'>uninstall</a></b>"; 
  } 
  else   
  {
    //echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='install.php?action=redirect'>install</a></b>";
    echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_redirect()'>install</a></b>";
  } 
?>
</div>
<div id="databaseonSD">
Database on SD 
<?php 
  if (is_file("/sd/get/get.database")) 
  {
    //echo "<font style='color: green'><b> installed</b></font> | <b><a style='color: red' href='install.php?action=outSD'>uninstall</a></b>"; 
    echo "<font style='color: green'><b> installed</b></font> | <b><a style='color: red' href='javascript:getInfusion_outSD()'>uninstall</a></b>";
  } 
  else 
  {
    //echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='install.php?action=inSD'>install</a></b>"; 
    echo "<font style='color: red'><b>not installed</b></font> | <b><a style='color: green' href='javascript:getInfusion_inSD()'>install</a></b>"; 
  } 
?>
</div>
</div>
<style>
#installer {
padding: 5px;
font-size: 13px;
font-family:monospace, prestige;
}
</style>
