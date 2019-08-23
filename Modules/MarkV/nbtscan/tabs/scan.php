<h2>Scan</h2>
<hr/>

<div id="controls">
  <center>
  	<form id="startScan" method="POST" action="/components/infusions/nbtscan/includes/requests.php?scan">
      <table>
	    <tr>
	      <td><label for="networkAddress">Network Address: </label></td>
	      <td><input type="text" value="172.16.42.0" id="networkAddress" name="networkAddress"></td>
	      <td><label for="cidrMask">CIDR Mask: </label></td>
	      <td><input type="text" value="24" id="cidrMask" name="cidrMask"></td>
	      <td><button type="button" onclick="preformNbtScan('large');">Scan Now</button></td>
	    </tr>
	  </table>
    </form>
  </center>
</div>
<br />
<div id="spinny" style="display:none; margin-left:auto; margin-right:auto;">
  <center>
    <img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif">
  </center>
</div>
<br/>

<b>Scan Results</b> - <a onclick="clearScanResults('resultArea');" href="#">[CLEAR]</a>
<br />
<div id="results">
  <center>
    <textarea id="resultArea" style="width:100%; height:250px" Placeholder="Scan results will be shown here" disabled></textarea>
  </center>
</div>

<br />

<b>Routing Table</b>
<div id="routing">
  <center>
    <textarea id="resultArea" style="width:100%; height:100px" Placeholder="Routing table will be displayed here" disabled><?=shell_exec("route") ?></textarea>
  </center>
</div>
