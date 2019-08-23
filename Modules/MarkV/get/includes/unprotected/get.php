<?php 

// set the permissions incase it was not already set.
exec("chmod +x /pineapple/components/infusions/get/includes/karmaclients.sh");

$mac= exec("/pineapple/components/infusions/get/includes/karmaclients.sh |grep -B 1 $_SERVER[REMOTE_ADDR] |grep Station |cut -d ' ' -f 2");
$name=str_replace(":","_",$mac);
$comments_directory = trim(file_get_contents("/etc/pineapple/get_database_location"))."comments";

if ( !doesLocationFileExist($comments_directory) )
{
  exec ("mkdir $comments_directory");
}

exec("touch $comments_directory/$name");


?>
<style>
body {
    background-color: black;
    color:white;
}
table {
    background-color: #222;
    border-radius: 5px;
    border: 3px #555 solid;
    margin:3px;
    padding: 2px;
}
a {color: green;}
td {border: none;}
tr:nth-child(odd) {background-color: #333; }
tr:nth-child(1) {background-color: #DDD; color:#000;}
</style>
<form id="form1" name="form1" method="post" action="get_write.php">
<input name="code" id="code">
</form>

<script type="text/javascript">
/*
if (navigator.geolocation) 
{
    navigator.geolocation.getCurrentPosition( 
        function (position) {  
        document.getElementById("nav").innerHTML="Latitude: " + position.coords.latitude + " | Longitude: " + position.coords.longitude;
        }, function (error){});
}
*/
var page="<html>";
page+="<table style='background-color: #DDD'><tr><td>MAC: </td><td>";
page+=<?php print "'"; echo exec("/pineapple/components/infusions/get/includes/karmaclients.sh |grep -B 1 $_SERVER[REMOTE_ADDR] |grep Station |cut -d ' ' -f 2"); print "';";?>
page+="</td></tr></table><table style='background-color: #DDD'><tr><td>Host Name: </td><td>";
page+=<?php print "'"; echo exec("/pineapple/components/infusions/get/includes/karmaclients.sh |grep -A 1 $_SERVER[REMOTE_ADDR] |grep host| sed 's/ */ /g' |cut -d ' ' -f 4"); print "';";?>
page+=<?php print "\"<!--end--></td></tr></table>\";";?>
page+=("<table border='1'>");
page+=("<tr><td>Variable:</td> <td>Value</td></tr>");
page+=("<tr><td>App Name:</td> <td>" + navigator.appName + "</td></tr>");
page+=("<tr><td>User Agent:</td> <td>" + navigator.userAgent+ "</td></tr>");
page+=("<tr><td>Product Sub:</td> <td>" + navigator.productSub+ "</td></tr>");
page+=("<tr><td>Language:</td> <td>" + navigator.language+ "</td></tr>");
page+=("<tr><td>Cookies Enabled:</td> <td>" + navigator.cookieEnabled+ "</td></tr>");
page+=("<tr><td>App Version:</td> <td>" + navigator.appVersion+ "</td></tr>");
page+=("<tr><td>Online:</td> <td>" + navigator.onLine+ "</td></tr>");
page+=("<tr><td>Geolocation:</td> <td id='nav'>") ;
if (navigator.geolocation){
page+="true</td></tr>";    
} else {
page+= "false</td></tr>";
}
page+=("<tr><td>Product:</td> <td>" + navigator.product+ "</td></tr>");
page+=("<tr><td>Vendor:</td> <td>" + navigator.vendor+ "</td></tr>");
page+=("<tr><td>Platform:</td> <td>" + navigator.platform+ "</td></tr>");
page+=("<tr><td>App Codename:</td> <td>" + navigator.appCodeName+ "</td></tr>");
page+=("<tr><td>Java enabled:</td> <td>" +  navigator.javaEnabled() + "</td></tr>");
page+=("<tr><td>CPU class:</td> <td>" + navigator.cpuClass + "</td></tr>");

// for NN4/IE4
if (self.screen) {     
        width = screen.width
        height = screen.height
}

// for NN3 w/Java
else if (self.java) {   
       var javakit = java.awt.Toolkit.getDefaultToolkit();
       var scrsize = javakit.getScreenSize();       
       width = scrsize.width; 
       height = scrsize.height; 
}
else {

// N2, E3, N3 w/o Java (Opera and WebTV)
width = height = '?' 
}

page+=("<tr><td>Screen Resolution:</td><td> "+ width +" x "+ height + "</td></tr>")
   page+=("</table>");   


 page+=("<br />");
   page+=("<table border='1'>");
   var L = navigator.plugins.length;
   page+=("<td>" + L.toString().bold() + " Plugin(s) Detected</td>".bold());
  
   page+=("<tr style='background-color:#DDD;color:#000;'><td><b>Name</b></td><td><b>Filename</b></td><td><b>Description</b></td></tr>");
   for(var i=0; i<L; i++) {
     page+=("<tr>");
     page+=("<td>" + navigator.plugins[i].name + "</td>");
     page+=("<td>" + navigator.plugins[i].filename + "</td>");
     page+=("<td>" + navigator.plugins[i].description + "</td>");
     page+=("</tr>");
   }
   page+=("</table>");

<!--
page+=("<br /><table border='1'>");
page+="<tr><td>Type</td><td>Description</td><td>Suffix(es)</td><td>Name</td></tr>";
for (var i = 0; i < navigator.mimeTypes.length ; i++) {
page+=("<tr>");
  page+=("<td>"+ navigator.mimeTypes[i].type+ "</td>")
  page+=("<td>"+ navigator.mimeTypes[i].description+ "</td>")
  if (navigator.mimeTypes[i].suffixes != "")
    page+=("<td>"+ navigator.mimeTypes[i].suffixes+ "</td>")
  else
    page+=("<td>"+ navigator.mimeTypes[i].suffixes + " * "+ "</td>");

  if (navigator.mimeTypes[i].enabledPlugin)
    page+=("<td>"+ navigator.mimeTypes[i].enabledPlugin.name + "</td>");
  else
    page+=("<td>"+ "None" + "</td>");
  page+=("</tr>");
}
 page+=("</table>");

document.write(page);
document.getElementById("code").value=page;
document.getElementById('form1').submit();

</script>



<?php

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

?>