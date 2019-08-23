<?php
$hostraw = $_POST[dnshost];
$BAD = array("<",">","&","/","*","{","}","|","[","]",";","?",":",",","!","@","#","$","%","^","(",")");
$hostnotags = strip_tags($hostraw);
$hostrem = str_replace($BAD, '', $hostnotags);
$hostnotags = strip_tags($hostrem);
$hostclean = htmlspecialchars($hostnotags, ENT_QUOTES, 'UTF-8');
$cmd = "echo 'nameserver $hostclean' > /etc/resolv.conf";
exec ($cmd);
exec ("cat /etc/resolv.conf", $response);

echo ("CONTENT OF /etc/resolv.conf updated:<br>");
foreach($response as $responseString){ //The result of the command comes back as an array and if you try to echo it directly you get "Array" so I used a foreach loop to get each line as a string
echo ("$responseString<br />"); //each line should be on a new line in the html
}

$cmd = "sed -i \"s/list.*6,.*/list 'dhcp_option' '6,$hostclean'/\" /etc/config/dhcp";
exec ($cmd);                                                                                                       
$response="";
exec ("cat /etc/config/dhcp", $response);                                                                                     

echo ("<br>CONTENT OF /etc/config/dhcp updated: <br />");                                

foreach($response as $responseString){                                             
echo ("$responseString<br />"); //each line should be on a new line in the html   
}

$response="";
$cmd = "grep 'dhcp-option=6' /etc/dnsmasq.conf";
exec ($cmd, $response);

if ($response)
{
echo ("<br><br> ==>Option detected in dnsmasq.conf");
$cmd = "sed -i \"s/dhcp-option=6.*/dhcp-option=6, $hostclean/\" /etc/dnsmasq.conf";                                          
exec ($cmd);
}
else
{
echo ("<br><br> ==>Option not yet set in dnsmasq.conf");
$cmd = "echo 'dhcp-option=6, $hostclean' >> /etc/dnsmasq.conf";
exec ($cmd);
}

$response="";
exec ("cat /etc/dnsmasq.conf", $response);                                                                                      
echo ("<br>CONTENT OF /etc/dnsmasq.conf updated: <br />");                                                                      
foreach($response as $responseString){                                                                                         
echo ("$responseString<br />"); //each line should be on a new line in the html      
}        

exec ("/etc/init.d/dnsmasq restart");
echo ("<br> DNSMASQ RESTARTED - ALL DONE <br>");

?>







