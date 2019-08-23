<?php
exec ("cat /etc/resolv.conf", $response);

echo ("CONTENT OF /etc/resolv.conf:<br>");
foreach($response as $responseString){ //The result of the command comes back as an array and if you try to echo it directly you get "Array" so I used a foreach loop to get each line as a string
echo ("$responseString<br />"); //each line should be on a new line in the html
}

$response="";
exec ("cat /etc/config/dhcp", $response);                                                                                     

echo ("<br>CONTENT OF /etc/config/dhcp: <br />");                                

foreach($response as $responseString){                                             
echo ("$responseString<br />"); //each line should be on a new line in the html   
}


$response="";
exec ("cat /etc/dnsmasq.conf", $response);

echo ("<br>CONTENT OF /etc/dnsmasq.conf: <br />");

foreach($response as $responseString){
echo ("$responseString<br />"); //each line should be on a new line in the html
}

?>







