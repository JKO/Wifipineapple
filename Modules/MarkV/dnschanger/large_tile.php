<html>
    <!-- head>
    <title>Pineapple Bar: DNSChanger</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" type="text/css" href="/includes/styles.css"> 
    <link rel="icon" href="/favicon.ico" type="image/x-icon"> 
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 
    <script type='text/javascript' src='<?=$rel_dir?>helpers.js'></script>

	</head -->
<body>
<center>
<br/><br /><br />
<p>
<pre><h1>DNSCHANGER</h1></pre>
<a><br /> Version 1.2 - Bugs </a>
</p>
</div>
<div class=content>

The aim of this infusion is to change the DNS server that is used by the Pineapple and that is provided by the Pineapple DHCP server <br>
<br>
This is useful in places where only specific DNS servers are allowed, such as OpenDNS. <br>
<br>
You can find out very quickly if you connect your pineapple to the Internet and you cannot ping google.com but can ping 8.8.8.8
<br>
(bear in mind, there could be other reasons as to why this does not work)
<br>
But if you are in a situation where say only OpenDNS is allowed on the network, the idea is that before you configure the DNS entry with this infusion you connect to that Network with your laptop/mobile device. Check what is the DNS entry provided by the DHCP server and use it explicitly here.
<br><br>
On a linux computer you can use the "dig" command to find that out, just do "dig google.com" and look for the SERVER: entry in the results.<br><br>
<br><br>
<b>
Please be aware this plugin may conflict with the use of DNSspoof infusion, as you are now potentially specifying a different DNS server than the Pineapple.<br>
If you want to reset the DNS server settings, just update the DNS entry to 172.16.42.1<br>
<br></b>
</center>
<hr>
<b> Changelog </b>
<br>
<li> Version 1.2 </li>
- Updated the internal version of the infusion so you don't always see an update available! (learning the hardway! :)
<br><br>
<li> Version 1.1 </li>
- Updated file structure, so it can now install from the Pineapple bar!<br>
- Cleaned the HTML code a bit<br>
- Added a Changelog<br>
<br>
<li>Version 1.0 </li>
Initial release
</div>
 </center>       
</body>
</html>
