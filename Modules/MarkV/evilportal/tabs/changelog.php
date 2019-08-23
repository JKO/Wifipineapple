<form id="fixconfig" method="GET" action="/components/infusions/evilportal/functions.php?fixconfig"></form>

<h2>Change Log</h2>
<hr />


<h3>2.4 <a href="#" onclick="evilportalShowLog('2-4')" id="2-4show">Hide Log</a></h3>
<div id="2-4" style="display:block;">
  <ul>
    <li>Fixed tab issue for 2.1.x+ firmware</li>
    <li>Library is now centered better</li>
    <li>The large tile now refreshes in sections</li>
        <li>Re-named tabs and re-styled contents</li>
    <li>Code Changes</li>
    <ul>
      <li>Using updated API calls</li>
      <li>Functions.php now only has functions in it</li>
      <li>Requests.php handles GET and POST requests</li>
    </ul>
    <li>Changed manual configuration instructions</li>
    <ul>
      <li>Removed old un-needed configuration steps</li>
      <li>Re-worded a few things</li>  
    </ul>
    <li>Organized the change log better</li>
  </ul>
</div>

<h3>2.3 <a href="#" onclick="evilportalShowLog('2-3')" id="2-3show">Show Log</a></h3>
<div id="2-3" style="display:none;">
  <ul>
    <li>Fixed popups not going away automatically on 2.x firmware</li>
    <li>Configuration chages that allow the webserver on port 80 to be accessed with no issues by un-authenticated users</li>
    <ul>
      <li><i>If you are updating from version 2.2 or lower you should <a href="#" onclick="ajaxPopup('#fixconfig');">fix your configuration</a></i></li>
    </ul>
    <li>Kmod-sched is no longer reuired so therefore no longer gets installed</li>
  </ul>
</div>

<h3>2.2 <a href="#" onclick="evilportalShowLog('2-2')" id="2-2show">Show Log</a></h3>
<div id="2-2" style="display:none;">
  <ul>
    <li>Added ability to backup portals for later use</li>
    <li>Configuration changes</li>
    <ul>
      <li>NoDogSplash now runs on port 2050</li>
      <li>NGINX no longer must be configured in any way</li>
      <li>If you are updating from a previous version of evil portal click <a href="#" onclick="ajaxPopup('#fixconfig');">here</a> to re-configure</li>
      <li>This is not needed if you have just installed evil portals dependencies and configured evil portal</li>
    </ul>
    <li>Fixed error message when there is no internet</li>
    <li>Fixed issues with installing dependencies in firefox</li>
  </ul>
</div>

<h3>2.1 <a href="#" onclick="evilportalShowLog('2-1')" id="2-1show">Show Log</a></h3>
<div id="2-1" style="display:none;">
  <ul>
    <li>Fixed kmod-sched not installing</li>
  </ul>
</div>

<h3>2.0 <a href="#" onclick="evilportalShowLog('2-0')" id="2-0show">Show Log</a></h3>
<div id="2-0" style="display:none;">
  <ul>
    <li>Initial 2.0 Release</li>
    <ul>
      <li>Shows a message while dependencies are being installed</li>
      <li>Automatic configuration at the click of a button</li>
      <li>Automatic configuration from the command line</li>
      <li>NoDogSplash running status</li>
      <li>NoDogSplash auto-run status</li>
      <li>Live Portal Preview</li>
      <li>Dev Portal Preview</li>
      <li>Small Tile is no longer a "live tile"</li>
    </ul>
  </ul>
</div>
