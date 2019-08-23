<script type='text/javascript'> function process(){
$('#options').AJAXifyForm(popup);
return false;
}</script>
<BR />
<form method="post" action="components/infusions/arping/functions.php" id="options">
Target: <input type="text" maxlenght="15" name="DST_IP">
Interface<select name="IFACE">
<!-- option value="eth0" -->
<!-- option value="wlan0" -->
<!-- option value="wlan1" -->
<?php
$interfacestring = exec('ifconfig |grep Link| cut -d" " -f1| tr "\\n" "!"');
$interfacearray = explode('!',$interfacestring);
$index = (count($interfacearray) - 2); //Subtract two because the array starts at zero and we wan't to ignore the last element
for ($i=0; $i <= $index; $i++){
echo('<option value="');
echo($interfacearray[$i]);
echo('">');
echo($interfacearray[$i]);
echo('</option>');
}
?>
</select>
Source IP<select name="SRC_IP">
<?php
$ipstring = exec("ifconfig |grep inet |sed 's/^....................//' |cut -d' ' -f1| tr '\\n' '!'");
$iparray = explode('!',$ipstring);
$index1 = (count($iparray) - 2);
for ($i1=0; $i1 <= $index1; $i1++){
echo('<option value="');
echo($iparray[$i1]);
echo('">');
echo($iparray[$i1]);
echo('</option>');
}
?>
</select>
<BR />
<input type="checkbox" name="f" value="1">Quit on first ARP reply <BR />
<input type="checkbox" name="b" value="1">Keep broadcasting, don't go unicast <BR />
<input type="checkbox" name="D" value="1">Duplicated address detection mode <BR />
<input type="checkbox" name="U" value="1">Unsolicited ARP mode, update your neighbors <BR />
<input type="checkbox" name="A" value="1">ARP answer mode, update your neighbors <BR />
<input type="checkbox" name="c" value="1">Stop after sending N ARP requests   <input type="text" name="CNT"> <BR />
<input type="checkbox" name="w" value="1">Time to wait for ARP reply, seconds <input type="text" name="TIMEOUT"> <BR />
<input type="checkbox" name="q" value="1">Don't show output <BR /> 
</form>
<button type="button" onclick="process()">ARPing</button>
<!-- special thanks to Tesla for helping me debug js -->
