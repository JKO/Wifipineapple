<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/strip-n-inject/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/strip-n-inject/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/strip-n-inject/includes/css/infusion.css')</style>

<script type="text/javascript">
  $(document).ready(function(){ codeinject_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="codeinject" class="refresh_text"></span></div>
<div class=sidePanelContent>

<?php

if(! $is_codeinject_installed)
{
  echo "sslstrip-inject <span id=\"codeinject_install_status\"><font color=\"red\"><strong>not installed</strong></font></span>";
  echo " <font color=\"white\"> | </font><a id=\"codeinject_install_link\" href=\"javascript:codeinject_install('install');\"><strong>Install</strong></a><br />";
}

if ($is_codeinject_running)
{
  echo "<font color=\"white\">strip-n-inject </font><span id=\"codeinject_status\"><font color=\"lime\"><strong>enabled</strong></font></span>";
  echo "<font color=\"white\"> | </font><a id=\"codeinject_link\" href=\"javascript:codeinject_toggle('stop');\"><strong>Stop</strong></a><br />";
} else {
  echo "<font color=\"white\">strip-n-inject </font><span id=\"codeinject_status\"><font color=\"red\"><strong>disabled</strong></font></span>";
  echo "<font color=\"white\"> | </font> <a id=\"codeinject_link\" href=\"javascript:codeinject_toggle('start');\"><strong>Start</strong></a><br />";
}
?>

</div>
</div>

<div id="tabs" class="tab">
  <ul>
    <li><a id="Output_link" class="selected" href="#Output">Proxy Log</a></li>
    <li><a id="script_link" href="#ScriptTab">Injection Code</a></li>
    <li><a id="ip_link" href="#IPTab">Attacker IP</a></li>
  </ul>

<div id="Output">
  [<a id="refresh" href="javascript:codeinject_refresh();">Refresh</a>]<br /><br />
  <textarea class="codeinject" id='status_output' name='status_output' cols='85' rows='29'></textarea>
</div>


<div id="ScriptTab">
  [<a href="javascript:codeinject_update_code($('#script').val(), 'script');">Save</a>]<br /><br />
  <?php
  echo "<textarea class='codeinject' id='script' name='script' cols='85' rows='29'>"; echo file_get_contents($code_path); echo "</textarea>";
  ?>
</div>

<div id="IPTab">
  [<a href="javascript:codeinject_update_ip($('#ip').val(), 'ip');">Save</a>]<br /><br />
  <?php
  echo "<textarea class='codeinject' id='ip' name='ip' cols='10' rows='29'>"; echo file_get_contents($ip_path); echo "</textarea>";
  ?>
</div>

</div>
<br />

Auto-refresh <select class="codeinject" id="auto_time">
  <option value="1000">1 sec</option>
  <option value="5000">5 sec</option>
  <option value="10000">10 sec</option>
  <option value="15000">15 sec</option>
  <option value="20000">20 sec</option>
  <option value="25000">25 sec</option>
  <option value="30000">30 sec</option>
</select> <a id="codeinject_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a>
