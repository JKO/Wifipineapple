<script type='text/javascript'>
function dns(){
$('#dnshost').AJAXifyForm(popup);
return false;
notify('Pong!');
}

function dnscheck(){
$('#checkhost').AJAXifyForm(popup);
return false;
notify('Pong!');
}
</script>
<center>
<a><font color="Red">Update resolv.conf, dhcp and dnsmasq.conf</font></a>
<form method="post" action="components/infusions/dnschanger/includes/dns.php" id="dnshost"><input type="text" value="208.67.222.222" name="dnshost" > 
<button type="button" onclick="dns()">DNS CHANGE (Wait 5 Seconds)</button>
</form>
<br><form method="post" action="components/infusions/dnschanger/includes/dns_check.php" id="checkhost">
<button type="button" onclick="dnscheck()">DISPLAY DNS VALUES</button>
</center>
</form>
